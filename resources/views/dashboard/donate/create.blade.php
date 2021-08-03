@extends('layouts.dashboard')

@section('content')

    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-6 col-sm-12">
                <h2>Donations
                    <small class="text-muted">Welcome to Nuset Application</small>
                </h2>
            </div>
            <div class="col-lg-5 col-md-6 col-sm-12">
                <ul class="breadcrumb float-md-right">
                    <li class="breadcrumb-item"><a href="{{ route('event.index') }}"><i
                                class="zmdi zmdi-home"></i>Events</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0);">Donatation</a></li>
                </ul>
            </div>
        </div>
    </div>
    {{-- widgets --}}
    @include('dashboard.partial._widget')
    <div class="row clearfix">

        <div class="col-lg-5 col-md-5 col-sm-12">
            <div class="card">
                <div class="header">
                    <h2>Recents Donation Events</h2>
                </div>
                <div class="body">
                    <div class="col-lg-12 col-md-12">
                        <div class="card">
                            <div class="header">
                                <h2> {{ $donationEvent->name }} <small>{{ $donationEvent->description }} </small> </h2>
                            </div>
                            <div class="body">
                                <ul class="list-group" id="sortable1">
                                    @foreach ($variables as $variable)
                                        <li class="list-group-item list-group-bg-pink item my-handle"
                                            data-itemNumber={{ $variable->order_in_variable }}
                                            variableId={{ $variable->id }}>

                                            <div class="variable" style="display: flex;paddng:5px; align-items:center">

                                                <div class="icons">
                                                    <i class="material-icons">blur_circular</i>
                                                </div>

                                                <div class="description" style="margin-left: 4px;width:100%">
                                                    <div class="name"><strong> {{ $variable->name }} </strong></div>

                                                    <div class="description">
                                                        {{ $variable->description }}
                                                    </div>
                                                    <div class="infor" style="width:90%">
                                                        <span class="badge bg-cyan">
                                                            {{ $variable->input_type }}
                                                        </span>

                                                        @if ($variable->input_type == 'single')
                                                            {{-- <strong> <i class="material-icons">skip_next</i> <span class="icon-name"></span></strong> --}}
                                                            @foreach ($variable->options->items as $item)

                                                                @if (isset($item->skip) && $item->skip != null)
                                                                    <span class="badge bg-orange" style="">
                                                                        {{ $item->skip }}
                                                                    </span>
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>

                                            </div>

                                        </li>
                                    @endforeach

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-lg-7 col-md-7 col-sm-12">
            <form method="POST" action="{{ route('template.create', ['eventId' => $donationEvent->id]) }}"
                class="needs-validation" enctype="multipart/form-data">
                <div class="card">
                    <div class="header">
                        <h2>Create Variable</h2>
                    </div>
                    <div class="body">


                        {{ csrf_field() }}
                        <div class="card">

                            <div class="body">

                                <div class="row clearfix">

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="form-line">

                                                <input type="text" name="name"
                                                    class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}"
                                                    value="{{ old('name') }}" placeholder=" Name">
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('name') }}
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="form-line">

                                                <select name="input_type" class="form-control show-tick input_type {{ $errors->has('input_type') ? ' is-invalid' : '' }}">
                                                    <option value="">Select Input type</option>
                                                    <option value="single">Single</option>
                                                    <option value="number">Number</option>
                                                    <option value="decimals">Decimals</option>
                                                    <option value="plain">Plain Text</option>
                                                </select>
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('input_type') }}
                                                </div>

                                            </div>
                                        </div>
                                    </div>




                                </div>

                                <div class="row clearfix demo-checkbox">

                                    <div class="col-md-4">

                                        <div class="form-line">
                                            <input type="checkbox" id="checkbox_1" name="required" value="{{ old('required') }}"/>
                                            <label for="checkbox_1">Required</label>
                                        </div>
                                    </div>

                                    <div class="col-md-4">

                                        <div class="form-line">
                                            <input type="checkbox" value="" name="hidden_text" id="checkbox_hide" />
                                            <label for="checkbox_hide">Hidden Text</label>
                                        </div>
                                    </div>

                                </div>

                                <div class="row clearfix">

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <h6>Description</h6>
                                            <div class="form-line">
                                                <textarea name="description" value="{{ old('bio') }}"
                                                    class="form-control no-resize {{ $errors->has('description') ? ' is-invalid' : '' }}"
                                                     rows="3" placeholder="Please type description"></textarea>
                                                <div class="invalid-feedback">{{ $errors->first('description') }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>



                                </div>


                            </div>
                        </div>

                    </div>
                </div>


                {{-- Single Choice --}}
                <div class="card disableSingle {{$errors->has('options') ? 'd-block': 'd-none'}}">
                    <div class="header">
                        <h2> Single Choose :<small class="{{$errors->has('options')? 'alert alert-danger': '' }}">{{$errors->has('options') ? $errors->first('options'):''}} </small> </h2>
                    </div>
                    <div class="body">
                        <div class="row clearfix addOption">
                          {{-- Add single options --}}
                        </div>
                        <div class="row ml-2 mt-2">
                            <div class="btn btn-primary" id="addSingleOption">ADD</div>
                        </div>
                    </div>
                </div>

                {{-- Min & Max --}}
                <div class="card disablePlain d-none">
                    <div class="header">
                        <h2> Max & Min </h2>
                    </div>
                    <div class="body">
                        <div class="row clearfix">
                            <div class="col-md-6">
                                <div class="form-line">
                                    <input type="number" id="mini" value="0" class="form-control" />
                                    <label for="checkbox_1">Minimum</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-line">
                                    <input type="number" id="max" value="10" class="form-control" />
                                    <label for="checkbox_1">Maximum</label>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <button class="btn btn-raised btn-primary waves-effect" type="submit">SUBMIT</button>

            </form>
        </div>
    </div>

    {{-- push sortable to the footer after jquery finish loading --}}
    @push('js')
        <script src="{{ asset('js/app.donation.js') }}" defer></script>
    @endpush
@endsection
