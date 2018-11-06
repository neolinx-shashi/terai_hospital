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
                  <li><a href="{{URL('usersetup/create')}}">User Configuration</a></li>
                  <li class="active">Edit User</li>
              </ol>
          </div>
          <div class="col-md-2">
              <a href="{{url('usersetup')}}">
                <button type="button" class="btn btn-warning btn-flat  pull-right ">
                  <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span> View Users
                </button>
              </a> 
          </div>
      </div>
  </div>
    </section>

    <section class="content">
        <form class="form-horizontal" method="post"
              action="{{url('update-user',array($edituser->id))}}"
              enctype="multipart/form-data">
            {!! csrf_field() !!}
                    <!-- Default box -->
            <div class="box edit-user">
                <div class="box-header with-border">
                    <h3 class="box-title">Edit {{ucfirst($edituser->fullname)}}</h3>

                </div>
                <div class="shadow">
                    <div class="row">
                        <div class="col-md-9 col-lg-9">
                            <div class="row">
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group{{ $errors->has('fullname') ? ' has-error' : '' }}">
                                        <br>
                                        <label for="name" class="col-sm-4 control-label">Full Name<span class=help-block"
                                                                                                        style="color: #b30000">&nbsp;* </span></label>

                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="name" name="fullname"
                                                   placeholder="Enter Your Full Name." value="{{ucfirst($edituser->fullname)}}">
                                            @if ($errors->has('fullname'))
                                                <span class="help-block" style="color: red">
                                                <strong> * {{ $errors->first('fullname') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                        <br>
                                        <label for="email" class="col-sm-4 control-label">
                                            Username<span class=help-block" style="color: #b30000">&nbsp; </span></label>

                                        <div class="col-sm-8">
                                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter Your Email Address." disabled value="{{$edituser->email}}">
                                            @if ($errors->has('email'))
                                                <span class="help-block" style="color: red">
                                                <strong> * {{ $errors->first('email') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group{{ $errors->has('contact_no') ? ' has-error' : '' }}">
                                        <label for="contact_no" class="col-sm-4 control-label">Contact No<span class=help-block"
                                                                                                               style="color: #b30000">&nbsp;* </span></label>

                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="contact_no" name="contact_no"
                                                   placeholder="Enter Your Contact Number." value="{{$edituser->contact_no}}">
                                            @if ($errors->has('contact_no'))
                                                <span class="help-block" style="color: red">
                                                <strong> * {{ $errors->first('contact_no') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group{{ $errors->has('gender') ? ' has-error' : '' }}">
                                        <label for="gender" class="col-sm-4 control-label">Gender <span class=help-block"
                                                                                                        style="color: #b30000">&nbsp;* </span></label>

                                        <div class="col-sm-8">
                                            <select id="gender" name="gender" class="form-control">
                                                <option value=" ">
                                                    Select Your Gender
                                                </option>
                                                <option value="Male" @if($edituser->gender=='Male') {{"Selected =\"Selected\""}} @endif>
                                                    Male
                                                </option>
                                                <option value="Female"  @if($edituser->gender=='Female') {{"Selected =\"Selected\""}} @endif>
                                                    Female
                                                </option>
                                                <option value="Others" @if($edituser->gender=='Others') {{"Selected =\"Selected\""}} @endif>
                                                    Other
                                                </option>
                                            </select>
                                            @if ($errors->has('gender'))
                                                <span class="help-block" style="color: red">
                                                <strong> * {{ $errors->first('gender') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                                        <label for="address" class="col-sm-4 control-label">Address<span class=help-block"
                                                                                                         style="color: #b30000">&nbsp;* </span></label>

                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="address" name="address"
                                                   placeholder="Enter Your Address." value="{{$edituser->address}}">
                                            @if ($errors->has('address'))
                                                <span class="help-block" style="color: red">
                                                <strong> * {{ $errors->first('address') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group {{ $errors->has('user_post') ? ' has-error' : '' }}">
                                        <label for="userpost" class="col-sm-4 control-label">Designation<span
                                                    class=help-block" style="color: #b30000">&nbsp;* </span></label>

                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="userpost" name="user_post"
                                                   placeholder="Enter User Designation." value="{{$edituser->user_post}}">
                                            @if ($errors->has('user_post'))
                                                <span class="help-block" style="color: red">
                                            <strong> * {{ $errors->first('user_post') }}</strong>
                                        </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                           
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-12">
                                        <button type="submit" class="btn btn-success btn-flat" id="myBtn"><i class="fa fa-refresh"></i>Update
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <p class="note" style="float: left;font-size: 14px;font-weight: normal;margin-left: 25px;"><strong>Note&nbsp;:</strong>&nbsp;&nbsp;Field With  <span class=help-block" style="color: #b30000">&nbsp;* </span> is a Required</p>
                        </div>
                        <div class="col-md-3 col-lg-3">
                            <div class="form-group {{ $errors->has('userimage_name') ? ' has-error' : '' }}">
                                <div class="col-sm-12">
                                    <br>
                                    @if($edituser->userimage_name!="")
                                        <img src="{{url('uploads/users')}}/{{$edituser->userimage_name}}"
                                             class="thumbnail"
                                             alt="User Image" id="profile" height="215px" width="210px">
                                    @else
                                        <img src="{{URL::asset('UserDefaultImage/logo.jpg')}}" class="thumbnail"
                                             alt="User Image" id="profile" height="215px" width="210px">
                                    @endif
                                    <div class="">
                                        <label class="pull-right" for="inputfile">Browse Image <span class=help-block" style="color: #b30000">&nbsp; </span></label>

                                        <input type="file" class="form-control" id="inputfile" name="userimage_name"
                                               onchange="document.getElementById('profile').src = window.URL.createObjectURL(this.files[0])">
                                                @if ($errors->has('userimage_name'))
                            <span class="help-block" style="color: red">
                                <strong> * {{ $errors->first('userimage_name') }}</strong>
                            </span>
                            @endif

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.box -->
            </div>
            <input type="hidden" name="_token" value="{{csrf_token()}}">
        </form>


    </section>
@stop