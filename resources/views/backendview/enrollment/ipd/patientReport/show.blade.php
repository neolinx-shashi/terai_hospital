@extends('backendlayout.master')
@extends('backendlayout.header')
@extends('backendlayout.leftmenu')
@extends('backendlayout.footer')
@section('userscontent')
    @extends('backendlayout.flashmessagecollection')

    <section class="content">
        <section class="content-header">
            <h1>{{$report->ipatient_name}}</h1>
            <ol class="breadcrumb">
                <li><a href="dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li><a href="{{URL('ip-enrollment/patients')}}">Patient List</a></li>
                <li class="active">View Patient Information</li>
            </ol>
        </section>
        <br>
        <div class="container-fluid spark-screen">
            <div class="row">
                <div class="col-md-12">
                    <!-- Default box -->
                    <div class="box">
                        {{--<div class="box-header with-border">--}}
                        {{--<div class="box-tools pull-right">--}}
                        {{--<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">--}}
                        {{--<i class="fa fa-minus"></i></button>--}}
                        {{--<button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">--}}
                        {{--<i class="fa fa-times"></i></button>--}}
                        {{--</div>--}}
                        {{--</div>--}}
                        <div class="box-body">
                            <div class="row" style="margin:10px 0 0 20px;">
                                <div class="col-md-6">
                                    <h4 style="text-decoration: underline;">Patient Details:</h4>
                                    <p><b>Patient Name:</b>
                                        &nbsp;{{ $report->ipatient_name }}
                                    </p>
                                    {{--<p><b>Date Of Birth:</b> &nbsp;{{ $patient->patient_dob }}</p>--}}
                                    {{--<p><b>Age:</b> &nbsp;{{ $patient->age }}</p>--}}
                                    {{--<p><b>Gender:</b> &nbsp;{{ $patient->gender }}</p>--}}
                                    {{--<p><b>Blood Group:</b> &nbsp;{{ucfirst($patient->hasBloodGroup->blood_group)}}</p>--}}
                                    {{--<p><b>Permanent Address:</b> &nbsp;{{ $patient->permanent_address }}</p>--}}
                                    {{--<p><b>Temporary Address:</b> &nbsp;{{ $patient->temporary_address }}</p>--}}
                                    {{--<p><b>Phone:</b> &nbsp;{{ $patient->phone }}</p>--}}
                                    {{--<p><b>Nationality:</b> &nbsp;{{ucfirst($patient->isOfNationality->country_name)}}--}}
                                    {{--</p>--}}
                                    {{--<p><b>Marital Status:</b> &nbsp;{{ $patient->marital_status }}</p>--}}
                                    {{--<p><b>Spouse Name:</b> &nbsp;{{ $patient->spouse_name }}</p>--}}
                                    {{--<p><b>Patient:</b> &nbsp;@if($patient->patient_type=='New')New Patient @else Old Patient @endif</p>--}}
                                    {{--<p><b>Status:</b> &nbsp;{{ $patient->status }}</p>--}}
                                    {{--<p><b>Discharged Date:</b> &nbsp;{{ $patient->discharged_at }}</p>--}}
                                </div>
                            </div>
                            <hr>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->


            </div>
        </div>
        </div>
    </section>
@endsection