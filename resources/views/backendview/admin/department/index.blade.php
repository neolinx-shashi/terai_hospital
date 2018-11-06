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
                        <li><a href="{{URL('department')}}">Department</a></li>
                        <li class="active">Edit Department</li>
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
                        <li><a href="{{URL('department')}}">Department</a></li>
                        <li class="active">Add Department</li>
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
                        @if(count($departments)>0)
                            <table id="example1" class="table table-hover table-bordered table-striped">
                                <thead>
                                <tr >
                                    <th>S.N</th>
                                    <th>Department Name/Code</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>

                                <?php
                                $i = $departments->firstItem();
                                ?>
                                @foreach($departments as $key=>$departmentsData)
                                <?php  $segment2 =  Request::segment(2);  ?>
                                    <tr @if($departmentsData->id==$segment2) class="success" @endif>
                                        <td>{{$i++}}.
                                        </td>
                                        <td>
                                            {{ucfirst($departmentsData->name)}}
                                            <br>
                                            <strong>{{ucfirst($departmentsData->department_code)}}</strong>
                                        </td>
                                        <td>
                                            {{ changeCreatedDateToNepali($departmentsData->created_at) }}
                                        </td>

                                        <td>
                                            <a href="{{ URL::to('department/' . $departmentsData->id . '/edit') }}">
                                                <button type="button" class="btn btn-default btn-flat  ">
                                                    <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                                                </button>
                                            </a>

                                            <a href="{{URL::to('remove-department',array($departmentsData->id))}}"
                                               onclick="return confirm('Are you sure you want to delete this record?')">
                                                <button type="button" class="btn btn-danger btn-flat  ">
                                        <span class="glyphicon glyphicon-trash"
                                              aria-hidden="true"></span>
                                                </button>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                            {{$departments->render()}}

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
                    @include('backendview/admin/department/edit')
                @else
                    @include('backendview/admin/department/create')
                @endif
            </div>
        </div>
    </section>
@stop
