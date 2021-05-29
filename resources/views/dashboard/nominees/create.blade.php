@extends('layouts.dashboard')


@section('content')
<div class="block-header">
    <div class="row">
        <div class="col-lg-7 col-md-6 col-sm-12">
            <h2>Nominee Page
                <small class="text-muted">Welcome to Nuset Application</small>
            </h2>
        </div>
        <div class="col-lg-5 col-md-6 col-sm-12">
            <ul class="breadcrumb float-md-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">
                    <i class="zmdi zmdi-home"></i>
                        Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('event.index') }}">Event</a></li>
                <li class="breadcrumb-item active">Create Nominee</li>
            </ul>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="card">
        <div class="header">
            <h2>Create Nominee</h2>

            <div class="header-dropdown m-r--5">
                <a class="btn  btn-raised bg-black waves-effect waves-light" href="{{route('event.index')}}">VIEW EVENTS</a>
            </div>

        </div>
        
        <div class="body">

            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <form method="POST" action="{{ route('nominee.store') }}" class="needs-validation"
                        enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="card">
                      
                            <div class="body">
                               
                                <div class="row clearfix">
        
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="form-line">
        
                                                <input type="text" name="name"
                                                    class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}"
                                                    value="{{ old('name') }}" placeholder="Nominee Name">
                                                <div class="invalid-feedback">{{ $errors->first('name') }}</div>
        
                                            </div>
                                        </div>
                                    </div>
        
                                </div>
        
                                <div class="row clearfix">
        
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <h6>Nominee Bio</h6>
                                            <div class="form-line">
                                                <textarea 
                                                    name="bio"
                                                    value="{{ old('bio') }}"
                                                    class="form-control {{ $errors->has('bio') ? ' is-invalid' : '' }}"
                                                    cols="10" 
                                                    rows="10"
                                                    >
                                                </textarea>
                                                <div class="invalid-feedback">{{ $errors->first('bio') }}</div>
                                            </div>
                                        </div>
                                    </div>
        
        
        
                                </div>
        
                                <button class="btn btn-raised btn-primary waves-effect" type="submit">SUBMIT</button>
        
                            </div>
                        </div>
                    </form>
                </div>
            </div>


        </div>
    </div>

   
</div>
@endsection