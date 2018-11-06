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
                  <li class="active">View Doctors</li>
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
                    <form class="doctor-form" method="post" onsubmit="return checkInp()"
                    action="{{URL::action('BackEndController\DoctorController@store')}}"
                    enctype="multipart/form-data">
                    <br/>
                    <div class="row">
                        <div class="col-sm-9">
                            <div class="form-group row {{ $errors->has('fullname') ? ' has-error' : '' }}">
                                <label for="first_name" class="col-sm-1 form-control-label">First Name <span style="color: #b30000"> * </span></label>

                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="first_name" name="first_name"
                                    placeholder="First Name" value="{{ old('first_name') }}">
                                    @if ($errors->has('first_name'))
                                    <span class="help-block" style="color: red">
                                        <strong>  {{ $errors->first('first_name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <label for="inputlname" class="col-sm-1 form-control-label">Last Name<span style="color: #b30000"> * </span></label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="inputlname" name="last_name"
                                    placeholder="Last Name" value="{{old('last_name')}}">
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
                                    <input type="text" class="form-control" id="inputmname" name="middle_name"
                                    placeholder="Middle Name" value="{{old('middle_name')}}">
                                </div>

                                <label for="inputage" class="col-sm-1 form-control-label">Age<span style="color: #b30000"> * </span></label>
                                <div class="col-sm-4">
                                    <input type="number" class="form-control" id="inputage" name="age"
                                    placeholder="Age" value="{{old('age')}}" maxlength="3" max="70">
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
                                        <option value="">Select Gender</option>
                                        <option value="Male" @if(old('gender')=='Male') <?php echo 'selected' ?> @endif>
                                            Male
                                        </option>
                                        <option value="Female" @if(old('gender')=='Female') <?php echo 'selected' ?> @endif>
                                            Female
                                        </option>
                                        <option value="Others" @if(old('gender')=='Others') <?php echo 'selected' ?> @endif>
                                            Other
                                        </option>
                                    </select>
                                    @if($errors->has('gender'))
                                    <span class="help-block" style="color: red">
                                        <strong> {{ $errors->first('gender') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <label for="faculty" class="col-sm-1 form-control-label">Department<span style="color: #b30000"> * </span></label>
                                <div class="col-sm-4">
                                    <select class="form-control" name="department_id" id="faculty">
                                        <option value=" ">Select Department</option>
                                        @foreach($department as $departments)
                                        <option value="{{$departments->id}}"
                                            @if(old('department_id')==$departments->id) <?php echo 'selected' ?> @endif>{{ucfirst($departments->name)}}</option>
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
                                    <label for="contact_no" class="col-sm-1 form-control-label">Phone/
                                        Mobile<span style="color: #b30000"> * </span></label>
                                        <div class="col-sm-4">
                                            <input type="number" class="form-control" id="contact_no" name="contact_no"
                                            placeholder="Phone/Contact Number" value="{{old('contact_no')}}"
                                            maxlength="15">

                                            @if($errors->has('contact_no'))
                                            <span class="help-block" style="color: red">
                                                <strong>  {{ $errors->first('contact_no') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                        <label for="nmcno" class="col-sm-1 form-control-label">NMC No.<span style="color: #b30000"> * </span></label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" id="nmcno" name="nmc_no"
                                            placeholder="NMC number" value="{{old('nmc_no')}}">
                                            @if($errors->has('nmc_no'))
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
                                                <input type="number" class="form-control" id="emergency_contact"
                                                name="emergency_contact"
                                                placeholder="Emergency Contact Number"
                                                value="{{old('emergency_contact')}}" maxlength="15">

                                                @if($errors->has('emergency_contact'))
                                                <span class="help-block" style="color: red">
                                                    <strong>  {{ $errors->first('emergency_contact') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                            <label for="email" class="col-sm-1 form-control-label">Email<span style="color: #b30000"> * </span></label>
                                            <div class="col-sm-4">
                                                <input type="email" class="form-control" id="email" name="email"
                                                placeholder="Email Address" value="{{old('email')}}">
                                                @if($errors->has('email'))
                                                <span class="help-block" style="color: red">
                                                    <strong>  {{ $errors->first('email') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>


                                        <div class="form-group row">


                                            <label for="designation" class="col-sm-1 form-control-label">Designation</label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" id="designation" name="designation"
                                                placeholder="Doctor Designation" value="{{old('designation')}}">
                                                @if($errors->has('designation'))
                                                <span class="help-block" style="color: red">
                                                    <strong>  {{ $errors->first('designation') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                            <label for="address" class="col-sm-1 form-control-label">Address<span style="color: #b30000"> * </span></label>
                                            <div class="col-sm-4">

                                                <textarea class="form-control col-md-5" id="address" name="address" rows="2"
                                                maxlength="80"
                                                placeholder="Only 80 character are allowed">{{old('address')}}</textarea>
                                                @if($errors->has('address'))
                                                <span class="help-block" style="color: red">
                                                    <strong>  {{ $errors->first('address') }}</strong>
                                                </span>
                                                @endif
                                            </div>

                                        </div>
                                        <hr>
                                        <h4>Consultation Fees: </h4>
                                        <div class="form-group row">
                                            <label for="normal_fee_id" class="col-sm-1 form-control-label">Normal
                                                Fee<span style="color: #b30000"> * </span></label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" id="normal_fee_id" name="normal_fee"
                                                    placeholder="Normal Fee" value="{{old('normal_fee')}}">
                                                    @if($errors->has('normal_fee'))
                                                    <span class="help-block" style="color: red">
                                                        <strong>  {{ $errors->first('normal_fee') }}</strong>
                                                    </span>
                                                    @endif
                                                </div>
                                                <label for="emergency_fee_id" class="col-sm-1 form-control-label">Emergency
                                                    Fee</label>
                                                    <div class="col-sm-4">
                                                        <input type="text" class="form-control" id="emergency_fee_id"
                                                        name="emergency_fee"
                                                        placeholder="Emergency Fee"  value="{{old('emergency_fee')}}">

                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="generalsymp" class="col-sm-1 form-control-label">
                                                        Description</label>
                                                        <div class="col-md-9">
                                                            <textarea class="form-control col-md-5" id="generalsymp"  placeholder="Only 150 character are allowed" name="doctor_description" rows="3" maxlength="150" >{{old('doctor_description')}}  
                                                            </textarea>
                                                        </div>

                                                    </div>


                                                    <hr>
                                                    <div class="form-group row ">

                                                        <div class="col-md-6">
                                                            <p><strong>Note :</strong> Field With <span style="color: #b30000"> (*) </span> are mandatory </p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <button type="submit"
                                                            class="col-md-4 col-lg-offset-2 btn btn-primary btn-flat">
                                                            Save
                                                        </button>
                                                        <input type="reset" class="col-md-4 btn btn-warning btn-flat"
                                                        style="margin-left: 1px;">
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3 image-browse {{ $errors->has('image_name') ? ' has-error' : '' }}">
                                            <img src="{{URL::asset('UserDefaultImage/male.jpg')}}" class="thumbnail"
                                            alt="User Image" id="profile" height="215px" width="210px">

                                            <div class="form-group">
                                                &nbsp; &nbsp; &nbsp; &nbsp; <label for="inputfile">Browse Image <span
                                                class=help-block" style="color: #b30000">&nbsp; </span></label>

                                                <input type="file" class="form-control" id="inputfile" name="image_name"
                                                onchange="document.getElementById('profile').src = window.URL.createObjectURL(this.files[0])"
                                                style="width:200px;">
                                                @if($errors->has('image_name'))
                                                <span class="help-block" style="color: red">
                                                    <strong> * {{ $errors->first('image_name') }}</strong>
                                                </span>
                                                @endif

                                            </div>
                                        </div>
                                        <hr>
                                        <br>
                                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <script type="text/javascript">
                $(document).ready(function () {
                    $("#createForm").validate({
                        rules: {
                            first_name: {
                                required: true,
                                alphabetWhiteSpace: true
                            },
                            last_name: {
                                required: true,
                                alphabetWhiteSpace: true
                            },
                            age: {
                                required: true,
                                maxlength: 3,
                                number: true
                            },
                            address: "required",
                            

                            department_id: {
                                required: true
                            }

                        },
                        messages: {
                            first_name: {
                                required: "Please enter first name",
                                alphabetWhiteSpace: "Only alphabet and white space allowed"

                            },
                            last_name: {
                                required: "Please enter your last name",
                                alphabetWhiteSpace: "Only alphabet and white space allowed"


                            },
                            age: {
                                required: "Please enter patient's age",
                                maxlength: "Age can be maximum 3 digits",
                                number: "Only numeric character allowed"
                            },
                            
                            address: "Please enter address",

                            department_id: "Please select the department"
                        },
                        errorElement: "em",
                        errorPlacement: function (error, element) {
                            error.addClass("help-block");
                            error.insertAfter(element);

                        },
                        highlight: function (element, errorClass, validClass) {
                            $(element).parents(".col-sm-4").addClass("has-error").removeClass("has-success");
                        },
                        unhighlight: function (element, errorClass, validClass) {
                            $(element).parents(".col-sm-4").addClass("has-success").removeClass("has-error");
                        }
                    });
                });
            </script>
            @endsection