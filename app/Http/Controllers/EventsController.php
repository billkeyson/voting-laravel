<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
class EventsController extends Controller
{
    public function index(){
        $userEvents = Event::where("user_id",auth()->id())->get();
        $totalCount = \count($userEvents);
        // dd($userEvents);
        
        return \view('dashboard.events.index',['events'=>$userEvents,'eventTotal'=>$totalCount]);
    }
    //

    public function create(){
        return \view('dashboard.events.create');
    }

    public function store(Request $request){
        $request->validate(
            [
                'name'=>'required|min:5|unique:events',
                'unit_cost'=>'required',
                'event_type'=>'required',
                'expiry_date'=>'required'
            ]
        );
        // dd(auth()->user());
        $events = Event::create(
            [
            'name'=>$request->input('name'),
            'event_type'=>$request->input('event_type'),
            'is_approved'=> isset(auth()->user()->is_admin) ? 1:0, 
            "description"=>$request->input('description'),
            "unit_cost"=>$request->input('unit_cost'),
            "expiry_date"=>$request->input('expiry_date'),
            'event_type'=>$request->input('event_type'),
            'user_id'=>auth()->id()

            ]
            );
        if($events)
        {
            $request->session()->flash('success','Event created successful');
            return redirect(route('event.index'));
            
        }
        $request->session()->flash('error','Event failed  to save successful');
        return redirect(route('event.index'));
    }
}
