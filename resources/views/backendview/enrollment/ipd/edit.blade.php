@extends('backendlayout.master')
@extends('backendlayout.header')
@extends('backendlayout.leftmenu')
@extends('backendlayout.footer')
@section('userscontent')
    @extends('backendlayout.flashmessagecollection')
    <script src="{{URL::asset('backendtheme/plugins/jQuery/jQuery-2.1.4.min.js')}}"></script>
    <section class="content-header">
        <h1>
            IP Enrollment Form
            <a href="{{url('ip-enrollment/patients')}}">
                <button type="button" class="btn btn-warning btn-flat  pull-right ">
                    <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span> View Patients
                </button>
            </a>
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12 ">
                <div class="box">
                    <div class="box-body">

                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#tab-1">Patient's Detail</a></li>
                                <li><a data-toggle="tab" href="#tab-2">Guardian's Detail</a></li>
                                <li><a data-toggle="tab" href="#tab-3">Referrer's Detail</a></li>
                            </ul>

                            <div class="tab-content">
                                <div id="tab-1" class="tab-pane fade in active">
                                    <div class="container">
                                        <br/>

                                        <form method="post" id="createForm"
                                              action="{{ URL::to('ip-enrollment/patients/' . $editPatients->id . '/update-patient') }}">
                                            {{ csrf_field() }}
                                            <div class="form-group row" id="div_1" hidden>

                                                <label for="inputfname" class="col-sm-1 form-control-label">Patient
                                                    Name<label
                                                            class="text-danger">*</label></label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" id="inputfname"
                                                           name="first_name"
                                                           placeholder="Patient full name"
                                                           value="{{$editPatients->first_name}}">
                                                    @if ($errors->has('first_name'))
                                                        <span class="help-block" style="color: red">
                                        <strong> * {{ $errors->first('first_name') }}</strong>
                                    </span>
                                                    @endif
                                                </div>

                                                <label for="inputcontact"
                                                       class="col-sm-1 form-control-label">Phone/Mobile<label
                                                            class="text-danger">*</label></label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" id="inputcontact"
                                                           name="phone"
                                                           placeholder="Phone" value="{{$editPatients->phone}}">
                                                    @if ($errors->has('phone'))
                                                        <span class="help-block" style="color: red">
                                        <strong> * {{ $errors->first('phone') }}</strong>
                                    </span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="form-group row" id="div_2" hidden>
                                                <label for="inputage" class="col-sm-1 form-control-label">Age</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" id="inputage" name="age"
                                                           value="{{$editPatients->age}}"
                                                           placeholder="Patient age" value="{{old('age')}}">
                                                    @if ($errors->has('age'))
                                                        <span class="help-block" style="color: red">
                                        <strong> * {{ $errors->first('age') }}</strong>
                                    </span>
                                                    @endif
                                                </div>

                                                <label for="gender" class="col-sm-1 form-control-label">Gender<label
                                                            class="text-danger">*</label></label>
                                                <div class="col-sm-4">
                                                    <div class="radio" name="gender">
                                                        <label><input type="radio" name="gender"
                                                                      value="Male" @if($editPatients->gender=='Male') <?php echo 'checked' ?> @endif>Male</label>
                                                        &nbsp;
                                                        <label><input type="radio" name="gender"
                                                                      value="Female" @if($editPatients->gender=='Female') <?php echo 'checked' ?> @endif>Female</label>
                                                        &nbsp;
                                                        <label><input type="radio" name="gender"
                                                                      value="Others" @if($editPatients->gender=='Others') <?php echo 'checked' ?> @endif>Others</label>
                                                        @if ($errors->has('gender'))
                                                            <span class="help-block" style="color: red">
                                                    <strong> * {{ $errors->first('gender') }}</strong>
                                                </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group row" id="div_3" hidden>
                                                <label for="doctor_id"
                                                       class="col-sm-1 form-control-label">Doctor<label
                                                            class="text-danger">*</label></label>
                                                <div class="col-md-4">
                                                    <select name="doctor_id" id="doctor_id" class="form-control">
                                                        <option value="">Select a Doctor</option>
                                                        @foreach($doctors as $doctor)
                                                            <option value="{{ $doctor->id }}"
                                                            @if($doctor->id==$editPatients->doctor_id) <?php echo 'selected' ?> @endif>{{ucfirst($doctor->first_name.' '.$doctor->last_name)}}</option>
                                                        @endforeach
                                                    </select>
                                                    @if ($errors->has('doctor_id'))
                                                        <span class="help-block" style="color: red">
                                                <strong> * {{ $errors->first('doctor_id') }}</strong>
                                            </span>
                                                    @endif
                                                </div>

                                                <label for="blood_type" class="col-sm-1 form-control-label">Blood Group
                                                </label>
                                                <div class="col-sm-4">
                                                    <select name="bloodGroup_id" id="blood_group" class="form-control">
                                                        <option>Select Blood Group</option>
                                                        <option value="A+" @if($editPatients->bloodGroup_id == 'A+')  <?php echo 'selected'?> @endif>
                                                            A Positive
                                                        </option>
                                                        <option value="A-" @if($editPatients->bloodGroup_id == 'A-')  <?php echo 'selected'?> @endif>
                                                            A Negative
                                                        </option>
                                                        <option value="A" @if($editPatients->bloodGroup_id == 'A')  <?php echo 'selected'?> @endif>
                                                            A Unknown
                                                        </option>
                                                        <option value="B+" @if($editPatients->bloodGroup_id == 'B+')  <?php echo 'selected'?> @endif>
                                                            B Positive
                                                        </option>
                                                        <option value="B-" @if($editPatients->bloodGroup_id == 'B-')  <?php echo 'selected'?> @endif>
                                                            B Negative
                                                        </option>
                                                        <option value="B" @if($editPatients->bloodGroup_id == 'B')  <?php echo 'selected'?> @endif>
                                                            B Unknown
                                                        </option>
                                                        <option value="AB+" @if($editPatients->bloodGroup_id == 'AB+')  <?php echo 'selected'?> @endif>
                                                            AB Positive
                                                        </option>
                                                        <option value="AB-" @if($editPatients->bloodGroup_id == 'AB-')  <?php echo 'selected'?> @endif>
                                                            AB Negative
                                                        </option>
                                                        <option value="AB" @if($editPatients->bloodGroup_id == 'AB')  <?php echo 'selected'?> @endif>
                                                            AB Unknown
                                                        </option>
                                                        <option value="O+" @if($editPatients->bloodGroup_id == 'O+')  <?php echo 'selected'?> @endif>
                                                            O Positive
                                                        </option>
                                                        <option value="O-" @if($editPatients->bloodGroup_id == 'O-')  <?php echo 'selected'?> @endif>
                                                            O Negative
                                                        </option>
                                                        <option value="O" @if($editPatients->bloodGroup_id == 'O')  <?php echo 'selected'?> @endif>
                                                            O Unknown
                                                        </option>
                                                        <option value="unknown" @if($editPatients->bloodGroup_id == 'unknown')  <?php echo 'selected'?> @endif>
                                                            Unknown
                                                        </option>
                                                    </select>
                                                    @if ($errors->has('bloodGroup_id'))
                                                        <span class="help-block" style="color: red">
                                                        <strong> * {{ $errors->first('bloodGroup_id') }}</strong>
                                                    </span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="form-group row" id="div_4" hidden>
                                                <label for="permanent" class="col-sm-1 form-control-label">Permanent
                                                    Address<label
                                                            class="text-danger">*</label></label>
                                                <div class="col-sm-4">
                                                <textarea class="form-control col-md-5" id="permanent"
                                                          name="permanent_address" rows="3"
                                                          placeholder="Only 80 character are allowed"
                                                          maxlength="80">{{ $editPatients->permanent_address }}</textarea>

                                                    @if ($errors->has('permanent_address'))
                                                        <span class="help-block" style="color: red">
                                        <strong> * {{ $errors->first('permanent_address') }}</strong>
                                    </span>
                                                    @endif
                                                </div>

                                                <label for="temp" class="col-sm-1 form-control-label">Temporary
                                                    Address</label>
                                                <div class="col-sm-4">
                                                <textarea class="form-control col-md-5" id="temp"
                                                          name="temporary_address" rows="3"
                                                          placeholder="Only 80 character are allowed"
                                                          maxlength="80">{{ $editPatients->temporary_address }}</textarea>

                                                    {{--@if ($errors->has('phone'))--}}
                                                    {{--<span class="help-block" style="color: red">--}}
                                                    {{--<strong> * {{ $errors->first('phone') }}</strong>--}}
                                                    {{--</span>--}}
                                                    {{--@endif--}}
                                                </div>
                                            </div>

                                            <div class="form-group row" id="div_5" hidden>
                                                <label for="deposit_amt" class="col-sm-1 form-control-label">Deposit
                                                    Amount
                                                </label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" id="deposit_amt"
                                                           name="deposit_amount"
                                                           value="{{$editPatients->deposit_amount}}"
                                                           placeholder="Deposit Amount" disabled>
                                                    {{--@if ($errors->has('phone'))--}}
                                                    {{--<span class="help-block" style="color: red">--}}
                                                    {{--<strong> * {{ $errors->first('phone') }}</strong>--}}
                                                    {{--</span>--}}
                                                    {{--@endif--}}
                                                </div>

                                                <label for="consultdoc"
                                                       class="col-sm-1 form-control-label">Nationality<label
                                                            class="text-danger">*</label>
                                                </label>
                                                <div class="col-sm-4">
                                                    <select name="nationality_id" id="doctor" class="form-control">
                                                        <option value="">Select Nationality</option>
                                                        @foreach($nationality as $nationalityData)
                                                            <option value="{{ $nationalityData->id }}"
                                                            @if($editPatients->nationality_id==$nationalityData->id)
                                                                <?php echo 'selected' ?>
                                                                    @endif
                                                            >{{ $nationalityData->country_name}}</option>
                                                        @endforeach
                                                    </select>
                                                    @if ($errors->has('nationality_id'))
                                                        <span class="help-block" style="color: red">
                                        <strong> * {{ $errors->first('nationality_id') }}</strong>
                                    </span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="form-group row" id="div_6" hidden>
                                                <label for="description" class="col-sm-1 form-control-label">Description
                                                </label>
                                                <div class="col-md-9">
                                    <textarea class="form-control col-md-5" id="description" name="description" rows="2"
                                              maxlength="150"
                                              placeholder="Only 150 character are allowed">{{ $editPatients->description }}</textarea>
                                                    @if ($errors->has('description'))
                                                        <span class="help-block" style="color: red">
                    <strong> * {{ $errors->first('description') }}</strong>
                </span>
                                                    @endif
                                                </div>
                                            </div>

                                            <h5>Placement:</h5>

                                            <div class="form-group row">
                                                <label style="margin:5px -50px 0 0px; " for="InstituteName"
                                                       class="col-sm-1 form-control-label">Ward<label
                                                            class="text-danger">*</label></label>
                                                <div class="col-sm-2">
                                                    <select name="ward_id" id="ward" class="form-control">
                                                        <option value="">Select Ward</option>
                                                        @foreach($wards as $ward)
                                                            <option value="{{ $ward->id }}"
                                                            @if($editPatients->ward_id==$ward->id)
                                                                <?php echo 'selected' ?>
                                                                    @endif
                                                            >{{ $ward->ward_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div id="room_type" hidden>
                                                    <label style="margin:5px -50px 0 0px; " for="room_type"
                                                           class="col-sm-1 form-control-label">Room Type<label
                                                                class="text-danger">*</label></label>
                                                    <div class="col-sm-2">
                                                        <select name="room_type" id="room_type1" class="form-control">
                                                            <option value=" ">Select Room Type</option>
                                                            <option value="deluxe" @if($editPatients->room_type == "deluxe") <?php echo 'selected' ?> @endif>
                                                                Deluxe
                                                            </option>
                                                            <option value="one bed" @if($editPatients->room_type == "one bed") <?php echo 'selected' ?> @endif>
                                                                One Bed
                                                            </option>
                                                            <option value="two bed" @if($editPatients->room_type == "two bed") <?php echo 'selected' ?> @endif>
                                                                Two Bed
                                                            </option>
                                                        </select>
                                                        @if ($errors->has('room_type'))
                                                            <span class="help-block" style="color: red">
                                    <strong> * {{ $errors->first('room_type') }}</strong>
                                    </span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <label style="margin:5px -50px 0 0px; " for="RefAddress"
                                                       class="col-sm-1 form-control-label">Room<label
                                                            class="text-danger">*</label></label>
                                                <div class="col-sm-2" id="rooms">
                                                    <select name="room_id" id="room" class="form-control">
                                                        <option value="">Select Room</option>
                                                        @foreach($rooms as $room)
                                                            <option value="{{ $room->id }}"
                                                            @if($editPatients->room_id==$room->id)
                                                                <?php echo 'selected' ?>
                                                                    @endif
                                                            >{{ $room->room_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <label style="margin:5px -50px 0 0px; " for="RefAddress"
                                                       class="col-sm-1 form-control-label">Bed<label
                                                            class="text-danger">*</label></label>
                                                <div class="col-sm-2" id="bed">
                                                    <select name="bed_id" id="beds" class="form-control">
                                                        <option value="">Select Bed</option>
                                                        @foreach($beds as $bed)
                                                            <option value="{{ $bed->id }}"
                                                            @if($editPatients->bed_id==$bed->id)
                                                                <?php echo 'selected' ?>
                                                                    @endif
                                                            >{{ $bed->bed_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <hr>

                                            @if($shift == 1)
                                                <div class="form-group row">
                                                    <div class="col-md-12">
                                                        <button type="submit" onclick="return ConfirmDelete()"
                                                                class="col-md-1 col-lg-offset-8 btn btn-primary btn-flat">
                                                            <span class="fa fa-exchange"> Shift</span>
                                                        </button>
                                                    </div>
                                                </div>
                                                @else
                                                <div class="form-group row">
                                                    <div class="col-md-12">
                                                        <button type="submit"
                                                                class="col-md-1 col-lg-offset-8 btn btn-primary btn-flat">
                                                            Update
                                                        </button>
                                                    </div>
                                                </div>
                                            @endif
                                        </form>
                                    </div>
                                </div>
                                <div id="tab-2" class="tab-pane fade">
                                    <div class="container">
                                        <form method="post"
                                              action="{{ URL::to('ip-enrollment/' . $editPatients->id . '/addGuardian') }}">
                                            {{ csrf_field() }}
                                            <br>
                                            {{--Guardian Details--}}
                                            <div class="form-group row">
                                                <label for="guardian_name" class="col-sm-1 form-control-label">Local
                                                    Guardian</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" id="guardian_name"
                                                           placeholder="Local Guardian Name" name="guardian_name"
                                                           value="{{$editPatients->guardian_name}}">
                                                    @if ($errors->has('guardian_name'))
                                                        <span class="help-block" style="color: red">
                                                <strong> * {{ $errors->first('guardian_name') }}</strong>
                                                </span>
                                                    @endif
                                                </div>
                                                <label for="inputmname"
                                                       class="col-sm-1 form-control-label">Relation</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" id="inputmname"
                                                           placeholder="Relation"
                                                           name="guardian_relation"
                                                           value="{{$editPatients->guardian_relation}}">
                                                    @if ($errors->has('guardian_relation'))
                                                        <span class="help-block" style="color: red">
                                                <strong> * {{ $errors->first('guardian_relation') }}</strong>
                                                </span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="guardian_phone"
                                                       class="col-sm-1 form-control-label">Phone/Mobile</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" id="guardian_phone"
                                                           placeholder="Phone/Mobile" name="guardian_phone"
                                                           value="{{$editPatients->guardian_phone}}">
                                                    @if ($errors->has('guardian_phone'))
                                                        <span class="help-block" style="color: red">
                                                <strong> * {{ $errors->first('guardian_phone') }}</strong>
                                                </span>
                                                    @endif
                                                </div>

                                                <label for="inputdob"
                                                       class="col-sm-1 form-control-label">Address</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" id="inputlname"
                                                           placeholder="Guardian Address" name="guardian_address"
                                                           value="{{$editPatients->guardian_address}}">
                                                    @if ($errors->has('guardian_address'))
                                                        <span class="help-block" style="color: red">
                                                <strong> * {{ $errors->first('guardian_address') }}</strong>
                                                </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="parent_name" class="col-sm-1 form-control-label">Parent's
                                                    Name</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" id="parent_name"
                                                           placeholder="Parent's Name" name="parent_name"
                                                           value="{{$editPatients->parent_name}}">
                                                    @if ($errors->has('parent_name'))
                                                        <span class="help-block" style="color: red">
                                                <strong> * {{ $errors->first('parent_name') }}</strong>
                                                </span>
                                                    @endif
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="checkbox">
                                                        <input type="checkbox" onchange="copyTextValue(this);">Is Local
                                                        Guardian
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="parent_phone"
                                                       class="col-sm-1 form-control-label">Phone/Mobile</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" id="parent_phone"
                                                           placeholder="Phone/Mobile" name="parent_phone"
                                                           value="{{$editPatients->parent_phone}}">
                                                    @if ($errors->has('parent_phone'))
                                                        <span class="help-block" style="color: red">
                                                <strong> * {{ $errors->first('parent_phone') }}</strong>
                                                </span>
                                                    @endif
                                                </div>
                                                <label for="GuardEmail"
                                                       class="col-sm-1 form-control-label">Email</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" id="GuardEmail"
                                                           placeholder="Email"
                                                           name="parent_email" value="{{$editPatients->parent_email}}">
                                                    @if ($errors->has('parent_email'))
                                                        <span class="help-block" style="color: red">
                                                <strong> * {{ $errors->first('parent_email') }}</strong>
                                                </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="Paddress" class="col-xs-1 form-control-label">Permanent
                                                    Address</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" id="Paddress"
                                                           placeholder="Permanent Address" name="parent_address"
                                                           value="{{$editPatients->parent_address}}">
                                                    @if ($errors->has('parent_address'))
                                                        <span class="help-block" style="color: red">
                                                <strong> * {{ $errors->first('parent_address') }}</strong>
                                                </span>
                                                    @endif
                                                </div>
                                                <label for="GuardOccupation"
                                                       class="col-sm-1 form-control-label">Occupation</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" id="GuardOccupation"
                                                           placeholder="Occupation" name="parent_occupation"
                                                           value="{{$editPatients->parent_occupation}}">
                                                    @if ($errors->has('parent_occupation'))
                                                        <span class="help-block" style="color: red">
                                                <strong> * {{ $errors->first('parent_occupation') }}</strong>
                                                </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <hr>
                                            <br>
                                            <div class="form-group row">
                                                <div class="col-md-12">
                                                    <button type="submit"
                                                            class="col-md-1 col-lg-offset-8 btn btn-primary btn-flat">
                                                        Update
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div id="tab-3" class="tab-pane fade">
                                    <div class="container">
                                        <form method="post"
                                              action="{{ URL::to('ip-enrollment/' . $editPatients->id . '/addReferrer') }}">
                                            {{ csrf_field() }}
                                            <br>
                                            <div class="form-group row">
                                                {{--Patient Details--}}
                                                <label for="InstituteName" class="col-sm-1 form-control-label">Institute
                                                    Name</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" id="InstituteName"
                                                           placeholder="Institute Name" name="institute_name"
                                                           value="{{$editPatients->institute_name}}">
                                                    @if ($errors->has('institute_name'))
                                                        <span class="help-block" style="color: red">
                                                <strong> * {{ $errors->first('institute_name') }}</strong>
                                                </span>
                                                    @endif
                                                </div>
                                                <label for="RefAddress"
                                                       class="col-sm-1 form-control-label">Address</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" id="RefAddress"
                                                           placeholder="Institute Address" name="institute_address"
                                                           value="{{$editPatients->institute_address}}">
                                                    @if ($errors->has('institute_address'))
                                                        <span class="help-block" style="color: red">
                                                <strong> * {{ $errors->first('institute_address') }}</strong>
                                                </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="MedicName" class="col-sm-1 form-control-label">Medic
                                                    Name</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" id="MedicName"
                                                           placeholder="Medic Name" name="medic_name"
                                                           value="{{$editPatients->medic_name}}">
                                                    @if ($errors->has('medic_name'))
                                                        <span class="help-block" style="color: red">
                                                <strong> * {{ $errors->first('medic_name') }}</strong>
                                                </span>
                                                    @endif
                                                </div>
                                                <label for="RefDesig"
                                                       class="col-sm-1 form-control-label">Designation</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" id="RefDesig"
                                                           placeholder="Designation" name="medic_designation"
                                                           value="{{$editPatients->medic_designation}}">
                                                    @if ($errors->has('medic_designation'))
                                                        <span class="help-block" style="color: red">
                                                <strong> * {{ $errors->first('medic_designation') }}</strong>
                                                </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="RefReason" class="col-sm-1 form-control-label">Refer
                                                    Reason</label>
                                                <div class="col-sm-9">
                                                <textarea class="form-control" id="RefReason" name="refer_reason"
                                                          value="{{$editPatients->refer_reason}}"></textarea>
                                                    @if ($errors->has('refer_reason'))
                                                        <span class="help-block" style="color: red">
                                                <strong> * {{ $errors->first('refer_reason') }}</strong>
                                                </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="dob" class="col-sm-1 form-control-label">Entry Date
                                                </label>
                                                <div class="col-sm-4">
                                                    <input type="date" class="form-control" id="dob" name="entry_date"
                                                           value="{{$editPatients->entry_date}}">
                                                    @if ($errors->has('entry_date'))
                                                        <span class="help-block" style="color: red">
                                                <strong> * {{ $errors->first('entry_date') }}</strong>
                                                </span>
                                                    @endif
                                                </div>

                                                <label for="dob" class="col-sm-1 form-control-label">Release Date
                                                </label>
                                                <div class="col-sm-4">
                                                    <input type="date" class="form-control" id="dob" name="release_date"
                                                           value="{{$editPatients->release_date}}">
                                                    @if ($errors->has('release_date'))
                                                        <span class="help-block" style="color: red">
                                                <strong> * {{ $errors->first('release_date') }}</strong>
                                                </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="transLetter" class="form-control-label"
                                                       style="float: left; margin-left: 15px;width:150px;">Upload
                                                    Transfer
                                                    Letter</label>
                                                <div class="col-sm-2">
                                                    <input id="transLetter" type="file" class="file"
                                                           name="transferLetter_name"
                                                           value="{{old('transferLetter_name')}}">
                                                </div>
                                            </div>
                                            <hr>
                                            <h4>Upload Documents:</h4><br>
                                            <div class="form-group row">
                                                <label for="LabDoc" class="form-control-label"
                                                       style="float: left; margin-left: 15px;width:150px;">Laboratory
                                                    Document</label>
                                                <div class="col-sm-2">
                                                    <input id="LabDoc" type="file" class="file" name="labDocument_name"
                                                           value="{{$editPatients->labDocument_name}}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="RadioDetial" class="form-control-label"
                                                       style="float: left; margin-left: 15px; width:150px;">Radiology
                                                    Details</label>
                                                <div class="col-sm-2">
                                                    <input id="RadioDetial" type="file" class="file"
                                                           name="radioDetail_name"
                                                           value="{{$editPatients->radioDetail_name}}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="SurgDetial" class="form-control-label"
                                                       style="float: left; margin-left: 15px;width:150px;">Surgeries
                                                    Details</label>
                                                <div class="col-sm-2">
                                                    <input id="SurgDetial" type="file" class="file"
                                                           name="surgeryDetail_name"
                                                           value="{{$editPatients->surgeryDetail_name}}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="PreDetect" class="col-sm-1 form-control-label">Previous
                                                    Detections</label>
                                                <div class="col-sm-9">
                                                <textarea class="form-control" id="PreDetect" name="previous_detections"
                                                          value="{{$editPatients->previous_detections}}"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="PatHistory" class="col-sm-1 form-control-label"
                                                       value="{{$editPatients->institute_address}}">Patient
                                                    History</label>
                                                <div class="col-sm-9">
                                                <textarea class="form-control" id="PatHistory" name="patient_history"
                                                          value="{{$editPatients->patient_history}}"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="Presc"
                                                       class="col-sm-1 form-control-label">Prescriptions</label>
                                                <div class="col-sm-9">
                                                <textarea class="form-control" id="Presc" name="prescriptions"
                                                          value="{{$editPatients->prescriptions}}"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="DischargeSum" class="col-sm-1 form-control-label">Discharge
                                                    Summary</label>
                                                <div class="col-sm-9">
                                                <textarea class="form-control" id="DischargeSum"
                                                          name="discharge_summary"
                                                          value="{{$editPatients->discharge_summary}}"></textarea>
                                                </div>
                                            </div>

                                            <hr>
                                            <br>
                                            <div class="form-group row">
                                                <div class="col-md-12">
                                                    <button type="submit"
                                                            class="col-md-1 col-lg-offset-8 btn btn-primary btn-flat">
                                                        Update
                                                    </button>
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
        </div>

    </section>

    <script type="text/javascript">
        $(document).ready(function () {
            /*Condition for Edit and Bed Shift to hide form fields*/
            var shift = <?php echo $shift; ?>;
            if (shift == 0) {
                document.getElementById("div_1").style.display = "block";
                document.getElementById("div_2").style.display = "block";
                document.getElementById("div_3").style.display = "block";
                document.getElementById("div_4").style.display = "block";
                document.getElementById("div_5").style.display = "block";
                document.getElementById("div_6").style.display = "block";
            }

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
                    phone: {
                        required: true,
                        maxlength: 15,
                        number: true
                    },
                    permanent_address: "required",

                    doctor_id: {
                        required: true
                    }, gender: {
                        required: true
                    },
                    description: {
                        required: true
                    },
                    nationality_id: {
                        required: true
                    },
                    ward_id: {
                        required: true
                    },
                    room_id: {
                        required: true
                    },
                    bed_id: {
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
                    phone: {
                        required: "Please enter phone number",
                        maxlength: "phone number can be maximum 15 digits",
                        number: "Only numeric character allowed"
                    },
                    permanent_address: "Please enter address",

                    doctor_id: "Please select the doctor",

                    gender: "Gender is required",

                    description: "Description is required",

                    nationality_id: "Nationality is required",

                    ward_id: "Ward is required",

                    room_id: "Room is required",

                    bed_id: "Bed is required"
                },
                errorElement: "em",
                errorPlacement: function (error, element) {
                    error.addClass("help-block");
                    error.insertAfter(element);

                },
                highlight: function (element, errorClass, validClass) {
                    $(element).parents(".col-sm-4").addClass("has-error").removeClass("has-success");
                    $(element).parents(".col-md-9").addClass("has-error").removeClass("has-success");
                    $(element).parents(".col-sm-2").addClass("has-error").removeClass("has-success");
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).parents(".col-sm-4").addClass("has-success").removeClass("has-error");
                    $(element).parents(".col-md-9").addClass("has-success").removeClass("has-error");
                    $(element).parents(".col-sm-2").addClass("has-success").removeClass("has-error");
                }
            });

            $('#ward').change(function () {
                document.getElementById("room").disabled = false;
                var wid = $(this).val();
                //alert(wid)
                var url = '{{ url("ward/get-ward/") }}/' + wid;
                $.get(url, function (res) {
                    if (res == "Private") {
                        document.getElementById("room_type").style.display = "block";
                        document.getElementById("room").disabled = true;
                        $('#room_type1').change(function () {
                            document.getElementById("room").disabled = false;
                            var roomType = $(this).val();
                            if (roomType == "one bed") {
                                roomType = "one";
                            } else if (roomType == "two bed") {
                                roomType = "two";
                            }
                            $("#room").load({!! json_encode(url('/ward/private/getRooms')) !!}  +'/' + roomType + '/0');
                        });
                    } else {
                        //alert(wid)
                        $("#room").load({!! json_encode(url('/ward/getRooms')) !!}  +'/' + wid + '/0');
                        document.getElementById("room_type").style.display = "none";
                    }
                });

                /*var officeName = $(this).val();
                $("#room").load({!! json_encode(url('/ward/getRooms')) !!}  +'/' + officeName + '/0');*/
            });

            $('#room').change(function () {
                document.getElementById("bed").disabled = false;
                var room = $(this).val();
                $("#bed").load({!! json_encode(url('/ward/getBeds')) !!}  +'/' + room + '/0');
            });
        });

        function ConfirmDelete()
        {
            var x = confirm("Are you sure you want to shift?");
            if (x)
                return true;
            else
                return false;
        }
    </script>

    @if($editPatients->ward_id)
        <?php
        $ward_id = $editPatients->ward_id;
        $ward = DB::table('ward')
            ->where('id', $ward_id)
            ->first();
        $ward_name = $ward->ward_name;
        if($ward_name == 'Private') {
        ?>
        <script type="text/javascript">
            document.getElementById("room_type").style.display = "block";
        </script>
        <?php } else {
        ?>
        <script>
            document.getElementById("room").disabled = false;
        </script>
        <?php } ?>
    @endif

    <?php if($editPatients->room_id)
    {?>
    <script type="text/javascript">
        document.getElementById("room").disabled = false;
        document.getElementById("bed_id").disabled = false;
        var room = <?php echo $editPatients->room_id ?>;
        $("#bed").load({!! json_encode(url('/ward/getBeds')) !!}  +'/' + room + '/0');
    </script>
    <?php } ?>

    <?php if(old('bed_id'))
    {?>
    <script type="text/javascript">
        document.getElementById("bed_id").disabled = false;
    </script>
    <?php } ?>

    @if(!empty($editPatients->room_type))
        <script type="text/javascript">
            document.getElementById("room_type").style.display = "block";
        </script>
    @endif
@endsection