@extends('backendlayout.master')
@extends('backendlayout.header')
@extends('backendlayout.leftmenu')
@extends('backendlayout.footer')
@section('userscontent')
    @extends('backendlayout.flashmessagecollection')
    @if(\Request::segment(3)=='edit')
        <div class="search-breadcrumb-only">
            <div class="row">
                <div class="col-lg-12">
                    <ol class="breadcrumb">
                        <li><a href="{{url('dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                        <li><a href="{{URL('doctor-charge')}}">Doctor Charges</a></li>
                        <li class="active">Edit Doctor Charge</li>
                    </ol>
                </div>
            </div>
        </div>
    @else
        <div class="search-breadcrumb-only">
            <div class="row">
                <div class="col-lg-12">
                    <ol class="breadcrumb">
                        <li><a href="{{url('dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                        <li><a href="{{URL('doctor-charge')}}">Doctor Charges</a></li>
                        <li class="active">Add Doctor Charge</li>
                    </ol>
                </div>
            </div>
        </div>
    @endif
    <section class="content">
        <div class="row">
            <div class="col-md-8">
                <div class="box">

                    <div class="box-body">
                        @if(count($doctorCharges)>0)
                            <table id="example1" class="table table-hover table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>S.N</th>
                                    <th>Title</th>
                                    <th>Doctor Charge</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>

                                <?php
                                $i = $doctorCharges->firstItem();
                                ?>
                                @foreach($doctorCharges as $key=>$doctorCharge)
                                    <?php  $segment2 = Request::segment(2);  ?>
                                    <tr @if($doctorCharge->id==$segment2) class="success" @endif>
                                        <td>{{$i++}}.
                                        </td>

                                        <td>
                                            {{ ucfirst($doctorCharge->title) }}
                                        </td>

                                        <td>
                                            {{ $doctorCharge->charge }}
                                        </td>

                                        <td>
                                            <a href="{{ URL::to('doctor-charge/' . $doctorCharge->id . '/edit') }}">
                                                <button type="button" class="btn btn-default btn-flat  ">
                                                    <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                                                </button>
                                            </a>

                                            @if(Auth::User()->id == 1)
                                                <a href="{{URL::to('remove-doctor-charge',array($doctorCharge->id))}}"
                                                   onclick="return confirm('Are you sure you want to delete this record?')">
                                                    <button type="button" class="btn btn-danger btn-flat  ">
                                        <span class="glyphicon glyphicon-trash"
                                              aria-hidden="true"></span>
                                                    </button>
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                            {{$doctorCharges->render()}}

                        @else
                            <div class="alert alert-danger">
                                <strong style="padding-left: 150px"> Sorry ! No record found
                                </strong>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
            <div class="col-md-4">
                @if(\Request::segment(3)=='edit')
                    @include('backendview/admin/doctorCharge/edit')
                @else
                    @include('backendview/admin/doctorCharge/create')
                @endif
            </div>
        </div>
    </section>
@stop
