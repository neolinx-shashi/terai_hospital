@extends('backendlayout.master')
@extends('backendlayout.header')
@extends('backendlayout.leftmenu')
@extends('backendlayout.footer')
@section('userscontent')
    @extends('backendlayout.flashmessagecollection')
    <script src="{{URL::asset('backendtheme/plugins/jQuery/jQuery-2.1.4.min.js')}}"></script>
    <div id="bids">

    </div>


    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">

                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#opd" data-toggle="tab" aria-expanded="true">OPD Patient</a>
                            </li>
                            <li class=""><a href="#ipd" data-toggle="tab" aria-expanded="false">IPD Patient</a></li>
                            <li><a href="#emergency" data-toggle="tab">Emergency Patient</a></li>
                        </ul>


                        <div class="tab-content">
                            <table cellpadding="3" cellspacing="3" align="center" width="100%" class="table-striped">
                                <tbody>
                                <tr>
                                    <td width="15%">Patient Id:</td>
                                    <td width="40%"><strong>{{$editPatients->patient_code}}</strong></td>

                                </tr>
                                <tr>
                                    <td width="5%">Full Name:</td>
                                    <td width="40%">{{ucfirst($editPatients->first_name).' '.ucfirst($editPatients->middle_name). ' '.ucfirst($editPatients->last_name)}}</td>

                                </tr>

                                <tr>
                                    <td width="5%">Age:</td>
                                    <td width="40%">{{$editPatients->age}}
                                        <strong>YRS</strong> {{$editPatients->gender}}</td>

                                </tr>

                                @if(isset($editPatients->isOfNationality->country_name))
                                    <tr>
                                        <td width="5%">Nationality:</td>
                                        <td width="40%">{{ucfirst($editPatients->isOfNationality->country_name)}}</td>

                                    </tr>
                                @endif


                                </tbody>
                            </table>

                            <div class="tab-pane  active " id="opd">
                                @include('backendview.readmitPatient.opd')
                            </div>
                            <!-- /.tab-pane -->
                            <div class="tab-pane " id="ipd">
                                @include('backendview.readmitPatient.ipd')
                            </div>
                            <!-- /.tab-pane -->
                            <div class="tab-pane " id="emergency">
                                @include('backendview.readmitPatient.emergency')
                            </div>
                            <!-- /.tab-pane -->
                        </div>


                        <!-- /.tab-content -->
                    </div>
                </div>
            </div>
        </div>
    </section>




@endsection