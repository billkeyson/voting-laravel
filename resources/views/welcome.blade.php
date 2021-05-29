@extends('layouts.app')
@section('jumbotron')

@component('layouts.components.jumbotron',['title'=>'Events','jumbotrons'=>['Events']])
    
@endcomponent
    
@endsection
@section('content')
    
@foreach ($events as $event)
<div class="col-md-4">

    <div class="card mb-4 ">
        <div class="card-body">
            @if ($event->event_type == 'awards')
                <h3 class="card-title" style="font-weight: 9000;"><a
                        href="{{ route('welcome.categories', ['eventType' => $event->event_type, 'eventId' => $event->id]) }}"
                        class="links">{{ $event->name }}</a>
                </h3>
            @elseif($event->event_type=='pagents')
                <h3 class="card-title" style="font-weight: 9000;"><a
                        href="{{ route('welcome.nominees', ['eventType' => $event->event_type, 'eventId' => $event->id]) }}"
                        class="links">{{ $event->name }}</a>
                </h3>

            @endif

            <div class="row" style="background-color:#f6f9fe;height:100%;padding:30px">
                <div class="col-md-4">
                    <img src="{{ asset('assets\images\image-gallery\thumb\avatar-1.png') }}"
                        class="rounded-circle" alt="{{ $event->name }}" width="80px"
                        height="80px">
                </div>
                <div class="col-md-8"
                    style="display: flex;justify-content:center;align-items:center;font-weight: 1000;font-size: large;">
                    <p class="card-text">{{ $event->user->company_name }}</p>

                </div>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection
