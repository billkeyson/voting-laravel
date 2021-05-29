<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use App\Nominee;

class NomineeController extends Controller
{
    //

    public function index($eventId)
    {
        // Get all Nominees
        $nominees = Nominee::where('event_id',$eventId)->get();
        $eventName = Event::where('id',$eventId)->first();
        if(!isset($eventId)){
          return redirect(route('event.index'));
        }
        return view('dashboard.nominees.index',['eventName'=>$eventName->name,'eventId'=>$eventId,'nominees'=>$nominees]);
    }


    public function create()
    {
        return view('dashboard.nominees.create');
    }

    public function store(Request $request,$eventId,$catId = null)
    {
        // dd($eventId);
        Nominee::create([
            'name'=>$request->input('name'),
            'bio'=>$request->input('bio'),
            'event_id'=>$eventId,
            'cat_id'=>$catId
        ]);
         return redirect()->back();
    }

    public function saveCategoryNominee(Request $request,$eventId,$catId)
    {
        
    }
}
