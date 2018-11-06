<div class="box add-patient">
    <div class="container"><br>
        <form method="post"
              id="ipdForm">
            {{ csrf_field() }}
            <input type="hidden" name="patientiId" id="patientiId" value="{{ $editPatients->id }}">

            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <input type="hidden" name="patient_code" value="{{$editPatients->patient_code}}">
            <input type="hidden" name="first_name" value="{{$editPatients->first_name}}">
            <input type="hidden" name="middle_name" value="{{$editPatients->middle_name}}">
            <input type="hidden" name="last_name" value="{{$editPatients->last_name}}">
            <input type="hidden" name="phone" value="{{$editPatients->phone}}">
            <input type="hidden" name="gender" value="{{$editPatients->gender}}">
            <input type="hidden" name="age" value="{{$editPatients->age}}">
            <input type="hidden" name="nationality_id" value="{{$editPatients->nationality_id}}">
            <div class="form-group row">
                <!--  <label for="inputfname" class="col-sm-1 form-control-label">Patient Id <span
                             style="color: #b30000"> </span></label>
                             -->
                <div class="col-sm-4">

                </div>

                <input type="hidden" class="form-control" id="inputfname" name="patient_code"
                       value="{{$editPatients->patient_code}}"
                >
                <div class="col-sm-5" style="text-align: right;" id="iprintTicket">

                <!-- @if(Session::get('renew_ipatient'))

                    <a href="{{ URL::to('ip-enrollment/ipatient/' . Session::get('renew_ipatient') . '/print-admit-invoice') }}"
                                           title="Print Patient Invoice"
                                           data-rel="tooltip">
                                            <button type="button" class="btn btn-success btn-flat  "
                                                    style="margin-left: 10px;">
                                                <span class="glyphicon glyphicon-print" aria-hidden="true"></span>
                                                Print IPD Sticker
                                            </button>
                                        </a>

                                        <a href="{{URL::action('BackEndController\IPDController@create')}}">
                                            <button type="button" class="btn btn-success btn-flat"
                                                    style="margin-left: 10px;">
                                                <span class="fa fa-user-plus" aria-hidden="true"></span> Admit IPD
                                                Patient
                                            </button>
                                        </a>
                                    @endif -->
                </div>
            </div>

        <!--  <div class="form-group row">

                                <label for="inputfname" class="col-sm-1 form-control-label">First
                                    Name<label class="text-danger">*</label></label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="inputfname"
                                           name="first_name"
                                           placeholder="Patient first name" value="{{old('first_name')}}">
                                    @if ($errors->has('first_name'))
            <span class="help-block" style="color: red">
            <strong> * {{ $errors->first('first_name') }}</strong>
                                    </span>
                                    @endif
                </div>

                <label for="inputmname" class="col-sm-1 form-control-label">Last
                    Name<label class="text-danger">*</label></label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="inputmname" name="last_name"
                           placeholder="Patient last name" value="{{old('last_name')}}">
                                    @if ($errors->has('last_name'))
            <span class="help-block" style="color: red">
            <strong> * {{ $errors->first('last_name') }}</strong>
                                    </span>
                                    @endif
                </div>
            </div> -->

        <!--   <div class="form-group row">
                                <label for="inputlname" class="col-sm-1 form-control-label">Middle
                                    Name</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="inputlname"
                                           name="middle_name"
                                           placeholder="Patient middle name">
                                </div>

                                <label for="inputcontact" class="col-sm-1 form-control-label">Phone/Mobile<label
                                            class="text-danger">*</label></label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="inputcontact" name="phone"
                                           placeholder="Phone" value="{{old('phone')}}">
                                    @if ($errors->has('phone'))
            <span class="help-block" style="color: red">
            <strong> * {{ $errors->first('phone') }}</strong>
                                    </span>
                                    @endif
                </div>


            </div>
-->
        <!-- <div class="form-group row">
                                

                                <label for="inputage" class="col-sm-1 form-control-label">Age</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="target" name="age"
                                           placeholder="Patient age" value="{{ old('age') }}">
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
        </div> -->

            <div class="form-group row">

                <label for="doctor_id" class="col-sm-1 form-control-label">Doctor<label
                            class="text-danger">*</label></label>
                <div class="col-md-4">
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
                        <option value="A+" @if($editPatients->bloodGroup_id=='A+')  <?php echo 'selected'?> @endif>
                            A Positive
                        </option>
                        <option value="A-" @if($editPatients->bloodGroup_id=='A-')  <?php echo 'selected'?> @endif>
                            A Negative
                        </option>
                        <option value="A" @if($editPatients->bloodGroup_id=='A')  <?php echo 'selected'?> @endif>
                            A Unknown
                        </option>
                        <option value="B+" @if($editPatients->bloodGroup_id=='B+')  <?php echo 'selected'?> @endif>
                            B Positive
                        </option>
                        <option value="B-" @if($editPatients->bloodGroup_id=='B-')  <?php echo 'selected'?> @endif>
                            B Negative
                        </option>
                        <option value="B" @if($editPatients->bloodGroup_id=='B')  <?php echo 'selected'?> @endif>
                            B Unknown
                        </option>
                        <option value="AB+" @if($editPatients->bloodGroup_id=='AB+')  <?php echo 'selected'?> @endif>
                            AB Positive
                        </option>
                        <option value="AB-" @if($editPatients->bloodGroup_id=='AB-')  <?php echo 'selected'?> @endif>
                            AB Negative
                        </option>
                        <option value="AB" @if($editPatients->bloodGroup_id=='AB')  <?php echo 'selected'?> @endif>
                            AB Unknown
                        </option>
                        <option value="O+" @if($editPatients->bloodGroup_id=='O+')  <?php echo 'selected'?> @endif>
                            O Positive
                        </option>
                        <option value="O-" @if($editPatients->bloodGroup_id=='O-')  <?php echo 'selected'?> @endif>
                            O Negative
                        </option>
                        <option value="O" @if($editPatients->bloodGroup_id=='O')  <?php echo 'selected'?> @endif>
                            O Unknown
                        </option>
                        <option value="unknown" @if($editPatients->bloodGroup_id=='unknown')  <?php echo 'selected'?> @endif>
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
                                                      maxlength="80">{{$editPatients->permanent_address}}</textarea>

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
                           placeholder="Deposit Amount" min="0">

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
                        @foreach($wardsIpd as $ward)
                            <option value="{{ $ward->id }}"
                            @if(old('ward_id')==$ward->id)
                                <?php echo 'selected' ?>
                                    @endif
                            >{{ $ward->ward_name}}</option>
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
                            <option value="">Select Room Type</option>
                            <option value="deluxe">Deluxe</option>
                            <option value="twobed">Two Bed</option>
                            <option value="onebed">One Bed</option>
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
                        @foreach($roomsIpd as $room)
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
                        @foreach($bedsIpd as $bed)
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
                <div class="col-md-4">
                    <p><strong>Note :</strong> Field With <span style="color: #b30000"> (*) </span> are
                        mandatory </p>
                </div>

                <div class="col-md-6">
                    <button type="submit" class="col-md-3 col-lg-offset-0 btn btn-success btn-flat print-button-spot"
                            style="margin-left: 10px; float: right;">Readmit
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $("#ipdForm").validate({
            rules: {
                permanent_address: "required",

                department_id: {
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
                },
                doctor_id: {
                    required: true
                }
            },
            messages: {
                permanent_address: "Please enter address",
                department_id: "Please select the department",
                ward_id: "Please select the ward",
                room_id: "Please select the room",
                bed_id: "Please select the Bed",
                doctor_id: "Please select the doctor"
            },
            errorElement: "em",
            errorPlacement: function (error, element) {
                error.addClass("help-block");
                error.insertAfter(element);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).parents(".col-sm-4").addClass("has-error").removeClass("has-success");
                $(element).parents(".col-sm-2").addClass("has-error").removeClass("has-success");
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).parents(".col-sm-4").addClass("has-success").removeClass("has-error");
                $(element).parents(".col-sm-2").addClass("has-error").removeClass("has-error");
            }
        });
    });

    $("#ipdForm").on("submit", function (e) {
        if ($('#doctor_id').val() == "") {
            alert('Please select a doctor!')
        } else {
            $('.print-button-spot').hide();

            e.preventDefault();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "/ipd/patient/ipd/" + $("#patientiId").val(),
                data: $(this).serialize(),
                success: function (data) {
                    console.log(data);

                    var eid = data.ipdadmit;
                    var xurl = "{{ url('ip-enrollment/ipatient') }}/" + eid + '/print-admit-invoice';

                    var eURL = '<a href="' + xurl + '" title="Print Patient Invoice" data-rel="tooltip"> <button type="button" class="btn btn-primary btn-flat " style="margin-left: 10px;"> <span class="glyphicon glyphicon-print" aria-hidden="true"></span>Print IPD Ticket</button></a>';

                    $('#bids').html('<div class="alert alert-success col-sm-12" >' + data.msg + '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button></div>');
                    $('#iprintTicket').html(eURL);
                    $('#errorDiv').css({"display": "none"});
                },
                error: function (xhr, ajaxOptions, thrownError) {
                }
            });
        }
    });
</script>
     
