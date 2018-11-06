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
            <div class="search input-group">
                <span class="input-group-addon" style="color: white; background-color: #f39c12;">SEARCH PATIENT</span>
                <input type="text" autocomplete="off" id="search" class="form-control input-lg" placeholder="Patient code/Name/contact number">
            </div>
        </div>

        <div class="col-lg-6">
            <ol class="breadcrumb">
                <li><a href="#{{url('Dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li><a href="{{URL('configuration/patient/create')}}">Create Patient </a></li>
                <li class="active">Renew Patient</li>
            </ol>
        </div>
    </div>   
</div>  
<div id="txtHint" class="title-color" style="padding-top:10px; " ></div>  
<script>
    $(document).ready(function(){
     $("#search").keyup(function(){
         var str=  $("#search").val();
         if(str == "") {
              $( "#txtHint" ).html("");
             $('.content').show(); 
         }else {
             $.get( "{{ url('renew/patient?id=') }}"+str, function( data ) {
                 $( "#txtHint" ).html( data );
                 $('.content').hide();
                 $('.content-header').hide();
             });
         }
     });  
 }); 
</script>
<section class="content-header">
 
 
</section>

<section class="content">
  <div class="row">
    <div class="col-md-12 ">
        <div class="box">

            <div class="container">
                <br/>
                <form method="post" action="{{URL::action('BackEndController\RenewPatientController@store')}}" id="createForm">

                {{ csrf_field() }}
                <input type="hidden" name="patient_code" value="{{$editPatients->patient_code}}">

                <div class="form-group row">
                            <label for="inputfname" class="col-sm-1 form-control-label">Patient Id <span style="color: #b30000"> </span></label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" id="inputfname" value="{{$editPatients->patient_code}}" 
                                disabled>
                            </div>
                        </div>
                <div class="form-group row">
                    <label for="inputfname" class="col-sm-1 form-control-label">First Name<span style="color: #b30000"> * </span></label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="inputfname" name="first_name"
                        placeholder="First Name" value="{{$editPatients->first_name}}">
                    </div>


                    <label for="inputmname" class="col-sm-1 form-control-label">Last Name<span style="color: #b30000"> * </span></label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="inputmname" name="last_name"
                        placeholder="Middle Name" value="{{$editPatients->last_name}}">
                    </div>

                    
                </div>

                <div class="form-group row">
                    <label for="inputlname" class="col-sm-1 form-control-label">Middle Name</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="inputlname" name="middle_name"
                        placeholder="Last Name" value="{{$editPatients->middle_name}}">
                    </div>

                    <label for="inputage" class="col-sm-1 form-control-label">Age<span style="color: #b30000"> * </span></label>
                    <div class="col-sm-4">
                        <input type="number" class="form-control" id="inputage" name="age"
                        placeholder="Age" value="{{$editPatients->age}}" maxlength="3" max="120">
                    </div>
                </div>

                <div class="form-group row">
                    

                    <label for="inputcontact" class="col-sm-1 form-control-label">Phone/Mobile<span style="color: #b30000"> * </span></label>
                    <div class="col-sm-4">
                        <input type="number" class="form-control" id="inputcontact" name="phone"
                        placeholder="Phone" value="{{$editPatients->phone}}" maxlength="15">
                    </div>

                    <label for="gender" class="col-sm-1 form-control-label">Gender<span style="color: #b30000"> * </span></label>
                    <div class="col-sm-4">
                        <div class="radio" name="gender">
                         <label><input type="radio" name="gender" value="Male" @if($editPatients->gender=='Male') <?php echo 'checked'?> @endif >Male</label>
                         &nbsp;
                         <label><input type="radio" name="gender" value="female" @if($editPatients->gender=='Female') <?php echo 'checked'?> @endif>Female</label>
                         &nbsp;
                         <label><input type="radio" name="gender" value="female" @if($editPatients->gender=='Others') <?php echo 'checked'?> @endif>Others</label>

                     </div>
                </div>
                </div>

                <div class="form-group row">
                    
                <label for="consultdoc" class="col-sm-1 form-control-label">Nationality
                 </label>
                 <div class="col-sm-4">
                    <select name="nationality_id" id="consultdoc" class="form-control">
                        <option value="">Select  Nationality</option>
                        @foreach($nationality as $nationalities)
                        {{$nationalities->country_name}}
                        <option value="{{ $nationalities->id }}"
                            @if($nationalities->id==$editPatients->nationality_id)<?php echo 'selected' ?> @endif>{{ ucfirst($nationalities->country_name)}}</option>
                            @endforeach
                        </select>
                    </div>
                    <label for="medfee" class="col-sm-1 form-control-label">Medical Department<span style="color: #b30000"> * </span></label>
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
                                <select name="office_name" id="doctor1" class="form-control" disabled="disabled">
                                    <option value="" >Please Select Department First</option>
                                        
                                        </select>
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
                                    <input type="text" class="form-control" id="inputcontact" name="appointment">
                                </div>

                                 <label for="discount_percent" class="col-sm-1 form-control-label">Discount % <span style="color: #b30000"> </span></label>
                            <div class="col-sm-2">
                                <input type="number" class="form-control" id="discount_percent" name="discount_percent"
                                placeholder="Discount percentage" value="{{old('discount_percent')}}" max="100">
                                @if ($errors->has('discount_percent'))
                                <span class="help-block" style="color: red">
                                    <strong> * {{ $errors->first('discount_percent') }}</strong>
                                </span>
                                @endif
                            </div>
                            </div>

                            <div class="form-group row">

                            <label for="inputaddress" class="col-sm-1 form-control-label">Address<span style="color: #b30000"> * </span></label>
                            <div class="col-sm-4">
                                <textarea class="form-control col-md-5" id="address" name="permanent_address" rows="3" placeholder="Only 80 character are allowed"maxlength="80">{{$editPatients->permanent_address}}</textarea>
                            </div>
                                <label for="generalsymp" class="col-sm-1 form-control-label">Description
                                </label>
                                <div class="col-md-4">
                                    <textarea class="form-control col-md-5" id="generalsymp"  name="symptoms" rows="3" maxlength="150" placeholder="Only 150 character are allowed"></textarea>
                                </div>
                            </div>

                              
                            <hr>
                             <div class="form-group row">
                                <div class="col-md-4">
                                    <p><strong>Note :</strong> Field With <span style="color: #b30000"> (*) </span> are
                                        mandatory </p>
                                </div>

                                <div class="col-md-6">
                                    <button type="submit" class="col-md-3 col-lg-offset-0 btn btn-primary btn-flat"
                                            style="margin-left: 10px; float: left;">Renew
                                    </button>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </section>


    <section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">

                <div class="box-body">
                   @if(count($patients)>0)
                   <table  class="table table-hover table-bordered table-striped">
                    <thead>
                        <tr>
                            <th class="col-lg-1">S.N</th>
                            <th class="col-lg-4">Patient Full  Name /Code</th>
                            <th class="col-lg-2">Created At</th>
                            <th class="col-lg-2">Actions</th>
                            <th class="col-lg-3" >Print </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = $patients->firstItem();

                        ?>
                        @foreach($patients as $patientData)
                        <tr>
                            <td>
                                {{$i++}} .
                            </td>

                            <td>
                                {{ucfirst($patientData->first_name)}} &nbsp; {{ucfirst($patientData->middle_name)}} &nbsp;
                                {{ucfirst($patientData->last_name)}}
                                <br>
                                {{$patientData->patient_code}}
                            </td>

                            <td>
                             {{ date('Y-m-d h:i A',strtotime($patientData->created_at)) }}
                         </td>

                         <td>

                            <a href="{{URL::to('configuration/patient/' .$patientData->id)}}" title="View Doctor Details"
                             data-rel="tooltip">
                             <button type="button" class="btn btn-default btn-flat ">
                                <span class="glyphicon glyphicon-zoom-in" aria-hidden="true"></span>
                            </button>
                        </a>

                      
                    </td>

                    <td>



                        <a href="{{ URL::to('configuration/patient/' . $patientData->id . '/print-invoice') }}">
                            <button type="button" class="btn btn-default btn-flat  ">
                                <span class="glyphicon glyphicon-print" aria-hidden="true"> Print OPD Ticket</span>
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
        <strong style="padding-left: 300px"> Sorry ! No record found
        </strong>
    </div>
    @endif

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
                     phone: {
                        required: true,
                        maxlength: 15,
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
                    phone: {
                        required: "Please enter phone number",
                        maxlength: "phone number can be maximum 15 digits",
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

     <script type="text/javascript">
        $(document).ready(function () {
            $('#district').change(function () {
                var officeName = $(this).val();

                $("#office_name").load({!! json_encode(url('/enterprise/register/getOffices/')) !!}  +'/' + officeName + '/0');
            });
        });

        function changeData()
        {
            var doctorName = $('#doctor').val();
            $("#doctor_name").load({!! json_encode(url('/patient/data/getDoctorCharge/')) !!}  +'/' + doctorName + '/0');

        }
    </script>




    <?php if(old('enterprise_district_id') && old('enterprise_district_id') && old('office_id') > 0)
    {?>
    <script type="text/javascript">
        var officeId = {{old('office_id')}};
        var officeName = {{old('enterprise_district_id')}}
        $("#office_name").load({!! json_encode(url('/enterprise/register/getOffices/')) !!}  +'/' + officeName + '/' + officeId);
    </script>
    <?php } ?>

    <?php if(old('enterprise_type_id') && old('enterprise_type_id') > 0)
    {  ?>

    <script type="text/javascript">
        var subCategoryIndustryName = {{old('enterprise_type_id')}}
        $("#subCategory_name").load({!! json_encode(url('/enterprise/register/subCategory/')) !!}  +'/' + subCategoryIndustryName);
    </script>
    <?php } ?>


<script type="text/javascript">
$(function() {
    $('input[name="appointment"]').daterangepicker({

        locale: {
                format: 'YYYY-MM-DD'
            },
        singleDatePicker: true,
        showDropdowns: true
    },
    function(start, end, label) {
        var years = moment().diff(start, 'years');

    });
});
</script>
    @endsection