@extends('layouts.dashboard')

@section('content')

    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-6 col-sm-12">
                <h2>Event Page
                    <small class="text-muted">Welcome to Nuset Application</small>
                </h2>
            </div>
            <div class="col-lg-5 col-md-6 col-sm-12">
                <ul class="breadcrumb float-md-right">
                    <li class="breadcrumb-item"><a href="index.html"><i class="zmdi zmdi-home"></i> Home</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Events</a></li>
                </ul>
            </div>
        </div>
    </div>
    {{-- widgets --}}
    @include('dashboard.partial._widget')

    <div class="container-fluid">

        @if (session()->has('success'))

            <div class="alert alert-info alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                {{ session()->get('success') }}
            </div>
        @elseif(session()->has('error'))
            <div class="alert alert-warning alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                {{ session()->get('error') }}
            </div>
        @endif
        <div class="col-lg-12 col-md-12">
            <div class="card ">
                <div class="header">
                    <h2>Recents Events</h2>
                </div>
                <div class="body">
                    
                    <ul class="inbox-widget list-unstyled clearfix">
                        @forelse ($events as $event)
                        <li class="inbox-inner"><a href="javascript:void(0);">
                            <div class="inbox-item">
                                <div class="inbox-img"> <img src="assets/images/xs/avatar3.jpg" alt=""> </div>
                                <div class="inbox-item-info">
                                    <p class="author">
                                        @if($event->event_type=='awards')
                                        <a href="{{route('category.index',['eventId'=>$event->id])}}"> {{$event->name}} <span class="badge badge-info">{{$event->event_type}}</span>  </a>
                                        
                                        @elseif($event->event_type=='pagents')
                                        <a href="{{route('nominee.index',['eventId'=>$event->id])}}"> {{$event->name}} <span class="badge badge-success">{{$event->event_type}}</span> </a>
                                        
                                        @else
                                        <a href="{{route('donate.index',['eventId'=>$event->id])}}"> {{$event->name}} <span class="badge badge-primary">{{$event->event_type}}</span></a>
                                        
                                    @endif
                                    </p>
                                    <p class="inbox-message">
                                        {{$event->description}}
                                    </p>
                                    <p class="inbox-date">{{$event->created_at->diffForHumans()}}</p>
                                </div>
                            </div>
                        </a></li>
                        @empty
                            No Events available
                        @endforelse

                    </ul>
                </div>
            </div>
        </div>


    </div>
@endsection
