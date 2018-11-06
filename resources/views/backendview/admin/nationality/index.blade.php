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
                        <li><a href="{{URL('nationality-setup')}}">Nationality</a></li>
                        <li class="active">Edit Nationality</li>
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
                        <li><a href="{{URL('nationality-setup')}}">Nationality</a></li>
                        <li class="active">Add Nationality</li>
                    </ol>
                </div>
            </div>
        </div>
    @endif
    <section class="content">
        <div class="row">
            <div class="col-xs-8">
                <div class="box">
                    <div class="box-header">
                    </div>
                    <div class="box-body">
                        <table id="example1" class="table table-hover table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>S.N</th>
                                <th>Short Form</th>
                                <th>Country Name</th>
                                <th>Calling Code</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            
                            @foreach($nationality as $key=>$nationalityData)
                               <?php  $segment2 =  Request::segment(2);  ?>
                                    <tr @if($nationalityData->id==$segment2) class="success" @endif>
                                    <td>
                                        {{$key+1}}.
                                    </td>

                                    <td>
                                        {{$nationalityData->short_form_name}}
                                    </td>

                                    <td>
                                        {{$nationalityData->country_name}}

                                    </td>

                                    <td>
                                        {{$nationalityData->calling_code}}
                                    </td>

                                    <td>
                                        <a href="{{ URL::to('nationality-setup/' . $nationalityData->id . '/edit') }}">
                                            <button type="button" class="btn btn-default btn-flat  ">
                                                <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                                            </button>
                                        </a>

                                        <a href="{{URL::to('remove-nationality',array($nationalityData->id))}}"
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
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                @if(\Request::segment(3)=='edit')
                    @include('backendview/admin/nationality/edit')
                @else
                    @include('backendview/admin/nationality/create')
                @endif
            </div>
        </div>
    </section>
@stop