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

        td.tbl-label {
            font-weight: bold;
            text-align: center;
            background: #00c0ef !important;
            color: #FFF;
        }

        td.tbl-label:hover {
            background: #00c0ef !important;
        }

        .ninja {
            display: none;
        }
    </style>
    <link href="{{ URL::asset('css/bootstrap-datetimepicker.css') }}">
    <section class="content-header">
        <h1>Doctor Report</h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body">
                        <div class="col-md-12"></div>

                        <form name="doctor-report" method="post" action="{{ url('/operate-doctor-report') }}">
                            {{ csrf_field() }}

                            <div class="col-md-2"></div>

                            <div class="form-group col-md-3">
                                <label class="sr-only" for="fromDate">From Date</label>
                                <div class="input-group">
                                    <div class="input-group-addon">From</div>
                                    <input name="date" id="datefrom" type="text" class="form-control"
                                           value="{{{ $dateNepali or getTodayNepaliDate()}}}"/>
                                </div>
                            </div>

                            <div class="form-group col-md-3">
                                <label class="sr-only" for="toDate">To Date</label>
                                <div class="input-group">
                                    <div class="input-group-addon">To</div>
                                    <input name="dateto" id="dateto" type="text" class="form-control"
                                           value="{{{ $dateToNepali or getTodayNepaliDate()}}}"/>
                                </div>
                            </div>

                            <div class="form-group col-md-3">
                                <label class="sr-only" for="doctorList">Doctor</label>
                                <div class="input-group">
                                    <div class="input-group-addon">Doctor</div>
                                    <select class="form-control" name="doctor_list">
                                        <option value="0">- Choose Doctor -</option>
                                        @foreach ($doctors as $key => $list)
                                            <option value="{{ $list->id }}" @if (isset($doctor) && $list->id == $doctor) {{ 'selected' }} @endif>{{ ucfirst($list->first_name) }} {{ $list->middle_name or '' }} {{ ucfirst($list->last_name) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                            <div class="col-md-1"><input name="submit" id="submit" type="submit" value="View"
                                                         class="btn btn-info"/></div>
                        </form>
                        <div class="clearfix"></div>
                        <br>

                        @if (isset($patients))
                            <button id="print-report" class="btn btn-info pull-right" style="margin-left: 10px;"><i
                                        class="fa fa-print" aria-hidden="true"></i> Print
                            </button>
                            <button type="button" class="btn btn-info pull-right" id="excel"><span
                                        class="glyphicon glyphicon-save"></span> Export to Excel
                            </button>
                            <div class="clearfix"></div>
                    @endif

                    <!-------------------------------------->


                        <div class="col-md-12">
                            <table class="table table-striped" id="doctor-report">
                                <thead>
                                <tr class="ninja h">
                                    <th colspan="2">Dr. {{{ $doctor_name or "" }}} - Doctor Report</th>
                                    <th colspan="4" class="date-range"></th>
                                </tr>
                                <tr class="ninja h">
                                    <th colspan="8"></th>
                                </tr>
                                <tr>
                                    <th>S.No.</th>
                                    <th>Patient Code</th>
                                    <th>Name</th>
                                    <th class="{{{ $class or '' }}}">Bill Number</th>
                                    <th width="100" style="text-align: center">Test</th>
                                    <th width="100" style="text-align: center">Fee</th>
                                    <th width="100" style="text-align: center">HST</th>
                                    <th width="100" style="text-align: center">Grand Total</th>
                                    @if ($consulting == 1)
                                        <th>Reference Doctor</th>@endif
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $opd_total = 0; $cnt = 1; $ipd_total = $path_total = $test_total = $opd_fee_total = 0;
                                $ipd_fee_total = $path_fee_total = $test_fee_total = $opd_hst_total = $ipd_hst_total = 0;
                                $path_hst_total = $test_hst_total = $round_chrg_total = $round_chrg_hst_total = $round_chrg_grandtotal = 0;
                                $bed_fee_total = $bed_hst_total = $bed_total = $test_fee_total = $test_hst_total = $test_total = 0;
                                $ipd_test_fee_total = $ipd_test_hst_total = $ipd_test_total = 0;
                                $ipd_path_fee_total = $ipd_path_hst_total = 0; $ipd_path_total = 0;
                                ?>
                                @if (isset($patients))
                                    @if (count($patients)>=1)
                                        @foreach ($patients as $key => $pat)
                                            @if ($key == 0)
                                                <tr>
                                                    <td colspan="{{ $cs }}" class="tbl-label">OPD</td>
                                                </tr>
                                            @endif
                                            <tr>
                                                <td>{{ $cnt }} <?php $cnt++;?></td>
                                                <td>{{ $pat->patient_code }}</td>
                                                <td>{{ $pat->first_name }} {{{ $pat->middle_name or '' }}} {{ $pat->last_name }}</td>
                                                <td class="{{{ $class or '' }}}">{{ $pat->bill_number }}</td>
                                                <td>OPD</td>
                                                <td align="center">{{ $pat->doctor_fee }} <?php $opd_fee_total += $pat->doctor_fee;?></td>
                                                <td align="center">{{ round($pat->doctor_tax_only, 2) }} <?php $opd_hst_total += $pat->doctor_tax_only;?></td>
                                                <td align="center">{{ round($pat->doctor_fee_with_tax, 2) }} <?php $opd_total += $pat->doctor_fee_with_tax;?></td>
                                                @if ($consulting == 1)
                                                    <td></td>@endif
                                            </tr>
                                        @endforeach
                                        <tr style="font-weight: bold;">
                                            <td colspan="{{ $cs-3 }}" align="right"><strong>Sub Total1:</strong></td>
                                            <td align="center">{{ round($opd_fee_total, 2) }}</td>
                                            <td align="center">{{ round($opd_hst_total, 2) }}</td>
                                            <td align="center">{{ round($opd_total, 2) }}</td>
                                        </tr>
                                    @endif
                                @endif

                                @if (isset($pathology_sub_arr))
                                    @if (count($pathology_sub_arr)>=1)
                                        <tr>
                                            <td colspan="{{ $cs }}" class="tbl-label">Pathology</td>
                                        </tr>
                                        @foreach ($pathology_sub_arr as $key => $res)
                                            @foreach ($res as $rkey => $path)
                                                <tr>
                                                    <td>{{ $cnt }} <?php $cnt++;?></td>
                                                    <td>{{ $path['patient_code'] }}</td>
                                                    <td>{{ $path['name'] }}</td>
                                                    <td class="{{{ $class or '' }}}">{{ $path['bill_number'] }}</td>
                                                    <td>{{ $path['test'] }}</td>
                                                    <td align="center">{{ $path['fee'] }} <?php $path_fee_total += $path['fee'];?></td>
                                                    <td align="center">{{ $path['tax'] }} <?php $path_hst_total += $path['tax'];?></td>
                                                    <td align="center">{{ $path['grand_total'] }} <?php $path_total += $path['grand_total'];?> </td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                        <tr style="font-weight: bold;">
                                            <td colspan="{{ $cs-3 }}" align="right"><strong>Sub Total:</strong></td>
                                            <td align="center">{{ round($path_fee_total ,2) }}</td>
                                            <td align="center">{{ round($path_hst_total ,2) }}</td>
                                            <td align="center">{{ round($path_total ,2) }}</td>
                                        </tr>
                                    @endif
                                @endif

                                @if (isset($test_res))
                                    @if (count($test_res)>=1)
                                        @foreach ($test_res as $key => $res)
                                            <?php $test_fee_subtotal = 0; $test_hst_subtotal = 0; $test_subtotal = 0; ?>
                                            <tr>
                                                <td colspan="{{ $cs }}" class="tbl-label">{{ $key }}</td>
                                            </tr>
                                            @foreach ($res as $val)
                                                <tr>
                                                    <td>{{ $cnt }} <?php $cnt++;?></td>
                                                    <td>{{ $val['patient_code'] }}</td>
                                                    <td>{{ $val['name'] }}</td>
                                                    <td class="{{{ $class or '' }}}">{{ $val['bill_number'] }}</td>
                                                    <td>{{ $val['test'] }}</td>
                                                    <td align="center">{{ $val['fee'] }} <?php $test_fee_subtotal += $val['fee'];?></td>
                                                    <td align="center">{{ $val['tax'] }} <?php $test_hst_subtotal += $val['tax'];?></td>
                                                    <td align="center">{{ $val['grand_total'] }} <?php $test_subtotal += $val['grand_total'];?></td>
                                                    @if ($consulting == 1)
                                                        <td>{{ $val['referal_doctor'] }} </td>@endif
                                                </tr>
                                            @endforeach
                                            <tr style="font-weight: bold;">
                                                <td colspan="{{ $cs-3 }}" align="right"><strong>Sub Total:</strong></td>
                                                <td align="center">{{ round($test_fee_subtotal, 2) }} <?php $test_fee_total += $test_fee_subtotal;?></td>
                                                <td align="center">{{ round($test_hst_subtotal, 2) }} <?php $test_hst_total += $test_hst_subtotal;?></td>
                                                <td align="center">{{ round($test_subtotal, 2) }} <?php $test_total += $test_subtotal;?></td>
                                            </tr>
                                        @endforeach
                                    @endif
                                @endif

                                @if (isset($patients_ipd))
                                    @if (count($patients_ipd)>=1)
                                        @foreach ($patients_ipd as $key => $pat)
                                            @if ($key == 0)
                                                <tr>
                                                    <td colspan="{{ $cs }}" class="tbl-label">IPD Admission
                                                        Charge
                                                    </td>
                                                </tr>
                                            @endif
                                            <tr>
                                                <td>{{ $cnt }} <?php $cnt++;?></td>
                                                <td>{{ $pat->patient_code }}</td>
                                                <td>{{ $pat->first_name }} {{{ $pat->middle_name or '' }}} {{ $pat->last_name }}</td>
                                                <td class="{{{ $class or '' }}}">{{ $pat->bill_number }}</td>
                                                <td>IPD</td>
                                                <td align="center">{{ $pat->admission_charge }} <?php $ipd_fee_total += $pat->admission_charge;?></td>
                                                <td align="center">{{ round($pat->admission_charge_hst, 2) }} <?php $ipd_hst_total += $pat->admission_charge_hst;?></td>
                                                <td align="center">{{ round($pat->admission_charge_with_tax, 2) }} <?php $ipd_total += $pat->admission_charge_with_tax;?></td>
                                                @if ($consulting == 1)
                                                    <td></td>@endif
                                            </tr>
                                        @endforeach
                                        <tr style="font-weight: bold;">
                                            <td colspan="{{ $cs-3 }}" align="right"><strong>Sub Total:</strong></td>
                                            <td align="center">{{ round($ipd_fee_total ,2) }}</td>
                                            <td align="center">{{ round($ipd_hst_total ,2) }}</td>
                                            <td align="center">{{ round($ipd_total ,2) }}</td>
                                        </tr>
                                    @endif
                                @endif

                                @if (isset($ipd_test_path))
                                    @if (count($ipd_test_path)>=1)
                                        <tr>
                                            <td colspan="8" class="tbl-label">IPD Pathology</td>
                                        </tr>
                                        @foreach ($ipd_test_path as $key => $res)
                                            @foreach ($res as $cnt => $val)
                                                <tr>
                                                    <td>{{ ++$cnt }}</td>
                                                    <td>{{ $val['patient_code'] }}</td>
                                                    <td>{{ strtoupper($val['name']) }}</td>
                                                    <td class="{{{ $class or '' }}}">{{ $val['bill_number'] }}</td>
                                                    <td>{{ $val['test'] }}</td>
                                                    <td align="center">{{ $val['fee'] }} <?php $ipd_path_fee_total += $val['fee'];?></td>
                                                    <td align="center">{{ $val['tax'] }} <?php $ipd_path_hst_total += $val['tax'];?></td>
                                                    <td align="center">{{ $val['grand_total'] }} <?php $ipd_path_total += $val['grand_total'];?></td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                        <tr style="font-weight: bold;">
                                            <td colspan="5" align="right"><strong>Sub Total:</strong></td>
                                            <td align="center">{{ round($ipd_path_fee_total, 2) }}</td>
                                            <td align="center">{{ round($ipd_path_hst_total, 2) }}</td>
                                            <td align="center">{{ round($ipd_path_total, 2) }}</td>
                                        </tr>
                                    @endif
                                @endif

                                @if (isset($ipd_test))
                                    @if (count($ipd_test)>=1)
                                        @foreach ($ipd_test as $key => $res)
                                            <?php $ipd_test_fee_subtotal = 0; $ipd_test_hst_subtotal = 0; $ipd_test_subtotal = 0; ?>
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
                                                    <td align="center">{{ $val['fee'] }} <?php $ipd_test_fee_subtotal += $val['fee'];?></td>
                                                    <td align="center">{{ $val['tax'] }} <?php $ipd_test_hst_subtotal += $val['tax'];?></td>
                                                    <td align="center">{{ $val['grand_total'] }} <?php $ipd_test_subtotal += $val['grand_total'];?></td>
                                                </tr>
                                            @endforeach
                                            <tr style="font-weight: bold;">
                                                <td colspan="5" align="right"><strong>Sub Total:</strong></td>
                                                <td align="center">{{ round($ipd_test_fee_subtotal, 2) }} <?php $ipd_test_fee_total += $ipd_test_fee_subtotal;?></td>
                                                <td align="center">{{ round($ipd_test_hst_subtotal, 2) }} <?php $ipd_test_hst_total += $ipd_test_hst_subtotal;?></td>
                                                <td align="center">{{ round($ipd_test_subtotal, 2) }} <?php $ipd_test_total += $ipd_test_subtotal;?></td>
                                            </tr>
                                        @endforeach
                                    @endif
                                @endif

                                @if (isset($ipd_round_charge))
                                    @if (count($ipd_round_charge)>=1)
                                        @foreach ($ipd_round_charge as $key => $data)
                                            @if(count($data)>=1)
                                                <tr>
                                                    <td colspan="{{ $cs }}"
                                                        class="tbl-label">{{ $data->charge_title }}</td>
                                                </tr>
                                                <?php $round_chrg = $round_chrg_hst = $round_chrg_total = 0; ?>
                                                @foreach($data as $key1 => $pat)
                                                    <tr>
                                                        <td>{{ $cnt }} <?php $cnt++;?></td>
                                                        <td>{{ $pat->patient_code }}</td>
                                                        <td>{{ $pat->first_name }}</td>
                                                        <td>{{{ $pat->bill_number or "-" }}}</td>
                                                        <td>IPD</td>
                                                        <td align="center">{{ $pat->doctor_fee }} <?php $round_chrg += $pat->doctor_fee;?></td>
                                                        <td align="center">{{ round($pat->hst, 2) }} <?php $round_chrg_hst += $pat->hst;?></td>
                                                        <td align="center">{{ round($pat->doctor_fee_with_tax, 2) }} <?php $round_chrg_total += $pat->doctor_fee_with_tax;?></td>
                                                        @if ($consulting == 1)
                                                            <td></td>@endif
                                                    </tr>
                                                @endforeach
                                                <tr style="font-weight: bold;">
                                                    <td colspan="{{ $cs-3 }}" align="right"><strong>Sub Total:</strong></td>
                                                    <td align="center">{{ round($round_chrg ,2) }} <?php $round_chrg_total += $round_chrg;?></td>
                                                    <td align="center">{{ round($round_chrg_hst ,2) }} <?php $round_chrg_hst_total += $round_chrg_hst;?></td>
                                                    <td align="center">{{ round($round_chrg_total ,2) }} <?php $round_chrg_grandtotal += $round_chrg_total;?></td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    @endif
                                @endif

                                @if (isset($bed_charge_detail))
                                    @if (count($bed_charge_detail)>=1)
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
                                                    <td>{{ $val['bill_number'] }}</td>
                                                    <td>Bed Charge</td>
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
                                    @endif
                                @endif
                                <tr style="font-weight: bold; background-color: #a4a7a9">
                                    <td colspan="5" align="right"><strong>Grand Total:</strong></td>
                                    <td align="center">{{ round($opd_fee_total + $ipd_fee_total + $path_fee_total + $test_fee_total + $round_chrg_total + $bed_fee_total + $ipd_test_fee_total + $ipd_path_fee_total, 2) }}</td>
                                    <td align="center">{{ round($opd_hst_total + $ipd_hst_total + $path_hst_total + $test_hst_total + $round_chrg_hst_total + $bed_hst_total + $ipd_test_hst_total + $ipd_path_hst_total, 2) }}</td>
                                    <td align="center">{{ round($opd_total + $ipd_total + $path_total + $test_total + $round_chrg_grandtotal + $bed_total + $ipd_test_total + $ipd_path_total, 2) }}</td>
                                </tr>
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

            $('#print-report').click(function () {
                $('#print-report, #submit').hide();
                window.print();
                $('#print-report, #submit').show();
            });


            /***/
            $('#excel').click(function () {
                var opd = $('#opd-report').html();
                var tests = $('#tests-report').html();
                $('#opd-here').html(opd);
                $('#tests-here').html(tests);
                $('.h').removeClass('ninja');
                var df = $('#datefrom').val();
                var dt = $('#dateto').val();
                var cont = df + ' to ' + dt;
                $('.date-range').text(cont);

                $('#doctor-report').tableExport({type: 'excel', escape: 'false'});

                $('.h').addClass('ninja');
                $('#opd-here').html('');
                $('#tests-here').html('');

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