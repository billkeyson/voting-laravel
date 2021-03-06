<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use App\Category;
use App\Nominee;

class WelcomeController extends Controller
{
    public function index()
    {

        $events = Event::where('event_type','!=','donation')->get();
        // foreach($events as $event){
        //     dd($event->user->name);
        // }
        return view('welcome', ['events'=>$events]);
    }


    public function categories($eventType=null,$eventId)
    {

        $eventName = Event::findOrFail($eventId);
        $categories = Category::where('event_id',$eventId)->get();
        // dd($categories[0]->event->name);
        return view('categories', ['categories'=>$categories,'eventName'=> $eventName->name]);
    }

    public function nominees($eventType=null,$eventId)
    {
        $eventName = Event::findOrFail($eventId);
        $awards =  ['Events','Nominee'];
        if ($eventType != null && $eventType=='awards')
        {
            $awards = ['Events','Categories','Nominee'];
            $eventName = $eventName->category->name;

        }
        else{
            $eventName = $eventName->name;
        }
        $nominees = Nominee::where('event_id',$eventId)->get();

        // dd($categories[0]->event->name);

        
        return view('nominees', ['nominees'=>$nominees,'eventName'=> $eventName,'jumbotronList'=>$awards]);
    }


    public function nomineesDetails($eventtype=null,$nomineeId){
        $nominee = Nominee::findOrFail($nomineeId);
        if($nominee->category!=null)
        {
            $eventName = $nominee->category->name;
        }else{
            $eventName = $nominee->event->name;
        }
        $unit_cost = $nominee->event->unit_cost;
        return view('nomineedetails',['nominee'=>$nominee,'eventName'=>$eventName,'unitCost'=>$unit_cost]);
    }
}
