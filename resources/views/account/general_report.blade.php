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

                        <form name="pathology-report" method="post" action="{{ url('/operate-general-report') }}">
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
                                        @foreach ($category as $cate)
                                            <option value="{{ $cate->id }}"
                                                    @if ($cate->id == $cat) selected @endif>{{ $cate->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-1"><input name="submit" id="submit" type="submit" value="View"
                                                         class="btn btn-info"/></div>
                        </form>
                        <div class="clearfix"></div>
                        <br>

                        @if (isset($report))
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
                                <?php $total_fee = $total_tax = $total_grand = 0; ?>
                                @foreach ($report as $key => $rep)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $rep->date_nep }}</td>
                                        <td>{{ $rep->first_name }} {{{ $rep->middle_name or '' }}} {{ $rep->last_name }}</td>
                                        <td>{{ $rep->patient_name }}</td>
                                        <td>{{ $rep->bill_number }}</td>
                                        <td>{{ $rep->test_list }}</td>
                                        <td style="text-align: right">{{ $rep->total_fee }} <?php $total_fee += $rep->total_fee; $tax = number_format(0.05 * $rep->total_fee, 2);?></td>
                                        <td style="text-align: right">{{ $tax }} <?php $total_tax += $tax; $grand = $rep->total_fee + $tax;?></td>
                                        <td align="right">{{ $grand }} <?php $total_grand += $grand;?></td>
                                    </tr>
                                @endforeach
                                <tr align="right" style="font-weight: bold;">
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>Total:</td>
                                    <td>{{ $total_fee }}</td>
                                    <td>{{ $total_tax }}</td>
                                    <td>{{ $total_grand }}</td>
                                </tr>
                                </tbody>
                            </table>
                            <br><br>
                        @else
                            <h4>From and To date should be either before "2074-07-21" or after it.</h4>
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