<style type="text/css">
    .panel-heading {
        display: none;
    }
    .box.side-box {
        max-height: 430px;
        height: 430px;
        overflow-y: auto;
    }
    .bg-darkseagreen{
        background-color: darkseagreen;
        color: #fff;
    }
    .bg-cadetblue{
        background-color: cadetblue;
        color: #fff;
    }
    .inner.create{
        padding: 15px 20px;
    }
    .create-opd-test{
        padding: 0 !important;
    }
    .nepali-date h4{
        /*font-family: HIMALAYA TT FONT;*/
        text-align: center;
        font-weight: bold;
        color: #0073b7;
    }
    /*section{
        display: none;
    }*/
</style>
@if(Auth::user()->user_type_id=='3')
<style type="text/css">
    .inner{
            /*min-height: 122px;*/
            padding: 20px;
        }
        .inner-link{
            text-decoration: none !important;
            color: #fff !important;
        }
</style>
<div class="row">
    <div class="col-lg-4 col-xs-6">
        <a href="{{ URL::to('billing/dailyReport', Auth::user()->id) }}" class="inner-link">
            <div class="small-box bg-aqua">
                <div class="inner">
                <h3>Rs. {{ round($total,2) }}</h3>
                <p>Today Collected </p>
                </div>
            <div class="icon">
                <i class="fa fa-file fa-md"></i>
            </div>
            <a href="{{ URL::to('billing/dailyReport', Auth::user()->id) }}" class="small-box-footer">
             Print Report <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </a>
    </div>

        <div class="col-lg-4 col-xs-6">
            <a href="{{ URL::to('billing/totalPatientsToday', Auth::user()->id) }}"
            class="inner-link">
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3>
                            <sup>
                            {{$getMyPatientsToday}}
                            </sup>
                        </h3>
                        <p>Total OPD Today </p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-list fa-md"></i>
                    </div>
                    <a href="{{ URL::to('billing/total-patients-today', Auth::user()->id) }}"
                    class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </a>
        </div>


    <div class="col-lg-4 col-xs-6">
    <!-- small box -->
        <a href="{{ URL::to('refunded-patients') }}" class="inner-link">
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>{{$refundedPatientsToday}}</h3>
                    <p>Total Refunded Patients</p>
                </div>
                <div class="icon">
                    <i class="fa fa-exchange fa-md"></i>
                </div>
                <a href="{{ URL::to('refunded-patients') }}" class="small-box-footer">More info <i
                class="fa fa-arrow-circle-right"></i></a>
            </div>
        </a>
    </div>
</div>


<div class="row">
    <div class="col-lg-4">
        <a href="{{URL::to('/configuration/patient')}}" class="inner-link">
            <div class="small-box bg-darkseagreen">
                <div class="inner">
                    <h3>{{ $testPatientsTodayOnly }}</h3>
                    <p>Total Test Patient</p>
                </div>
                <div class="icon">
                    <i class="fa fa-h-square fa-md"></i>
                </div>
                <a href="{{URL::to('#')}}" class="small-box-footer">More info
                <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </a>
    </div>

    <div class="col-lg-4">
        <a href="{{URL::to('/dashboard')}}" class="inner-link">
            <div class="small-box bg-cadetblue">
                <div class="inner">
                    <h3>{{ $getMyIPDPatientsToday }}</h3>
                    <p>Total IPD Patient</p>
                </div>
                <div class="icon">
                    <i class="fa fa-wheelchair fa-md"></i>
                </div>
                <a href="{{URL::to('#')}}" class="small-box-footer">More info
                <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </a>
    </div>
    <div class="col-lg-4">
        <a href="{{URL::to('emergency/patient')}}" class="inner-link">
            <div class="small-box bg-red">
                <div class="inner">
                    <h3>{{ $emergencyPatient }}</h3>
                    <p>Emergency Patient Today</p>
                </div>
                <div class="icon">
                    <i class="fa fa-medkit fa-md"></i>
                </div>
                <a href="{{URL::to('emergency/patient')}}" class="small-box-footer">More info
                <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </a>
    </div>
</div>
<div class="row">
    <div class="col-lg-4" id="create-patient">
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
            <a href="{{url('ip-enrollment/patients/create')}}">
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
            {{--<a --}}{{--href="{{URL::to('/configuration/patient')}}"--}}{{-- class="small-box-footer">More info
            <!-- <i class="fa fa-arrow-circle-right"></i> --></a>--}}
            </div>
            </a>
        </div>
    </div>
    <div class="col-lg-4 col-xs-6">
        <div class="panel panel-default">
        <div class="panel-body" id="container" style="min-width: 310px; height: 430px; max-width: 600px; margin: 0 auto">
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
        text: 'Patient Information by Gender '
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
        data:<?php echo json_encode($genderPieDataUserOnly); ?>   
        }]
        });
        });
        </script>
        </div>
        </div>
    </div>
    <div class="col-lg-4 col-xs-6">
        <div class="box side-box">
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

<!-- <div class="col-md-8 col-xs-6">
</div> -->

