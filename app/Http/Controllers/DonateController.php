<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Event;
use App\UssdTemplate;

class DonateController extends Controller
{
    //

    public function index(){

        $userDonationEvents = Event::where("user_id",auth()->id())
        ->where('event_type','donation')->get();
        $totalCount = \count($userDonationEvents);
        // dd($userEvents);
        // ussd variables
        
        return view('dashboard.donate.index',['userDonationEvents'=>$userDonationEvents,'eventTotal'=>$totalCount]);
    }


    public function create($eventId)
    {
        $donationEvents = Event::findOrFail($eventId);
        $ussdVariables = UssdTemplate::where('event_id',$donationEvents->id)->orderBy('order_in_variable', 'ASC')->get();
        $ussdVariables = collect($ussdVariables);

        $ussdVariables = $ussdVariables->map(function($variable,$key){
            if($variable->input_type=='single'){
                $options = json_decode($variable->options);
                $variable['options'] = $options;
                // dd($variable->options);
                return $variable;
            }
            return $variable;
        });
        // dd($ussdVariables->all()[1]->options->items);
        return view('dashboard.donate.create',['donationEvent'=>$donationEvents,'variables'=>$ussdVariables->all()]);
    }

    public function store(Request $request,$eventId)
    {

        $event = Event::find($eventId);
        dd($event);
        dd(count($event->ussdtemplate));
        
        $response = Validator::validator($request->all(),
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


    $ussdtemplate = UssdTemplate::create(
        [
        'event_id' =>$eventId,
        "user_id"  => auth()->id(),
        "input_type"  => $request->input('input_type'),
        'options'=>json_encode($request->input('options')),
        'description'=> $request->input('description'),
        'name'=> $request->input('name'),
        'required'=> $request->input('required',0),
        'min_length'=> $request->input('min_length',0),
        'max_length'=> $request->input('max_length',10),
        'default_value'=> $request->input('default_value',''),
        'order_in_variable'=> count($event->ussdtemplate)+1,
        'hidden_text'=> $request->input('hidden_text')
    ]);
    $request->session()->flash('info','Variable Created Sucessful'); 
    return redirect()->back();

    }
}
