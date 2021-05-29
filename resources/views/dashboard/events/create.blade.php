@extends('layouts.dashboard')
@section('content')

    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-6 col-sm-12">
                <h2>Event Page
                    <small class="text-muted">Welcome to Nexa Application</small>
                </h2>
            </div>
            <div class="col-lg-5 col-md-6 col-sm-12">
                <ul class="breadcrumb float-md-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}"><i class="zmdi zmdi-home"></i>
                            Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('event.index') }}">Event</a></li>
                    <li class="breadcrumb-item active">Create</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container-fluid">


        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <form method="POST" action="{{ route('event.store') }}" class="needs-validation"
                    enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="card">
                  ` 
                  
                        <div class="body">
                           
                            <div class="row clearfix">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" name="name"
                                                class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                                value="{{ old('name') }}" placeholder="Event Name">
                                            <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="number" name="unit_cost"
                                                class="form-control {{ $errors->has('unit_cost') ? 'is-invalid' : '' }}"
                                                value="{{ old('unit_cost') }}" placeholder="Unit Cost">
                                            <div class="invalid-feedback">{{ $errors->first('unit_cost') }}</div>

                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="row clearfix">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select name="event_type" class="form-control">
                                                <option value="awards">Awards</option>
                                                <option value="pagents">Pagents</option>
                                                <option value="donation">Donation</option>
                                            </select>
                                            <div class="invalid-feedback">{{ $errors->first('event_type') }}</div>

                                        </div>
                                    </div>
                                </div>


                                 <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="date" name="expiry_date"
                                                class="form-control {{ $errors->has('expiry_date') ? 'is-invalid' : '' }}"
                                                value="{{ old('expiry_date') }}" placeholder="Expiry Date">
                                            <div class="invalid-feedback">{{ $errors->first('expiry_date') }}</div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>

                            <div class="row clearfix">

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <h6>Event Description</h6>
                                        <div class="form-line">
                                            <textarea name="description" value="{{ old('description') }}"
                                                class="form-control {{ $errors->has('description') ? ' is-invalid' : '' }}"
                                                cols="10" rows="10"></textarea>
                                            <div class="invalid-feedback">{{ $errors->first('description') }}</div>
                                        </div>
                                    </div>
                                </div>



                            </div>

                            <div class="row clearfix">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <h5>Select Event Logo</h5>
                                        <div class="form-line">
                                            <input type="file" name="logo" class="form-control" placeholder="Unit Cost">
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
@endsection
