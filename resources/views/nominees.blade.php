@extends('layouts.app')


@section('jumbotron')
 
@component('layouts.components.jumbotron',['title'=>$eventName.'<br /> <strong>Nominees</strong>','jumbotrons'=>$jumbotronList])
    
@endcomponent    
@endsection


@section('content')
@foreach ($nominees as $nominee)
<div class="col-md-4">

    <div class="card mb-4 ">
        <div class="card-body">

            <h3 class="card-title" style="font-weight: 9000;"><a
                href="{{ route('welcome.nominees', ['eventType' => $nominee->name, 'eventId' => $nominee->id]) }}"
                class="links">{{ $nominee->name }}</a>
            </h3>

            <div class="row" style="background-color:#f6f9fe;height:100%;padding:30px">
                <div class="col-md-4">
                    <img src="{{ asset('assets\images\image-gallery\thumb\avatar-1.png') }}"
                        class="rounded-circle" alt="{{ $nominee->name }}" width="80px"
                        height="80px">
                </div>
                <div class="col-md-8"
                    style="display: flex;justify-content:center;align-items:center;font-weight: 1000;font-size: large;">
                    <p class="card-text"></p>

                </div>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection