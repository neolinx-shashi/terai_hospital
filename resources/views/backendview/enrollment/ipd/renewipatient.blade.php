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

                                        <form method="post"
                                              action="{{URL::action('BackEndController\RenewIPatientController@store')}}">
                                            {{ csrf_field() }}
                                            <div class="form-group row">

                                                <label for="inputfname" class="col-sm-1 form-control-label">First
                                                    Name</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" id="inputfname"
                                                           name="first_name"
                                                           placeholder="Patient first name"
                                                           value="{{$editPatients->first_name}}">
                                                    @if ($errors->has('first_name'))
                                                        <span class="help-block" style="color: red">
                                        <strong> * {{ $errors->first('first_name') }}</strong>
                                    </span>
                                                    @endif
                                                </div>

                                                <label for="inputlname" class="col-sm-1 form-control-label">Middle
                                                    Name</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" id="inputlname"
                                                           name="middle_name" value="{{$editPatients->middle_name}}"
                                                           placeholder="Patient middle name">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="inputmname" class="col-sm-1 form-control-label">Last
                                                    Name</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" id="inputmname"
                                                           name="last_name"
                                                           placeholder="Patient last name"
                                                           value="{{$editPatients->last_name}}">
                                                    @if ($errors->has('last_name'))
                                                        <span class="help-block" style="color: red">
                                        <strong> * {{ $errors->first('last_name') }}</strong>
                                    </span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="dob" class="col-sm-1 form-control-label">Date of Birth
                                                </label>
                                                <div class="col-sm-4">
                                                    <input type="date" class="form-control" id="dob" name="patient_dob"
                                                           value="{{$editPatients->patient_dob}}">
                                                    @if ($errors->has('patient_dob'))
                                                        <span class="help-block" style="color: red">
                                        <strong> * {{ $errors->first('patient_dob') }}</strong>
                                    </span>
                                                    @endif
                                                </div>

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
                                            </div>

                                            <div class="form-group row">
                                                <label for="gender" class="col-sm-1 form-control-label">Gender</label>
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

                                                <label for="blood_type" class="col-sm-1 form-control-label">Blood Group
                                                </label>
                                                <div class="col-sm-4">
                                                    <select name="bloodGroup_id" id="blood_group" class="form-control">
                                                        <option>Select Blood Group</option>
                                                        @foreach($bloodGroup as $bg)
                                                            <option value="{{ $bg->id }}"
                                                                    {{--@foreach($nationality as $nationalityData)--}}
                                                                    {{--<option value="{{ $nationalityData->id }}"--}}
                                                            @if($editPatients->bloodGroup_id==$bg->id)
                                                                <?php echo 'selected' ?>
                                                                    @endif
                                                            >{{ $bg->blood_group}}</option>
                                                        @endforeach
                                                    </select>
                                                    @if ($errors->has('bloodGroup_id'))
                                                        <span class="help-block" style="color: red">
                                        <strong> * {{ $errors->first('bloodGroup_id') }}</strong>
                                    </span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="permanent" class="col-sm-1 form-control-label">Permanent
                                                    Address</label>
                                                <div class="col-sm-4">
                                                    <textarea class="form-control col-md-5" id="permanent"
                                                              name="permanent_address" rows="3"
                                                              placeholder="Only 80 character are allowed"
                                                              maxlength="80">{{old('permanent_address')}}</textarea>

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
                                                              maxlength="80">{{old('temporary_address')}}</textarea>

                                                    {{--@if ($errors->has('phone'))--}}
                                                    {{--<span class="help-block" style="color: red">--}}
                                                    {{--<strong> * {{ $errors->first('phone') }}</strong>--}}
                                                    {{--</span>--}}
                                                    {{--@endif--}}
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="inputcontact"
                                                       class="col-sm-1 form-control-label">Phone</label>
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

                                                <label for="consultdoc" class="col-sm-1 form-control-label">Nationality
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

                                            <div class="form-group row">
                                                <label for="marital_status" class="col-sm-1 form-control-label">Marital
                                                    Status</label>
                                                <div class="col-sm-4">
                                                    <select name="marital_status" id="marital_status"
                                                            class="form-control">
                                                        <option value="">Select Marital Status</option>
                                                        <option value="Married" @if($editPatients->marital_status=='Married') <?php echo 'selected' ?> @endif>
                                                            Married
                                                        </option>
                                                        <option value="Unmarried" @if($editPatients->marital_status=='Unmarried') <?php echo 'selected' ?> @endif>
                                                            Unmarried
                                                        </option>

                                                        {{--@foreach($departments as $department)--}}
                                                        {{--<option value="{{ $department->id }}" @if(old('department_id')==$department->id)--}}
                                                        {{--<?php echo 'selected' ?>--}}
                                                        {{--@endif>{{ $department->name }}</option>--}}
                                                        {{--@endforeach--}}
                                                    </select>
                                                    @if ($errors->has('marital_status'))
                                                        <span class="help-block" style="color: red">
                                        <strong> * {{ $errors->first('marital_status') }}</strong>
                                    </span>
                                                    @endif
                                                </div>

                                                <label for="spouse_name" class="col-sm-1 form-control-label">Spouse
                                                    Name</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" id="spouse_name"
                                                           name="spouse_name" value="{{$editPatients->spouse_name}}"
                                                           placeholder="Spouse Name">
                                                    {{--@if ($errors->has('phone'))--}}
                                                    {{--<span class="help-block" style="color: red">--}}
                                                    {{--<strong> * {{ $errors->first('phone') }}</strong>--}}
                                                    {{--</span>--}}
                                                    {{--@endif--}}
                                                </div>
                                            </div>
                                            <br>
                                            <h4>Ward Assignment:</h4>
                                            <br>

                                            <input type="hidden" name="ipatient_code"
                                                   value="{{$editPatients->ipatient_code}}">
                                            <div class="form-group row">
                                                <label style="margin:5px -50px 0 0px; " for="InstituteName"
                                                       class="col-sm-1 form-control-label">Ward</label>
                                                <div class="col-sm-3">
                                                    <select name="ward_id" id="ward" class="form-control">
                                                        <option value="">Select Ward</option>
                                                        @foreach($wards as $ward)
                                                            <option value="{{ $ward->id }}"
                                                            @if(old('ward_id')==$ward->id)
                                                                <?php echo 'selected' ?>
                                                                    @endif
                                                            >{{ $ward->ward_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <label style="margin:5px -50px 0 0px; " for="RefAddress"
                                                       class="col-sm-1 form-control-label">Room</label>
                                                <div class="col-sm-3" id="rooms">
                                                    <select name="room_id" id="room" class="form-control">
                                                        <option value="">Select Room</option>
                                                        @foreach($rooms as $room)
                                                            <option value="{{ $room->id }}"
                                                            @if(old('room_id')==$room->id)
                                                                <?php echo 'selected' ?>
                                                                    @endif
                                                            >{{ $room->room_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <label style="margin:5px -50px 0 0px; " for="RefAddress"
                                                       class="col-sm-1 form-control-label">Bed</label>
                                                <div class="col-sm-3" id="bed">
                                                    <select name="bed_id" id="beds" class="form-control">
                                                        <option value="">Select Bed</option>
                                                        @foreach($beds as $bed)
                                                            <option value="{{ $bed->id }}"
                                                            @if(old('bed_id')==$bed->id)
                                                                <?php echo 'selected' ?>
                                                                    @endif
                                                            >{{ $bed->bed_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="form-group row">
                                                <div class="col-md-12">
                                                    <button type="submit"
                                                            class="col-md-1 col-lg-offset-8 btn btn-primary btn-flat">
                                                        Save
                                                    </button>
                                                    <button type="reset" class="col-md-1 btn btn-warning btn-flat"
                                                            style="margin-left: 10px;">Reset
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div id="tab-2">
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
                                                </div>
                                                <label for="inputmname"
                                                       class="col-sm-1 form-control-label">Relation</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" id="inputmname"
                                                           placeholder="Relation"
                                                           name="guardian_relation"
                                                           value="{{$editPatients->guardian_relation}}">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="guardian_phone"
                                                       class="col-sm-1 form-control-label">Phone/Mobile</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" id="guardian_phone"
                                                           placeholder="Phone/Mobile" name="guardian_phone"
                                                           value="{{$editPatients->guardian_phone}}">
                                                </div>

                                                <label for="inputdob"
                                                       class="col-sm-1 form-control-label">Address</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" id="inputlname"
                                                           placeholder="Guardian Address" name="guardian_address"
                                                           value="{{$editPatients->guardian_address}}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="parent_name" class="col-sm-1 form-control-label">Parent's
                                                    Name</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" id="parent_name"
                                                           placeholder="Parent's Name" name="parent_name"
                                                           value="{{$editPatients->parent_name}}">
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="checkbox">
                                                        <input type="checkbox" onchange="copyTextValue(this);">Is Local
                                                        Guardian</label>
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
                                                </div>
                                                <label for="GuardEmail"
                                                       class="col-sm-1 form-control-label">Email</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" id="GuardEmail"
                                                           placeholder="Email"
                                                           name="parent_email" value="{{$editPatients->parent_email}}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="Paddress" class="col-xs-1 form-control-label">Permanent
                                                    Address</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" id="Paddress"
                                                           placeholder="Permanent Address" name="parent_address"
                                                           value="{{$editPatients->parent_address}}">
                                                </div>
                                                <label for="GuardOccupation"
                                                       class="col-sm-1 form-control-label">Occupation</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" id="GuardOccupation"
                                                           placeholder="Occupation" name="parent_occupation"
                                                           value="{{$editPatients->parent_occupation}}">
                                                </div>
                                            </div>
                                            <hr>
                                            <br>
                                            <div class="form-group row">
                                                <div class="col-md-12">
                                                    <button type="submit"
                                                            class="col-md-1 col-lg-offset-8 btn btn-primary">
                                                        Submit
                                                    </button>
                                                    <button type="reset" class="col-md-1 btn btn-warning"
                                                            style="margin-left: 10px;">Reset
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div id="tab-3">
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
                                                </div>
                                                <label for="RefAddress"
                                                       class="col-sm-1 form-control-label">Address</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" id="RefAddress"
                                                           placeholder="Institute Address" name="institute_address"
                                                           value="{{$editPatients->institute_address}}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="MedicName" class="col-sm-1 form-control-label">Medic
                                                    Name</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" id="MedicName"
                                                           placeholder="Medic Name" name="medic_name"
                                                           value="{{$editPatients->medic_name}}">
                                                </div>
                                                <label for="RefDesig"
                                                       class="col-sm-1 form-control-label">Designation</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" id="RefDesig"
                                                           placeholder="Designation" name="medic_designation"
                                                           value="{{$editPatients->medic_designation}}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="RefReason" class="col-sm-1 form-control-label">Refer
                                                    Reason</label>
                                                <div class="col-sm-9">
                                                    <textarea class="form-control" id="RefReason" name="refer_reason"
                                                              value="{{$editPatients->refer_reason}}"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="dob" class="col-sm-1 form-control-label">Entry Date
                                                </label>
                                                <div class="col-sm-4">
                                                    <input type="date" class="form-control" id="dob" name="entry_date"
                                                           value="{{$editPatients->entry_date}}">
                                                </div>

                                                <label for="dob" class="col-sm-1 form-control-label">Release Date
                                                </label>
                                                <div class="col-sm-4">
                                                    <input type="date" class="form-control" id="dob" name="release_date"
                                                           value="{{$editPatients->release_date}}">
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
                                                    <textarea class="form-control" id="PreDetect"
                                                              name="previous_detections"
                                                              value="{{$editPatients->previous_detections}}"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="PatHistory" class="col-sm-1 form-control-label"
                                                       value="{{$editPatients->institute_address}}">Patient
                                                    History</label>
                                                <div class="col-sm-9">
                                                    <textarea class="form-control" id="PatHistory"
                                                              name="patient_history"
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
                                                            class="col-md-1 col-lg-offset-8 btn btn-primary">
                                                        Submit
                                                    </button>
                                                    <button type="reset" class="col-md-1 btn btn-warning"
                                                            style="margin-left: 10px;">Reset
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
    </section>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#spouse_name').attr('disabled', 'disabled');
            $('select[name="marital_status"]').on('change', function () {
                var married = $(this).val();
                if (married == "Married") {
                    $('#spouse_name').removeAttr('disabled');
                } else {
                    $('#spouse_name').attr('disabled', 'disabled');
                }

            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#ward').change(function () {
                var officeName = $(this).val();
                $("#room").load({!! json_encode(url('/ward/getRooms')) !!}  +'/' + officeName + '/0');
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            $('#room').change(function () {
                var beds = $(this).val();
                $("#bed").load({!! json_encode(url('/ward/getBeds')) !!}  +'/' + beds + '/0');
            });
        });
    </script>
@endsection