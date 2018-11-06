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
                  <li class="active">Edit Nurse</li>
              </ol>
          </div>
          <div class="col-md-2">
              <a href="{{url('configuration/nurse')}}">
                <button type="button" class="btn btn-warning btn-flat  pull-right ">
                  <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span> View Nurses
                </button>
              </a> 
          </div>
      </div>
  </div>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12 ">
                <div class="box">
                    <div class="container">
                        <form class="doctor-form" method="post"
                              action="{{url('update-nurse',array($nurse->id))}}"
                              enctype="multipart/form-data">
                            <br/>
                            <div class="row">
                                <div class="col-sm-9">
                                    <div class="form-group row">
                                        <label for="first_name" class="col-sm-1 form-control-label">First Name<span style="color: #b30000"> * </span></label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" id="first_name" name="first_name"
                                                   placeholder="First Name" value="{{$nurse->first_name}}">
                                                   @if ($errors->has('first_name'))
                                                <span class="help-block" style="color: red">
                                            <strong>  {{ $errors->first('first_name') }}</strong>
                                        </span>
                                            @endif
                                        </div>
                                         <label for="inputlname" class="col-sm-1 form-control-label">Last Name<span style="color: #b30000"> * </span></label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" id="inputlname" name="last_name"
                                                   value="{{$nurse->last_name}}">
                                                   @if ($errors->has('first_name'))
                                                <span class="help-block" style="color: red">
                                            <strong>  {{ $errors->first('last_name') }}</strong>
                                        </span>
                                            @endif
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                    <label for="inputmname" class="col-sm-1 form-control-label">Middle Name</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" id="inputmname" name="middle_name"
                                                   placeholder="Middle Name" value="{{$nurse->middle_name}}">

                                        </div>
                                       
                                        <label for="inputage" class="col-sm-1 form-control-label">Age<span style="color: #b30000"> * </span></label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" id="inputage" name="age"
                                                   value="{{$nurse->age}}" maxlength="3">
                                                    @if ($errors->has('age'))
                                                <span class="help-block" style="color: red">
                                            <strong>  {{ $errors->first('age') }}</strong>
                                        </span>
                                            @endif

                                        </div>
                                    </div>
                                    <div class="form-group row">

                                        <label for="gender" class="col-sm-1 form-control-label">Gender<span style="color: #b30000"> * </span></label>
                                        <div class="col-sm-4">
                                            <select class="form-control" id="gender" name="gender">
                                                <option value="Male" @if($nurse->gender=='Male') {{"Selected =\"Selected\""}} @endif>
                                                    Male
                                                </option>
                                                <option value="Female" @if($nurse->gender=='Female') {{"Selected =\"Selected\""}} @endif>
                                                    Female
                                                </option>
                                                <option value="Others" @if($nurse->gender=='Others') {{"Selected =\"Selected\""}} @endif>
                                                    Other
                                                </option>
                                            </select>
                                             @if ($errors->has('gender'))
                                                <span class="help-block" style="color: red">
                                            <strong>  {{ $errors->first('gender') }}</strong>
                                        </span>
                                            @endif
                                        </div>

                                        <label for="address" class="col-sm-1 form-control-label">Address<span style="color: #b30000"> * </span></label>
                                        <div class="col-sm-4">
                                            <textarea class="form-control col-md-5" id="address" name="address"
                                                      rows="2">{{$nurse->address}}</textarea>
                                                       @if ($errors->has('address'))
                                                <span class="help-block" style="color: red">
                                            <strong>  {{ $errors->first('address') }}</strong>
                                        </span>
                                            @endif

                                        </div>

                                    </div>

                                    <div class="form-group row">
                                        <label for="designation" class="col-sm-1 form-control-label">Phone/
                                            Mobile<span style="color: #b30000"> * </span></label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" id="designation" name="contact_no"
                                                   placeholder="Designation" value="{{$nurse->contact_no}}"
                                                   maxlength="15">
                                                    @if ($errors->has('contact_no'))
                                                <span class="help-block" style="color: red">
                                            <strong>  {{ $errors->first('contact_no') }}</strong>
                                        </span>
                                            @endif
                                        </div>
                                        <label for="nmcno" class="col-sm-1 form-control-label">NMC No.</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" id="nmcno" name="nmc_no"
                                                   placeholder="NMC number" value="{{$nurse->nmc_no}}">
                                                    @if ($errors->has('nmc_no'))
                                                <span class="help-block" style="color: red">
                                            <strong>  {{ $errors->first('nmc_no') }}</strong>
                                        </span>
                                            @endif
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label for="emergency_contact" class="col-sm-1 form-control-label">Emergency
                                            No.<span style="color: #b30000"> * </span></label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" id="emergency_contact"
                                                   name="emergency_contact"
                                                   placeholder="Emergency Contact Number"
                                                   value="{{$nurse->emergency_contact}}" maxlength="15">

                                            @if($errors->has('emergency_contact'))
                                                <span class="help-block" style="color: red">
                                                <strong>  {{ $errors->first('emergency_contact') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                        <label for="email" class="col-sm-1 form-control-label">Email<span style="color: #b30000">  </span></label>
                                        <div class="col-sm-4">
                                            <input type="email" class="form-control" id="email" name="email"
                                                   value="{{$nurse->email}}" required disabled="disabled">
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label for="designation" class="col-sm-1 form-control-label">Designation</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" id="designation" name="designation"
                                                   placeholder="Nurse Designation" value="{{$nurse->designation}}">
                                            @if($errors->has('designation'))
                                                <span class="help-block" style="color: red">
                                                <strong>  {{ $errors->first('designation') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    {{--<hr>
                                    <h4>Consultation Fees: </h4>
                                    <div class="form-group row">
                                        <label for="hours" class="col-sm-1 form-control-label">Normal Hours</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" id="normal_fee_id" name="normal_fee"
                                                   placeholder="Normal Fee" required value="{{$editDoctor->normal_fee}}">
                                        </div>
                                        <label for="emergHoours" class="col-sm-1 form-control-label">Emergency</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" id="normal_fee_id" name="emergency_fee"
                                                   placeholder="Emergency Fee"  value="{{$editDoctor->emergency_fee}}">
                                        </div>
                                    </div>--}}
                                    <div class="form-group row">
                                        <label for="generalsymp" class="col-sm-1 form-control-label">Description</label>
                                        <div class="col-md-9">
                                            <textarea class="form-control col-md-5" id="generalsymp"
                                                      name="nurse_description" rows="3"
                                                      maxlength="150">{{$nurse->nurse_description}}</textarea>
                                        </div>

                                    </div>

                                    <hr>
                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            <button type="submit"
                                                    class="col-md-1 col-lg-offset-2 btn btn-primary btn-flat">
                                                Update
                                            </button>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3 image-browse">

                                    @if($nurse->image_name!="")
                                        <img src="{{url('uploads/Nurses')}}/{{$nurse->image_name}}" class="thumbnail"
                                             alt="Nurse profile picture" height="215px" width="215px" id="profile">

                                    @else
                                        <img src="{{URL::asset('UserDefaultImage/nurse.png')}}" class="thumbnail"
                                             alt="Nurse Image" id="profile" height="215px" width="210px">
                                    @endif


                                    <div class="form-group">
                                        &nbsp; &nbsp; &nbsp; &nbsp; <label for="inputfile">Browse Image <span
                                                    class=help-block" style="color: #b30000">&nbsp; </span></label>

                                        <input type="file" class="form-control" id="inputfile" name="image_name"
                                               onchange="document.getElementById('profile').src = window.URL.createObjectURL(this.files[0])"
                                               style="width:200px;">


                                    </div>

                                </div>


                                <hr>
                                <br>
                            </div>
                            {!! csrf_field() !!}
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
