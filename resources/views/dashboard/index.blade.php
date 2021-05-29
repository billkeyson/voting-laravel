@extends('layouts.dashboard')


@section('content')
<div class="block-header">
    <div class="row">
        <div class="col-lg-7 col-md-6 col-sm-12">
            <h2>Dashboard-Page
            <small class="text-muted">Welcome to Nuset Application</small>
            </h2>
        </div>
        <div class="col-lg-5 col-md-6 col-sm-12">
            <ul class="breadcrumb float-md-right">
                <li class="breadcrumb-item"><a href=""><i class="zmdi zmdi-home"></i> Home</a></li>
            </ul>
        </div>
    </div>
</div>
{{-- widgets --}}
@include('dashboard.partial._widget')    

<div class="container-fluid">
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="body">
                    
                    <div class="row clearfix">
                        <div class="col-sm-12 col-md-12 col-lg-12">
                            <div class="card">
                                <div class="header">
                                    <h2>Recent Profiles <small>Members Status</small> </h2>
                                    <ul class="header-dropdown m-r--5">
                                        <li class="dropdown"><a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more-vert"></i> </a>
                                            <ul class="dropdown-menu slideUp ">
                                                <li><a href="javascript:void(0);">Action</a></li>
                                                <li><a href="javascript:void(0);">Another action</a></li>
                                                <li><a href="javascript:void(0);">Something else</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                                <div class="body table-responsive members_profiles">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th style="width:60px;">Member</th>
                                                <th>Name</th>
                                                <th>Status</th>
                                                <th>Created</th>                                    
                                                <th>Modified</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <img class="rounded-circle" src="assets/images/xs/avatar1.jpg" alt="user" width="40"> </td>
                                                <td>
                                                    <a href="javascript:void(0);">Logan</a>
                                                </td>
                                                <td>{{Date('y')}}</td>
                                                <td>23</td>                                   
                                                <td>
                                                    <span class="label label-warning">WAIT APPROVEL</span>
                                                </td>
                                              
                                            </tr>
                                            <tr>
                                                <td>
                                                    <img class="rounded-circle" src="assets/images/xs/avatar2.jpg" alt="user" width="40"> </td>
                                                <td>
                                                    <a href="javascript:void(0);">Isabella</a>
                                                </td>
                                                <td>$350</td>
                                                <td>16</td>                                   
                                                <td>
                                                    <span class="label label-danger">SUSPENDED</span>
                                                </td>
                                               
                                            </tr>
                                            <tr>
                                                <td>
                                                    <img class="rounded-circle" src="assets/images/xs/avatar3.jpg" alt="user" width="40"> </td>
                                                <td>
                                                    <a href="javascript:void(0);">Jackson</a>
                                                </td>
                                                <td>$201</td>
                                                <td>11</td>                                   
                                                <td>
                                                    <span class="label label-danger">SUSPENDED</span>
                                                </td>
                                                 
                                            </tr>
                                            <tr>
                                                <td>
                                                    <img class="rounded-circle" src="assets/images/xs/avatar4.jpg" alt="user" width="40"> </td>
                                                <td>
                                                    <a href="javascript:void(0);">Victoria</a>
                                                </td>
                                                <td>$651</td>
                                                <td>28</td>                                   
                                                <td>
                                                    <span class="label label-danger">SUSPENDED</span>
                                                </td>
                                                
                                            </tr>
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>    


                </div>
            </div>
        </div>
    </div>
</div>   
    
@endsection