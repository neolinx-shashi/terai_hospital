@extends('backendlayout.master')
@extends('backendlayout.header')
@extends('backendlayout.leftmenu')
@extends('backendlayout.footer')
@section('userscontent')
    @extends('backendlayout.flashmessagecollection')
    <section class="content-header">
     <div class="search-breadcrumb-only">
      <div class="row">
          <div class="col-md-8">
              <ol class="breadcrumb">
                  <li><a href="{{url('dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                  <li><a href="{{URL('configuration/doctor')}}">System Setup</a></li>
                  <li class="active">Doctor {{ucfirst($viewUserData->first_name)}}
                                    {{ucfirst($viewUserData->middle_name)}}
                                    {{ucfirst($viewUserData->last_name)}}</li>
              </ol>
          </div>
          <div class="col-md-4">

          <a href="{{URL::action('BackEndController\DoctorController@create')}}">
                <button type="button" class="btn btn-success btn-flat  pull-right ">
                  <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add Doctor
                </button>
              </a> 
              <a href="{{URL::action('BackEndController\DoctorController@index')}}">
                <button type="button" class="btn btn-warning btn-flat  pull-right ">
                  <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span> View Doctors
                </button>
              </a> 


          </div>
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
                                @if($viewUserData->image_name!="")
                                    <img src="{{url('uploads/Doctors')}}/{{$viewUserData->image_name}}"
                                         class="thumbnail"
                                         alt="User profile picture" height="215px" width="215px">

                                @else
                                    <img src="{{URL::asset('UserDefaultImage/male.jpg')}}" class="thumbnail"
                                         id="profile" height="215px" width="210px" alt="Doctor profile picture">
                                @endif
                                <h3 class="profile-username text-center">
                                    {{ucfirst($viewUserData->first_name)}}
                                    {{ucfirst($viewUserData->middle_name)}}
                                    {{ucfirst($viewUserData->last_name)}}
                                </h3>

                                <p class="text-muted text-center">{{ucfirst($viewUserData->nmc_no)}}</p>

                                <ul class="list-group list-group-unborde#b30000">
                                    <li class="list-group-item">
                                        <i class="fa fa-envelope-o"></i>
                                        <a class="text-center">{{$viewUserData->email}}</a>
                                    </li>
                                    <li class="list-group-item">
                                        <i class="fa fa-calendar-o"></i> <a class="pull-right" style="color: black">
                                            <?php
                                      $todayDate= date('Y-m-d',strtotime($viewUserData->created_at));
                                      $localDate = str_replace("-", ",", $todayDate);
                                      $classes=explode(",",$localDate);  
                                      $a=$classes[0];
                                      $b=$classes[1];
                                      $c=$classes[2];
                                      echo eng_to_nep_dashboard($a,$b,$c);
                                      echo  '&nbsp';
                                     echo date('h:i A',strtotime($viewUserData->created_at));
                                  ?>
                                         <!--    {{$time = \Carbon\Carbon::today()}} --> <br>
                                            <!-- {{date_format($time, ' l - jS F, Y')}}
                                            -{{ \Carbon\Carbon::now()->toDateTimeString() }} <br>
                                            {{$viewUserData->created_at}} -->
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#activity" data-toggle="tab"> <i
                                                class="fa   fa-info-circle"></i>
                                        Basic Information</a></li>


                            </ul>
                            <div class="tab-content">
                                <div class="active tab-pane" id="activity">
                                    <table class="table table-hover ">
                                        <tr>
                                            <th class="text-right col-lg-3">&nbsp; &nbsp;Full Name:</th>
                                            <td>{{ucfirst($viewUserData->first_name)}}
                                                {{ucfirst($viewUserData->middle_name)}}
                                                {{ucfirst($viewUserData->last_name)}}
                                            </td>
                                        </tr>

                                        <tr>
                                            <th class="text-right col-lg-3">&nbsp; &nbsp;Designation:</th>
                                            <td>
                                                @if ( !empty ( $viewUserData->designation ) )
                                                    {{ucfirst($viewUserData->designation)}}

                                                @else
                                                    <span class="label label-default">
                                                Not Available
                                                </span>
                                                @endif

                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-right col-lg-3">&nbsp; &nbsp;Email:</th>
                                            <td>{{$viewUserData->email}}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-right col-lg-4">&nbsp; &nbsp;Phone/Mobile:</th>
                                            <td>
                                                <i class="fa fa-phone" aria-hidden="true"></i>
                                                {{$viewUserData->contact_no}}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-right col-lg-4">&nbsp; &nbsp;Emergency No:</th>
                                            <td>
                                                <i class="fa fa-phone" aria-hidden="true"></i>

                                                @if ( !empty ( $viewUserData->emergency_contact ) )
                                                    {{$viewUserData->emergency_contact}}

                                                @else
                                                    <span class="label label-default">
                                                Not Available
                                                </span>
                                                @endif

                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-right col-lg-4">&nbsp; &nbsp;NMC Number:</th>
                                            <td>{{$viewUserData->nmc_no}}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-right col-lg-3">Gender/Age:</th>
                                            <td>
                                                @if($viewUserData->gender == 'Male')
                                                    <i class="fa fa-male fa-1x" style="color: darkgreen"></i>
                                                    Male/{{$viewUserData->age}}
                                                @endif
                                                @if($viewUserData->gender == 'Female')
                                                    <i class="fa fa-female" style="color: #b30000"></i>
                                                    Female/{{$viewUserData->age}}
                                                @endif


                                                @if($viewUserData->gender == 'Others')
                                                    Others &nbsp;&nbsp;{{$viewUserData->age}}
                                                @endif
                                            </td>
                                        </tr>


                                        <tr>
                                            <th class="text-right col-lg-3">&nbsp; &nbsp;Address:</th>
                                            <td>{{ucfirst($viewUserData->address)}}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-right col-lg-3">&nbsp; &nbsp;Department:</th>
                                            <td>{{ucfirst($viewUserData->isInDepartment->name)}}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-right col-lg-3">&nbsp; &nbsp;Consulting Fee:</th>
                                            <td>{{ucfirst($viewUserData->normal_fee)}}</td>
                                        </tr>
                                         <tr>
                                            <th class="text-right col-lg-3">&nbsp; &nbsp;Emergency Fee:</th>
                                            <td>{{ucfirst($viewUserData->emergency_fee)}}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-right col-lg-3">Created At:</th>
                                                    <td><?php
                                              $todayDate= date('Y-m-d',strtotime($viewUserData->created_at));
                                              $localDate = str_replace("-", ",", $todayDate);
                                              $classes=explode(",",$localDate);  
                                              $a=$classes[0];
                                              $b=$classes[1];
                                              $c=$classes[2];
                                              echo eng_to_nep($a,$b,$c);
                                              echo  '&nbsp';
                                             echo date('h:i A',strtotime($viewUserData->created_at));
                                          ?></td>
                                        </tr>
                                        <tr>
                                            <th class="text-right col-lg-3">&nbsp; &nbsp;Description:</th>
                                            <td>
                                                @if ( !empty ( $viewUserData->doctor_description ) )
                                                    {{ucfirst($viewUserData->doctor_description)}}

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
    </section>
@stop