@extends('backendlayout.master')
@extends('backendlayout.header')
@extends('backendlayout.leftmenu')
@extends('backendlayout.footer')
@section('userscontent')
    @extends('backendlayout.flashmessagecollection')
    <script src="{{URL::asset('backendtheme/plugins/jQuery/jQuery-2.1.4.min.js')}}"></script>
    <div class="search-breadcrumb">
        <div class="row">
            <div class="col-lg-6">
               <!--  <div class="search input-group">
                    <span class="input-group-addon"
                    style="color: white; background-color: #f39c12;">SEARCH PATIENT</span>
                    <input type="text" autocomplete="off" id="search" class="form-control input-lg"
                    placeholder="Patient code/Name/contact number">
                    </div> -->
            </div>

            <div class="col-lg-6">
                <ol class="breadcrumb">
                    <li><a href="{{url('dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                    <li><a href="{{URL('emergency/patient/create')}}">Emergency Patient</a></li>
                    <li class="active">Create Patient</li>
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
                    $.get("{{ url('live-emergency/patient?id=') }}" + str, function (data) {
                        $("#txtHint").html(data);
                        $('.content').hide();
                        $('.content-header').hide();
                    });
                }
            });
        });
    </script>
   <!-- form only -->

@include('backendview.emergency.addform')

    <!-- patient today  only -->
@include('backendview.emergency.patient_todayonly')


    <script type="text/javascript">
        $(function () {
            $('input[name="appointment"]').daterangepicker({

                    locale: {
                        format: 'YYYY-MM-DD'
                    },
                    singleDatePicker: true,
                    showDropdowns: true
                },
                function (start, end, label) {
                    var years = moment().diff(start, 'years');

                });
        });
    </script>

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


    <?php if(old('doctor_id') && old('doctor_id'))
    {?>
    <script type="text/javascript">
       var doctorName = $('#doctor').val();
            $("#doctor_name").load({!! json_encode(url('/patient/data/getDoctorCharge/')) !!}  +'/' + doctorName + '/0');
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

                    gender:{required:true},

                    permanent_address: "required",

                    doctor_id: {
                        required: true
                    },
                     bed_id: {
                        required: true
                    },
                    nationality_id: {
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
                        maxlength: "Phone can be maximum 15 digits",
                        number: "Only numeric character allowed"
                    },   
                        gender:"Please Select your gender" ,            
                        permanent_address: "Please enter address",

                    doctor_id: "Please select Doctor",
                    bed_id:"Please select Bed",
                    nationality_id:"Please select Nationality"

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
@endsection

