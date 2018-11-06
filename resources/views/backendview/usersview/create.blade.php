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
                  <li class="active">Add User</li>
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
    action="{{URL::action('BackEndController\UsersController@store')}}"
    enctype="multipart/form-data">
    {!! csrf_field() !!}
    <!-- Default box -->
    <div class="box users-config">
    
      <div class="shadow">
        <div class="row">
            <div class="col-md-9 col-lg-9">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="form-group{{ $errors->has('fullname') ? ' has-error' : '' }}">
                            <br>
                            <label for="name" class="col-sm-4 control-label">
                                Full Name<span class=help-block" style="color: #b30000">&nbsp;*</span>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="name" name="fullname"
                                placeholder="Enter Your Full Name."  value="{{ old('fullname') }}">
                                @if ($errors->has('fullname'))
                                <span class="help-block" style="color: red">
                                    <strong> * {{ $errors->first('fullname') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="form-group {{ $errors->has('user_post') ? ' has-error' : '' }}">
                        <br>
                            <label for="userpost" class="col-sm-4 control-label">Designation<span class=help-block" style="color: #b30000">&nbsp;* </span></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="userpost" name="user_post"
                                placeholder="Enter User Designation." value="{{ old('user_post') }}">
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
                    <div class="col-lg-6 col-md-6">
                        <div class="form-group{{ $errors->has('contact_no') ? ' has-error' : '' }}">
                            <label for="contact_no" class="col-sm-4 control-label">Contact No<span class=help-block" style="color: #b30000">&nbsp;* </span></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="contact_no" name="contact_no"
                                placeholder="Enter Your Contact Number." value="{{ old('contact_no') }}">
                                @if ($errors->has('contact_no'))
                                <span class="help-block" style="color: red">
                                    <strong> * {{ $errors->first('contact_no') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                         <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-sm-4 control-label">
                                Username<span class= help-block" style="color: #b30000">&nbsp;*</span>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="email" name="email"
                                placeholder="Enter Your username."  value="{{ old('email') }}">
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
                    <div class="col-lg-6 col-md-6">
                        <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                            <label for="address" class="col-sm-4 control-label">Address<span class=help-block" style="color: #b30000">&nbsp;* </span></label>
                            <div class="col-sm-8">
                                <textarea type="text" class="form-control" id="address" name="address"
                                placeholder="Enter Your Address."value="{{ old('address') }}"></textarea>
                                @if ($errors->has('address'))
                                <span class="help-block" style="color: red">
                                    <strong> * {{ $errors->first('address') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="pass1" class="col-sm-4 control-label">Password<span class=help-block" style="color: #b30000">&nbsp;* </span></label>

                            <div class="col-sm-8">
                                <input type="password" class="form-control" id="pass1"
                                placeholder="Enter Password." name="password">
                                @if ($errors->has('password'))
                                <span class="help-block" style="color: red">
                                    <strong> * {{ $errors->first('password') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                         
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="form-group{{ $errors->has('user_type_id') ? ' has-error' : '' }}">
                            <label for="accesslevel" class="col-sm-4 control-label">User Type<span
                                class=help-block"
                                style="color: #b30000">&nbsp;* </span></label>
                                <div class="col-sm-8">
                                    <select class="form-control select2" style="width: 100%;" id="accesslevel"
                                    name="user_type_id">
                                    <option selected="selected" value=" ">Select User Type</option>
                                    @foreach($userType as $type)
                                    <?php $selected = (old('user_type_id') == $type->id) ? "selected='selected" : null;
                                    ?>


                                    <option value="{{$type->id}}" {{$selected}}>{{ucfirst($type->type_label)}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('user_type_id'))
                                <span class="help-block" style="color: red">
                                    <strong> * {{ $errors->first('user_type_id') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="form-group">
                            <label for="pass2" class="col-sm-4 control-label">Re-Password<span class=help-block"
                             style="color: #b30000">&nbsp;* </span></label>

                             <div class="col-sm-8">
                                <input type="password" class="form-control"
                                placeholder="Re Type Initial Password." id="pass2" required
                                onkeyup="checkPass(); return false;">
                            </div>
                        </div>
                       
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="form-group{{ $errors->has('gender') ? ' has-error' : '' }}">
                            <label for="gender" class="col-sm-4 control-label">Gender <span class=help-block" style="color: #b30000">&nbsp;* </span></label>
                            <div class="col-sm-8">
                                <select id="gender" name="gender" class="form-control">
                                    <option value=" ">
                                        Select Your Gender
                                    </option>
                                    <option value="Male" @if(old('gender')=='Male') <?php echo 'selected' ?> @endif>Male</option>
                                    <option value="Female" @if(old('gender')=='Female') <?php echo 'selected' ?> @endif>Female</option>
                                    <option value="Others" @if(old('gender')=='Others') <?php echo 'selected' ?> @endif>Other</option>
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
                    <div class="col-lg-12 col-md-12">
                    <div class="form-group">
                        <div class="col-sm-offset-4 col-sm-8">
                            <button type="submit" class="col-md-4 col-lg-offset-2 btn btn-success btn-flat" id="myBtn" disabled="disabled"
                            onkeyup="checkPass()">Save
                        </button>
                        &nbsp;
                        <button type="reset" class="btn btn-default btn-flat" style="background: #f0ad4e;">Reset</button>
                        </div>
                    </div>
                    </div>
                </div>
                <p class="note" style="float: left;font-size: 14px;font-weight: normal;margin-left: 25px;"><strong>Note&nbsp;:</strong>&nbsp;&nbsp;Field With  <span class=help-block" style="color: #b30000">&nbsp;* </span> is a Required</p>

            </div>


            <div class="col-md-3 col-lg-3">
                <div class="form-group">
                    <div class="col-sm-12">
                        <br>
                        <img src="{{URL::asset('UserDefaultImage/logo.jpg')}}" class="thumbnail"
                        alt="User Image" id="profile" height="215px" width="210px">

                        <div class="">
                           <label class="pull-right" for="inputfile">Browse Image <span
                            class=help-block" style="color: #b30000">&nbsp; </span></label>

                            <input type="file" class="form-control" id="inputfile" name="userimage_name"
                            onchange="document.getElementById('profile').src = window.URL.createObjectURL(this.files[0])">

                        
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<input type="hidden" name="_token" value="{{csrf_token()}}">
</form>
</section>
@stop