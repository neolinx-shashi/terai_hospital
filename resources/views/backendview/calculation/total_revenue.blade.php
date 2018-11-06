@extends('backendlayout.master')
@extends('backendlayout.header')
@extends('backendlayout.leftmenu')
@extends('backendlayout.footer')
@section('userscontent')
    @extends('backendlayout.flashmessagecollection')
    <script src="{{URL::asset('backendtheme/plugins/jQuery/jQuery-2.1.4.min.js')}}"></script>
    <link rel="stylesheet" type="text/css"
          href="{{URL::asset('backendtheme/lib/nepali.datepicker.v2/css/bootstrap.min.css')}}"/>
    <link rel="stylesheet" type="text/css"
          href="{{URL::asset('backendtheme/lib/nepali.datepicker.v2/nepali.datepicker.v2.min.css')}}"/>
    <style type="text/css">
        .dataTables_paginat {
            margin: 0;
            white-space: nowrap;
            text-align: right;
            display: block;
        }

        #revenue input[type="text"], #revenue1 input[type="text"], #revenue2 input[type="text"], #revenue3 input[type="text"] {
            color: #000;
            width: 100%;
        }

        .modal-dialog {
            color: #000;
        }

        .modal-dialog td {
            background: none !important;
            color: #000 !important;
        }

        .box-body {
            padding: 0px;
        }

        tr:hover td {
            color: #fff !important;
        }

        /*#revenue_wrapper input[type="text"] {
            width: 100%;
        }*/
        a.gererate_excell {
            display: block;
            padding: 10px;
            color: #fff;
            background: #3c8dbc;
            margin-bottom: 10px;
            width: 330px;
        }

        select#daterange {
            height: 35px;
        }

        .ninja {
            display: none;
        }
    </style>
    <!--     <script src="{{URL::asset('backendtheme/plugins/jQuery/jQuery-2.1.4.min.js')}}"></script>
 -->
    <section class="content-header">
        <h1>
            Total Revenue
        </h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box" style="background: #FFF">
                    <div class="box-body">
                        <div class="col-md-12">
                            <br>
                            <form name="date-chooser" method="post" action="{{ url('/operateTotalRevenue') }}">
                                {{ csrf_field() }}
                                <div class="col-md-5"></div>
                                <div class="form-group col-md-3">
                                    <label class="sr-only" for="fromDate">From Date</label>
                                    <div class="input-group">
                                        <div class="input-group-addon">From</div>
                                        <input name="from" class="form-control" id="datefrom"
                                               type="text" value="{{{ $date_from or getTodayNepaliDate() }}}"/>
                                    </div>
                                </div>

                                <div class="form-group col-md-3">
                                    <label class="sr-only" for="toDate">To Date</label>
                                    <div class="input-group">
                                        <div class="input-group-addon">To</div>
                                        <input name="to" class="form-control" type="text" id="dateto"
                                               value="{{{ $date_to or getTodayNepaliDate() }}}"/>
                                    </div>
                                </div>

                                <div class="col-md-1">
                                    <input name="submit" type="submit" value="Search"
                                           class="btn btn-info search-report"/>
                                </div>
                            </form>
                        </div>

                        @if ($rep == 1)
                            <div class="report col-md-12">
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs" role="tablist">
                                    <li role="presentation" class="active"><a href="#home" aria-controls="home"
                                                                              role="tab" data-toggle="tab">OPD
                                            Patients</a></li>
                                    <li role="presentation"><a href="#profile" aria-controls="profile" role="tab"
                                                               data-toggle="tab">Emergency Patients</a></li>
                                    <li role="presentation"><a href="#messages" aria-controls="messages" role="tab"
                                                               data-toggle="tab">IPD Patients</a></li>
                                    <li role="presentation"><a href="#settings" aria-controls="settings" role="tab"
                                                               data-toggle="tab">Test/Pathology Patients</a></li>
                                </ul>

                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane active" id="home">
                                        @if (count($opd) > 0)
                                            <br>
                                            <button id="print-report" class="btn btn-info pull-right"
                                                    style="margin-left: 10px;"><i
                                                        class="fa fa-print" aria-hidden="true"></i> Print
                                            </button>
                                            <button id="excel-opd" class="btn btn-info pull-right"
                                                    style="margin-right: 10px;"><span
                                                        class="glyphicon glyphicon-save"></span> Export to Excel
                                            </button>
                                            <div class="clearfix"></div><br>
                                            <?php $opd_total = $opd_tax = $opd_net = 0;?>
                                            <table class="table table-striped" id="opd-table">
                                                <thead>
                                                <tr class="ninja h_opd">
                                                    <th colspan="2">OPD Total Revenue</th>
                                                    <th colspan="4" class="date-range"></th>
                                                </tr>
                                                <tr class="ninja h_opd">
                                                    <th colspan="8"></th>
                                                </tr>
                                                <tr>
                                                    <th>S.N.</th>
                                                    <th>Patient</th>
                                                    <th>Patient Code</th>
                                                    <th>Bill No.</th>
                                                    <th>Doctor</th>
                                                    <th>Created by</th>
                                                    <th>Doctor Fee</th>
                                                    <th>HST 5%</th>
                                                    <th>Amount (Rs)</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach ($opd as $key => $val)
                                                    <tr>
                                                        <td><b>{{ ++$key }}</b></td>
                                                        <td>{{ $val->first_name }}</td>
                                                        <td>{{ $val->patient_code }}</td>
                                                        <td>{{ $val->bill_number }}</td>
                                                        <td>{{ $val->fname }} {{{ $val->mname or '' }}} {{ $val->lname }}</td>
                                                        <td>{{ $val->fullname }}<br><b>{{ $val->created_at }}</b></td>
                                                        <td>{{ $val->doctor_fee }} <?php $opd_total += $val->doctor_fee;?></td>
                                                        <td>{{ round($val->doctor_tax_only, 2) }} <?php $opd_tax += $val->doctor_tax_only;?></td>
                                                        <td>{{ $val->doctor_fee_with_tax }} <?php $opd_net += $val->doctor_fee_with_tax;?></td>
                                                    </tr>
                                                @endforeach
                                                <tr style="font-weight: bold;">
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td align="right">Total:</td>
                                                    <td>{{ $opd_total }}</td>
                                                    <td>{{ round($opd_tax, 2) }}</td>
                                                    <td>{{ $opd_net }}</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        @else
                                            <p>No Data Available.</p>
                                        @endif
                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="profile">
                                        @if (count($emergency) > 0)
                                            <br>
                                            <button id="print-report-1" class="btn btn-info pull-right"
                                                    style="margin-left: 10px;"><i
                                                        class="fa fa-print" aria-hidden="true"></i> Print
                                            </button>
                                            <button id="excel-emergency" class="btn btn-info pull-right"
                                                    style="margin-right: 10px;"><span
                                                        class="glyphicon glyphicon-save"></span> Export to Excel
                                            </button>
                                            <div class="clearfix"></div><br>
                                            <?php $emergency_total = $emergency_tax = $emergency_net = $room_charge = $emr_test = $emr_test_tax = $emr_test_total = $grand_total = 0;?>
                                            <table class="table table-striped" id="emergency-table">
                                                <thead>
                                                <tr class="ninja h_emr">
                                                    <th colspan="2">Emergency Total Revenue</th>
                                                    <th colspan="4" class="date-range"></th>
                                                </tr>
                                                <tr class="ninja h_emr">
                                                    <th colspan="8"></th>
                                                </tr>
                                                <tr>
                                                    <th>S.N.</th>
                                                    <th>Patient</th>
                                                    <th>Patient Code</th>
                                                    <th>Bill No.</th>
                                                    <th>Admitted By</th>
                                                    <th>Status</th>
                                                    <th>Ward/Room/Bed</th>
                                                    <th>Doctor</th>
                                                    <th>Doctor Fee</th>
                                                    <th>HST 5%</th>
                                                    <th>Dr. Fee With Tax</th>
                                                    <th>Test Price</th>
                                                    <th>HST 5%</th>
                                                    <th>Test Price With Tax</th>
                                                    <th>Total Amount (Rs.)</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach ($emergency as $key => $val)
                                                    <tr>
                                                        <td><b>{{ ++$key }}</b></td>
                                                        <td>{{ $val->first_name }}</td>
                                                        <td>{{ $val->patient_code }}</td>
                                                        <td>{{ $val->bill_number }}</td>
                                                        <td>{{ $val->fullname }}<br><b>{{ $val->created_at }}</b></td>
                                                        <td>@if ($val->status == 'Emergency')In Ward @else
                                                                {{ $val->status }} at<br>
                                                                <b>{{ $val->discharged_at }}</b> @endif</td>
                                                        <td>{{ $val->ward_name . '/' . $val->room_name . '/' . $val->bed_name }}</td>
                                                        <td>{{ $val->fname }} {{{ $val->mname or '' }}} {{ $val->lname }}</td>
                                                        <td>{{ $val->doctor_fee }} <?php $emergency_total += $val->doctor_fee;?></td>
                                                        <td>{{ round($val->doctor_tax_only, 2) }} <?php $emergency_tax += $val->doctor_tax_only;?></td>
                                                        <td>{{ round($val->doctor_fee_with_tax, 2) }} <?php $emergency_net += $val->doctor_fee_with_tax;?></td>
                                                        <td>{{ round($val->sub_total, 2) }} <?php $emr_test += $val->sub_total;?></td>
                                                        <td>{{ round($val->tax, 2) }} <?php $emr_test_tax += $val->tax;?></td>
                                                        <td>{{ round($val->grand_total, 2) }} <?php $emr_test_total += $val->grand_total;?></td>
                                                        <td>{{ round($val->doctor_fee_with_tax + $val->grand_total, 2) }} <?php $grand_total += ($val->doctor_fee_with_tax + $val->grand_total)?></td>
                                                    </tr>
                                                @endforeach
                                                <tr style="font-weight: bold;">
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td align="right">Total:</td>
                                                    <td>{{ $emergency_total }}</td>
                                                    <td>{{ round($emergency_tax, 2) }}</td>
                                                    <td>{{ round($emergency_net, 2) }}</td>
                                                    <td>{{ round($emr_test, 2) }}</td>
                                                    <td>{{ round($emr_test_tax, 2) }}</td>
                                                    <td>{{ round($emr_test_total, 2) }}</td>
                                                    <td>{{ round($grand_total, 2) }}</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        @else
                                            <p>No Data Available.</p>
                                        @endif
                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="messages">
                                        @if (count($ipd) > 0)
                                            <br>
                                            <button id="print-report-2" class="btn btn-info pull-right"
                                                    style="margin-left: 10px;"><i
                                                        class="fa fa-print" aria-hidden="true"></i> Print
                                            </button>
                                            <button id="excel-ipd" class="btn btn-info pull-right"
                                                    style="margin-right: 10px;"><span
                                                        class="glyphicon glyphicon-save"></span> Export to Excel
                                            </button>
                                            <div class="clearfix"></div><br>
                                            <?php $ipd_adm = $ipd_deposit = $ipd_dis = 0;?>
                                            <table class="table table-striped" id="ipd-table">
                                                <thead>
                                                <tr class="ninja h_ipd">
                                                    <th colspan="2">IPD Total Revenue</th>
                                                    <th colspan="4" class="date-range"></th>
                                                </tr>
                                                <tr class="ninja h_ipd">
                                                    <th colspan="8"></th>
                                                </tr>
                                                <tr>
                                                    <th>S.N.</th>
                                                    <th>Patient</th>
                                                    <th>Address</th>
                                                    <th>Patient Code</th>
                                                    <th>Bill No.</th>
                                                    <th>Admitted By</th>
                                                    <th>Status</th>
                                                    <th>Consulting Doctor</th>
                                                    <th>Ward/Room/Bed</th>
                                                    <th>Deposit</th>
                                                    <th>Admission Charge</th>
                                                    <th>Total after Discharge</th>
                                                    <th>Grand Total</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $gtotal = 0;?>
                                                @foreach ($ipd as $key => $val)
                                                    <tr>
                                                        <td><b>{{ ++$key }}</b></td>
                                                        <td>{{ $val->first_name }}</td>
                                                        <td>{{ $val->permanent_address }}</td>
                                                        <td>{{ $val->patient_code }}</td>
                                                        <td>{{ $val->bill_number }}</td>
                                                        <td>{{ $val->fullname }}<br><b>{{ $val->created_at }}</b></td>
                                                        <td>@if ($val->status != 'In Ward'){{ $val->status }} at<br>
                                                            <b>{{ $val->discharged_at }}</b>@else
                                                                {{ $val->status }} @endif</td>
                                                        <td>{{ $val->fname }} {{{ $val->mname or '' }}} {{ $val->lname }}</td>
                                                        <td>{{ $val->ward_detail }}</td>
                                                        <td>{{ $val->total_deposit }} <?php $ipd_deposit += $val->total_deposit;?></td>
                                                        <td>{{ $val->admission_charge_with_tax }} <?php $ipd_adm += $val->admission_charge_with_tax; ?></td>
                                                        <td>{{ $val->total_after_discharge }} <?php $ipd_dis += $val->total_after_discharge; ?></td>
                                                        <td>@if ($val->status != 'In Ward'){{ $val->total_after_discharge - $val->total_deposit }} <?php $gtotal += $val->total_after_discharge - $val->total_deposit; ?>@endif</td>
                                                    </tr>
                                                @endforeach
                                                <tr style="font-weight: bold;">
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td align="right">Total:</td>
                                                    <td>{{ round($ipd_deposit, 2) }}</td>
                                                    <td>{{ round($ipd_adm, 2) }}</td>
                                                    <td>{{ round($ipd_dis, 2) }}</td>
                                                    <td><?php echo $gtotal;?></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        @else
                                            <p>No Data Available.</p>
                                        @endif
                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="settings">
                                        @if (count($tests) > 0)
                                            <br>
                                            <button id="print-report-3" class="btn btn-info pull-right"
                                                    style="margin-left: 10px;"><i
                                                        class="fa fa-print" aria-hidden="true"></i> Print
                                            </button>
                                            <button id="excel-tests" class="btn btn-info pull-right"
                                                    style="margin-right: 10px;"><span
                                                        class="glyphicon glyphicon-save"></span> Export to Excel
                                            </button>
                                            <div class="clearfix"></div><br>
                                            <?php $tests_total = $tests_tax = $tests_net = 0;?>
                                            <table class="table table-striped" id="tests-table">
                                                <thead>
                                                <tr class="ninja h_test">
                                                    <th colspan="2">Pathology/Test Total Revenue</th>
                                                    <th colspan="4" class="date-range"></th>
                                                </tr>
                                                <tr class="ninja h_test">
                                                    <th colspan="8"></th>
                                                </tr>
                                                <tr>
                                                    <th>S.N.</th>
                                                    <th>Patient</th>
                                                    <th>Patient Code</th>
                                                    <th>Bill No.</th>
                                                    <th>Doctor</th>
                                                    <th>Tests</th>
                                                    <th>Created By</th>
                                                    <th>Test Price</th>
                                                    <th>HST 5%</th>
                                                    <th>Amount (Rs)</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach ($tests as $key => $val)
                                                    <tr>
                                                        <td><b>{{ ++$key }}</b></td>
                                                        <td>{{ $val->patient_name }} </td>
                                                        <td>{{ $val->patient_code }}</td>
                                                        <td>{{ $val->bill_number }}</td>
                                                        <td>{{ $val->fname }} {{{ $val->mname or '' }}} {{ $val->lname }}</td>
                                                        <td>{{ $val->test_list }}</td>
                                                        <td>{{ $val->fullname }} <br><b>{{ $val->created_at }}</b></td>
                                                        <td>{{ $val->sub_total }} <?php $tests_total += $val->sub_total;?></td>
                                                        <td>{{ $val->tax }} <?php $tests_tax += $val->tax;?></td>
                                                        <td>{{ $val->grand_total }} <?php $tests_net += $val->grand_total;?></td>
                                                    </tr>
                                                @endforeach
                                                <tr style="font-weight: bold;">
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td align="right">Total:</td>
                                                    <td>{{ $tests_total }}</td>
                                                    <td>{{ $tests_tax }}</td>
                                                    <td>{{ $tests_net }}</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        @else
                                            <p>No Data Available.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>



    <script>
        $(document).ready(function () {


            $('#datefrom').nepaliDatePicker({
                ndpEnglishInput: 'englishDate'
            });

            $('#dateto').nepaliDatePicker({
                onChange: function () {
                    var startDate = document.getElementById("datefrom").value;
                    var endDate = document.getElementById("dateto").value;

                    if ((Date.parse(startDate) > Date.parse(endDate))) {
                        alert("End date should be greater than Start date");
                        document.getElementById("datepicker1").value = "";
                    }
                }
            });
        });

        $('#print-report').click(function () {
            $('#print-report, #submit').hide();
            window.print();
            $('#print-report, #submit').show();
        });

        $('#print-report-1').click(function () {
            $('#print-report, #submit').hide();
            window.print();
            $('#print-report, #submit').show();
        });

        $('#print-report-2').click(function () {
            $('#print-report, #submit').hide();
            window.print();
            $('#print-report, #submit').show();
        });

        $('#print-report-3').click(function () {
            $('#print-report, #submit').hide();
            window.print();
            $('#print-report, #submit').show();
        });

        $('#excel-opd').click(function () {
            $('.h_opd').removeClass('ninja');
            var df = $('#datefrom').val();
            var dt = $('#dateto').val();
            var cont = df + ' to ' + dt;
            $('.date-range').text(cont);
            $('#opd-table').tableExport({type: 'excel', escape: 'false'});
            $('.h_opd').addClass('ninja');
        });
        $('#excel-emergency').click(function () {
            $('.h_emr').removeClass('ninja');
            var df = $('#datefrom').val();
            var dt = $('#dateto').val();
            var cont = df + ' to ' + dt;
            $('.date-range').text(cont);
            $('#emergency-table').tableExport({type: 'excel', escape: 'false'});
            $('.h_emr').addClass('ninja');

        });
        $('#excel-ipd').click(function () {
            $('.h_ipd').removeClass('ninja');
            var df = $('#datefrom').val();
            var dt = $('#dateto').val();
            var cont = df + ' to ' + dt;
            $('.date-range').text(cont);
            $('#ipd-table').tableExport({type: 'excel', escape: 'false'});
            $('.h_ipd').addClass('ninja');
        });
        $('#excel-tests').click(function () {
            $('.h_test').removeClass('ninja');
            var df = $('#datefrom').val();
            var dt = $('#dateto').val();
            var cont = df + ' to ' + dt;
            $('.date-range').text(cont);
            $('#tests-table').tableExport({type: 'excel', escape: 'false'});
            $('.h_test').addClass('ninja');
        });

    </script>



@stop


@section('footerscripts')


    <!-- excel export -->
    <script type="text/javascript" src="{{ URL::asset('js/xl/tableExport.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/xl/jquery.base64.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/xl/html2canvas.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/xl/jspdf/libs/sprintf.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/xl/jspdf/jspdf.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/xl/jspdf/libs/base64.js') }}"></script>

@stop
