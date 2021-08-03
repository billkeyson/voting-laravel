<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\UssdTemplate;
use App\Event;


class UssdTemplateController extends Controller
{
    //
    public function create(Request $request,$eventId=null){

        // dd($request->input('input_type'));
        $options = [];
        Event::findOrFail($eventId);
       
        $request->validate(
            [
            'name'=>'required',
            'description'=>'required|min:5',
            'input_type'=>'required'
            ]);


    if($request->input('input_type')=='single'){
        $request->validate(
            [
                'options'=>'required'
            ]
        );
        // dd( $request->input('options')['items']);

        $parseOptions = $request->input('options')['items'];
        $options['type'] = $request->input('options')['type'];
        foreach($parseOptions as $items){
            $options['items'][] =$items;
        }

        // dd($options);
    }

    // order_in_variable count
    $order_in_variable_count  = UssdTemplate::where('event_id',$eventId)->count()+1;
    // dd($request->all());
        $ussdtemplate =new UssdTemplate([
            'event_id' =>$eventId,
            "user_id"  => auth()->id(),
            "input_type"  => $request->input('input_type'),
            'options'=> json_encode($options),
            'description'=> $request->input('description'),
            'name'=> $request->input('name'),
            'required'=> $request->input('required') !=null ? 1 : 0,
            'min_length'=> $request->input('min_length',0),
            'max_length'=> $request->input('max_length',10),
            'default_value'=> $request->input('default_value',''),
            'order_in_variable'=> $order_in_variable_count,
            'hidden_text'=> $request->input('hidden_text') ?? 0
        ]);

        $ussdtemplate->save();
        return redirect()->back();
        
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
