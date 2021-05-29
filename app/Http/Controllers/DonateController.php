<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Event;
class DonateController extends Controller
{
    //

    public function index(){

        $userEvents = Event::where("user_id",1)->get();
        $totalCount = \count($userEvents);
        // dd($userEvents);
        
        return \view('dashboard.donate.index',['events'=>$userEvents,'eventTotal'=>$totalCount]);
    }
}
