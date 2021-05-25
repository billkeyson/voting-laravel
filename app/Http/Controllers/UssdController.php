<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UssdProviderMap;
use App\UssdTemplate;
use Carbon\Carbon;


class UssdController extends Controller
{
   
    public function ussd(){}

    public function ussdNalodWebhook(Request $request)
    {

        $sessionName = '#_'.$request->input('MSISDN');
        // First Time 
        if($request->input('MSGTYPE')==true){
            // search for event by shortcode
           $eventShortCode =  UssdProviderMap::where('shortcode',$request->input('USERDATA'))->first();
           if($eventShortCode)
           {
            // Get all variable template 
                $result =  UssdTemplate::where('event_id',$eventShortCode->event_id)->orderBy('order_in_variable', 'ASC')->get();
           if($result)
           {
            //Save user event variables as a session for the first time
            $current = $this->saveInitUserSession(
                $request, 
                $result,
                $eventShortCode->user_id,
                $eventShortCode->event_id,
                $request->input('MSISDN'));
            // dd($current['current']);
            $msg = $this->formatVariableDisplay($current['current']);
            }
            
            return response($msg, 200)
            ->header('Content-Type', 'text/plain');
        
        }
    //    IF event do not exist return Unregisted Event

    return response('Event Is no more available', 200)
        ->header('Content-Type', 'text/plain');

    }else{

        // reset or update next variable
        $nextVar = $this->updateNextVariable($request,$sessionName,$request->input('USERDATA'));
        // $nextVar = $this->findUserSession($request,$sessionName);

        // dd($nextVar);
            $msg = '';
            // dd($nextVar->next_variable);
            if(isset($nextVar->current_variable)){
                $current = $nextVar->current_variable;
               $msg =  $this->formatVariableDisplay($current);
            }
     
    
        return response($msg, 200)
        ->header('Content-Type', 'text/plain');

    }
   
}


    // format variable to show to user base on input type
    private function formatVariableDisplay($optionsItems)
    {
        $displays = "";
        // dd($optionsItems);
        if($optionsItems)
        {

        if($optionsItems->input_type=='single')
        {
            $optionsItem = \json_decode($optionsItems->options)->items;
            $countText = 1;
            $displays = $optionsItems->description;
            foreach($optionsItem as $label){
                $displays =$displays."\n{$countText}. {$label->label}";
                $countText=$countText+1;
            }
            // var_dump($displays);
        }
        else
        {
            $displays = $optionsItems->description;;
        }

        }
        return $displays;
    }


    // save history
    private function saveVariableHistory($userid,Request $request,$ussdHistory)
    {
       $userSession = findUserSession($userId);
       if($userSession)
       {
            $userHistory['history'] = $ussdHistory;
            $request->session()->put($userId,$ussdHistory);
            return true;
       }
       return false;
    }

    // update next variable
    private function updateNextVariable(Request $request, $userId,$responseUserData)
    {
        // goNext
        $goNext = false;
        // find user session
        $findNext  = $this->findUserSession($request,$userId);
        // dd("THe");
        if(isset($findNext))
        {
            // set the next variable as a current variable   
            if($findNext->current_variable)
            {
                // current variable
                $current_variable  = $findNext->current_variable;
                // check user resonse for current variable
                 // skip is pre-cedence over hidden
                 $option = \json_decode($current_variable->options);
                
                //  check single input-type which has more items in options
                 if($current_variable->input_type=='single')
                 {
                    //  only singles has (items)
                    $optionsItem = \json_decode($current_variable->options)->items;

                     foreach($optionsItem as $item)
                     {
                        //  Check for the selected item in the option
                         if($responseUserData == strval($item->id)){

                            $value = null;
                            // check items input type and convert to the right type
                            if($option->type='int')
                            {
                                // dd($responseUserData);
                                $value = (int)$responseUserData;
                            }
                            else if($option->type='decimals')
                            {
                                $value = (float)$responseUserData;
                            }
                            else{
                                $value = $responseUserData;
                            }

                            // save response
                            $response  = [$current_variable->name=>$value];
                            $this->updateVartDB($request,$userId,null,null,$response);

                            //  skip if is the selected item

                            if (isset($item->skip) && $item->skip !='')
                            {
                                // dd($item);
                                // find the skiped to variable name
                                foreach($findNext->var_history as $history)
                                {
                                    // dd($history);
                                    if ($item->skip==$history->name)
                                    {
                                        // update the next variable to skip to and return 
                                        $this->updateVartDB($request,$userId,$history,null,null);
                                        // re-assign or call saved data
                                        $findNext = $this->findUserSession($request,$userId);
                                        // dd($findNext);
                                        $goNext =true;
                                        break;
                                    }
                                }
                                // dd("ship2");

                                break;
                            }

                            break;
                         }
                     }
 
                 }else if ($current_variable->input_type=='decimals'){
                     // save response
                     $value = (float)$responseUserData;
                     $response  = [$current_variable->name => $value];
                    //  dd("decimals");
                     $this->updateVartDB($request,$userId,null,null,$response);
                 }
                 else if($current_variable->input_type=='plain'){
                    $value =$responseUserData;
                    $response  = [$current_variable->name => $value];
                    $this->updateVartDB($request,$userId,null,null,$response);
                 }
                $this->updateVartDB($request,$userId,null,$findNext->next_variable,null);
                 
            }

            // find the next variable by order id and increasement by 1
            if(!$goNext)
            {
            $order_Var_id = $findNext->next_variable->order_in_variable+1;
            }else{
                $order_Var_id = $findNext->next_variable->order_in_variable;
            }

            // loop through all event variable and find the next variable by variable order numb.
            foreach($findNext->var_history as $history)
            {


                // TODO check to see if you will maintain it
                
                // find the next ordered variable and save it as the next 
                if($order_Var_id==$history->order_in_variable)
                {

                    // set new next variable
                    $this->updateVartDB($request,$userId,$history,null);
                    // get the updated version
                    $findNext = $this->findUserSession($request,$userId);
                    break;
                    
                }  
               

            }
           
        }
        // dd($findNext);
        return $findNext;

    }

    // handle skip conditions
    private function skipConditionHandler($variable){


        $current_variable  =  $current_variable  = $variable;
                // check user resonse for current variable
                 // skip is pre-cedence over hidden
                 $option = \json_decode($current_variable->options);
                 $optionsItem = \json_decode($current_variable->options)->items;
                //  check single input-type which has more items in options
                 if($current_variable->input_type=='single')
                 {
                     foreach($optionsItem as $item)
                     {
                        //  Check for the selected item in the option
                         if($responseUserData == strval($item->id)){

                            $value = null;
                            // check items input type and convert to the right type
                            if($option->type='int')
                            {
                                // dd($responseUserData);
                                $value = (int)$responseUserData;
                            }
                            else if($option->type='decimals')
                            {
                                $value = (float)$responseUserData;
                            }
                            else{
                                $value = $responseUserData;
                            }

                            // save response
                            $response  = [$current_variable->name=>$value];
                            $this->updateVartDB($request,$userId,null,null,$response);

                            //  skip if is the selected item

                            if (isset($item->skip) && $item->skip !='')
                            {
                                // dd($item);
                                // find the skiped to variable name
                                foreach($findNext->var_history as $history)
                                {
                                    // dd($history);
                                    if ($item->skip==$history->name)
                                    {
                                        // update the next variable to skip to and return 
                                        $this->updateVartDB($request,$userId,$history,null,null);
                                        // re-assign or call saved data
                                        $findNext = $this->findUserSession($request,$userId);
                                        // dd($findNext);
                                        break;
                                    }
                                }
                                // dd("ship2");

                                break;
                            }

                            break;
                         }
                     }
 
                 }else if ($current_variable->input_type=='decimals'){
                     // save response
                     $value = (float)$responseUserData;
                     $response  = [$current_variable->name => $value];
                     $this->updateVartDB($request,$userId,null,null,$response);
                 }
                 else if($current_variable->input_type=='plain'){
                    $value =$responseUserData;
                    $response  = [$current_variable->name => $value];
                    $this->updateVartDB($request,$userId,null,null,$response);
                 };
        // check user resonse for current variable
         // skip is pre-cedence over hidden
         $option = \json_decode($current_variable->options);
         $optionsItem = \json_decode($current_variable->options)->items;
        //  check single input-type which has more items in options
         if($current_variable->input_type=='single')
         {
             foreach($optionsItem as $item)
             {
                //  Check for the selected item in the option
                 if($responseUserData == strval($item->id)){

                    $value = null;
                    // check items input type and convert to the right type
                    if($option->type='int')
                    {
                        // dd($responseUserData);
                        $value = (int)$responseUserData;
                    }
                    else if($option->type='decimals')
                    {
                        $value = (float)$responseUserData;
                    }
                    else{
                        $value = $responseUserData;
                    }

                    // save response
                    $response  = [$current_variable->name=>$value];
                    $this->updateVartDB($request,$userId,null,null,$response);

                    //  skip if is the selected item

                    if (isset($item->skip) && $item->skip !='')
                    {
                        // dd($item);
                        // find the skiped to variable name
                        foreach($findNext->var_history as $history)
                        {
                            // dd($history);
                            if ($item->skip==$history->name)
                            {
                                // update the next variable to skip to and return 
                                $this->updateVartDB($request,$userId,$history,null,null);
                                // re-assign or call saved data
                                $findNext = $this->findUserSession($request,$userId);
                                // dd($findNext);
                                break;
                            }
                        }
                        // dd("ship2");

                        break;
                    }

                    break;
                 }
             }

         }else if ($current_variable->input_type=='decimals'){
             // save response
             $value = (float)$responseUserData;
             $response  = [$current_variable->name => $value];
             $this->updateVartDB($request,$userId,null,null,$response);
         }
         else if($current_variable->input_type=='plain'){
            $value =$responseUserData;
            $response  = [$current_variable->name => $value];
            $this->updateVartDB($request,$userId,null,null,$response);
         }

    }
    
// update history
    private function updateVartDB(Request $request,$userId,$nextVar=null,$current=null,$response=null,$errorMessages=null)
    {
        $userSession = $request->session()->get($userId);
        if($userSession)
        {
            $mobile = $userSession->mobile;
            $var_history = $userSession->var_history;
            $user_id = $userSession->user_id;
            $event_id = $userSession->event_id;
            $current_variable = $userSession->current_variable;
            $next_variable = $userSession->next_variable;
            $variable_response = $userSession->variable_response;
            
        }
        $userSessions =
        [
            'mobile'=>$mobile,
            'var_history'=>$var_history,
            'event_id'=>$event_id,
            'user_id'=>$user_id,
            'current_variable'=>$current_variable,
            'next_variable'=>$next_variable,
            'variable_response'=>$variable_response,
            'last_modified'=>Carbon::now()
        ];
        // update next variable
        if($nextVar!=null)
        {
            $userSessions['next_variable'] = $nextVar;
        }
        // update current
        if($current != null)
        {
            $userSessions['current_variable'] = $current;

        }
        // update response
        if($response != null)
        {
            $valuesKey = array_keys($response)[0];
            if(!array_key_exists($valuesKey,$response))
            {
            $userSessions['variable_response'][] = $response;
            }

        }

        // error messages
        if($error != null)
        {
            // system messages Keyes ['END','START','ERROR']
            $userSessions['error_messages'] = $error;

        }

        // save  to session by userid
        $request->session()->put($userId,json_decode(json_encode($userSessions)));

    }

    // finding user session ID
    private function findUserSession(Request $request, $userId)
    {
        $userSessions = $request->session()->get($userId);
        return $userSessions;

    }
    // First time session
    private function saveInitUserSession(Request $request,$requestResult,$userId=-1,$eventid=-1,$mobile='')
    {

        $history = $requestResult;
        $current= count($requestResult)>0?$requestResult[0] : [];
        $next_variable =count($requestResult)>1?$requestResult[1]:[];
        // generated userID
        $generatedId = '#_'.$request->input('MSISDN');
        $userSessions =
        [
            'mobile'=>$request->input('MSISDN'),
            'var_history'=>$history,
            'event_id'=>$eventid,
            'user_id'=>$userId,
            'current_variable'=>$current,
            'next_variable'=>$next_variable,
            'variable_response'=>[],
            'last_modified'=>Carbon::now()
        ];
        // save  to session by userid

        $request->session()->put($generatedId,json_decode(json_encode($userSessions)));
        // dd($request->session()->get($generatedId));
        return ["id"=>$generatedId,"current"=>$current];

    }

    // replace key strings
    private function replaceStrings($Str,$replace)
    {
        if(strpos($Str, ":eventName")){
            $msg =str_replace(":eventName",$replace,$Str);  

        }

        if(strpos($Str, ":fee")){
            $msg =str_replace(":fee",$replace,$Str);  

        }

        if(strpos($Str, ":sysName")){
            $msg =str_replace(":sysName",$replace,$Str);  
        }else{
        $msg =str_replace($find,$replaceWith,$replaceStr);  
        }

        return $msg;
    }

    public function donationHandler($ussdUserData)
    {
        // if($ussdUserData=='')

    }
}
