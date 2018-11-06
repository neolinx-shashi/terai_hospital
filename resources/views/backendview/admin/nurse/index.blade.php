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
                  <li><a href="{{URL('configuration/nurse')}}">System Setup</a></li>
                  <li class="active">View Nurse</li>
              </ol>
          </div>
          <div class="col-md-2">
              <a href="{{url('configuration/nurse/create')}}">
                <button type="button" class="btn btn-success btn-flat  pull-right ">
                  <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add Nurse
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
                        @if(count($nurses)>0)
                            <table id="example1" class="table table-hover table-bordered table-striped">
                                <thead>
                                <tr>

                                    <th class="col-lg-1">S.N</th>
                                    <th class="col-lg-4">Nurse Name/ Contact No.</th>
                                    <th class="col-lg-2">NMC No.</th>
                                    <th class="col-lg-2">Created At</th>
                                    <th class="col-lg-2">Actions</th>
                                    <th class="col-lg-2=1">Shift</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $i = $nurses->firstItem();
                                ?>

                                @foreach($nurses as $key=>$nurse)
                                    <tr>
                                        <td>
                                            {{$i++}}.
                                        </td>

                                        <td>
                                            <a href="{{URL::to('configuration/nurse/' .$nurse->id)}}">
                                                {{ucfirst($nurse->first_name)}}
                                                {{ucfirst($nurse->middle_name)}}
                                                {{ucfirst($nurse->last_name)}}
                                            </a>
                                            <br>
                                            <i class="fa fa-phone" aria-hidden="true">&nbsp;</i>
                                            {{ $nurse->contact_no }}
                                        </td>

                                        <td>
                                            {{$nurse->nmc_no}}
                                        </td>

                                        <td>
                                           {{changeCreatedDateToNepali($nurse->created_at)}}
                                        </td>

                                        <td>

                                            <a href="{{ URL::to('configuration/nurse/' . $nurse->id . '/edit') }}"
                                               title="Edit Nurse Details"
                                               data-rel="tooltip">
                                                <button type="button" class="btn btn-default btn-flat  ">
                                                    <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                                                </button>
                                            </a>
                                            <a href="{{URL::to('configuration/nurse/' .$nurse->id)}}"
                                               title="View Nurse Details"
                                               data-rel="tooltip">
                                                <button type="button" class="btn btn-default btn-flat ">
                                                    <span class="glyphicon glyphicon-zoom-in" aria-hidden="true"></span>
                                                </button>
                                            </a>


                                            <a href="{{URL::to('remove-nurse',array($nurse->id))}}"
                                               onclick="return confirm('Are you sure you want to delete this record?')">
                                                <button type="button" class="btn btn-danger btn-flat  ">
                                    <span class="glyphicon glyphicon-trash"
                                          aria-hidden="true"></span>
                                                </button>
                                            </a>
                                        </td>


                                        <td>

                                            <a href="{{URL::to('configuration/assign/shift/nurse/' .$nurse->id)}}"
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
   

@endsection