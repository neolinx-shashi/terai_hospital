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
                  <li><a href="{{URL('usersetup')}}">User Configuration</a></li>
                  <li class="active">{{ucfirst($viewuserData->fullname)}}</li>
              </ol>
          </div>
          <div class="col-md-4">
        @if(Auth::user()->user_type_id=='1' || Auth::user()->user_type_id=='2' )
          <a href="{{URL::action('BackEndController\UsersController@create')}}">
                <button type="button" class="btn btn-success btn-flat  pull-right ">
                  <span class="glyphicon glyphicon-user" aria-hidden="true"></span> Add User
                </button>
              </a> 
              @endif
              <a href="{{URL::action('BackEndController\UsersController@index')}}">
                <button type="button" class="btn btn-warning btn-flat  pull-right ">
                  <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span> View Users
                </button>
              </a> 


          </div>
      </div>
  </div>

       
    </section>
    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">  </h3>
            </div>
            <div class="shadow">
                <div class="row">
                    <div class="col-md-3">
                        <div class="box box-primary">
                            <div class="box-body box-profile">
                                @if($viewuserData->userimage_name!="")
                                    <img src="{{url('uploads/users')}}/{{$viewusopderData->userimage_name}}" class="thumbnail"
                                         alt="User profile picture" height="215px" width="215px">

                                @else
                                    <img src="{{URL::asset('UserDefaultImage/logo.jpg')}}" class="thumbnail"
                                         alt="User profile picture" height="215px" width="215px">
                                @endif
                                <h3 class="profile-username text-center">{{ucfirst($viewuserData->fullname)}}</h3>

                                <p class="text-muted text-center">{{ucfirst($viewuserData->user_post)}}</p>

                                <ul class="list-group list-group-unbordered">
                                    <li class="list-group-item">
                                        <i class="fa fa-envelope-o"></i>
                                        <a class="pull-right">{{$viewuserData->email}}</a>
                                    </li>
                                    <li class="list-group-item">
                                        <i class="fa fa-calendar-o"></i> <a class="pull-right" style="color: black">
                                            <?php
                                                $todayDate= date('Y-m-d',strtotime($viewuserData->created_at));
                                                $localDate = str_replace("-", ",", $todayDate);
                                                $classes=explode(",",$localDate);  
                                                $a=$classes[0];
                                                $b=$classes[1];
                                                $c=$classes[2];
                                                echo eng_to_nep_dashboard($a,$b,$c);
                                                echo  '&nbsp';
                                               echo date('h:i A',strtotime($viewuserData->created_at));
                                            ?>
                                        </a>
                                    </li>
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

                                @if(Auth::user()->id == $viewuserData->id)
                                <li>
                                <a href="#timeline" data-toggle="tab">
                                        <i class="fa fa-fw fa-key"></i>
                                        Security</a></li>


                                        @elseif(Auth::user()->id != $viewuserData->id)
                                         <li>
                                     <a href="#timelinereset" data-toggle="tab">
                                        <i class="fa fa-fw fa-key"></i>
                                        Reset Password</a></li>

                                          @endif

                            </ul>
                            <div class="tab-content">
                                <div class="active tab-pane" id="activity">
                                    <table class="table table-hover ">
                                        <tr>
                                            <th class="text-right col-lg-3">&nbsp; &nbsp;Full Name:</th>
                                            <td>{{ucfirst($viewuserData->fullname)}}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-right col-lg-3">&nbsp; &nbsp;Username:</th>
                                            <td>{{$viewuserData->email}}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-right col-lg-4">&nbsp; &nbsp;Contact No:</th>
                                            <td>
                                            <i class="fa fa-phone" aria-hidden="true"></i>
                                            {{$viewuserData->contact_no}}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-right col-lg-3">Gender:</th>
                                            <td>
                                                @if($viewuserData->gender == 'Male')
                                                    <i class="fa fa-male fa-1x" style="color: darkgreen"></i>
                                                    Male
                                                @endif
                                                @if($viewuserData->gender == 'Female')
                                                    <i class="fa fa-female" style="color: red"></i>
                                                    Female
                                                @endif

                                                 @if($viewuserData->gender == 'Others')
                                                    <i class="fa fa-info" style="color: black"></i>
                                                    Others
                                                @endif
                                            </td>
                                        </tr>


                                        <tr>
                                            <th class="text-right col-lg-3">&nbsp; &nbsp;Address:</th>
                                            <td>{{ucfirst($viewuserData->address)}}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-right col-lg-3">&nbsp; &nbsp;Designation:</th>
                                            <td>{{ucfirst($viewuserData->user_post)}}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-right col-lg-4">&nbsp; &nbsp;User Type:</th>
                                            <td> 
                                            {{ucfirst($viewuserData->userTypes->type_label)}}
                                            </td>


                                        </tr>
                                        <tr>
                                            <th class="text-right col-lg-3">Status:</th>
                                            <td>  @if($viewuserData->status == 'Active')
                                                    <span class="label label-success">Active </span>
                                                @endif
                                                @if($viewuserData->status == 'Inactive')
                                                    <span class="label label-danger">Inactive</span>
                                                @endif
                                            </td>


                                        </tr>
                                        
                                        <tr>
                                            <th class="text-right col-lg-3">Created On:</th>
                                            <td> <?php
                                                $todayDate= date('Y-m-d',strtotime($viewuserData->created_at));
                                                $localDate = str_replace("-", ",", $todayDate);
                                                $classes=explode(",",$localDate);  
                                                $a=$classes[0];
                                                $b=$classes[1];
                                                $c=$classes[2];
                                                echo eng_to_nep($a,$b,$c);
                                                echo  '&nbsp';
                                               echo date('h:i A',strtotime($viewuserData->created_at));
                                            ?></td>
                                        </tr>
                                        <tr>
                                            <th class="text-right col-lg-3">Last Updated On:</th>
                                            <td> <?php
                                                $todayDate= date('Y-m-d',strtotime($viewuserData->updated_at));
                                                $localDate = str_replace("-", ",", $todayDate);
                                                $classes=explode(",",$localDate);  
                                                $a=$classes[0];
                                                $b=$classes[1];
                                                $c=$classes[2];
                                                echo eng_to_nep($a,$b,$c);
                                                echo  '&nbsp';
                                               echo date('h:i A',strtotime($viewuserData->updated_at));
                                            ?></td>
                                        </tr>
                                    </table>
                                </div>


                                <div class="tab-pane" id="timeline">

                                    <div class="well box box-primary">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="alert alert-success">
                                                    <i class="fa fa-info"></i>
                                                    Change Your Password Here.
                                                </div>
                                            </div>
                                        </div>
                                        <form method="post" class="form"
                                              action="{{url('/changepassword')}}" id="passwordChange">
                                            <input type="hidden" name="id" value="{{Auth::user()->id}}">
                                            <input type="hidden" name="_token" value="{{csrf_token()}}" >

                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group ">
                                                        <label for="current_password">Current Password(*)</label>
                                                        <input class="form-control"
                                                               placeholder="Enter Current Password."
                                                               required="required" name="current_password"
                                                               type="password"
                                                               id="current_password">

                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group ">
                                                        <label for="pass1">New Password(*)</label>
                                                        <input class="form-control" placeholder="Enter  New Password."
                                                               required="required" name="new_password" type="password"
                                                               id="pass1">

                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group ">
                                                        <label for="pass2">Confirm Password(*)</label>
                                                        <input class="form-control" placeholder="Confirm New Password."
                                                               required="required"
                                                               name="confirm_password" type="password"
                                                               id="pass2" required
                                                               onkeyup="checkPass(); return false;">

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <button type="submit" class="btn btn-success btn-flat" id="myBtn" disabled="disabled"
                                                            onkeyup="checkPass()">Update</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                            <!--reset password -->
                                <div class="tab-pane" id="timelinereset">
                                    <div class="well box box-primary">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="alert alert-success">
                                                    <i class="fa fa-info"></i>
                                                    Reset Password Here.
                                                </div>
                                            </div>
                                        </div>
                                        <form method="post" class="form"
                                              action="{{url('/resetPassword',$viewuserData->id)}}" id="passwordReset">
                                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group ">
                                                        <label for="pass1reset">New Password(*)</label>
                                                        <input class="form-control" placeholder="Enter  New Password." required="required" name="new_password" type="password" id="pass1reset">

                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group ">
                                                        <label for="pass2reset">Confirm Password(*)</label>
                                                        <input class="form-control" placeholder="Confirm New Password."
                                                               required="required"
                                                               name="confirm_password" type="password"
                                                               id="pass2reset" required
                                                               onkeyup="checkPassReset(); return false;">

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <button type="submit" class="btn btn-success btn-flat" id="myBtnreset" disabled="disabled"
                                                            onkeyup="checkPassReset()">Reset</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

    </section>
    <script type="text/javascript">
        $( document ).ready( function () {
            $( "#passwordReset" ).validate( {
                rules: {
                    
                    new_password: {
                        required: true,
                        minlength: 6
                    }
                   
                },
                messages: {
                    
                     new_password: {
                        required: "Please enter password",
                        minlength: "Password must be minimum 6 character in length"
                    
                    }

                },
                errorElement: "em",
                errorPlacement: function ( error, element ) {
                    error.addClass( "help-block" );
                     error.insertAfter( element );
                    
                },
                highlight: function ( element, errorClass, validClass ) {
                    $( element ).parents( ".col-md-4" ).addClass( "has-error" ).removeClass( "has-success" );
                },
                unhighlight: function (element, errorClass, validClass) {
                    $( element ).parents( ".col-md-4" ).addClass( "has-success" ).removeClass( "has-error" );
                }
            } );
        } );
    </script>


    <script type="text/javascript">
        $( document ).ready( function () {
            $( "#passwordChange" ).validate( {
                rules: {
                    
                    new_password: {
                        required: true,
                        minlength: 6
                    }
                   
                },
                messages: {
                    
                     new_password: {
                        required: "Please enter password",
                        minlength: "Password must be minimum 6 character in length"
                    
                    }

                },
                errorElement: "em",
                errorPlacement: function ( error, element ) {
                    error.addClass( "help-block" );
                     error.insertAfter( element );
                    
                },
                highlight: function ( element, errorClass, validClass ) {
                    $( element ).parents( ".col-md-4" ).addClass( "has-error" ).removeClass( "has-success" );
                },
                unhighlight: function (element, errorClass, validClass) {
                    $( element ).parents( ".col-md-4" ).addClass( "has-success" ).removeClass( "has-error" );
                }
            } );
        } );
    </script>
@stop