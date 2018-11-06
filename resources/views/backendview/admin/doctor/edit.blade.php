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
                  <li><a href="{{URL('configuration/doctor')}}">System Setup</a></li>
                  <li class="active">Edit Doctors</li>
              </ol>
          </div>
          <div class="col-md-2">
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
    <div class="row">
        <div class="col-md-12 ">
            <div class="box">
                <div class="container">
                    <form class="doctor-form" method="post"
                    action="{{url('update-doctor',array($editDoctor->id))}}"
                    enctype="multipart/form-data">
                    <br/>
                    <div class="row">
                        <div class="col-sm-9">
                            <div class="form-group row">
                                <label for="first_name" class="col-sm-1 form-control-label">First Name<span style="color: #b30000"> * </span></label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="first_name" name="first_name"
                                    placeholder="First Name" value="{{$editDoctor->first_name}}">
                                    @if($errors->has('first_name'))
                                    <span class="help-block" style="color: red">
                                        <strong>  {{ $errors->first('first_name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <label for="inputlname" class="col-sm-1 form-control-label">Last Name<span style="color: #b30000"> * </span></label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="inputlname" name="last_name" value="{{$editDoctor->last_name}}">
                                    @if($errors->has('last_name'))
                                    <span class="help-block" style="color: red">
                                        <strong>  {{ $errors->first('last_name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                
                            </div>
                            

                            <div class="form-group row">
                                    <label for="inputmname" class="col-sm-1 form-control-label">Middle Name</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="inputmname" name="middle_name" placeholder="Middle Name" value="{{$editDoctor->middle_name}}">
                                </div>


                                



                                <label for="inputage" class="col-sm-1 form-control-label">Age<span style="color: #b30000"> * </span></label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="inputage" name="age" value="{{$editDoctor->age}}" maxlength="3">
                                    @if($errors->has('age'))
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
                                     <option value="Male" @if($editDoctor->gender=='Male') {{"Selected =\"Selected\""}} @endif>
                                        Male
                                    </option>
                                    <option value="Female"  @if($editDoctor->gender=='Female') {{"Selected =\"Selected\""}} @endif>
                                        Female
                                    </option>
                                    <option value="Others" @if($editDoctor->gender=='Others') {{"Selected =\"Selected\""}} @endif>
                                        Others
                                    </option>
                                </select>
                                @if($errors->has('gender'))
                                    <span class="help-block" style="color: red">
                                        <strong>  {{ $errors->first('gender') }}</strong>
                                    </span>
                                    @endif
                            </div>
                            <label for="faculty" class="col-sm-1 form-control-label">Department<span style="color: #b30000"> * </span></label>
                            <div class="col-sm-4">
                                <select class="form-control" name="department_id" id="faculty">
                                    <option value=" ">Select Department</option>
                                    @foreach($department as $departments)

                                    <option value="{{$departments->id}}" 
                                     @if($departments->id == $editDoctor->department_id)
                                     <?php echo 'selected' ?>

                                     @endif
                                     >{{ucfirst($departments->name)}}</option>
                                     @endforeach
                                 </select>
                                 @if($errors->has('department_id'))
                                    <span class="help-block" style="color: red">
                                        <strong>  {{ $errors->first('department_id') }}</strong>
                                    </span>
                                    @endif
                             </div>
                         </div>

                         <div class="form-group row">
                            <label for="designation" class="col-sm-1 form-control-label">Phone/ Mobile<span style="color: #b30000"> * </span></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="designation" name="contact_no"
                                placeholder="Designation" value="{{$editDoctor->contact_no}}" maxlength="15">


                            </div>
                            <label for="nmcno" class="col-sm-1 form-control-label">NMC No.</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="nmcno" name="nmc_no"
                                placeholder="NMC number" value="{{$editDoctor->nmc_no}}">
                                @if($errors->has('nmc_no'))
                                    <span class="help-block" style="color: red">
                                        <strong>  {{ $errors->first('nmc_no') }}</strong>
                                    </span>
                                    @endif
                            </div>
                        </div>



                            <div class="form-group row">
                                        <label for="emergency_contact" class="col-sm-1 form-control-label">Emergency No.<span style="color: #b30000"> * </span></label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" id="emergency_contact" name="emergency_contact"
                                            placeholder="Emergency Contact Number" value="{{$editDoctor->emergency_contact}}" maxlength="15">

                                            @if($errors->has('emergency_contact'))
                                            <span class="help-block" style="color: red">
                                                <strong>  {{ $errors->first('emergency_contact') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                         <label for="email" class="col-sm-1 form-control-label">Email<span style="color: #b30000">  </span></label>
                           <div class="col-sm-4">
                            <input type="email" class="form-control" id="email" name="email"
                            value="{{$editDoctor->email}}" required disabled="disabled">
                        </div>
                                    </div>


                        <div class="form-group row">
                         <label for="designation" class="col-sm-1 form-control-label">Designation</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" id="designation" name="designation"
                                            placeholder="Doctor Designation"  value="{{$editDoctor->designation}}"> 
                                            @if($errors->has('designation'))
                                            <span class="help-block" style="color: red">
                                                <strong>  {{ $errors->first('designation') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                            <label for="address" class="col-sm-1 form-control-label">Address<span style="color: #b30000"> * </span></label>
                            <div class="col-sm-4">
                               <textarea class="form-control col-md-5" id="address"  name="address" rows="2">{{$editDoctor->address}}</textarea>
                               
                           </div>
                          
                    </div>
                    <hr>
                    <h4>Consultation Fees: </h4>
                    <div class="form-group row">
                        <label for="hours" class="col-sm-1 form-control-label">Normal Fee<span style="color: #b30000"> * </span></label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="normal_fee_id" name="normal_fee"
                            placeholder="Normal Fee" required value="{{$editDoctor->normal_fee}}">
                            @if($errors->has('normal_fee'))
                                    <span class="help-block" style="color: red">
                                        <strong>  {{ $errors->first('normal_fee') }}</strong>
                                    </span>
                                    @endif
                        </div>
                        <label for="emergHoours" class="col-sm-1 form-control-label">Emergency</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="normal_fee_id" name="emergency_fee"
                            placeholder="Emergency Fee"  value="{{$editDoctor->emergency_fee}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="generalsymp" class="col-sm-1 form-control-label">Description</label>
                        <div class="col-md-9">
                        <textarea class="form-control col-md-5" id="generalsymp" name="doctor_description" rows="3" maxlength="150">{{$editDoctor->doctor_description}}</textarea>
                        @if($errors->has('doctor_description'))
                                    <span class="help-block" style="color: red">
                                        <strong>  {{ $errors->first('doctor_description') }}</strong>
                                    </span>
                                    @endif
                        </div>

                    </div>

                    <hr>
                    <div class="form-group row">
                     <div class="col-md-6">
                                            <p><strong>Note :</strong> Field With <span style="color: #b30000"> (*) </span> are mandatory </p>
                                        </div>
                        <div class="col-md-6">
                            <button type="submit" class="col-md-4 col-lg-offset-2 btn btn-primary btn-flat">
                                Update
                            </button>

                        </div>
                    </div>
                </div>
                <div class="col-sm-3 image-browse">

                    @if($editDoctor->image_name!="")
                    <img src="{{url('uploads/Doctors')}}/{{$editDoctor->image_name}}" class="thumbnail"
                    alt="Doctor profile picture" height="215px" width="215px" id="profile">

                    @else
                    <img src="{{URL::asset('UserDefaultImage/male.jpg')}}" class="thumbnail"
                    alt="User Image" id="profile" height="215px" width="210px">
                    @endif




                    <div class="form-group">
                        &nbsp; &nbsp; &nbsp; &nbsp; <label for="inputfile">Browse Image <span
                        class=help-block" style="color: #b30000">&nbsp; </span></label>

                        <input type="file" class="form-control" id="inputfile" name="image_name"
                        onchange="document.getElementById('profile').src = window.URL.createObjectURL(this.files[0])" style="width:200px;">



                    </div>

                </div>



                <hr>
                <br>
                {!! csrf_field() !!}
            </form>
        </div>
    </div>
</div>
</div>
</div>
</section>
@endsection
