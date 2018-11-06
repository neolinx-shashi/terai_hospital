@extends('backendlayout.master')
@extends('backendlayout.header')
@extends('backendlayout.leftmenu')
@extends('backendlayout.footer')
@section('userscontent')
    @extends('backendlayout.flashmessagecollection')

    <section class="content">
        <section class="content-header">
            <h1>{{($patient->first_name) }}</h1>
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
                        
                        <div class="box-body">
                            <div class="row" style="margin:10px 0 0 20px;">
                                <div class="col-md-6">
                                    <h4 style="text-decoration: underline;">Patient Details:</h4>
                                    <p><b>Patient Name:</b>
                                        &nbsp;{{ $patient->first_name }}
                                    </p>

                                    <p><b>Age:</b> &nbsp;{{ $patient->age }}</p>

                                    <p><b>Gender:</b> &nbsp;{{ $patient->gender }}</p>

                                    <p><b>Blood Group:</b>
                                        @if ($patient->bloodGroup_id)
                                            {{ $patient->bloodGroup_id }}
                                        @endif
                                    </p>

                                    <p><b>Permanent Address:</b> {{ $patient->permanent_address }}</p>

                                    <p><b>Temporary Address:</b> &nbsp;
                                        @if($patient->temporary_address)
                                            {{ $patient->temporary_address }}
                                        @endif
                                    </p>

                                    <p><b>Phone/Mobile:</b> {{ $patient->phone }}</p>

                                    <p><b>Doctor:</b>
                                        &nbsp;{{strtoupper($patient->isConsultedToDoctor->first_name).' '.strtoupper($patient->isConsultedToDoctor->middle_name).' '.strtoupper($patient->isConsultedToDoctor->last_name)}}
                                    </p>

                                    <p><b>Nationality:</b>
                                    </p>

                                    <p><b>Deposit Amount:</b>
                                        @if($patient->deposit_amount)
                                            &nbsp;
                                            Rs. {{ $patient->deposit_amount }}
                                        @else
                                            --
                                        @endif
                                    </p>

                                    <p><b>Description:</b> {{ $patient->description }}
                                    </p>

                                    @if($patient->status == "Discharged")
                                        <p><b>Status:</b> &nbsp;{{ $patient->status.' on '.$patient->discharged_at }}
                                        </p>
                                    @else
                                        <p><b>Status:</b> &nbsp;{{ $patient->status }} </p>
                                    @endif
                                </div>

                                <div class="col-md-6">
                                    <h4 style="text-decoration: underline;">Ward Details:</h4>
                                    <p><b>Ward:</b> &nbsp;{{ $patient->isOfWard->ward_name }}</p>
                                    @if($patient->isOfRoom->room_type)
                                        <p><b>Room Type:</b> {{ucfirst($patient->isOfRoom->room_type)}}</p>
                                    @endif
                                    <p><b>Room:</b> &nbsp;{{ $patient->isOfRoom->room_name }}</p>
                                    <p><b>Bed:</b> &nbsp;{{ $patient->isOfBed->bed_name }}</p>
                                </div>
                            </div>

                            <hr>


                            <hr>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->


            </div>
        </div>
    </section>
@endsection