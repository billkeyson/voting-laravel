<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request as HttpRequest;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;

use Illuminate\Http\Request;

use App\Event;
use App\Nominee;
use App\Transaction;


class PaymentController extends Controller
{
    //

    public function charge(Request $request,$nomineeId)
    {
        // $request->validator(
        //     [
        //         "vote_count"=>$request->input('vote_count'),
        //         'payment_type'=>$request->input('payment_type'),
        //         'payment_channel'=>$request->input('payment_channel'),
        //         'payment_channel'=>$request->input('mobile_number')
        //     ]
        //     [

        //         ''
        // ]);

        $nominee = Nominee::findOrFail($nomineeId);
        if($request->input('payment_method')=='mobile_money')
        {
            $channel = 
                [
                    "phone" => $request->input('mobilenumber'),
                    "provider" => $request->input('network_provider')
                ];
        }
        else if($request->input('payment_method')=='card'){
            $channel = 
          
                [
                    "code" => "",
                    "account_number" => ""
                ];
        }else{
            dd('failed');
        }

        // convert amount to peaweas
        $amount = ($nominee->event->unit_cost * $request->input('vote_counts'))*100;
        // dd($amount);
        // charge request body
        $body = [
            "amount"=> $amount, 
            "email"=>$request->input('email') ?? 'billkeyson@gmail.com',
            "currency"=> "GHS"
            ];
        // update body
        $body[$request->input('payment_method')]=$channel;
        // dd($body);
        // Make http request
        try {
            $headers = [
                'Authorization' => 'Bearer '.env('PAYSTACK_LIVE_SECRET_KEY'),
                'Content-Type' => 'application/json'
            ];
            $client = new Client(['headers' => $headers]);
    
            $response = $client->request('POST', 'https://api.paystack.co/charge',  ['body'=>json_encode($body)]);
            $parse_response = json_decode($response->getBody()->getContents());
            // dd($parse_response);
            if($response->getStatusCode() && $parse_response->status)
            {
                
                // First time init transactions
                Transaction::create(
                    [
                        'event_id'=>$nominee->event->id,
                        'nominee_id'=>$nominee->id,
                        'amount'=>$amount,
                        'total_count'=>$request->input('vote_counts'),
                        'reference'=>$parse_response->data->reference,
                        'payment_channel'=>$request->input('network_provider'),
                        'payment_method'=>$request->input('payment_method'),
                        'customer_mobile'=>$request->input('mobilenumber'),
                        'currency'=>"GHS",
                        'status'=>"pending"
                    ]);

                if($parse_response->data->status=='pay_offline')
                {
                    $request->session()->flash('info',$parse_response->data->display_text);
                    return redirect()->route('payment.complete', ['referenceId'=>$parse_response->data->reference]);
                }
                else if($parse_response->data->status=='send_otp'){
                    $request->session()->flash('info',$parse_response->data->display_text);
                    return redirect()->route('payment.otp', ['referenceId'=>$parse_response->data->reference]);
                    
                }
                   
            }
             
            $request->session()->flash('error','Payment Failed. Please Try again !');
            return redirect()->back();
        } catch (RequestException $th) {
            
            $request->session()->flash('error','Payment Failed. Please Try again !');
            return redirect()->back();
            // dd(json_decode($th->getResponse()->getBody()));
        }
        catch (Exception $th) {
            
            $request->session()->flash('error','Payment Failed. Please Try again !');
            return redirect()->back();
            // dd(json_decode($th->getResponse()->getBody()));
        }
       

    }

    // send otp
    public function send_otp(Request $request ,$referenceId){
            // header
            $headers = [
                'Authorization' => 'Bearer '.env('PAYSTACK_TEST_SECRET_KEY'),
                'Content-Type' => 'application/json'
            ];
            // Request Body
            $body = [
                'otp'=>$request->input('otp'),
                'reference'=>$referenceId
            ];
            try {
                $client = new Client(['headers' => $headers]);
                $response = $client->request('POST', 'https://api.paystack.co/charge/submit_otp',  ['body'=>json_encode($body)]);
                $parse_response = json_decode($response->getBody()->getContents());
                dd($parse_response);
                // If the otp is correct
                if($parse_response->status)
                {

                }
            } catch (RequestException $th) {
                dd(json_decode($th->getResponse()->getBody()));

            }
           

    }

    public function verify($referenceId)
    {

        return view('payments.verify',['reference'=>$referenceId]);
    }

    public function complete()
    {
        return view('payments.complete');
    }
}


            // dd($parse_response);
            // $promise = $client->sendAsync($response);

            // dd($promise);
            // $promise->then(
            //     function (ResponseInterface $res) {
            //         var_dump($res->getStatusCode() . "\n");
            //     },
            //     function (RequestException $e) {
            //         var_dump($e->getMessage() . "\n");
            //         var_dump($e->getRequest()->getMethod());
            //     }
            // );