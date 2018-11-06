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

                        <form method="post" action="{{ url('/operate-date-discharge-report') }}">
                            {{ csrf_field() }}
                            <div class="col-md-5"></div>
                            <div class="form-group col-md-2" style="text-align: right;"><label>Date:</label></div>
                            <div class="form-group col-md-3">
                                <input name="datefrom" id="datefrom" type="text" class="form-control" value="{{{ $date or getTodayNepaliDate()}}}"/>
                            </div>
                            <div class="form-group col-md-2">
                                <input class="btn btn-info" type="submit" name="submit" value="Search" />
                            </div>
                        </form>
                        <div class="clearfix"></div>
                        <br>

                        @if (isset($detail) && count($detail) > 0)
                            <h4>Discharge Detail Report of {{ $date }}</h4>
                            <button class="btn btn-info pull-right print-report" id="print-report"><span
                                            class="glyphicon glyphicon-print"></span> Print
                                </button>
                                <button id="excel" class="btn btn-info pull-right" style="margin-right: 10px;"><span
                                            class="glyphicon glyphicon-save"></span> Export to Excel
                                </button>
                                <div class="clearfix"></div><br>
                            
                            <table class="table table-striped" id="discharge-report">
                                <thead>
                                    <tr>
                                        <th>S.No.</th>
                                        <th>Name</th>
                                        <th>Patient Code</th>
                                        <th>Deposit (Rs)</th>
                                        <th>Admission Charge (Rs)</th>
                                        <th>Total After Discharge</th>
                                        <th>Received (Rs)</th>
                                        <th>Returned (Rs)</th>
                                        <th>Discharged By</th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                    <?php $dep_sum = $admission_sum = $total_sum = $received_sum = $returned_sum = 0;?>
                                    @foreach ($detail as $key => $val)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $val->first_name }}</td>
                                            <td>{{ $val->patient_code }}</td>
                                            <td>{{ $val->total_deposit }} <?php $dep_sum += $val->total_deposit;?></td>
                                            <td>{{ $val->admission_charge_with_tax }} <?php $admission_sum += $val->admission_charge_with_tax;?></td>
                                            <td>{{ $val->total_after_tax }} <?php $total_sum += $val->total_after_tax;?></td>
                                            <td>{{ $val->received_amount or 0 }} <?php $received_sum += $val->received_amount;?></td>
                                            <td>{{{ $val->returned_amount or 0 }}} <?php $returned_sum += $val->returned_amount;?></td>
                                            <td>{{ $val->fullname }}</td>
                                        </tr>
                                    @endforeach

                                    <tr style="font-weight: bold;">
                                        <td></td>
                                        <td></td>
                                        <td align="right">Total: </td>
                                        <td>{{ $dep_sum }}</td>
                                        <td>{{ $admission_sum }}</td>
                                        <td>{{ $total_sum }}</td>
                                        <td>{{ $received_sum }}</td>
                                        <td>{{ $returned_sum }}</td>
                                        <td></td>
                                    </tr>
                                </tbody>

                            </table>
                        @else
                            <h4>Discharge Detail Report</h4>
                            <strong>No User Found.</strong>
                        @endif   
                        <br><br>                    
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="{{ url('js/jquery-3.2.1.min.js') }}"></script>
    <!--<script src="{{URL::asset('backendtheme/plugins/jQuery/jQuery-2.1.4.min.js')}}"></script>-->
    <script>
        function confirmCode() {
            var code = $('#patient-code').val();
            if (code === '') {
                alert("Enter Patient Code.");
                $('#patient-code').select();
                return false;
            }
        }

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
                $('#discharge-report').tableExport({type: 'excel', escape: 'false'});
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