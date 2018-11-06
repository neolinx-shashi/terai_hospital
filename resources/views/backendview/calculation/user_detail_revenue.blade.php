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

        .header-bg {
            font-weight: bold;
            background: #00c0ef !important;
            color: #FFF;
        }

        .head-cont {
            font-weight: bold;
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
                            <h3>{{ $user->fullname }}</h3>
                            <h4>Date: {{ $from_n }} to {{ $to_n }}</h4>
                            <button class="btn btn-info pull-right print-report" onclick="printContent()"><span
                                        class="glyphicon glyphicon-print"></span> Print
                            </button>
                            <button id="excel" class="btn btn-info pull-right" style="margin-right: 10px;"><span
                                        class="glyphicon glyphicon-save"></span> Export to Excel
                            </button>

                            <div class="clearfix"></div>
                            <br>

                            <table class="table table-striped" id="user-report">
                                <thead>
                                <tr class="h ninja">
                                    <th></th>
                                    <th>User: {{ $user->fullname }}</th>
                                    <th></th>
                                    <th>Date:</th>
                                    <th>{{ $from_n }} to {{ $to_n }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $sno = 1;
                                $total_opd = $total_hst = $total_grand = $total_ipd = $total_ipd_hst = $total_ipd_grand = $total_emergency = $total_emergency_hst = $total_emergency_grand = $total_patho = $hst_patho = $grand_patho = 0;
                                ?>

                                @if (isset($wrong))
                                    <h3>Date Range should be before "2074-07-21" or from "2074-07-21".</h3>
                                @else


                                    @if (count($opd) > 0)
                                        <tr align="center">
                                            <td class="header-bg" colspan="8">OPD</td>
                                        </tr>
                                        <tr class="head-cont">
                                            <td>S.No.</td>
                                            <td>Patient</td>
                                            <td>Bill No.</td>
                                            <td>Status</td>
                                            <td style="text-align: right;">Fee</td>
                                            <td style="text-align: right;">HST</td>
                                            <td style="text-align: right;">Grand Total</td>
                                        </tr>
                                        @foreach ($opd as $key => $val)
                                            <tr>
                                                <td>{{ $sno }} <?php $sno++;?></td>
                                                <td>{{ $val->first_name }}</td>
                                                <td>{{ $val->bill_number }}</td>
                                                <td>@if ($val->refund_status == 'Inactive') Refund @endif</td>
                                                <td align="right">{{ $val->doctor_fee }} <?php $total_opd += $val->doctor_fee;?></td>
                                                <td align="right">{{ round($val->doctor_tax_only, 2) }} <?php $total_hst += $val->doctor_tax_only; ?></td>
                                                <td align="right">{{ $val->doctor_fee_with_tax }} <?php $total_grand += $val->doctor_fee_with_tax;?></td>
                                            </tr>
                                        @endforeach

                                        <tr align="right" style="font-weight: bold;">
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>Total:</td>
                                            <td>{{ $total_opd }}</td>
                                            <td>{{ round($total_hst, 2) }}</td>
                                            <td>{{ $total_grand }}</td>
                                        </tr>
                                    @endif

                                    @if (count($ipd) > 0)
                                        <tr align="center">
                                            <td class="header-bg" colspan="8">IPD</td>
                                        </tr>
                                        <tr class="head-cont">
                                            <td>S.No.</td>
                                            <td>Patient</td>
                                            <td>Bill No.</td>
                                            <td>Status</td>
                                            <td>Charge Type</td>
                                            <td style="text-align: right;">Fee</td>
                                            <td style="text-align: right;">HST</td>
                                            <td style="text-align: right;">Grand Total</td>
                                        </tr>
                                        @foreach ($ipd as $key => $val)
                                            <tr>
                                                <td>{{ $sno }} <?php $sno++;?></td>
                                                <td>{{ $val->first_name }}</td>
                                                <td>{{ $val->bill_number }}</td>
                                                <td>@if ($val->refund_status == 'Inactive') Refund @endif</td>
                                                <td>Admission</td>
                                                <td align="right">{{ round($val->admission_charge, 2) }} <?php $total_ipd += $val->admission_charge;?></td>
                                                <td align="right">{{ round($val->admission_charge_hst, 2) }} <?php $total_ipd_hst += $val->admission_charge_hst; ?></td>
                                                <td align="right">{{ round($val->admission_charge_with_tax, 2) }} <?php $total_ipd_grand += $val->admission_charge_with_tax;?></td>
                                            </tr>
                                            @if($val->status == "Discharged")
                                                <tr>
                                                    <td>{{ $sno }} <?php $sno++;?></td>
                                                    <td>{{ $val->first_name }}</td>
                                                    <td>{{ $val->discharge_bill_number }}</td>
                                                    <td>@if ($val->refund_status == 'Inactive') Refund @endif</td>
                                                    <td>Discharge</td>
                                                    <td align="right">{{ round($val->discharge_subtotal, 2) }} <?php $total_ipd += $val->discharge_subtotal;?></td>
                                                    <td align="right">{{ round($val->discharge_hst, 2) }} <?php $total_ipd_hst += $val->discharge_hst; ?></td>
                                                    <td align="right">{{ round($val->discharge_grandtotal, 2) }} <?php $total_ipd_grand += $val->discharge_grandtotal;?></td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        <tr align="right" style="font-weight: bold;">
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>Total:</td>
                                            <td>{{ round($total_opd, 2) }}</td>
                                            <td>{{ round($total_ipd_hst, 2) }}</td>
                                            <td>{{ round($total_ipd_grand, 2) }}</td>
                                        </tr>
                                    @endif

                                    @if (count($emergency) > 0)
                                        <tr align="center">
                                            <td class="header-bg" colspan="8">Emergency</td>
                                        </tr>
                                        <tr class="head-cont">
                                            <td>S.No.</td>
                                            <td>Patient</td>
                                            <td>Bill No.</td>
                                            <td>Status</td>
                                            <td>Charge Type</td>
                                            <td style="text-align: right;">Fee</td>
                                            <td style="text-align: right;">HST</td>
                                            <td style="text-align: right;">Grand Total</td>
                                        </tr>
                                        @foreach ($emergency as $key => $val)
                                            <tr>
                                                <td>{{ $sno }} <?php $sno++;?></td>
                                                <td>{{ $val->first_name }}</td>
                                                <td>{{ $val->bill_number }}</td>
                                                <td>@if ($val->refund_status == 'Inactive') Refund @endif</td>
                                                <td>Admission</td>
                                                <td align="right">{{ round($val->doctor_fee, 2) }} <?php $total_emergency += $val->doctor_fee;?></td>
                                                <td align="right">{{ round($val->doctor_tax_only, 2) }} <?php $total_emergency_hst += $val->doctor_tax_only; ?></td>
                                                <td align="right">{{ round($val->doctor_fee_with_tax, 2) }} <?php $total_emergency_grand += $val->doctor_fee_with_tax;?></td>
                                            </tr>
                                            @if($val->status == 'Discharged')
                                                <tr>
                                                    <td>{{ $sno }} <?php $sno++;?></td>
                                                    <td>{{ $val->first_name }}</td>
                                                    <td>{{ $val->discharge_bill_number }}</td>
                                                    <td>@if ($val->refund_status == 'Inactive') Refund @endif</td>
                                                    <td>Discharge</td>
                                                    <td align="right">{{ round($val->discharge_subtotal, 2) }} <?php $total_emergency += $val->discharge_subtotal;?></td>
                                                    <td align="right">{{ round($val->discharge_tax, 2) }} <?php $total_emergency_hst += $val->discharge_tax; ?></td>
                                                    <td align="right">{{ round($val->discharge_grandtotal, 2) }} <?php $total_emergency_grand += $val->discharge_grandtotal;?></td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        <tr align="right" style="font-weight: bold;">
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>Total:</td>
                                            <td>{{ round($total_emergency, 2) }}</td>
                                            <td>{{ round($total_emergency_hst, 2) }}</td>
                                            <td>{{ round($total_emergency_grand, 2) }}</td>
                                        </tr>
                                    @endif


                                    @if (count($pathology_sub_arr) > 0)
                                        <tr align="center">
                                            <td class="header-bg" colspan="8">Pathology</td>
                                        </tr>
                                        <tr class="head-cont">
                                            <td>S.No.
                                            </th>
                                            <td>Patient
                                            </th>
                                            <td>Bill No.
                                            </th>
                                            <td>Status
                                            </th>
                                            <td width="300">Tests
                                            </th>
                                            <td style="text-align: right;">Fee
                                            </th>
                                            <td style="text-align: right;">HST
                                            </th>
                                            <td style="text-align: right;">Grand Total
                                            </th>
                                        </tr>
                                        @foreach ($pathology_sub_arr as $key => $res)
                                            @foreach ($res as $rkey => $path)
                                                <tr>
                                                    <td>{{ $sno }} <?php $sno++;?></td>
                                                    <td>{{ $path['name'] }}</td>
                                                    <td>{{ $path['bill'] }}</td>
                                                    <td>@if ($path['status'] != 'Active') Refund @endif</td>
                                                    <td>{{ $path['test'] }}</td>
                                                    <td align="right">{{ $path['fee'] }} <?php $total_patho += $path['fee'];?></td>
                                                    <td align="right">{{ $path['hst'] }} <?php $hst_patho += $path['hst'];?></td>
                                                    <td align="right">{{ round($path['grand'], 2) }} <?php $grand_patho += $path['grand'];?></td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                        <tr align="right" style="font-weight: bold;">
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>Total:</td>
                                            <td>{{ $total_patho }}</td>
                                            <td>{{ round($hst_patho, 2) }}</td>
                                            <td>{{ round($grand_patho, 2) }}</td>
                                        </tr>
                                    @endif

                                    @if (count($test_res) > 0)

                                        @foreach ($test_res as $key => $res)
                                            <?php $total = $hst = $grand = 0;?>
                                            <tr align="center">
                                                <td class="header-bg" colspan="8">{{ $key }}</td>
                                            </tr>
                                            <tr class="head-cont">
                                                <td>S.No.
                                                </th>
                                                <td>Patient
                                                </th>
                                                <td>Bill No.
                                                </th>
                                                <td>Status
                                                </th>
                                                <td>Tests
                                                </th>
                                                <td style="text-align: right;">Fee
                                                </th>
                                                <td style="text-align: right;">HST
                                                </th>
                                                <td style="text-align: right;">Grand Total
                                                </th>
                                            </tr>
                                            @foreach ($res as $val)
                                                <tr>
                                                    <td>{{ $sno }} <?php $sno++;?></td>
                                                    <td>{{ $val['name'] }}</td>
                                                    <td>{{ $val['bill'] }}</td>
                                                    <td>@if ($val['status'] != 'Active') Refund @endif</td>
                                                    <td>{{ $val['test'] }}</td>
                                                    <td align="right">{{ $val['fee'] }} <?php $total += $val['fee'];?></td>
                                                    <td align="right">{{ $val['hst'] }} <?php $hst += $val['hst'];?></td>
                                                    <td align="right">{{ round($val['grand'], 2) }} <?php $grand += $val['grand'];?></td>
                                                </tr>
                                            @endforeach
                                            <tr align="right" style="font-weight: bold;">
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td>Total:</td>
                                                <td>{{ $total }}</td>
                                                <td>{{ round($hst, 2) }}</td>
                                                <td>{{ round($grand, 2) }}</td>
                                            </tr>
                                        @endforeach

                                    @endif
                                @endif
                                </tbody>
                            </table>
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
            $('footer').hide();
            window.print();
            $('footer').show();
        }

        $('#excel').click(function () {
            $('.h').removeClass('ninja');
            $('.s').addClass('ninja');
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

