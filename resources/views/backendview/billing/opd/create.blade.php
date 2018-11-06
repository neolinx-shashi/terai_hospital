@extends('backendlayout.master')
@extends('backendlayout.header')
@extends('backendlayout.leftmenu')
@extends('backendlayout.footer')
@section('userscontent')
    @extends('backendlayout.flashmessagecollection')
    <script src="{{URL::asset('backendtheme/plugins/jQuery/jQuery-2.1.4.min.js')}}"></script>
    <link rel="stylesheet" type="text/css"
          href="{{URL::asset('backendtheme/lib/nepali.datepicker.v2/css/bootstrap.min.css')}}"/>
    <link rel="stylesheet" type="text/css"
          href="{{URL::asset('backendtheme/lib/nepali.datepicker.v2/nepali.datepicker.v2.min.css')}}"/>
    <div class="search-breadcrumb">
        <div class="row">
            <!--  <div class="col-lg-6">
                 <div class="search input-group">
                     <span class="input-group-addon"
                           style="color: white; background-color: #f39c12;">SEARCH OPD PATIENT</span>
                     <input type="text" autocomplete="off" id="search" class="form-control input-lg"
                            placeholder="Patient code/Name/contact number">
                 </div>
             </div> -->

            <div class="col-lg-12">
                <ol class="breadcrumb">
                    <li><a href="{{url('dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                    <li><a href="{{URL('configuration/patient/create')}}">Create Patient</a></li>
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
                    $.get("{{ url('renew/patient?id=') }}" + str, function (data) {
                        $("#txtHint").html(data);
                        $('.content').hide();
                        $('.content-header').hide();
                    });
                }
            });
        });
    </script>
    <section class="content">
        <div class="row">
            <div class="col-md-12 ">
                <div class="box">
                    <div class="container">
                        <br/>
                        <form method="post" action="{{URL::action('Billing\PatientController@store')}}" id="createForm">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            <div class="form-group row">
                                <!-- <div class="col-sm-8"> -->
                                <label for="inputfname" class="col-sm-1 form-control-label">Patient Code <span
                                            style="color: #b30000"> </span></label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="inputfname" value="{{$patientCode}}"
                                           disabled>
                                </div>
                                <!-- </div> -->
                                <div class="col-sm-5" style="text-align: right;">

                                    @if(Session::get('opd_patient_id'))

                                        <a href="{{ URL::to('configuration/patient/' . Session::get('opd_patient_id') . '/print-invoice/pat') }}"
                                           title="Print Patient Invoice"
                                           data-rel="tooltip">
                                            <button type="button" class="btn btn-primary btn-flat  "
                                                    style="margin-left: 10px;">
                                                <span class="glyphicon glyphicon-print" aria-hidden="true"></span>
                                                Print OPD Ticket
                                            </button>
                                        </a>

                                        <a href="{{URL::action('Billing\PatientController@create')}}">
                                            <button type="button" class="btn btn-success btn-flat"
                                                    style="margin-left: 10px;">
                                                <span class="fa fa-user-plus" aria-hidden="true"></span> New OPD Patient
                                            </button>
                                        </a>
                                    @endif
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="first_name" class="col-sm-1 form-control-label">Patient Name<span
                                            style="color: #b30000"> * </span><span
                                            style="color: #b30000"> </span></label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="first_name" name="first_name"
                                           placeholder="Patient full name" value="{{old('first_name')}}">
                                    @if ($errors->has('first_name'))
                                        <span class="help-block" style="color: red">
                                            <strong> * {{ $errors->first('first_name') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <label for="inputcontact" class="col-sm-1 form-control-label">Phone/Mobile<span
                                            style="color: #b30000"> * </span></label>
                                <div class="col-sm-4">
                                    <input type="number" class="form-control" id="inputcontact" name="phone"
                                           placeholder="Enter phone/Mobile Number" value="{{old('phone')}}"
                                           maxlength="15" min="0">
                                    @if ($errors->has('phone'))
                                        <span class="help-block" style="color: red">
                                <strong> * {{ $errors->first('phone') }}</strong>
                            </span>
                                    @endif
                                </div>


                                {{--<label for="inputmname" class="col-sm-1 form-control-label">Last Name <span style="color: #b30000"> * </span></label>
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
                                <label for="inputlname" class="col-sm-1 form-control-label">Middle Name</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="inputlname" name="middle_name"
                                           placeholder="Patient middle name" value="{{old('middle_name')}}">
                                </div>

                            </div>--}}

                            <div class="form-group row">
                                <label for="age" class="col-sm-1 form-control-label">Age <span
                                            style="color: #b30000"> * </span></label>
                                <div class="col-sm-4">
                                    <input type="number" class="form-control" id="age" name="age"
                                           placeholder="Patient age" value="{{old('age')}}" maxlength="3" max="120"
                                           min="0">
                                    @if ($errors->has('age'))
                                        <span class="help-block" style="color: red">
                                <strong> * {{ $errors->first('age') }}</strong>
                            </span>
                                    @endif
                                </div>

                                <label for="gender" class="col-sm-1 form-control-label">Gender<span
                                            style="color: #b30000"> * </span></label>
                                <div class="col-sm-4">
                                    <div class="radio">
                                        <label><input type="radio" name="gender" id="gender"
                                                      value="Male" @if(old('gender')=='Male') <?php echo 'checked' ?> @endif>Male</label>
                                        &nbsp;
                                        <label><input type="radio" name="gender" id="gender"
                                                      value="Female" @if(old('gender')=='Female') <?php echo 'checked' ?> @endif>Female</label>
                                        &nbsp;
                                        <label><input type="radio" name="gender" id="gender"
                                                      value="Others" @if(old('gender')=='Others') <?php echo 'checked' ?> @endif>Other</label>
                                        @if ($errors->has('gender'))
                                            <span class="help-block" style="color: red">
                                            <strong> * {{ $errors->first('gender') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                            </div>

                            <div class="form-group row">

                                <label for="nationality_id" class="col-sm-1 form-control-label">Nationality
                                </label>
                                <div class="col-sm-4">
                                    <select name="nationality_id" id="nationality_id" class="form-control">
                                        <option value=" ">Select Nationality</option>
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

                                <label for="medfee" class="col-sm-1 form-control-label">Medical Department <span
                                            style="color: #b30000"> * </span></label>
                                <div class="col-sm-4">

                                    <select name="department_id" id="district" class="form-control">
                                        <option value="">Select a Department</option>
                                        @foreach($departments as $department)
                                            <option value="{{ $department->id }}" @if(old('department_id')==$department->id)
                                                <?php echo 'selected' ?>
                                                    @endif>{{ ucwords($department->name) }}</option>
                                        @endforeach
                                    </select>


                                    @if ($errors->has('department_id'))
                                        <span class="help-block" style="color: red">
                                                <strong> * {{ $errors->first('department_id') }}</strong>
                                            </span>
                                    @endif
                                </div>

                            </div>

                            <div class="form-group row">


                                <label for="district" class="col-sm-1 form-control-label">Consult to
                                </label>
                                <div class="col-sm-4">
                                    <div id="office_name">
                                        <select name="office_name" id="doctor1" class="form-control"
                                                disabled="disabled">
                                            <option value="">Please Select Department First</option>
                                        </select>


                                        @if ($errors->has('doctor_id'))
                                            <span class="help-block" style="color: red">
                                                <strong> * {{ $errors->first('doctor_id') }}</strong>
                                            </span>
                                        @endif

                                    </div>
                                </div>

                                <label for="doctor" class="col-sm-1 form-control-label">Consulting Charge</label>
                                <div class="col-sm-4">
                                    <div id="doctor_name">
                                        <input type="text" class="form-control" id="inputcontact"
                                               disabled placeholder="Doctor Not Selected yet">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">

                                <label for="consultdoc" class="col-sm-1 form-control-label">Appointment Date
                                </label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="datefrom" name="appointment"
                                           value="{{getTodayNepaliDate()}}" readonly>
                                </div>

                                <label for="discount_percent" class="col-sm-1 form-control-label">Discount % <span
                                            style="color: #b30000"> </span></label>
                                <div class="col-sm-2">
                                    <input type="number" class="form-control" id="discount_percent"
                                           name="discount_percent"
                                           placeholder="Discount percentage" value="{{old('discount_percent')}}"
                                           max="100" min="0">
                                    @if ($errors->has('discount_percent'))
                                        <span class="help-block" style="color: red">
                    <strong> * {{ $errors->first('discount_percent') }}</strong>
                </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">


                                <label for="permanent_address" class="col-sm-1 form-control-label">Address <span
                                            style="color: #b30000"> * </span></label>
                                <div class="col-sm-4">


                                    <textarea class="form-control col-md-5" id="permanent_address"
                                              name="permanent_address" rows="3"
                                              placeholder="Only 80 character are allowed"
                                              maxlength="80">{{old('permanent_address')}}</textarea>

                                    @if ($errors->has('permanent_address'))
                                        <span class="help-block" style="color: red">
                                <strong> * {{ $errors->first('permanent_address') }}</strong>
                            </span>
                                    @endif


                                </div>

                                <label for="generalsymp" class="col-sm-1 form-control-label">Description
                                </label>
                                <div class="col-md-4">
                                    <textarea class="form-control col-md-5" id="generalsymp" name="symptoms" rows="3"
                                              maxlength="150"
                                              placeholder="Only 150 character are allowed">{{old('symptoms')}}</textarea>
                                    @if ($errors->has('generalsymp'))
                                        <span class="help-block" style="color: red">
                                        <strong> * {{ $errors->first('generalsymp') }}</strong>
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
                                    <button type="reset" class="col-md-3 col-lg-offset-0 btn btn-warning btn-flat"
                                            style="margin-left: 10px; float: right;">
                                        Reset
                                    </button>
                                    <button type="submit"
                                            class="col-md-3 col-lg-offset-1 btn btn-primary btn-flat print-button-spot"
                                            style="float: right;" onclick="hideSubmitBtn()">
                                        Save
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
                        <h3 class="box-title">Registered Patient Today - ({{count($registeredPatientToday)}})</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        @if(count($patients)>0)
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
                                $i = $patients->firstItem();

                                ?>
                                @foreach($patients as $patientData)

                                    <tr @if($patientData->id ==Session::get('opd_patient_id')) style="background-color:#9fdfbf" @endif>
                                        <td>
                                            {{$i++}}.
                                        </td>

                                        <td>
                                            {{ucfirst($patientData->first_name)}}

                                            {{ucfirst($patientData->middle_name)}}
                                            {{ucfirst($patientData->last_name)}}
                                            <br>
                                            {{$patientData->patient_code}}
                                        </td>
                                        <td>
                                            <?php
                                            $todayDate = date('Y-m-d', strtotime($patientData->created_at));
                                            $localDate = str_replace("-", ",", $todayDate);
                                            $classes = explode(",", $localDate);
                                            $a = $classes[0];
                                            $b = $classes[1];
                                            $c = $classes[2];
                                            echo eng_to_nep($a, $b, $c);
                                            echo '&nbsp';
                                            echo date('h:i A', strtotime($patientData->created_at));
                                            ?>
                                        </td>
                                        <td>
                                            <a href="{{ URL::to('configuration/patient/' . $patientData->id . '/edit') }}"
                                               title="Edit Patient Details"
                                               data-rel="tooltip">
                                                <button type="button" class="btn btn-default btn-flat  ">
                                                    <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                                                </button>
                                            </a>
                                            <a href="{{URL::to('configuration/patient/' .$patientData->id)}}"
                                               title="View Patient Details"
                                               data-rel="tooltip">
                                                <button type="button" class="btn btn-default btn-flat ">
                                                    <span class="glyphicon glyphicon-zoom-in" aria-hidden="true"></span>
                                                </button>
                                            </a>
                                        </td>
                                        <td>

                                            <a href="{{ URL::to('configuration/patient/' . $patientData->id . '/print-invoice/rep') }}"
                                               title="Print Patient Invoice"
                                               data-rel="tooltip">
                                                <button type="button" class="btn btn-default btn-flat ">
                                                    <span class="glyphicon glyphicon-print" aria-hidden="true"></span>
                                                    Print OPD Ticket
                                                </button>


                                            </a>


                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {{$patients->render()}}
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
            $('#district').change(function () {
                var officeName = $(this).val();

                $("#office_name").load({!! json_encode(url('/enterprise/register/getOffices/')) !!}  +'/' + officeName + '/0');
            });
        });

        function changeData() {
            var doctorName = $('#doctor').val();
            $("#doctor_name").load({!! json_encode(url('/patient/data/getDoctorCharge/')) !!}  +'/' + doctorName + '/0');

        }
    </script>


    <?php if(old('department_id') && old('department_id'))
    {?>
    <script type="text/javascript">
        window.onload = function () {
            var officeId = {{old('department_id')}};
            $("#office_name").load({!! json_encode(url('/enterprise/register/getOffices/')) !!}  +'/' + officeId + '/0');


            var doctorName = $('#doctor').val();
            $("#doctor_name").load({!! json_encode(url('/patient/data/getDoctorCharge/')) !!}  +'/' + doctorName + '/0');


        }
    </script>
    <?php } ?>




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
                    phone: {
                        required: true,
                        maxlength: 15,
                        number: true
                    },
                    address: "required",


                    department_id: {
                        required: true
                    },
                    doctor_id: {
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
                    phone: {
                        required: "Please enter phone number",
                        maxlength: "phone number can be maximum 15 digits",
                        number: "Only numeric character allowed"
                    },
                    address: "Please enter address",

                    department_id: "Please select the department",
                    doctor_id: "Please select the doctor"
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

    <script type="text/javascript">
        $(document).ready(function () {


            $('#datefrom').nepaliDatePicker({
                ndpEnglishInput: 'englishDate'
            });


        });

        function hideSubmitBtn() {
            $('.print-button-spot').hide();
        }
    </script>
@endsection

