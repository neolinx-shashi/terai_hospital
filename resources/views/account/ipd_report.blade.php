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
    <style>
        .no-padding {
            padding: 0;
        }

        .spacer {
            margin: 20px 0;
        }

        .fat {
            font-weight: bold;
        }

        .ninja {
            display: none;
        }

        td.tbl-label {
            font-weight: bold;
            text-align: center;
            background: #00c0ef !important;
            color: #FFF;
        }

        td.tbl-label:hover {
            background: #00c0ef !important;
        }
    </style>
    <link href="{{ URL::asset('css/bootstrap-datetimepicker.css') }}">
    <section class="content-header">
        <h1>{{{ $title or '' }}} Report</h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body">
                        <div class="col-md-12"></div>

                        <form name="pathology-report" method="post" action="{{ url('/generate-ipd-report') }}">
                            {{ csrf_field() }}

                            <div class="col-md-2"></div>

                            <div class="form-group col-md-3">
                                <label class="sr-only" for="fromDate">From Date</label>
                                <div class="input-group">
                                    <div class="input-group-addon">From</div>
                                    <input name="datefrom" id="datefrom" type="text" class="form-control"
                                           value="{{{ $date_from or getTodayNepaliDate()}}}"/>
                                </div>
                            </div>

                            <div class="form-group col-md-3">
                                <label class="sr-only" for="toDate">To Date</label>
                                <div class="input-group">
                                    <div class="input-group-addon">To</div>
                                    <input name="dateto" id="dateto" type="text" class="form-control"
                                           value="{{{ $date_to or getTodayNepaliDate()}}}"/>
                                </div>
                            </div>

                            <div class="form-group col-md-3">
                                <label class="sr-only" for="category">Test</label>
                                <div class="input-group">
                                    <div class="input-group-addon">Test</div>
                                    <select class="form-control" name="category" id="category">
                                        <option value="0">- Select Test -</option>
                                        <option value="test" @if ($cat == "test") selected @endif>Test Report</option>
                                        <option value="bed charge" @if ($cat == "bed charge") selected @endif>Bed Charge
                                            Report
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-1"><input name="submit" id="submit" type="submit" value="View"
                                                         class="btn btn-info"/></div>
                        </form>
                        <div class="clearfix"></div>
                        <br>

                        @if (isset($test_res) || isset($ipd_test_path))
                            @if (count($test_res)>=1 || count($ipd_test_path)>=1)
                                <?php
                                $test_fee_total = $test_hst_total = $test_total = 0;
                                $path_fee_total = $path_hst_total = $path_total = 0;
                                ?>
                                <button id="print-report" class="btn btn-info pull-right" style="margin-left: 10px;"><i
                                            class="fa fa-print" aria-hidden="true"></i> Print
                                </button>

                                <button type="button" class="btn btn-info pull-right" id="excel"><span
                                            class="glyphicon glyphicon-save"></span> Export to Excel
                                </button>
                                <div class="clearfix"></div>

                                <table class="table table-striped" id="pathology-report">
                                    <thead>
                                    <tr class="ninja h">
                                        <th colspan="2">{{{ $title or '' }}} Report</th>
                                        <th colspan="4" class="date-range"></th>
                                    </tr>
                                    <tr class="ninja h">
                                        <th colspan="8"></th>
                                    </tr>
                                    <tr>
                                        <th>S.No.</th>
                                        <th>Patient Code</th>
                                        <th>Patient</th>
                                        <th>Bill Number</th>
                                        <th>Test</th>
                                        <th style="text-align: right">Fee</th>
                                        <th style="text-align: right">HST</th>
                                        <th style="text-align: right">Grand Total</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    {{--IPD Pathology Test Report--}}
                                    @if (count($ipd_test_path)>=1)
                                        <tr>
                                            <td colspan="8" class="tbl-label">Pathology</td>
                                        </tr>
                                        @foreach ($ipd_test_path as $key => $res)
                                            @foreach ($res as $cnt => $val)
                                                <tr>
                                                    <td>{{ ++$cnt }}</td>
                                                    <td>{{ $val['patient_code'] }}</td>
                                                    <td>{{ strtoupper($val['name']) }}</td>
                                                    <td class="{{{ $class or '' }}}">{{ $val['bill_number'] }}</td>
                                                    <td>{{ $val['test'] }}</td>
                                                    <td align="center">{{ $val['fee'] }} <?php $path_fee_total += $val['fee'];?></td>
                                                    <td align="center">{{ $val['tax'] }} <?php $path_hst_total += $val['tax'];?></td>
                                                    <td align="center">{{ $val['grand_total'] }} <?php $path_total += $val['grand_total'];?></td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                        <tr style="font-weight: bold;">
                                            <td colspan="5" align="right"><strong>Sub Total:</strong></td>
                                            <td align="center">{{ round($path_fee_total, 2) }}</td>
                                            <td align="center">{{ round($path_hst_total, 2) }}</td>
                                            <td align="center">{{ round($path_total, 2) }}</td>
                                        </tr>
                                    @endif

                                    {{--IPD Test Report by Sub-Category--}}
                                    @if (count($test_res)>=1)
                                        @foreach ($test_res as $key => $res)
                                            <?php $test_fee_subtotal = 0; $test_hst_subtotal = 0; $test_subtotal = 0; ?>
                                            <tr>
                                                <td colspan="8" class="tbl-label">{{ $key }}</td>
                                            </tr>
                                            @foreach ($res as $cnt => $val)
                                                <tr>
                                                    <td>{{ ++$cnt }}</td>
                                                    <td>{{ $val['patient_code'] }}</td>
                                                    <td>{{ strtoupper($val['name']) }}</td>
                                                    <td class="{{{ $class or '' }}}">{{ $val['bill_number'] }}</td>
                                                    <td>{{ $val['test'] }}</td>
                                                    <td align="center">{{ $val['fee'] }} <?php $test_fee_subtotal += $val['fee'];?></td>
                                                    <td align="center">{{ $val['tax'] }} <?php $test_hst_subtotal += $val['tax'];?></td>
                                                    <td align="center">{{ $val['grand_total'] }} <?php $test_subtotal += $val['grand_total'];?></td>
                                                </tr>
                                            @endforeach
                                            <tr style="font-weight: bold;">
                                                <td colspan="5" align="right"><strong>Sub Total:</strong></td>
                                                <td align="center">{{ round($test_fee_subtotal, 2) }} <?php $test_fee_total += $test_fee_subtotal;?></td>
                                                <td align="center">{{ round($test_hst_subtotal, 2) }} <?php $test_hst_total += $test_hst_subtotal;?></td>
                                                <td align="center">{{ round($test_subtotal, 2) }} <?php $test_total += $test_subtotal;?></td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    <tr style="font-weight: bold; background-color: #a4a7a9">
                                        <td colspan="5" align="right"><strong>Grand Total:</strong></td>
                                        <td align="center">{{ round($test_fee_total + $path_fee_total, 2) }}</td>
                                        <td align="center">{{ round($test_hst_total + $path_hst_total, 2) }}</td>
                                        <td align="center">{{ round($test_total + $path_total, 2) }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                                <br><br>
                            @endif
                        @elseif (isset($bed_charge_detail))
                            @if (count($bed_charge_detail)>=1)
                                <button id="print-report" class="btn btn-info pull-right"
                                        style="margin-left: 10px;"><i class="fa fa-print" aria-hidden="true"></i> Print
                                </button>

                                <button type="button" class="btn btn-info pull-right" id="excel"><span
                                            class="glyphicon glyphicon-save"></span> Export to Excel
                                </button>
                                <div class="clearfix"></div>

                                <table class="table table-striped" id="pathology-report">
                                    <thead>
                                    <tr class="ninja h">
                                        <th colspan="2">{{{ $title or '' }}} Report</th>
                                        <th colspan="4" class="date-range"></th>
                                    </tr>
                                    <tr class="ninja h">
                                        <th colspan="8"></th>
                                    </tr>
                                    <tr>
                                        <th>S.No.</th>
                                        <th>Patient Code</th>
                                        <th>Patient</th>
                                        <th>Doctor</th>
                                        <th>Bill Number</th>
                                        <th style="text-align: right">Fee</th>
                                        <th style="text-align: right">HST</th>
                                        <th style="text-align: right">Grand Total</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $bed_fee_total = $bed_hst_total = $bed_total = 0; ?>
                                    @foreach ($bed_charge_detail as $key => $res)
                                        <?php $bed_fee_subtotal = 0; $bed_hst_subtotal = 0; $bed_subtotal = 0; ?>
                                        <tr>
                                            <td colspan="8" class="tbl-label">{{ $key }}</td>
                                        </tr>
                                        @foreach ($res as $cnt => $val)
                                            <tr>
                                                <td>{{ ++$cnt }}</td>
                                                <td>{{ $val['patient_code'] }}</td>
                                                <td>{{ strtoupper($val['patient_name']) }}</td>
                                                <td>{{ $val['doctor_name'] }}</td>
                                                <td>{{ $val['bill_number'] }}</td>
                                                <td align="center">{{ $val['room_charge'] }} <?php $bed_fee_subtotal += $val['room_charge'];?></td>
                                                <td align="center">{{ $val['tax'] }} <?php $bed_hst_subtotal += $val['tax'];?></td>
                                                <td align="center">{{ $val['grand_total'] }} <?php $bed_subtotal += $val['grand_total'];?></td>
                                            </tr>
                                        @endforeach
                                        <tr style="font-weight: bold;">
                                            <td colspan="5" align="right"><strong>Sub Total:</strong></td>
                                            <td align="center">{{ round($bed_fee_subtotal, 2) }} <?php $bed_fee_total += $bed_fee_subtotal;?></td>
                                            <td align="center">{{ round($bed_hst_subtotal, 2) }} <?php $bed_hst_total += $bed_hst_subtotal;?></td>
                                            <td align="center">{{ round($bed_subtotal, 2) }} <?php $bed_total += $bed_subtotal;?></td>
                                        </tr>
                                    @endforeach
                                    <tr style="font-weight: bold; background-color: #a4a7a9;">
                                        <td colspan="5" align="right"><strong>Grand Total:</strong></td>
                                        <td align="center">{{ round($bed_fee_total, 2) }}</td>
                                        <td align="center">{{ round($bed_hst_total, 2) }}</td>
                                        <td align="center">{{ round($bed_total, 2) }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                                <br><br>
                            @endif
                        @elseif (isset($ipd_discharge))
                            <button id="print-report" class="btn btn-info pull-right" style="margin-left: 10px;"><i
                                        class="fa fa-print" aria-hidden="true"></i> Print
                            </button>

                            <button type="button" class="btn btn-info pull-right" id="excel"><span
                                        class="glyphicon glyphicon-save"></span> Export to Excel
                            </button>
                            <div class="clearfix"></div>

                            <table class="table table-striped" id="pathology-report">
                                <thead>
                                <tr class="ninja h">
                                    <th colspan="2">{{{ $title or '' }}} Report</th>
                                    <th colspan="4" class="date-range"></th>
                                </tr>
                                <tr class="ninja h">
                                    <th colspan="8"></th>
                                </tr>
                                <tr>
                                    <th>S.No.</th>
                                    <th>Date</th>
                                    <th>Doctor</th>
                                    <th>Patient</th>
                                    <th>Bill Number</th>
                                    <th>Test</th>
                                    <th style="text-align: right">Fee</th>
                                    <th style="text-align: right">HST</th>
                                    <th style="text-align: right">Grand Total</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $total_fee = $total_tax = $total_grand = $sn = 0; ?>
                                @foreach ($ipd_discharge as $key => $rep)
                                    @if($rep->test_list != "")
                                        <tr>
                                            <td>{{ ++$sn }}</td>
                                            <td>{{ $rep->date_nep }}</td>
                                            <td>{{ $rep->doctor_name }}</td>
                                            <td>{{ $rep->first_name }}</td>
                                            <td>{{ $rep->bill_number }}</td>
                                            <td>{{ $rep->test_list }}</td>
                                            <td style="text-align: right">{{ $rep->total_fee }} <?php $total_fee += $rep->total_fee; ?></td>
                                            <td style="text-align: right">{{ $rep->tax }} <?php $total_tax += $rep->tax; ?></td>
                                            <td align="right">{{ $rep->gtotal }} <?php $total_grand += $rep->gtotal;?></td>
                                        </tr>
                                    @endif
                                @endforeach
                                <tr style="font-weight: bold; background-color: #a4a7a9">
                                    <td colspan="6" align="right"><strong>Grand Total:</strong></td>
                                    <td>{{ round($total_fee, 2) }}</td>
                                    <td>{{ round($total_tax, 2) }}</td>
                                    <td>{{ round($total_grand, 2) }}</td>
                                </tr>
                                </tbody>
                            </table>
                            <br><br>
                        @else
                            <h4 style="text-align: center; font-weight: bold">Sorry! No data available.</h4>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="{{ url('js/jquery-3.2.1.min.js') }}"></script>
    <!--<script src="{{URL::asset('backendtheme/plugins/jQuery/jQuery-2.1.4.min.js')}}"></script>-->
    <script>
        $(function () {
            $('#datetimepicker1').datetimepicker({
                userCurrent: true
            });

            $('#print-report').click(function () {
                $('#print-report, #submit, #excel, footer').hide();
                window.print();
                $('#print-report, #submit, #excel, footer').show();
            });


            /***/
            $('#excel').click(function () {
                $('.h').removeClass('ninja');
                var df = $('#datefrom').val();
                var dt = $('#dateto').val();
                var cont = df + ' to ' + dt;
                $('.date-range').text(cont);
                $('#pathology-report').tableExport({type: 'excel', escape: 'false'});
                $('.h').addClass('ninja');
            });


        });
    </script>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#datefrom').nepaliDatePicker({
                ndpEnglishInput: 'englishDate'
            });

            $('#dateto').nepaliDatePicker({
                ndpEnglishInput: 'englishDate'
            });


            $('#category').change(function () {
                var cat = $(this).val();
                if (cat === "0") {
                    alert('Choose Test');
                    $('#submit').attr('disabled', 'disabled');
                } else {
                    $('#submit').removeAttr('disabled');
                }
            });
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