@extends('backendlayout.master')
@extends('backendlayout.header')
@extends('backendlayout.leftmenu')
@extends('backendlayout.footer')
@section('userscontent')
    @extends('backendlayout.flashmessagecollection')
    <section class="content-header">
        <div class="search-breadcrumb-only">
            <div class="row">
                <div class="col-md-10">
                    <ol class="breadcrumb">
                        <li><a href="{{url('dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                        <li><a href="{{URL('configuration/doctor/create')}}">System Setup</a></li>
                        <li class="active">Add Doctor</li>
                    </ol>
                </div>
                <div class="col-md-2">
                    <a href="{{URL::action('BackEndController\DoctorController@create')}}">
                        <button type="button" class="btn btn-success btn-flat  pull-right ">
                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add Doctor
                        </button>
                    </a>
                </div>
            </div>
        </div>

    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                    </div>
                    <div class="box-body">
                        @if(count($viewDoctor)>0)
                            <table id="example1" class="table table-hover table-bordered table-striped">
                                <thead>
                                <tr>

                                    <th class="col-lg-1">S.N</th>
                                    <th class="col-lg-4">Doctor Name</th>
                                    <th class="col-lg-2">NMC No.</th>
                                    <th class="col-lg-1">Status</th>
                                    <th class="col-lg-2">Created At</th>
                                    <th class="col-lg-2">Actions</th>
                                    <th class="col-lg-2=1">Shift</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $i = $viewDoctor->firstItem();
                                ?>

                                @foreach($viewDoctor as $key=>$doctorData)
                                    <tr>
                                        <td>
                                            {{$i++}}.
                                        </td>

                                        <td>
                                            <a href="{{URL::to('configuration/doctor/' .$doctorData->id)}}">
                                                {{ucfirst($doctorData->first_name)}} {{ucfirst($doctorData->middle_name)}}
                                                {{ucfirst($doctorData->last_name)}}
                                            </a>
                                            <br>
                                            <i class="fa fa-phone" aria-hidden="true">&nbsp;
                                                &nbsp;{{$doctorData->contact_no}} &nbsp;
                                            </i>
                                        </td>

                                        <td>
                                            {{$doctorData->nmc_no}}
                                        </td>

                                        <td>
                                            @if($doctorData->status=='Active')
                                                <a href="{{URL::to('configuration/doctor/status',array($doctorData->id))}}">
                                                    <span class="label label-success">Active</span>
                                                </a>

                                            @elseif($doctorData->status=='Inactive')
                                                <a href="{{URL::to('configuration/doctor/status',array($doctorData->id))}}"
                                                   class="label label-danger">
                                                    <span class="label label-danger">Inactive</span>
                                                </a>
                                            @endif

                                        </td>

                                        <td>
                                            {{changeCreatedDateToNepali($doctorData->created_at)}}
                                        </td>

                                        <td>

                                            <a href="{{ URL::to('configuration/doctor/' . $doctorData->id . '/edit') }}"
                                               title="Edit Doctor Details"
                                               data-rel="tooltip">
                                                <button type="button" class="btn btn-default btn-flat  ">
                                                    <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                                                </button>
                                            </a>
                                            <a href="{{URL::to('configuration/doctor/' .$doctorData->id)}}"
                                               title="View Doctor Details"
                                               data-rel="tooltip">
                                                <button type="button" class="btn btn-default btn-flat ">
                                                    <span class="glyphicon glyphicon-zoom-in" aria-hidden="true"></span>
                                                </button>
                                            </a>


                                            @if(Auth::user()->user_type_id=='1')
                                                <a href="{{URL::to('remove-doctor',array($doctorData->id))}}"
                                                   onclick="return confirm('Are you sure you want to delete this record?')">
                                                    <button type="button" class="btn btn-danger btn-flat  ">
                                    <span class="glyphicon glyphicon-trash"
                                          aria-hidden="true"></span>
                                                    </button>
                                                </a>
                                            @else
                                            @endif
                                        </td>


                                        <td>

                                            <a href="{{URL::to('configuration/assign/shift/' .$doctorData->id)}}"
                                               title="Assign Shift"
                                               data-rel="tooltip">
                                                <button type="button" class="btn btn-default btn-flat ">Assign
                                                    <!-- <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> -->
                                                </button>
                                            </a>


                                        </td>

                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {{$viewDoctor->render()}}
                        @else
                            <div class="alert alert-danger">
                                <strong style="padding-left: 300px"> Sorry ! No record found
                                </strong>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    <style>
        a:link {
            text-decoration: none;
        }

        a:visited {
            text-decoration: none;
        }

        a:hover {
            text-decoration: none;
            color: green;
        }

        a:active {
            text-decoration: none;
        }
    </style>

@endsection