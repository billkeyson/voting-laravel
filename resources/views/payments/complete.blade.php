@extends('layouts.app')
@section('content')
<div class="col-md-12">

        <div style="display: flex;align-items:center;justify-content: center;flex-direction: column">
            <img 

                src="{{ asset('assets\images\sm\payments.png') }}"
                class="rounded-circle"
                alt=""
                width="150px"
                height="150px" 
            />
            <div style="font-weight:950;margin:10px">
                Please complete the authorisation process by inputting your PIN on your mobile device
                <span style="color: rgb(230, 69, 69)">  Thank You For Voting</span>
            </div>
        </div>
        <div class="col-md-12">
            <a href="{{route('welcome')}}" class="btn btn-primary">Back To Events</a>
        </div>
    

</div>

    
@endsection