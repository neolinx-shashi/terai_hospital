@extends('backendlayout.master')
@extends('backendlayout.header')
@extends('backendlayout.leftmenu')
@extends('backendlayout.footer')
@section('userscontent')
@extends('backendlayout.flashmessagecollection')
<link rel="stylesheet" type="text/css" href="{{URL::asset('backendtheme/lib/nepali.datepicker.v2/css/bootstrap.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{URL::asset('backendtheme/lib/nepali.datepicker.v2/nepali.datepicker.v2.min.css')}}" />
<style>
    .no-padding {padding: 0;}
    .spacer {margin: 20px 0;}
</style>
<link href="{{ URL::asset('css/bootstrap-datetimepicker.css') }}">
<section class="content-header">
    <h1>Billing Report</h1>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    <div class="col-md-12 no-padding">
                        <span class="pull-right">
                            <a href="{{ url('billing-report') }}" class="btn btn-info">Today</a>
                            <a href="{{ url('monthly-report') }}" class="btn btn-primary">This Month</a>
                            <a href="{{ url('yearly-report') }}" class="btn btn-success">This Year</a>
                        </span>

                        <div class="clearfix"></div><div class="spacer"></div>
                        <form action="{{ url('report-by-date') }}" method="post">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            <div class="col-md-3">
                                <div class="input-group">
                                    <span class="input-group-addon">From</span>
                                    <input name="date_from" type="text" id="datefrom" class="form-control" value="{{ getTodayNepaliDate() }}" readonly>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="input-group">
                                    <span class="input-group-addon">To</span>
                                    <input name="date_to" type="text" id="dateto" class="form-control" value="{{ getTodayNepaliDate() }}" readonly>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <input name="submit" type="submit" class="btn btn-primary" value="Search">
                            </div>
                        </form>

                        <div class="clearfix"></div><div class="spacer"></div>

                    </div>
                    <div class="col-md-4">
                        <label for="test by patients">Patients</label>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th width="60">S. No.</th>
                                    <th>Patient</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (empty($report))
                                <tr>
                                    <td colspan="3" align="center">No Data Available.</td>
                                </tr>
                                @else
                                @foreach ($report as $key => $val)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ ucfirst($val->first_name) }} {{ $val->middle_name or '' }} {{ ucfirst($val->last_name) }}</td>
                                    <td>{{ $val->grand_total }}</td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <div class="col-md-4">
                        <label for="report by tests">Tests</label>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th width="60">S. No.</th>
                                    <th>Tests</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (empty($test_report))
                                <tr>
                                    <td colspan="3" align="center">No Data Available.</td>
                                </tr>
                                @else
                                @foreach ($test_report as $key => $val)
                                <tr>
                                    <td>{{ $key + 1 }}.</td>
                                    <td>{{ ucwords($val->title) }}</td>
                                    <td>{{ $val->test_price }}</td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>


                    <div class="col-md-4">
                        <label for="report by doctors">Doctors</label>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>S. No.</th>
                                    <th>Doctor</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (empty($doctor_report))
                                <tr>
                                    <td colspan="3" align="center">No Data Available</td>
                                </tr>
                                @else
                                @foreach ($doctor_report as $key => $val)
                                <tr>
                                    <td>{{ $key + 1 }}.</td>
                                    <td>{{ ucfirst($val->first_name) }} {{ $val->middle_name or '' }} {{ ucfirst($val->last_name) }}</td>
                                    <td>{{ $val->total }}</td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="{{URL::asset('backendtheme/plugins/jQuery/jQuery-2.1.4.min.js')}}"></script>
<script>
$(function () {
    $('#datetimepicker1').datetimepicker({
        userCurrent: true
    });
});
</script>


 <script type="text/javascript">
         $(document).ready(function(){
        $('#datefrom').nepaliDatePicker({
            ndpEnglishInput: 'englishDate'
        });

         $('#dateto').nepaliDatePicker({
            ndpEnglishInput: 'englishDate'
        });

        });
    </script>
@stop