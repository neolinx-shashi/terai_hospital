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

                        <form method="post" action="{{ url('/generate-ipd-deposit-report') }}" onsubmit="return confirmCode()">
                            {{ csrf_field() }}
                            <div class="col-md-5"></div>
                            <div class="form-group col-md-2" style="text-align: right;"><label>Patient Code:</label></div>
                            <div class="form-group col-md-3">
                                <input class="form-control" name="patient_code" id="patient-code" placeholder="Eg: TH-0000" value="{{{ $code or '' }}}" />
                            </div>
                            <div class="form-group col-md-2">
                                <input class="btn btn-info" type="submit" name="submit" value="Search" />
                            </div>
                        </form>
                        <div class="clearfix"></div>
                        <br>

                        @if (isset($detail) && count($detail) > 0)
                            <h4>Deposit Detail Report</h4>
                            <strong>Name: </strong>{{ $detail[0]->first_name }}<br>
                            <strong>Status: </strong>{{ $detail[0]->status }} @if ($detail[0]->status == 'Discharged') on {{ $detail[0]->discharged_at }} by {{ $detail[0]->fullname }} @endif<br>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Dates</th>
                                        <th>Deposit (Rs)</th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                    <?php $sum = 0;?>
                                    @foreach ($detail as $val)
                                        @for ($i = 0; $i < count($val->deposit_amount); $i++)
                                        <tr>
                                            <td>{{ $val->deposit_dates[$i] }}</td>
                                            <td>{{ $val->deposit_amount[$i] }} <?php $sum += $val->deposit_amount[$i];?></td>
                                            
                                        </tr>
                                        @endfor
                                    @endforeach
                                </tbody>

                                <tfoot>
                                    <tr style="font-weight: bold;">
                                        <td align="right">Total: </td>
                                        <td>{{ $sum }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        @else
                            <h4>Deposit Detail Report</h4>
                            <strong>No User Found.</strong>
                        @endif                        
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