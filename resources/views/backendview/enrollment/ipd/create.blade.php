@extends('backendlayout.master')
@extends('backendlayout.header')
@extends('backendlayout.leftmenu')
@extends('backendlayout.footer')
@section('userscontent')
    @extends('backendlayout.flashmessagecollection')
    <script src="{{URL::asset('backendtheme/plugins/jQuery/jQuery-2.1.4.min.js')}}"></script>

    <div class="search-breadcrumb" style="padding-top: 20px">
        <div class="row">
            <div class="col-lg-6">
             <!--    <div class="search input-group">
                    <span class="input-group-addon"
                          style="color: white; background-color: #f39c12;  border-radius:5px;">OLD PATIENT</span>
                    <input type="text" autocomplete="off" id="search"
                           style="border-radius:5px; font-size: 1em; padding: 5px 0 -5px 0;"
                           class="form-control input-lg"
                           placeholder="Patient code/Name/contact number">
                </div> -->
            </div>
            <div class="col-lg-6">
                <ol class="breadcrumb pull-right">
                    <li><a href="{{url('dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                    <li><a href="{{URL('ip-enrollment/patients/create')}}">Create Patient</a></li>
                    <li class="active">Add Patient</li>
                </ol>
            </div>
        </div>
    </div>
    <div id="txtHint" class="title-color" style="padding-top:10px; "></div>
    <script>
        $(document).ready(function () {
            $("#search").keyup(function () {
                var str = $("#search").val();
                if (str == "") {
                    $("#txtHint").html("");
                    $('.content').show();
                } else {
                    $.get("{{ url('ip-enrollment/renew/patient?id=') }}" + str, function (data) {
                        $("#txtHint").html(data);
                        $('.content').hide();
                    });
                }
            });
        });
    </script>

    <section class="content">
        <div class="row">
            <div class="col-md-12 ">
                <div class="box add-patient">
                    <div class="container"><br>
                        <form method="post" id="createForm"
                              action="{{URL::action('BackEndController\IPDController@store')}}">
                            {{ csrf_field() }}

                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            <div class="form-group row">
                                <label for="inputfname" class="col-sm-1 form-control-label">Patient Code <span
                                            style="color: #b30000"> </span></label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" id="inputfname"
                                           value="{{$patientCode}}"
                                           disabled>
                                </div>

                                {{--<div class="col-sm-5" style="text-align: right;" hidden>

                                    @if(Session::get('ipatient_id'))

                                        <a href="{{ URL::to('ip-enrollment/ipatient/' . Session::get('ipatient_id') . '/print-admit-invoice') }}"
                                           title="Print Patient Invoice"
                                           data-rel="tooltip">
                                            <button type="button" class="btn btn-primary btn-flat  "
                                                    style="margin-left: 10px;">
                                                <span class="glyphicon glyphicon-print" aria-hidden="true"></span>
                                                Print IPD Ticket
                                            </button>
                                        </a>

                                        <a href="{{URL::action('BackEndController\IPDController@create')}}">
                                            <button type="button" class="btn btn-success btn-flat"
                                                    style="margin-left: 10px;">
                                                <span class="fa fa-user-plus" aria-hidden="true"></span> Admit IPD
                                                Patient
                                            </button>
                                        </a>
                                    @endif
                                </div>--}}
                            </div>

                            <div class="form-group row">

                                <label for="inputfname" class="col-sm-1 form-control-label">Patient
                                    Name<label class="text-danger">*</label></label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="inputfname"
                                           name="first_name"
                                           placeholder="Patient full name" value="{{old('first_name')}}">
                                    @if ($errors->has('first_name'))
                                        <span class="help-block" style="color: red">
                                        <strong> * {{ $errors->first('first_name') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <label for="inputcontact" class="col-sm-1 form-control-label">Phone/Mobile<label
                                            class="text-danger">*</label></label>
                                <div class="col-sm-4">
                                    <input type="number" class="form-control" id="inputcontact" name="phone"
                                           placeholder="Phone" value="{{old('phone')}}" min="0">
                                    @if ($errors->has('phone'))
                                        <span class="help-block" style="color: red">
                                        <strong> * {{ $errors->first('phone') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                {{--<label for="inputmname" class="col-sm-1 form-control-label">Last
                                    Name<label class="text-danger">*</label></label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="inputmname" name="last_name"
                                           placeholder="Patient last name" value="{{old('last_name')}}">
                                    @if ($errors->has('last_name'))
                                        <span class="help-block" style="color: red">
                                        <strong> * {{ $errors->first('last_name') }}</strong>
                                    </span>
                                    @endif
                                </div>--}}
                            </div>

                            {{--<div class="form-group row">
                                <label for="inputlname" class="col-sm-1 form-control-label">Middle
                                    Name</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="inputlname"
                                           name="middle_name"
                                           placeholder="Patient middle name" value="{{old('middle_name')}}">
                                </div>


                            </div>--}}

                            <div class="form-group row">


                                <label for="inputage" class="col-sm-1 form-control-label">Age<span
                                            style="color: #b30000"> * </span></label>
                                <div class="col-sm-4">
                                    <input type="number" class="form-control" id="target" name="age"
                                           placeholder="Patient age" value="{{ old('age') }}" min="0">
                                    @if ($errors->has('age'))
                                        <span class="help-block" style="color: red">
                                        <strong> * {{ $errors->first('age') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <label for="gender" class="col-sm-1 form-control-label">Gender<label
                                            class="text-danger">*</label></label>
                                <div class="col-sm-4">
                                    <div class="radio">
                                        <label><input type="radio" name="gender"
                                                      value="Male" @if(old('gender')=='Male') <?php echo 'checked' ?> @endif>Male</label>
                                        &nbsp;
                                        <label><input type="radio" name="gender"
                                                      value="Female" @if(old('gender')=='Female') <?php echo 'checked' ?> @endif>Female</label>
                                        &nbsp;
                                        <label><input type="radio" name="gender"
                                                      value="Others" @if(old('gender')=='Others') <?php echo 'checked' ?> @endif>Others</label>
                                        @if ($errors->has('gender'))
                                            <span class="help-block" style="color: red">
                                                    <strong> * {{ $errors->first('gender') }}</strong>
                                                </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="doctor_id" class="col-sm-1 form-control-label">Doctor<label
                                            class="text-danger">*</label></label>
                                <div class="col-sm-4">
                                    <select name="doctor_id" id="doctor_id" class="form-control">
                                        <option value="">Select a Doctor</option>
                                        @foreach($doctors as $doctor)
                                            <option value="{{ $doctor->id }}" @if(old('doctor_id')==$doctor->id)
                                                <?php echo 'selected' ?>
                                                    @endif>{{ ucwords($doctor->first_name).' '.ucwords($doctor->middle_name).' '.ucwords($doctor->last_name) }}</option>
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
                                        <option value=" ">Select Blood Group</option>
                                        <option value="A+" @if(old('bloodGroup_id')=='A+')  <?php echo 'selected'?> @endif>
                                            A Positive
                                        </option>
                                        <option value="A-" @if(old('bloodGroup_id')=='A-')  <?php echo 'selected'?> @endif>
                                            A Negative
                                        </option>
                                        <option value="A" @if(old('bloodGroup_id')=='A')  <?php echo 'selected'?> @endif>
                                            A Unknown
                                        </option>
                                        <option value="B+" @if(old('bloodGroup_id')=='B+')  <?php echo 'selected'?> @endif>
                                            B Positive
                                        </option>
                                        <option value="B-" @if(old('bloodGroup_id')=='B-')  <?php echo 'selected'?> @endif>
                                            B Negative
                                        </option>
                                        <option value="B" @if(old('bloodGroup_id')=='B')  <?php echo 'selected'?> @endif>
                                            B Unknown
                                        </option>
                                        <option value="AB+" @if(old('bloodGroup_id')=='AB+')  <?php echo 'selected'?> @endif>
                                            AB Positive
                                        </option>
                                        <option value="AB-" @if(old('bloodGroup_id')=='AB-')  <?php echo 'selected'?> @endif>
                                            AB Negative
                                        </option>
                                        <option value="AB" @if(old('bloodGroup_id')=='AB')  <?php echo 'selected'?> @endif>
                                            AB Unknown
                                        </option>
                                        <option value="O+" @if(old('bloodGroup_id')=='O+')  <?php echo 'selected'?> @endif>
                                            O Positive
                                        </option>
                                        <option value="O-" @if(old('bloodGroup_id')=='O-')  <?php echo 'selected'?> @endif>
                                            O Negative
                                        </option>
                                        <option value="O" @if(old('bloodGroup_id')=='O')  <?php echo 'selected'?> @endif>
                                            O Unknown
                                        </option>
                                        <option value="unknown" @if(old('bloodGroup_id')=='unknown')  <?php echo 'selected'?> @endif>
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

                            <div class="form-group row">
                                <label for="permanent" class="col-sm-1 form-control-label">Permanent
                                    Address<label class="text-danger">*</label></label>
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
                                            <textarea class="form-control col-md-5" id="temp" name="temporary_address"
                                                      rows="3" placeholder="Only 80 character are allowed"
                                                      maxlength="80">{{old('temporary_address')}}</textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="deposit_amt" class="col-sm-1 form-control-label">Deposit Amount
                                </label>
                                <div class="col-sm-4">
                                    <input type="number" class="form-control" id="deposit_amt"
                                           name="deposit_amount"
                                           placeholder="Deposit Amount" value="{{ old('deposit_amount') }}" min="0">
                                    @if ($errors->has('deposit_amount'))
                                        <span class="help-block" style="color: red">
                                        <strong> * {{ $errors->first('deposit_amount') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <label for="consultdoc" class="col-sm-1 form-control-label">Nationality<label
                                            class="text-danger">*</label>
                                </label>
                                <div class="col-sm-4">
                                    <select name="nationality_id" id="doctor" class="form-control">
                                        <option value="">Select Nationality</option>
                                        @foreach($nationality as $nationalityData)
                                            <option value="{{ $nationalityData->id }}"
                                            @if(old('nationality_id')==$nationalityData->id)
                                                <?php echo 'selected' ?>
                                                    @endif
                                            @if($nationalityData->id=='1') <?php echo 'selected';?>@endif >{{ $nationalityData->country_name}}</option>
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
                                <label for="description" class="col-sm-1 form-control-label">Description<label
                                            class="text-danger">*</label>
                                </label>

                                <div class="col-md-9">
                                    <textarea class="form-control col-md-5" id="description" name="description" rows="2"
                                              maxlength="150"
                                              placeholder="Only 150 character are allowed">{{old('description')}}</textarea>
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
                                            @if(old('ward_id')==$ward->id)
                                                <?php echo 'selected' ?>
                                                    @endif
                                            >{{ucfirst($ward->ward_name)}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('ward_id'))
                                        <span class="help-block" style="color: red">
                                        <strong> * {{ $errors->first('ward_id') }}</strong>
                                    </span>
                                    @endif
                                </div>


                                <div id="room_type" hidden>
                                    <label style="margin:5px -50px 0 0px; " for="room_type"
                                           class="col-sm-1 form-control-label">Room Type<label
                                                class="text-danger">*</label></label>
                                    <div class="col-sm-2">
                                        <select name="room_type" id="room_type1" class="form-control">
                                            <option value=" ">Select Room Type</option>
                                            <option value="deluxe" @if(old('room_type') == "deluxe") <?php echo 'selected' ?> @endif>
                                                Deluxe
                                            </option>
                                            <option value="one bed" @if(old('room_type') == "one bed") <?php echo 'selected' ?> @endif>
                                                One Bed
                                            </option>
                                            <option value="two bed" @if(old('room_type') == "two bed") <?php echo 'selected' ?> @endif>
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
                                    <select name="room_id" id="room" class="form-control" disabled>
                                        <option value="">Select Room</option>
                                        @foreach($rooms as $room)
                                            <option value="{{ $room->id }}"
                                            @if(old('room_id')==$room->id)
                                                <?php echo 'selected' ?>
                                                    @endif
                                            >{{ $room->room_name}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('room_id'))
                                        <span class="help-block" style="color: red">
                                        <strong> * {{ $errors->first('room_id') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <label style="margin:5px -50px 0 0px; " for="RefAddress"
                                       class="col-sm-1 form-control-label">Bed<label
                                            class="text-danger">*</label></label>
                                <div class="col-sm-2" id="bed">
                                    <select name="bed_id" id="bed_id" class="form-control" disabled>
                                        <option value="">Select Bed</option>
                                        @foreach($beds as $bed)
                                            <option value="{{ $bed->id }}"
                                            @if(old('bed_id')==$bed->id)
                                                <?php echo 'selected' ?>
                                                    @endif
                                            >{{ $bed->bed_name}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('bed_id'))
                                        <span class="help-block" style="color: red">
                                        <strong> * {{ $errors->first('bed_id') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <hr>

                            <div class="form-group row">
                                <div class="col-md-12">
                                    <button type="submit" class="col-md-1 col-lg-offset-8 btn btn-primary btn-flat">
                                        <i class="fa fa-floppy-o" aria-hidden="true"></i> Save
                                    </button>
                                    <button type="reset" class="btn btn-warning btn-flat" style="margin-left: 10px;">
                                        <i class="fa fa-refresh" aria-hidden="true"></i> <input type="reset" class="">
                                    </button>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="content" style="padding: 0 15px 15px 15px !important;">

        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Registered Patient Today - ({{ count($registeredPatientsToday) }})</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        @if(count($registeredPatientsToday)>0)
                            <table class="table table-hover table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th class="col-lg-1">S.N</th>
                                    <th class="col-lg-4">Patient Full Name /Code</th>
                                    <th class="col-lg-2">Created On</th>
                                    <th class="col-lg-2">Actions</th>
                                    <th class="col-lg-3">Print</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $i = $registeredPatientsToday->firstItem();

                                ?>
                                @foreach($registeredPatientsToday as $patientData)

                                    <tr @if($patientData->id ==Session::get('ipatient_id')) style="background-color:#9fdfbf" @endif>
                                        <td>
                                            {{$i++}}.
                                        </td>

                                        <td>
                                            {{ucfirst($patientData->first_name)}}
                                            {{ucfirst($patientData->middle_name)}}
                                            {{ucfirst($patientData->last_name)}}
                                            <br>
                                            {{$patientData->ipatient_code}}
                                        </td>
                                        <td>
                                            <?php
                                                $todayDate= date('Y-m-d',strtotime($patientData->created_at));
                                                $localDate = str_replace("-", ",", $todayDate);
                                                $classes=explode(",",$localDate);  
                                                $a=$classes[0];
                                                $b=$classes[1];
                                                $c=$classes[2];
                                                echo eng_to_nep($a,$b,$c);
                                                echo  '&nbsp';
                                               echo date('h:i A',strtotime($patientData->created_at));
                                            ?>
                                        </td>
                                        <td>
                                            <a href="{{ URL::to('ip-enrollment/patients/' . $patientData->id . '/edit') }}"
                                               title="Edit Patient Details"
                                               data-rel="tooltip">
                                                <button type="button" class="btn btn-default btn-flat  ">
                                                    <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                                                </button>
                                            </a>
                                            <a href="{{URL::to('ip-enrollment/patients/' .$patientData->id)}}"
                                               title="View Patient Details"
                                               data-rel="tooltip">
                                                <button type="button" class="btn btn-default btn-flat ">
                                                    <span class="glyphicon glyphicon-zoom-in" aria-hidden="true"></span>
                                                </button>
                                            </a>
                                        </td>
                                        <td>

                                            <a href="{{ URL::to('ip-enrollment/ipatient/' . $patientData->id . '/print-admit-invoice') }}"
                                               title="Print Patient Invoice"
                                               data-rel="tooltip">
                                                <button type="button" class="btn btn-default btn-flat ">
                                                    <span class="glyphicon glyphicon-print" aria-hidden="true"></span>
                                                    Print IPD Ticket
                                                </button>


                                            </a>

                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {{$registeredPatientsToday->render()}}
                        @else
                            <div class="alert alert-danger">
                                <strong style="padding-left: 350px"> Sorry ! No record found
                                </strong>
                            </div>
                        @endif
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
                    phone: {
                        required: true,
                        maxlength: 15,
                        number: true
                    },
                    permanent_address: "required",

                    doctor_id: {
                        required: true
                    },gender: {
                        required: true
                    },
                    age: {
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

                    age: "Age is Required",

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

            /*$('#spouse_name').attr('disabled', 'disabled');
            $('select[name="marital_status"]').on('change', function () {
                var married = $(this).val();
                if (married == "Married") {
                    $('#spouse_name').removeAttr('disabled');
                } else {
                    $('#spouse_name').attr('disabled', 'disabled');
                }

            });*/

            $('#ward').change(function () {
                document.getElementById("room").disabled = false;
                var wid = $(this).val();
                var url = '{{ url("ward/get-ward/") }}/' + wid;
                $.get(url, function (res) {
                    $("#room").load({!! json_encode(url('/ward/getRooms')) !!}  +'/' + wid + '/0');
                    /*if (res == "Private") {
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
                    }*/
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

        /*$(function () {
            $('input[id="date"]').daterangepicker({
                    locale: {
                        format: 'YYYY-MM-DD'
                    },

                    singleDatePicker: true,
                    showDropdowns: true
                },
                function (start, end, label) {
                    var years = moment().diff(start, 'years');
// alert("You are " + years + " years old.");
                    $("#target").text(years);
                    document.getElementById("target").value = years;
                });
        });*/
    </script>

    @if(old('ward_id'))
        <?php
        $ward_id = old('ward_id');
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
            var wid = <?php echo old('ward_id') ?>;
            $("#room").load({!! json_encode(url('/ward/getRooms')) !!}  +'/' + wid + '/0');
        </script>
        <?php } ?>
    @endif

    <?php if(old('room_type'))
    {?>
    <script type="text/javascript">
        document.getElementById("room").disabled = false;
        var roomType = <?php echo old('room_type') ?>;
        $("#room").load({!! json_encode(url('/ward/private/getRooms')) !!}  +'/' + roomType + '/0');
    </script>
    <?php } ?>

    <?php
    if(old('room_id')) {
    ?>
    <script type="text/javascript">
        document.getElementById("room").disabled = false;
        document.getElementById("bed_id").disabled = false;
        var room = <?php echo old('room_id') ?>;
        $("#bed").load({!! json_encode(url('/ward/getBeds')) !!}  +'/' + room + '/0');
    </script>
    <?php } ?>

    <?php if(old('bed_id'))
    {?>
    <script type="text/javascript">
        document.getElementById("bed_id").disabled = false;
    </script>
    <?php } ?>

@endsection

