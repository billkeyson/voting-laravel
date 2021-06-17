<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\UssdTemplate;

class UssdTemplateController extends Controller
{
    //
    public function create(Request $request){

        if(!$request->isjson()){
            return response()->json(['status'=>2001,'messgae'=>'content type is application/json'], 401);
        }

        $response = Validator::make($request->all(),
        [
            'event_id'=>'required',
            'user_id'=>'required',
            'name'=>'required',
            'description'=>'required|min:5',
            'min_length'=>'required',
            'max_length'=>'required',
            'input_type'=>'required',
            'order_in_variable'=>'required'
        ]
    );



        if($response->fails()){
            // var_dump($response->fails());
            return response()->json(['status'=>4004,'messgae'=>'require field(s) mission'], 401);
        }

        $ussdtemplate =new UssdTemplate([
            'event_id' =>$request->input('event_id'),
            "user_id"  => $request->input('event_id'),
            "input_type"  => $request->input('input_type'),
            'options'=>json_encode($request->input('options')),
            'description'=> $request->input('description'),
            'name'=> $request->input('name'),
            'required'=> $request->input('required',0),
            'min_length'=> $request->input('min_length',0),
            'max_length'=> $request->input('max_length',10),
            'default_value'=> $request->input('default_value',''),
            'order_in_variable'=> $request->input('order_in_variable'),
            'hidden_text'=> $request->input('hidden_text')
        ]);
        
        if($ussdtemplate->save()){
            return response()->json(['status'=>2001,'messgae'=>'ussd variable created successfully'], 200);
        }
        return response()->json(['status'=>4001,'messgae'=>'ussd variable failed to be created'], 401);
    }

    public function reorderVariables(Request $request){
        // dd($request->all()[0]->variableId);
        $updateVariables = $request->all();

        foreach($updateVariables as $variable){
            $update = UssdTemplate::find($variable['variableId']);
            $update->order_in_variable= $variable['orderNumber'];
            $update->save();
        }
        return response()->json(['status'=>200,'messgae'=>'variable update successful'], 200);
    }
}
