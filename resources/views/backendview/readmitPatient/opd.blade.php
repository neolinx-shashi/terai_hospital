<link rel="stylesheet" type="text/css" href="{{URL::asset('backendtheme/lib/nepali.datepicker.v2/css/bootstrap.min.css')}}" />
<link rel="stylesheet" type="text/css" href="{{URL::asset('backendtheme/lib/nepali.datepicker.v2/nepali.datepicker.v2.min.css')}}" />
<div class="box">
    <div class="container">
        <br/>
        <form method="post" action="{{URL::action('BackEndController\ReadmitController@readmitOpdSection',$editPatients->id)}}" id="opdForm">

            {{ csrf_field() }}
            <input type="hidden" name="patient_code" value="{{$editPatients->patient_code}}">
            <input type="hidden" name="first_name" value="{{$editPatients->first_name}}">
            <input type="hidden" name="middle_name" value="{{$editPatients->middle_name}}">
            <input type="hidden" name="last_name" value="{{$editPatients->last_name}}">
            <input type="hidden" name="phone" value="{{$editPatients->phone}}">
            <input type="hidden" name="gender" value="{{$editPatients->gender}}">
            <input type="hidden" name="age" value="{{$editPatients->age}}">
            <input type="hidden" name="nationality_id" value="{{$editPatients->nationality_id}}">
            <div class="form-group row">

                <div class="col-sm-4">

                </div>
                <div class="col-sm-5" style="text-align: right;">

                    @if(Session::get('opd_patient_readmit'))

                        <a href="{{ URL::to('configuration/patient/' . Session::get('opd_patient_readmit') . '/print-invoice/pat') }}"
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

        <!-- <div class="form-group row">
                            <label for="inputfname" class="col-sm-1 form-control-label">Patient Id <span style="color: #b30000"> </span></label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" id="inputfname" value="{{$editPatients->patient_code}}"
                                disabled>
                            </div>
                        </div> -->
        <!-- <div class="form-group row">
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


                </div> -->

        <!--    <div class="form-group row">
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
 -->
        <!--  <div class="form-group row">


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
                </div> -->

            <div class="form-group row">

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
                <label for="district" class="col-sm-1 form-control-label">Consult to
                </label>
                <div class="col-sm-4">
                    <div id="office_name">
                        <select name="office_name" id="doctor1" class="form-control" disabled="disabled">
                            <option value="" >Please Select Department First</option>

                        </select>
                    </div>
                </div>
            </div>



            <div class="form-group row">



                <label for="doctor" class="col-sm-1 form-control-label">Consulting Charge</label>
                <div class="col-sm-4">

                    <div id="doctor_name">
                        <input type="text" class="form-control" id="inputcontact"
                               disabled placeholder="Doctor Not Selected yet">


                    </div>

                </div>


                <label for="consultdoc" class="col-sm-1 form-control-label">Appointment Date
                </label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="datefrom" name="appointment" value="{{getTodayNepaliDate()}}">
                </div>

            </div>

            <div class="form-group row">


                <label for="discount_percent" class="col-sm-1 form-control-label">Discount % <span style="color: #b30000"> </span></label>
                <div class="col-sm-2">
                    <input type="number" class="form-control" id="discount_percent" name="discount_percent"
                           placeholder="Discount percentage" value="{{old('discount_percent')}}" max="100" min="0">
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
                    <button type="submit" class="col-md-3 col-lg-offset-0 btn btn-success btn-flat print-button-spot"
                            style="margin-left: 10px; float: right;" onclick="hideSubmitBtn()">Readmit
                    </button>

                </div>
            </div>
        </form>
    </div>

</div>
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
    $(document).ready(function(){



        $('#datefrom').nepaliDatePicker({
            ndpEnglishInput: 'englishDate'
        });


    });
</script>


<script type="text/javascript">
    $(document).ready(function () {
        $("#opdForm").validate({
            rules: {

                permanent_address: "required",


                department_id: {
                    required: true
                }

            },
            messages: {

                permanent_address: "Please enter address",

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

    function hideSubmitBtn() {
        $('.print-button-spot').hide();
    }
</script>