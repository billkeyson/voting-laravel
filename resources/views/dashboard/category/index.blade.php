@extends('layouts.dashboard')

@section('content')

    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-6 col-sm-12">
                <h2>Category
                    <small class="text-muted">Welcome to Nuset Application</small>
                </h2>
            </div>
            <div class="col-lg-5 col-md-6 col-sm-12">
                <ul class="breadcrumb float-md-right">
                    <li class="breadcrumb-item"><a href="{{ route('event.index') }}"><i
                                class="zmdi zmdi-home"></i>Events</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);">{{ $eventName }}</a></li>
                    <li class="breadcrumb-item active">Category</li>

                </ul>
            </div>
        </div>
    </div>
    {{-- widgets --}}
    @include('dashboard.partial._widget')
    <div class="row clearfix">

    <div class="col-lg-8 col-md-8 col-sm-12">
        <div class="card">
            <div class="header">
                <h2>Recents Category</h2>
            </div>
            <div class="body">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="table-responsive social_media_table">

                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Media</th>
                                    <th>Name</th>
                                    <th>Created</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($categories as $category)
                                    <tr>
                                        <td>
                                            <span class="list-icon linkedin"><i class="zmdi zmdi-linkedin"></i></span>
                                        </td>
                                        <td>
                                            <span class="list-name"><a href="{{route('category.create',['catId'=>$category->id])}}">{{$category->name }}</a></span>
                                            <span class="text-muted">{{ $category->description }}</span>
                                        </td>

                                        <td>
                                            <span
                                                class="badge badge-success">{{ $category->created_at->diffForHumans() }}</span>
                                        </td>
                                    </tr>

                                @empty
                                    <tr>
                                        <td rowspan="3">
                                            No Categries available
                                        </td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <div class="col-lg-4 col-md-4 col-sm-12">
        <div class="card">
            <div class="header">
                <h2>Create Category</h2>
            </div>
            <div class="body">

                <form method="POST" action="{{ route('category.store',['eventId'=> $eventId])}}" class="needs-validation"
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
                                            value="{{ old('name') }}" placeholder="Category Name">
                                        <div class="invalid-feedback">
                                            {{ $errors->first('name') }}
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="row clearfix">

                            <div class="col-md-12">
                                <div class="form-group">
                                    <h6>Category Description</h6>
                                    <div class="form-line">
                                        <textarea name="description" value="{{ old('description') }}"
                                            class="form-control {{ $errors->has('description') ? ' is-invalid' : '' }}"
                                            cols="4" rows="3">
                                            </textarea>
                                        <div class="invalid-feedback">{{ $errors->first('description') }}
                                        </div>
                                    </div>
                                </div>
                            </div>



                        </div>

                        <button class="btn btn-raised btn-primary waves-effect"
                            type="submit">SUBMIT</button>

                    </div>
                </div>
            </form>

            </div>
        </div>
    </div>
</div>


@endsection
