@extends('backendlayout.master')
@extends('backendlayout.header')
@extends('backendlayout.leftmenu')
@extends('backendlayout.footer')
@section('userscontent')
    @extends('backendlayout.flashmessagecollection')
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

        .ninja {
            display: none;
        }

        /*#revenue_wrapper input[type="text"] {
            width: 100%;
        }*/

    </style>
    <script src="{{URL::asset('backendtheme/plugins/jQuery/jQuery-2.1.4.min.js')}}"></script>
    <section class="content-header">
        <h1>
            {{ $title }}
        </h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                        <div class="col-md-12">
                            <form name="date-chooser" method="post" action="{{ url('/revenue/by-user') }}">
                                {{ csrf_field() }}
                                <div class="form-group col-md-3">
                                    <label class="sr-only" for="fromDate">From Date</label>
                                    <div class="input-group">
                                        <div class="input-group-addon">From</div>
                                        <input name="from" class="form-control" id="datefrom"
                                               type="text" value="{{{ $fromOld or getTodayNepaliDate() }}}"/>
                                    </div>
                                </div>

                                <div class="form-group col-md-3">
                                    <label class="sr-only" for="toDate">To Date</label>
                                    <div class="input-group">
                                        <div class="input-group-addon">To</div>
                                        <input name="to" class="form-control" type="text" id="dateto"
                                               value="{{{ $toNew or getTodayNepaliDate() }}}"/>
                                    </div>
                                </div>

                                <div class="form-group col-md-3">
                                    <label class="sr-only" for="user">User</label>
                                    <div class="input-group">
                                        <div class="input-group-addon">User</div>
                                        <select name="user" class="form-control">
                                            <option value="0">-- All Users --</option>
                                            @foreach ($usersllist as $val)
                                                <option value="{{ $val->id }}"
                                                        @if ($val->id == $uid) selected @endif>{{ $val->fullname }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-1">
                                    <input name="submit" type="submit" value="Search"
                                           class="btn btn-info search-report"/>
                                </div>
                            </form>
                        </div>

                        <div class="col-md-12">
                            @if (!empty($data))
                                <button class="btn btn-info pull-right print-report" onclick="printContent()"><span
                                            class="glyphicon glyphicon-print"></span> Print
                                </button>
                                <button id="excel" class="btn btn-info pull-right" style="margin-right: 10px;"><span
                                            class="glyphicon glyphicon-save"></span> Export to Excel
                                </button>
                                <div class="clearfix"></div><br>
                                <table class="table table-bordered" id="user-report">
                                    <thead>
                                    <tr class="ninja h">
                                        <th colspan="2">{{ $title }}</th>
                                        <th colspan="4" class="date-range"></th>
                                    </tr>
                                    <tr class="s">
                                        <th rowspan="2">S.No.</th>
                                        <th rowspan="2">User</th>
                                        <th colspan="2">Tests</th>
                                        <th colspan="2">OPD</th>
                                        <th colspan="3">IPD</th>
                                        <th colspan="2">Emergency</th>
                                        <th rowspan="1"></th>
                                    </tr>

                                    <tr class="s">
                                        <th>Total</th>
                                        <th>Refund</th>
                                        <th>Total</th>
                                        <th>Refund</th>
                                        <th>Admission</th>
                                        <th>Deposit</th>
                                        <th>Discharge</th>
                                        <th>Charge</th>
                                        <th>Discharge</th>
                                        <th>Grand Total</th>
                                    </tr>

                                    <tr class="h ninja">
                                        <th>S.No.</th>
                                        <th>User</th>
                                        <th>Tests Total</th>
                                        <th>Tests Refund</th>
                                        <th>OPD Total</th>
                                        <th>OPD Refund</th>
                                        <th>IPD Admission</th>
                                        <th>IPD Deposit</th>
                                        <th>IPD Discharge</th>
                                        <th>Emergency Charge</th>
                                        <th>Emergency Discharge</th>
                                        <th>Grand Total</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach ($data as $key=>$val)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $val['user'] }}</td>
                                            <td>{{ $val['test']['total'] }}</td>
                                            <td>{{ $val['test']['refund'] }}</td>
                                            <td>{{ $val['opd']['total'] }}</td>
                                            <td>{{ $val['opd']['refund'] }}</td>
                                            <td>{{ $val['ipd']['admission'] }}</td>
                                            <td>{{ $val['ipd']['total'] }}</td>
                                            <td>{{ $val['ipd']['discharge'] }}</td>
                                            <td>{{ $val['emergency']['total'] }}</td>
                                            <td>{{ $val['emergency']['discharge'] }}</td>
                                            <td>{{ $val['grand']['total'] }}</td>
                                            <td>@if ($uid != 0)<a
                                                        href="{{ url('revenue/detail-user/' . $uid . '/' . $from . '/' . $to) }}"
                                                        class="btn btn-info detail-btn" target="_blank">Detail</a>@endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    {{--Total for all users--}}
                                    @if ($uid == 0)
                                        <tr>
                                            <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                                            <td align="right"><strong>Table Total:</strong></td>
                                            <td>{{ round($all_users_total, 2) }}</td>
                                        </tr>
                                    @endif


                                    @if ($uid != 0)
                                        <tr class="h ninja">
                                            <td colspan="10"></td>
                                        </tr>
                                        <tr class="h ninja">
                                            <td colspan="10">Tests Refund Detail</td>
                                        </tr>
                                        <tr class="h ninja">
                                            <td>S.No.</td>
                                            <td>Patient</td>
                                            <td>Date</td>
                                            <td>Amount</td>
                                        </tr>

                                        <?php $sum = 0; ?>
                                        @foreach ($refund_user_tests as $key => $val)
                                            <tr class="h ninja">
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $val->first_name }} {{{ $val->middle_name or '' }}} {{ $val->last_name }}</td>
                                                <td>{{ $val->date }}</td>
                                                <td align="right">{{ $val->grand_total }} <?php $sum += $val->grand_total; ?></td>
                                            </tr>
                                        @endforeach
                                        <tr style="font-weight: bold;" class="h ninja">
                                            <td></td>
                                            <td></td>
                                            <td align="right">Total:</td>
                                            <td align="right">{{ $sum }}</td>
                                        </tr>
                                    @endif

                                    @if (!empty($refund_user_opd))
                                        <tr class="h ninja">
                                            <td colspan="9"></td>
                                        </tr>
                                        <tr class="h ninja">
                                            <td colspan="9">OPD Refund Detail</td>
                                        </tr>
                                        <tr class="h ninja">
                                            <td>S.No.</td>
                                            <td>Patient</td>
                                            <td>Date</td>
                                            <td>Amount</td>
                                        </tr>

                                        <?php $sum = 0; ?>

                                        @foreach ($refund_user_opd as $key => $val)
                                            <tr class="h ninja">
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $val->first_name }} {{{ $val->middle_name or '' }}} {{ $val->last_name }}</td>
                                                <td>{{ $val->created_at }}</td>
                                                <td align="right">{{ $val->doctor_fee_with_tax }} <?php $sum += $val->doctor_fee_with_tax; ?></td>
                                            </tr>
                                        @endforeach

                                        <tr style="font-weight: bold;" class="h ninja">
                                            <td></td>
                                            <td></td>
                                            <td align="right">Total:</td>
                                            <td align="right">{{ $sum }}</td>
                                        </tr>
                                    @endif

                                    </tbody>
                                </table>
                            @endif
                        </div>

                        <div class="col-md-12 s">
                            @if ($uid != 0)
                                <div class="col-md-6">
                                    <h4>Tests Refund Detail</h4>
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>S.No.</th>
                                            <th>Patient</th>
                                            <th>Date</th>
                                            <th>Amount</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $sum = 0; ?>
                                        @foreach ($refund_user_tests as $key => $val)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $val->first_name }} {{{ $val->middle_name or '' }}} {{ $val->last_name }}</td>
                                                <td>{{ $val->date }}</td>
                                                <td align="right">{{ $val->grand_total }} <?php $sum += $val->grand_total; ?></td>
                                            </tr>
                                        @endforeach
                                        <tr style="font-weight: bold;">
                                            <td colspan="3" align="right">Total:</td>
                                            <td align="right">{{ $sum }}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="col-md-6">
                                    <h4>OPD Refund Detail</h4>
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>S.No.</th>
                                            <th>Patient</th>
                                            <th>Date</th>
                                            <th>Amount</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $sum = 0; ?>
                                        @foreach ($refund_user_opd as $key => $val)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $val->first_name }} {{{ $val->middle_name or '' }}} {{ $val->last_name }}</td>
                                                <td>{{ $val->created_at }}</td>
                                                <td align="right">{{ $val->doctor_fee_with_tax }} <?php $sum += $val->doctor_fee_with_tax; ?></td>
                                            </tr>
                                        @endforeach
                                        <tr style="font-weight: bold;">
                                            <td colspan="3" align="right">Total:</td>
                                            <td align="right">{{ $sum }}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>
                </div><!-- end of box -->
            </div>
        </div>
    </section>


    <script type="text/javascript">
        $(document).ready(function () {
            $('#datefrom').nepaliDatePicker({
                ndpEnglishInput: 'englishDate'
            });

            $('#dateto').nepaliDatePicker({
                ndpEnglishInput: 'englishDate'
            });

        });


        function printContent() {
            $('.search-report, .print-report, footer, .detail-btn').hide();
            window.print();
            $('.search-report, .print-report, footer, .detail-btn').show();
        }

        $('#excel').click(function () {
            $('.h').removeClass('ninja');
            $('.s').addClass('ninja');
            var df = $('#datefrom').val();
            var dt = $('#dateto').val();
            var cont = df + ' to ' + dt;
            $('.date-range').text(cont);
            $('#user-report').tableExport({type: 'excel', escape: 'false'});
            $('.h').addClass('ninja');
            $('.s').removeClass('ninja');
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

