 <style type="text/css">
     .box.side-box.doctors {
        max-height: 330px !important;
        height: 330px !important;
        overflow-y: auto !important;
    }
    #create-patient a:hover{
        font-weight: bold;
        text-decoration: none;
        -webkit-transition: all 0.4s;
        -moz-transition: all 0.4s;
        -o-transition: all 0.4s;
        transition: all 0.4s;
    }
 </style>
 @if(Auth::user()->user_type_id=='1' ||  Auth::user()->user_type_id=='2')
            <div class="row">
                <div class="col-lg-4 col-xs-6">
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            <h3>{{$getAllDoctors}}</h3>
                            <p>Total Doctors</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-user-md fa-md"></i>
                        </div>
                        <a href="{{URL::to('/configuration/doctor')}}" class="small-box-footer">More info <i
                                    class="fa fa-arrow-circle-right"></i></a>
                    </div>


                </div>
                <div class="col-lg-4 col-xs-6">
                    <div class="small-box bg-green">
                        <div class="inner">
                            <h3>
                                {{$getAllDepartments}}
                            </h3>
                            <p>Total Departments</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-hospital-o fa-md"></i>
                        </div>
                        <a href="{{URL::to('/department')}}" class="small-box-footer">More info <i
                                    class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div><!-- ./col -->
                <div class="col-lg-4 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-yellow">
                        <div class="inner">
                            <h3>{{$getAllUsers}}</h3>
                            <p>Total Registered Users</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-users fa-md"></i>
                        </div>
                        <a href="{{URL::to('/usersetup')}}" class="small-box-footer">More info <i
                                    class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="row">
                <!-- <div class="col-md-8 row2"> -->
                    <div class="col-lg-4">
                        <div class="small-box bg-darkseagreen">
                            <div class="inner">
                                <h3>{{$getMyPatientsToday}}</h3>
                                <p>Total OPD Patients</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-h-square fa-md"></i>
                            </div>
                            <a href="{{ URL::to('billing/total-patients-today', Auth::user()->id) }}" class="small-box-footer">More info
                                <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="small-box bg-cadetblue">
                            <div class="inner">
                                <h3>{{ $getMyIPDPatientsToday }}</h3>
                                <p>Total IPD Patients</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-wheelchair fa-md"></i>
                            </div>
                            <a href="{{URL::to('/ip-enrollment/patients')}}" class="small-box-footer">More info
                                <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="small-box bg-red">
                            <div class="inner">
                                <h3>{{ $emergencyPatient }}</h3>
                                <p>Total Emergency Patient</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-medkit fa-md"></i>
                            </div>
                            <a href="{{url('emergency/patient')}}" class="small-box-footer">More info
                                <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- <div class="col-lg-6">
                        <div class="small-box bg-yellow">
                            <div class="inner">
                                <h3>{{$getAllPatients}}</h3>
                                <p>Birth Certificates Issued</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-child fa-md"></i>
                            </div>
                            <a href="{{URL::to('/dashboard')}}" class="small-box-footer">More info
                                <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div> -->
                   <!--  <div class="col-lg-6">
                        <div class="small-box bg-purple">
                            <div class="inner">
                                <h3>{{$getAllPatients}}</h3>
                                <p>Death Certificates Issued</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-bed fa-md"></i>
                            </div>
                            <a href="{{URL::to('/dashboard')}}" class="small-box-footer">More info
                                <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div> -->
                    <!-- <div class="col-md-12">
                    <div class="panel-body" id="bar">
                        <script type="text/javascript">
                                 $(document).ready(function () {
                                    Highcharts.chart('bar', {
                                    chart: {
                                        type: 'column'
                                    },
                                    title: {
                                        text: 'Patient Average Arrival In Month'
                                    },
                                    subtitle: {
                                        
                                    },
                                    xAxis: {
                                        categories: [
                                            'Jan',
                                            'Feb',
                                            'Mar',
                                            'Apr',
                                            'May',
                                            'Jun',
                                            'Jul',
                                            'Aug',
                                            'Sep',
                                            'Oct',
                                            'Nov',
                                            'Dec'
                                        ],
                                        crosshair: true
                                    },
                                    yAxis: {
                                        min: 0,
                                        title: {
                                            text: 'Patient (Number)'
                                        }
                                    },
                                    tooltip: {
                                        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                                        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                                            '<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
                                        footerFormat: '</table>',
                                        shared: true,
                                        useHTML: true
                                    },
                                    plotOptions: {
                                        column: {
                                            pointPadding: 0.2,
                                            borderWidth: 0
                                        }
                                    },
                                    series: [{
                                        name: 'Male',
                                        data: [49.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4]

                                    }, {
                                        name: 'Female',
                                        data: <?php echo json_encode($genderPieData); ?>

                                    }, {
                                        name: 'Others',
                                        data: [48.9, 38.8, 39.3, 41.4, 47.0, 48.3, 59.0, 59.6, 52.4, 65.2, 59.3, 51.2]

                                    }]
                                });  
                            });
                        </script>
                        </div>
                    </div> -->


                <!-- </div> -->
            </div>
            <div class="row">
                <div class="col-md-4 col-xs-6" id="create-patient">
                     <div class="col-sm-12  create-opd-test">
                        <a href="/configuration/patient/create">
                        <div class="small-box bg-darkseagreen">
                        <div class="inner create">
                        <p>Create OPD Patient</p>
                        </div>
                        <div class="icon-button">
                        <i class="fa fa-h-square" style="font-size: 50px;"></i>
                        </div>
                        {{--<a --}}{{--href="{{URL::to('/configuration/patient')}}"--}}{{-- class="small-box-footer">More info
                       <!--  <i class="fa fa-arrow-circle-right"></i> --></a>--}}
                        </div>
                        </a>
                    </div>

                    <div class="col-sm-12 create-opd-test">
                        <a href="configuration/print-test-invoice">
                        <div class="small-box bg-yellow">
                        <div class="inner create">
                        <p>Create Pathology/Test</p>
                        </div>
                        <div class="icon-button">
                        <i class="fa fa-print" style="font-size: 50px;"></i>
                        </div>
                        {{--<a --}}{{--href="{{URL::to('/configuration/patient')}}"--}}{{-- class="small-box-footer">More info
                        <!-- <i class="fa fa-arrow-circle-right"></i> --></a>--}}
                        </div>
                        </a>
                    </div>
                    <div class="col-sm-12  create-opd-test">
                        <a href="ip-enrollment/patients/create">
                        <div class="small-box bg-cadetblue">
                        <div class="inner create">
                        <p>Create IPD Patient</p>
                        </div>
                        <div class="icon-button">
                        <i class="fa fa-wheelchair" style="font-size: 50px;"></i>
                        </div>
                        {{--<a --}}{{--href="{{URL::to('/configuration/patient')}}"--}}{{-- class="small-box-footer">More info
                       <!--  <i class="fa fa-arrow-circle-right"></i> --></a>--}}
                        </div>
                        </a>
                    </div>

                    <div class="col-sm-12 create-opd-test">
                        <a href="{{url('emergency/patient/create')}}">
                        <div class="small-box bg-red">
                        <div class="inner create">
                        <p>Create Emergency Patient</p>
                        </div>
                        <div class="icon-button">
                        <i class="fa fa-medkit" style="font-size: 50px;"></i>
                        </div>
                        {{--<a --}}{{--href="{{URL::to('/emergency/patient/create')}}"--}}{{-- class="small-box-footer">More info
                        <!-- <i class="fa fa-arrow-circle-right"></i> --></a>--}}
                        </div>
                        </a>
                    </div>
                </div>
                <div class="col-md-4 col-xs-6">
                    <div class="panel panel-default">
                        <div class="panel-body" id="container" style="min-width: 310px; height: 330px; max-width: 600px; margin: 0 auto">
                                <script type="text/javascript">
                                   $(document).ready(function () {
                                        Highcharts.chart('container', {
                                            chart: {
                                                plotBackgroundColor: null,
                                                plotBorderWidth: null,
                                                plotShadow: false,
                                                type: 'pie'
                                            },
                                            title: {
                                                text: 'Patient Information By Gender '
                                            },
                                            tooltip: {
                                                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                                            },
                                            plotOptions: {
                                                pie: {
                                                    allowPointSelect: true,
                                                    cursor: 'pointer',
                                                    dataLabels: {
                                                        enabled: false
                                                    },
                                                    showInLegend: true
                                                }
                                            },
                                            series: [{
                                                name: 'Gender',
                                                colorByPoint: true,
                                                 data:<?php echo json_encode($genderPieData); ?>   
                                            }]
                                        });
                                    });
                            </script>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-xs-6">
                    <div class="box side-box doctors">
                        <div class="box-body">
                            @if(count($doctorListToday)>0)
                            <table class="table table-hover table-bordered table-striped">
                                <thead>

                                Available Doctors Today - <strong style="font-size: medium">({{ count($doctorListToday) }})</strong>


                                <tr>
                                    <th>
                                        Doctors
                                    </th>
                                    <th class="col-lg-3">
                                        Actions
                                    </th>


                                </tr>
                                </thead>
                                <tbody>
                                @foreach($doctorListToday as $key=>$dayName)
                                    <tr>
                                        <td>
                                            <strong>
                                                {{ucfirst($dayName->first_name). ' '. ucfirst($dayName->middle_name). ' '. ucfirst($dayName->last_name) }}

                                            </strong>
                                        </td>
                                        <td>
                                            <a title="View Today Doctor Shift"
                                               data-rel="tooltip">
                                            

                                                <button type="button" class="btn btn-default btn-flat previewimage"
                                                        data-toggle="modal" data-target="#previewimage"
                                                        data-link="{{URL::to('shift/overview',$dayName->doctorId)}}">
                                                    Preview
                                                </button>

                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                            @else
                            <div class="alert alert-danger">
                                <strong> Sorry ! No Doctor Available Today
                                </strong>
                            </div>
                            @endif
                        </div>
                    </div>
                    </div>
                </div>
        @endif