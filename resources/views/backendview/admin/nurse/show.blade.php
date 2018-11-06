@extends('backendlayout.master')
@extends('backendlayout.header')
@extends('backendlayout.leftmenu')
@extends('backendlayout.footer')
@section('userscontent')
    @extends('backendlayout.flashmessagecollection')
    <section class="content-header">
       <div class="row">
          <div class="col-md-8">
              <ol class="breadcrumb">
                  <li><a href="{{url('dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                  <li><a href="{{URL('configuration/nurse')}}">System Setup</a></li>
                  <li class="active">Nurse {{ucfirst($nurse->first_name)}}
                                    {{ucfirst($nurse->middle_name)}}
                                    {{ucfirst($nurse->last_name)}}</li>
              </ol>
          </div>
          <div class="col-md-4">

          <a href="{{url('configuration/nurse/create')}}">
                <button type="button" class="btn btn-success btn-flat  pull-right ">
                  <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add Nurse
                </button>
              </a> 
              <a href="{{url('configuration/nurse')}}">
                <button type="button" class="btn btn-warning btn-flat  pull-right ">
                  <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span> View Nurses
                </button>
              </a> 


          </div>
      </div>

        
    </section>
    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"></h3>
            </div>
            <div class="shadow">
                <div class="row">
                    <div class="col-md-3">
                        <!-- Profile Image -->
                        <div class="box box-primary">
                            <div class="box-body box-profile">
                                @if($nurse->image_name!="")
                                    <img src="{{url('uploads/Nurses')}}/{{$nurse->image_name}}"
                                         class="thumbnail"
                                         alt="User profile picture" height="215px" width="215px">

                                @else
                                    <img src="{{URL::asset('UserDefaultImage/nurse.png')}}" class="thumbnail"
                                         id="profile" height="215px" width="210px" alt="Nurse profile picture">
                                @endif
                                <h3 class="profile-username text-center">
                                    {{ucfirst($nurse->first_name)}}
                                    {{ucfirst($nurse->middle_name)}}
                                    {{ucfirst($nurse->last_name)}}
                                </h3>

                                <p class="text-muted text-center">{{ucfirst($nurse->nmc_no)}}</p>

                                <ul class="list-group list-group-unborde#b30000">
                                    <li class="list-group-item">
                                        <i class="fa fa-envelope-o"></i>
                                        <a class="text-center">{{$nurse->email}}</a>
                                    </li>
                                    <li class="list-group-item">
                                        <i class="fa fa-calendar-o"></i> <a class="pull-right" style="color: black">
                                            <?php
                                      $todayDate= date('Y-m-d',strtotime($nurse->created_at));
                                      $localDate = str_replace("-", ",", $todayDate);
                                      $classes=explode(",",$localDate);  
                                      $a=$classes[0];
                                      $b=$classes[1];
                                      $c=$classes[2];
                                      echo eng_to_nep_dashboard($a,$b,$c);
                                      echo  '&nbsp';
                                     echo date('h:i A',strtotime($nurse->created_at));
                                  ?>
                                            
                                           
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="nav-tabs-custom">
                           
                            <div class="tab-content">
                                <div class="active tab-pane" id="activity">
                                    <table class="table table-hover ">
                                        <tr>
                                            <th class="text-right col-lg-3">&nbsp; &nbsp;Full Name:</th>
                                            <td>{{ucfirst($nurse->first_name)}}
                                                {{ucfirst($nurse->middle_name)}}
                                                {{ucfirst($nurse->last_name)}}
                                            </td>
                                        </tr>

                                        <tr>
                                            <th class="text-right col-lg-3">&nbsp; &nbsp;Designation:</th>
                                            <td>
                                                @if ( !empty ( $nurse->designation ) )
                                                    {{ucfirst($nurse->designation)}}

                                                @else
                                                    <span class="label label-default">
                                                Not Available
                                                </span>
                                                @endif

                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-right col-lg-3">&nbsp; &nbsp;Email:</th>
                                            <td>{{$nurse->email}}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-right col-lg-4">&nbsp; &nbsp;Phone/Mobile:</th>
                                            <td>
                                                <i class="fa fa-phone" aria-hidden="true"></i>
                                                {{$nurse->contact_no}}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-right col-lg-4">&nbsp; &nbsp;Emergency No:</th>
                                            <td>
                                                <i class="fa fa-phone" aria-hidden="true"></i>

                                                @if ( !empty ( $nurse->emergency_contact ) )
                                                    {{$nurse->emergency_contact}}

                                                @else
                                                    <span class="label label-default">
                                                Not Available
                                                </span>
                                                @endif

                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-right col-lg-4">&nbsp; &nbsp;NMC Number:</th>
                                            <td>{{$nurse->nmc_no}}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-right col-lg-3">Gender/Age:</th>
                                            <td>
                                                @if($nurse->gender == 'Male')
                                                    <i class="fa fa-male fa-1x" style="color: darkgreen"></i>
                                                    Male/{{$nurse->age}}
                                                @endif
                                                @if($nurse->gender == 'Female')
                                                    <i class="fa fa-female" style="color: #b30000"></i>
                                                    Female/{{$nurse->age}}
                                                @endif


                                                @if($nurse->gender == 'Others')
                                                    Others &nbsp;&nbsp;{{$nurse->age}}
                                                @endif
                                            </td>
                                        </tr>


                                        <tr>
                                            <th class="text-right col-lg-3">&nbsp; &nbsp;Address:</th>
                                            <td>{{ucfirst($nurse->address)}}</td>
                                        </tr>

                                        {{--<tr>
                                            <th class="text-right col-lg-3">&nbsp; &nbsp;Department:</th>
                                            <td>{{ucfirst($nurse->isInDepartment->name)}}</td>
                                        </tr>--}}

                                        <tr>
                                            <th class="text-right col-lg-3">Created At:</th>
                                            <td>{{changeCreatedDateToNepali($nurse->created_at)}}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-right col-lg-3">&nbsp; &nbsp;Description:</th>
                                            <td>
                                                @if ( !empty ( $nurse->nurse_description ) )
                                                    {{ucfirst($nurse->nurse_description)}}

                                                @else
                                                    <span class="label label-default">
                                                Not Available
                                                </span>
                                                @endif
                                            </td>
                                        </tr>


                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop