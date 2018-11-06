@extends('backendlayout.master')
@extends('backendlayout.header')
@extends('backendlayout.leftmenu')
@extends('backendlayout.footer')
@section('userscontent')
    @extends('backendlayout.flashmessagecollection')
    <script src="{{URL::asset('backendtheme/plugins/jQuery/jQuery-2.1.4.min.js')}}"></script>

    {{--<section class="content-header">--}}
    {{--<h1>Create Report:</h1>--}}
    {{--<h1>--}}
    {{--In Patient Enrollment--}}
    {{--<a href="{{url('configuration/patient')}}">--}}
    {{--<button type="button" class="btn btn-warning btn-flat  pull-right ">--}}
    {{--<span class="glyphicon glyphicon-th-list" aria-hidden="true"></span> View Patients--}}
    {{--</button>--}}
    {{--</a>--}}
    {{--</h1>--}}
    {{--</section>--}}
    {{--<div class="search" style="padding-top: 20px">--}}
    {{--<div class="row">--}}
    {{--<div class="col-lg-6 col-lg-offset-1">--}}
    {{--<div class="input-group">--}}
    {{--<span class="input-group-addon"--}}
    {{--style="color: white; background-color: #f39c12;  border-radius:4px; margin: -5px 0 -5px 0;">OLD PATIENT</span>--}}
    {{--<input type="text" autocomplete="off" id="search"--}}
    {{--style="border-radius:5px; font-size: 1em; padding: 5px 0 -5px 0;"--}}
    {{--class="form-control input-lg"--}}
    {{--placeholder="Patient code/Name/contact number">--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--<div id="txtHint" class="title-color" style="padding-top:10px; "></div>--}}
    {{--<script>--}}
    {{--$(document).ready(function () {--}}
    {{--$("#search").keyup(function () {--}}
    {{--var str = $("#search").val();--}}
    {{--if (str == "") {--}}
    {{--$("#txtHint").html("<b>Patient information will be listed here...</b>");--}}
    {{--$('.content').show();--}}
    {{--} else {--}}
    {{--$.get("{{ url('ip-enrollment/renew/patient?id=') }}" + str, function (data) {--}}
    {{--$("#txtHint").html(data);--}}
    {{--$('.content').hide();--}}
    {{--});--}}
    {{--}--}}
    {{--});--}}
    {{--});--}}
    {{--</script>--}}

    <section class="content">
        <div class="row">
            <div class="col-md-6">
                <h4>Create Report</h4>
            </div>
            <div class="col-md-6">
                <ol class="breadcrumb pull-right">
                    <li><a href=""><i class="fa fa-dashboard"></i> Dashboard</a></li>
                    <li><a href="{{URL('ip-enrollment/patient-report')}}">Report List</a></li>
                    <li class="active">Create Report</li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 ">
                <div class="box">
                    <div class="box-body">
                        <div id="tabs">

                            <div class="container">
                                <br/>

                                <form method="post"
                                      action="{{URL::action('BackendController\PatientReportController@store')}}">
                                    {{ csrf_field() }}
                                    <div class="form-group row">
                                        <label for="code" class="col-sm-1 form-control-label">Report No.:</label>
                                        <div class="col-md-2">
                                            <input class="form-control" type="text" id="code" name="report_number"
                                                   value={{$reportCode}}>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="code" class="col-sm-1 form-control-label">Patient Code:</label>
                                        <div class="col-md-2">
                                            <input class="form-control" type="text" id="code" name="ipatient_code"
                                                   value={{$patient->ipatient_code}}>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="code" class="col-sm-1 form-control-label">Patient Name:</label>
                                        <div class="col-md-4">
                                            {{--hidden field for patient id--}}
                                            <input type="hidden" name="ipatient_id" value="{{$patient_id}}">
                                            <input class="form-control" type="text" id="code"
                                                   value={{$patient->first_name .'&nbsp;'. $patient->middle_name. '&nbsp;'. $patient->last_name}}>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="code" class="col-sm-1 form-control-label">Doctor:</label>
                                        <div class="col-sm-4">
                                            <select name="doctor_id" id="doctor" class="form-control">
                                                <option value="">Select Doctor</option>
                                                @foreach($doctors as $doctor)
                                                    <option value="{{ $doctor->id }}"
                                                    @if(old('doctor_id')==$doctor->id)
                                                        <?php echo 'selected' ?>
                                                            @endif
                                                    >{{ $doctor->first_name. ' '.$doctor->middle_name. ' '.$doctor->last_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="code" class="col-sm-1 form-control-label">Doctor Note:</label>
                                        <div class="col-md-8">
                                            <textarea class="form-control" style="height:100px;" type="text" id="code"
                                                      name="doctor_report"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            <button type="submit"
                                                    class="col-md-1 col-lg-offset-8 btn btn-primary btn-flat"
                                                    style="width:120px;">
                                                Save & View
                                            </button>
                                            <button type="reset" class="col-md-1 btn btn-warning btn-flat"
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
    </section>
@endsection

