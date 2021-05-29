<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Event;
use App\Category;
use App\Nominee;
class CategoryController extends Controller
{
    //

    public function index($eventId)
    
    {
        $eventName = Event::where('id',$eventId)->first();
        $categories  = Category::where('event_id',$eventId)->get();
        if(!$eventName)
        return redirect()->back();
        return \view('dashboard.category.index',['eventId'=>$eventId,'eventName'=>$eventName->name,'categories'=>$categories]);
    }

    public function create($catId)
    
    {
        // get cat by id
        $category  = Category::findOrFail($catId);
        // get event by id
        $event = Event::findOrFail($category->event_id);
        // get nominees by catId and event id
        $nominees = Nominee::where('cat_id',$category->id)->where('event_id',$event->id)->get();
        return \view('dashboard.category.create',['category'=>$category,'event'=>$event,'nominees'=>$nominees]);
    }

    public function store(Request $request,$eventId)
    
    {

        $validator = Validator::make(
        [
            'name'=>$request->input('name'),
            'description'=>$request->input('description'),
            'event_id'=>$eventId
        ], 
        [
            'name' => 'required|max:255',
            'description' => 'required',
            'event_id'=>'required|integer'
        ]);

        if ($validator->fails()) {
            // dd('sas');
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $event = Event::find($eventId)->get();
        if($event)
        {

            // dd('save');
            Category::create([
                'event_id'=>$eventId,
                'name'=>$request->input('name'),
                'description'=>$request->input('description')

            ]);
        }
        return redirect()->back();
    }
}
