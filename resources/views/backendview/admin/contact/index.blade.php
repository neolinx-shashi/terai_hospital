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
                        @if(Auth::User()->id == 1)
                            <li><a href="{{URL('contact')}}">Contact</a></li>
                        @else
                            <li><a href="{{URL('contact-view')}}">Contact</a></li>
                        @endif
                        <li class="active">Edit Contact</li>
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
                        @if(Auth::User()->id == 1)
                            <li><a href="{{URL('contact')}}">Contact</a></li>
                        @else
                            <li><a href="{{URL('contact-view')}}">Contact</a></li>
                        @endif
                        <li class="active">Add Contact</li>
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
                        @if(count($contacts)>0)
                            <table id="example1" class="table table-hover table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>S.N</th>
                                    <th>Contact Name</th>
                                    <th>Contact Number</th>
                                    <th>Contact Type</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>

                                <?php
                                $i = $contacts->firstItem();
                                ?>
                                @foreach($contacts as $key=>$contact)
                                    <?php  $segment2 = Request::segment(2);  ?>
                                    <tr @if($contact->id==$segment2) class="success" @endif>
                                        <td>{{$i++}}.
                                        </td>
                                        <td>
                                            {{ ucfirst($contact->name) }}
                                        </td>

                                        <td>
                                            {{ $contact->contact }}
                                        </td>

                                        <td>
                                            {{ ucfirst($contact->type) }}
                                        </td>

                                        <td>
                                            <a href="{{ URL::to('contact/' . $contact->id . '/edit') }}">
                                                <button type="button" class="btn btn-default btn-flat  ">
                                                    <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                                                </button>
                                            </a>

                                            @if(Auth::User()->id == 1)
                                                <a href="{{URL::to('remove-contact',array($contact->id))}}"
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
                            {{$contacts->render()}}

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
                    @include('backendview/admin/contact/edit')
                @else
                    @include('backendview/admin/contact/create')
                @endif
            </div>
        </div>
    </section>
@stop
