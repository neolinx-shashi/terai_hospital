@extends('backendlayout.master')
@extends('backendlayout.header')
@extends('backendlayout.leftmenu')
@extends('backendlayout.footer')
@section('userscontent')
    @extends('backendlayout.flashmessagecollection')
    <section class="content-header">
        <div class="search-breadcrumb-only">
            <div class="row">
                @if(\Request::segment(4)=='edit')
                    <div class="col-lg-12">
                        <ol class="breadcrumb">
                            <li><a href="{{url('dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                            <li><a href="{{URL('ward/ward-details')}}">Ward List</a></li>
                            <li class="active">Edit Ward</li>
                        </ol>
                    </div>
                @else
                    <ol class="breadcrumb ">
                        <li><a href="{{url('dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                        <li><a href="{{URL('ward/ward-details')}}">Ward List</a></li>
                        <li class="active">Create Ward</li>
                    </ol>
                @endif

            </div>
        </div>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-8">
                <div class="box">
                    <div class="box-header">
                    </div>
                    <div class="box-body">

                        @if(count($wards)>0)
                            <table id="example1" class="table table-hover table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th style="width: 50px;">S.N</th>
                                    <th>Ward Name</th>
                                    <th>Ward Description</th>
                                    <th>Total Rooms</th>
                                    <th>Total Beds</th>
                                    <th class="col-md-2">Actions</th>
                                </tr>
                                </thead>
                                <tbody>

                                <?php
                                $i = $wards->firstItem();
                                ?>
                                @foreach($wards as $key=>$ward)
                                    <?php  $segment2 = Request::segment(3);  ?>
                                    <tr @if($ward->id==$segment2) class="success" @endif>
                                        <td>{{$i++}}.
                                        </td>

                                        <td>
                                            {{ucfirst($ward->ward_name)}}
                                        </td>

                                        <td>
                                        @if($ward->ward_desc==null)
                                        <span class="label label-default">Not available</span>
                                        @else
                                            {{ $ward->ward_desc }}
                                            @endif
                                        </td>

                                        <td>
                                            <?php $roomCount = 0; ?>
                                            @foreach($rooms as $room)
                                                @if($room->isOfWard->id == $ward->id)
                                                    <?php $roomCount++ ?>
                                                @endif
                                            @endforeach
                                            {{ $roomCount }}
                                        </td>

                                        <td>
                                            <?php $bedCount = 0; ?>
                                            @foreach($beds as $bed)
                                                @if($bed->isOfWard->id == $ward->id)
                                                    <?php $bedCount++ ?>
                                                @endif
                                            @endforeach
                                            {{ $bedCount }}
                                        </td>

                                        <td>
                                            <a href="{{ URL::to('ward/ward-details/' . $ward->id ).'/edit' }}"
                                               data-toogle="tooltip" data-placement="top" title="Edit Ward Details">
                                                <button type="button" class="btn btn-default btn-flat  ">
                                                    <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                                                </button>
                                            </a>

                                            <a href="{{URL::to('ward/ward-detail',array($ward->id))}}"
                                               onclick="return confirm('Are you sure you want to delete this record?')"
                                               data-toogle="tooltip" data-placement="top" title="Delete Ward Details" hidden>
                                                <button type="button" class="btn btn-danger btn-flat">
                                                <span class="glyphicon glyphicon-trash"
                                                      aria-hidden="true"></span>
                                                </button>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                            {{ $wards->render() }}

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
                @if(\Request::segment(4)=='edit')
                    @include('backendview.ward.edit')
                @else
                    @include('backendview.ward.create')
                @endif
            </div>
        </div>
    </section>
@stop