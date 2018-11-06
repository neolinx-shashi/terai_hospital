
<script src="{{URL::asset('backendtheme/plugins/jQuery/jQuery-2.1.4.min.js')}}"></script>

<div class="box">
    <div class="container">
        <br/>
        <form method="post"  id="emergencyForm">

            <input type="hidden" name="patientId" id="patientId" value="{{ $editPatients->id }}">

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
                <!-- <label for="inputfname" class="col-sm-1 form-control-label">Patient Id <span
                            style="color: #b30000"> </span></label>-->
                <div class="col-sm-4">

                </div>
                <input type="hidden" name="patient_code" value="{{$editPatients->patient_code}}">
                <div class="col-sm-5" style="text-align: right;" id="printTicket" >







                <!--   <a href="{{url('emergency/patient/create')}}">
                    <button type="button" class="btn btn-success btn-flat"
                            style="margin-left: 10px;">
                        <span class="fa fa-user-plus" aria-hidden="true"></span> New Emergency Patient
                    </button>
                </a> -->



                </div>
            </div>


        <!--  <div class="form-group row">
                    <label for="first_name" class="col-sm-1 form-control-label">First Name<span style="color: #b30000"> * </span><span
                                style="color: #b30000"> </span></label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="first_name" name="first_name"
                               placeholder="Patient first name" value="{{$editPatients->first_name}}">
                        @if ($errors->has('first_name'))
            <span class="help-block" style="color: red">
    <strong> * {{ $errors->first('first_name') }}</strong>
                </span>
                        @endif
                </div>
                <label for="inputmname" class="col-sm-1 form-control-label">Last Name <span style="color: #b30000"> * </span></label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="inputmname" name="last_name"
                           placeholder="Patient last name" value="{{$editPatients->last_name}}">
                        @if ($errors->has('last_name'))
            <span class="help-block" style="color: red">
    <strong> * {{ $errors->first('last_name') }}</strong>
                </span>
                        @endif
                </div>

            </div> -->

        <!--  <div class="form-group row">
                    <label for="inputlname" class="col-sm-1 form-control-label">Middle Name</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="inputlname" name="middle_name"
                        placeholder="Patient middle name" value="{{$editPatients->middle_name}}">
                    </div>


                    <label for="age" class="col-sm-1 form-control-label">Age <span style="color: #b30000">* </span></label>
                    <div class="col-sm-4">
                        <input type="number" class="form-control" id="age" name="age"
                         placeholder="Patient age" value="{{$editPatients->age}}" maxlength="3" max="120">
                    </div>
                </div> -->

        <!--   <div class="form-group row">

                 <label for="inputcontact" class="col-sm-1 form-control-label">Phone/Mobile
                 <span style="color: #b30000"> * </span><span
                                style="color: #b30000"> </span></label>
                    <div class="col-sm-4">
                        <input type="number" class="form-control" id="inputcontact" name="phone"
                               placeholder="Enter phone/Mobile Number" value="{{$editPatients->phone}}"
                               maxlength="15">
                        @if ($errors->has('phone'))
            <span class="help-block" style="color: red">
    <strong> * {{ $errors->first('phone') }}</strong>
                </span>
                        @endif
                </div>


                            <label for="gender" class="col-sm-1 form-control-label">Gender
                            <span style="color: #b30000"> * </span><span
                            style="color: #b30000"> </span></label>
                            <div class="col-sm-4">
                                <div class="radio" name="gender">
                             <label><input type="radio" name="gender" id="gender"
                            value="Male" @if($editPatients->gender=='Male') <?php echo 'checked' ?> @endif>Male</label>
                                        &nbsp;
                                <label><input type="radio" name="gender" id="gender"
                        value="Female" @if($editPatients->gender=='Female') <?php echo 'checked' ?> @endif>Female</label>
                                        &nbsp;
                    <label><input type="radio" name="gender" id="gender"
                     value="Others" @if($editPatients->gender=='Others') <?php echo 'checked' ?> @endif>Other</label>
                                @if ($errors->has('gender'))
            <span class="help-block" style="color: red">
            <strong> * {{ $errors->first('gender') }}</strong>
                                </span>
                                @endif
                </div>
            </div>
         </div> -->

            <div class="form-group row">


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
                <label for="district" class="col-sm-1 form-control-label">Emergency Doctor
                    <span style="color: #b30000"> * </span><span
                            style="color: #b30000"> </span></label>
                <div class="col-sm-4">
                    <div id="office_name">
                        <select name="doctor_id"  class="form-control" >
                            <option value="">Please Select Doctor</option>
                            @foreach($doctorByDepartment as $doctor)
                                <?php $selected = (old('doctor_id') == $doctor->id) ? "selected='selected" : null;
                                ?>
                                <option value="{{$doctor->id}}" {{$selected}}>
                                    {{ucfirst($doctor->first_name)}}
                                    {{ucfirst($doctor->middle_name)}}
                                    {{ucfirst($doctor->last_name)}}
                                </option>
                            @endforeach
                        </select>




                        @if ($errors->has('doctor_id'))
                            <span class="help-block" style="color: red">
                                                <strong> * {{ $errors->first('doctor_id') }}</strong>
                                            </span>
                        @endif

                    </div>
                </div>

            </div>

            <div class="form-group row">


                <label for="doctor" class="col-sm-1 form-control-label">Emergency Fee</label>
                <div class="col-sm-4">
                    <div id="doctor_name">
                        <input type="text" class="form-control" name="doctor_fee" id="inputcont" value="{{$emergencyFee->emergency_fee}}" placeholder="Doctor Not Selected yet" disabled="disabled">
                    </div>
                </div>

            </div>

            <div class="form-group row">
                <label for="address" class="col-sm-1 form-control-label">Address
                    <span style="color: #b30000"> * </span>
                </label>
                <div class="col-sm-4">
                                <textarea class="form-control col-md-5" id="address" name="permanent_address" rows="3" placeholder="Only 80 character are allowed"
                                          maxlength="80">{{$editPatients->permanent_address}}</textarea>

                    @if ($errors->has('permanent_address'))
                        <span class="help-block" style="color: red">
                                <strong> * {{ $errors->first('permanent_address') }}</strong>
                            </span>
                    @endif
                </div>

                <label for="description" class="col-sm-1 form-control-label">Description
                </label>
                <div class="col-md-4">
                                    <textarea class="form-control col-md-5" id="description" name="description" rows="3"
                                              maxlength="150"
                                              placeholder="Only 150 character are allowed">{{$editPatients->description}}</textarea>
                    @if ($errors->has('description'))
                        <span class="help-block" style="color: red">
                             <strong> * {{ $errors->first('description') }}</strong>
                           </span>
                    @endif
                </div>

            </div>




            <h5>Room and Bed Placement:</h5>

            <div class="form-group row">
                <label style="margin:5px -50px 0 0px; " for="RefAddress"
                       class="col-sm-1 form-control-label">Room<label
                            class="text-danger"></label></label>
                <div class="col-sm-2" id="rooms">

                    <input type="text" name="" class="form-control" value="{{$rooms->room_name}}" disabled="disabled">

                    <input type="hidden" name="room_id" class="form-control" value="{{$rooms->id}}">

                    <input type="hidden" name="room_charge" class="form-control" value="{{$rooms->room_rate}}">

                </div>

                <label style="margin:5px -50px 0 0px; " for="RefAddress"
                       class="col-sm-1 form-control-label">Bed<label
                            class="text-danger">*</label></label>
                <div class="col-sm-2" id="bed">
                    <select name="bed_id" id="beds" class="form-control" >
                        <option value="">Select Bed</option>
                        @foreach($beds as $bed)
                            <option value="{{ $bed->id }}"
                            @if(old('bed_id')==$bed->id)
                                <?php echo 'selected' ?>
                                    @endif
                            >{{ ucfirst($bed->bed_name)}}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('bed_id'))
                        <span class="help-block" style="color: red">
                                        <strong> * {{ $errors->first('bed_id') }}</strong>
                                    </span>
                    @endif
                </div>

                <label style="margin:5px -50px 0 0px; " for="RefAddress"
                       class="col-sm-1 form-control-label"> {{$availableBeds}} Beds Available out of {{$totalBeds}}

            </div>


            <div class="form-group row">
                <div class="col-md-4">
                    <p><strong>Note :</strong> Field With <span style="color: #b30000"> (*) </span> are
                        mandatory </p>
                </div>
                <div class="col-md-6">

                    <button type="submit" class="col-md-3 col-lg-offset-1 btn btn-success btn-flat print-button-spot" style="float: right;">
                        Readmit
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
</div>


<script>
    $("#emergencyForm").on("submit", function (e) {
        $('.print-button-spot').hide();


        e.preventDefault();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        $.ajax({
            type: "POST",
            url: "/emergency/patient/emergency/" + $("#patientId").val(),
            data: $(this).serialize(),
            success: function (data) {
                console.log(data);

                var eid=data.emergency;
                //var xurl = "{{url('emergency/patient/"+eid+"/print-invoice')}}"; 
                var xurl = "{{ url('emergency/patient') }}/" + eid + '/print-invoice/pat';

                var eURL='<a href="'+xurl+'" title="Print Patient Invoice" data-rel="tooltip"> <button type="button" class="btn btn-primary btn-flat " style="margin-left: 10px;"> <span class="glyphicon glyphicon-print" aria-hidden="true"></span> Print Emergency Ticket</button></a>';

                $('#bids').html('<div class="alert alert-success col-sm-12" >' + data.msg + '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button></div>');
                $('#printTicket').html(eURL);
                $('#errorDiv').css({"display": "none"});
            },
            error: function (xhr, ajaxOptions, thrownError) {
            }
        });
    });
</script>




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

        $('#ward').change(function () {
            document.getElementById("room").disabled = false;
            var officeName = $(this).val();
            $("#room").load({!! json_encode(url('/ward/getRooms')) !!}  +'/' + officeName + '/0');
        });



        $('#room').change(function () {
            document.getElementById("bed").disabled = false;
            var beds = $(this).val();
            $("#bed").load({!! json_encode(url('/ward/getBeds')) !!}  +'/' + beds + '/0');
        });
    });

    $(function () {
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
    });
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#emergencyForm").validate({
            rules: {


                permanent_address: "required",

                doctor_id: {
                    required: true
                },
                bed_id: {
                    required: true
                },


            },
            messages: {


                doctor_id: "Please select Doctor",
                bed_id:"Please select Bed",
                permanent_address:"Please select Bed",

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
</script>