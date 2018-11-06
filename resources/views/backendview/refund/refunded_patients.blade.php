@extends('backendlayout.master')
@extends('backendlayout.header')
@extends('backendlayout.leftmenu')
@extends('backendlayout.footer')
@section('userscontent')
    @extends('backendlayout.flashmessagecollection')
    <section class="content-header">
        <h1>
            Refunded Patients
        </h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">

                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#opd">OPD Patients ({{count($patients)}})</a> </li>
                            <li><a data-toggle="tab" href="#test">Test Patients  ({{count($testPatients)}}) </a></li>
                        </ul>
                        <div class="box-body">
                            <div class="tab-content">
                                <div id="opd" class="tab-pane fade in active">
                                    @if(count($patients)>0)
                                        <table id="example1" class="table table-hover table-bordered table-striped">
                                            <thead>
                                            <tr>
                                                <th class="col-lg-1">S.N</th>
                                                <th class="col-lg-4">Patient Full Name/Code</th>
                                                <th class="col-lg-1">Fee</th>
                                                <th class="col-lg-2">Created At</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $i = $patients->firstItem();
                                            ?>
                                            @foreach($patients as $key=>$patientData)

                                                <tr>
                                                    <td>
                                                        {{$i++}}.
                                                    </td>

                                               
                                                    <td>
                                                        <strong>
                                                            <a href="{{ URL::action('BackEndController\RefundController@refundPage', $patientData->id) }}">
                                                                {{ucfirst($patientData->first_name)}}
                                                                {{ucfirst($patientData->middle_name)}}
                                                                {{ucfirst($patientData->last_name)}}
                                                            </a>
                                                        </strong>
                                            <br>
                                                <strong>{{$patientData->patient_code}}</strong>

                                                    </td>

                                                    <td>
                                                        Rs. {{ $patientData->doctor_fee_with_tax }}
                                                    </td>

                                                    <td>
                                                        {{ date('Y-m-d h:i A',strtotime($patientData->created_at)) }}
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

                                <div id="test" class="tab-pane fade">
                                    @if(count($testPatients)>0)
                                        <table id="example2" class="table table-hover table-bordered table-striped">
                                            <thead>
                                            <tr>
                                                <th class="col-lg-1">S.N</th>
                                                <th class="col-lg-4">Patient Full Name/Code</th>
                                                <th class="col-lg-1">Fee</th>
                                                <th class="col-lg-2">Created At</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $i = $testPatients->firstItem();
                                            ?>
                                            @foreach($testPatients as $key=>$patientData)

                                                <tr>
                                                    <td>
                                                        {{$i++}}.
                                                    </td>

                                                   

                                                    <td>
                                                        <strong>
                                                    
                                                                {{ucfirst($patientData->belongsToPatient->first_name)}}
                                                                {{ucfirst($patientData->belongsToPatient->middle_name)}}
                                                                {{ucfirst($patientData->belongsToPatient->last_name)}}
                                                         
                                                        </strong>
                                                        <br>
                                                        <strong>{{$patientData->belongsToPatient->patient_code}}</strong>

                                                    </td>

                                                    <td>
                                                        Rs. {{ $patientData->grand_total }}
                                                    </td>

                                                    <td>
                                                        {{ date('Y-m-d h:i A',strtotime($patientData->created_at)) }}
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
                    </div>
                </div>
            </div>
        </div>
    </section>
   

@endsection