@extends('backendlayout.master')
@extends('backendlayout.header')
@extends('backendlayout.leftmenu')
@extends('backendlayout.footer')
@section('userscontent')
    @extends('backendlayout.flashmessagecollection')

    <style type="text/css">

        .logo-area-text span, .logo-area-text p {
            font-size: 9px;
            line-height: 13px;
            margin: 0;
        }

        .logo-area-text {
            position: static;
            top: auto;
            width: auto;
            left: auto;
            margin-left: auto;
        }

        .tax-invoice {
            font-weight: bold;
            /*padding: 0 20px;*/
        }

        .tax-invoice td {
            padding: 3px 8px;
            font-weight: 600;
        }

        .tax-invoice table .first-row td {
            font-weight: bold;
        }

        /*.tax-invoice .table{
            width: 100%;
            height: auto;
            position: relative;
        }*/
        .total-calculation {
            display: inline-block;
            width: 100%;
        }

        .total-calculation ul li {
            list-style: none;
        }

        /*.total-calculation .result{
            border: 1px solid #000;
            font-weight: bold;
            width: 100%;
            height: auto;
            padding: 0 10px
        }*/
        .pan-no tr td {
            border: 1px solid;
            padding: 0 5px;
        }

        p.in-words {
            margin-top: 10px;
            margin-bottom: 5px;
            display: inline-block;
        }

        .footer-content {
            text-align: center;
            /*position: absolute;
            bottom: 60px;
            width: 300px;
            left: 50%;
            margin-left: -160px;*/
        }

        .certificate_info {
            color: #777;
        }

        .tax-invoice .body p strong {
            font-weight: 600;
        }

        .tax-invoice .body p {
            font-weight: normal;
            font-size: 10px;
            margin: 0;
            margin-top: -5px;
            clear: both;
            line-height: 18px;
        }

        .print-button {
            display: inline-block;
            margin-top: 20px;
            margin-left: 15px;
        }

        /*.print-right strong{
            float: left;
        }*/
        .print-right span {
            border: 1px solid #333;
            padding: 3px;
            float: left;
            line-height: 22px;
            margin-bottom: 10px;
        }

        #bottom_right_table td {
            width: 148px;
            padding: 0px 8px;
            text-align: right;
        }

        #bottom_right_table .semi {
            width: 0px;
            padding: 0;
        }

        .table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
            padding: 3px 8px;
        }

    </style>

    <section class="content-header">
        <h1>
            <a href="{{url('ip-enrollment/patients/create')}}">
                <button type="button" class="btn btn-warning btn-flat  pull-right ">
                    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Back
                </button>
            </a>

        </h1>
    </section>

    <section class="content" style="padding: 0;">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default" id="printCertificate" style="border-color: transparent !important;">


                    <div class="panel-body" style="color: #000; padding: 0;">

                        <div class="tax-invoice">
                            <div class="logo text-center" style="margin-bottom:8px;">

                                <div class="logo-area-text">
                                    <h4 style="font-size: 13px; margin: 0;">Terai Hospital & Research Centre</h4>
                                    <span>Padam Road, Birgunj</span>
                                    <span>Reg No.: 80071/067-68 / PAN No: 601240803</span>
                                    <p>Ph: 051-419252</p>

                                    <span style="font-size: 13px; text-align: center;   ">In Patient Ticket</span>
                                </div>


                            </div>

                            <div class="body" style="margin-top: 0px; ">
                                <div class="print-left" style=" float: left; width: 45%;">

                                    <p>
                                        <strong>Patient Code: </strong> {{$patient->patient_code}}
                                    </p>

                                    <p>
                                        <strong>Name: </strong> {{strtoupper($patient->first_name).'    '. strtoupper($patient->middle_name). ' '. strtoupper($patient->last_name)}}
                                    </p>

                                    <p>
                                        <strong>Doctor: </strong>Dr. {{ucfirst($doctor->first_name).' '.ucfirst($doctor->middle_name).' '.ucfirst($doctor->last_name)}}
                                    </p>

                                    <p>
                                        <strong>Ward/Room/Bed: </strong> {{ $ward.'/ '.$room.'/ '.$bed }}
                                    </p>
                                </div>

                                <div class="print-center" style=" float: left;">
                                    <p><strong>Age/Sex: </strong>{{$patient->age}}
                                        /<strong>{{$patient->gender['0']}}</strong></p>

                                    <p><strong>Phone: </strong> {{$patient->phone}} </p>
                                <!-- <p>
                                        <strong>Address: </strong> {{$patient->permanent_address}}
                                        </p> -->

                                    <p>
                                        <strong>Admission Charge: &nbsp;</strong> Rs. {{ $patient->admission_charge }}
                                    </p>

                                    <p>
                                        <strong>HST @ 5%: &nbsp;</strong> Rs. {{ $patient->admission_charge_hst }}
                                    </p>

                                    <p class="hcopy">@if ($stat == '1') <b>Hospital Copy</b> @endif</p>
                                </div>

                                <div class="print-right" style="float: right;">

                                    {{--<p>
                                        <strong>Invoice No: </strong> {{ $patient->getCurrentFiscalYear->fiscal_year_start_date }}-{{$patient->id}}
                                    </p>--}}

                                    <p>
                                        <strong>Bill No: </strong> {{ $patient->bill_number }}
                                    </p>

                                    <p>
                                        <strong>Admitted On: &nbsp;</strong>
                                        <?php
                                        $todayDate = date('Y-m-d', strtotime($patient->created_at));
                                        $localDate = str_replace("-", ",", $todayDate);
                                        $classes = explode(",", $localDate);
                                        $a = $classes[0];
                                        $b = $classes[1];
                                        $c = $classes[2];
                                        echo eng_to_nep($a, $b, $c);
                                        // echo  '&nbsp';
                                        // echo date('h:i A',strtotime($patient->created_at));
                                        ?>
                                    </p>

                                    <p>
                                        <strong>Deposit: &nbsp;</strong> Rs. {{ $patient->deposit_amount }}.00
                                    </p>

                                    <p>
                                        <strong>Grand Total: &nbsp;</strong>
                                        Rs. {{ $patient->admission_charge_with_tax + $patient->deposit_amount }}
                                    </p>


                                </div>
                            <!--
                                <div class="table"
                                     style="float: none; clear: both; margin-top: 7px; display: inline-block; ">
                                    <div class="table-body">
                                        <table border="1" style="width: 100%">

                                            <tr class="first-row">
                                                <th>S.N</th>
                                                <th>Description</th>
                                                <th>Unit Price(In Rs)</th>
                                                <th>Quantity</th>
                                                <th>Line Total</th>
                                            </tr>

                                            <tr>
                                                <td>1.</td>
                                                <td>Room Charge
                                                <td style="text-align: right">{{ $roomCharge }}</td>
                                                <td style="text-align: right">1 Day</td>
                                                <td style="text-align: right">{{ $roomCharge }}</td>
                                            </tr>

                                            <tr>
                                                <td>2.</td>
                                                <td>Doctor Charge
                                                <td style="text-align: right">{{ $doctorCharge }}</td>
                                                <td style="text-align: right">1 Day</td>
                                                <td style="text-align: right">{{ $doctorCharge }}</td>
                                            </tr>

                                        </table>

                                    </div>
                                </div> -->

                            <!--  <div class="print-bottom total-calculation">
                                    <div class="print-bottom-left" style="float: left; width: 50%;">
                                        <div class="applicant" style="margin-top: 25px;">
                                            <p>{{ strtoupper($patient->belongsToUser->fullname) }}</p><strong
                                                    style="border-top:1px solid #444;">RECEIVED BY</strong>
                                        </div>
                                    </div>
                                    <div class="print-bottom-right" style="float: right;">
                                        <table id="bottom_right_table" style="width: 100%;     margin-top: -15px;">


                                            <div class="test-invoice-total pull-right" style="margin-right:18px;">
                                                <p>Sub Total: <strong>&nbsp; Rs. {{ $subTotal }} </strong></p>

                                                <p>HST@ 5% : <strong>Rs.{{ round($hst, 2) }} </strong></p>

                                                <p>G. Total: <strong>&nbsp; Rs. {{round($total)}} </strong></p>
                                            </div>
                                        </table>
                                    </div>

                                    {{--hidden fields--}}{{--
                                    <td class="discount-amount" hidden="hidden"></td>
                                    <input type="text" class="patient-id" id="ipatient_id" value="{{ $patient->id }}"
                                           hidden>
                                    <input type="text" class="total-after-tax" name="total-after-tax"
                                           value="{{ $subTotal }}" hidden>--}}

                                    </div> -->
                                <div class="print-bottom total-calculation">
                                    <p class="in-words">In
                                        Words:<strong> {{convert_number_to_words(round($patient->admission_charge_with_tax, 2))}}
                                            Only</strong></p>

                                    <div class="print-bottom-left" style="float: left; width: 37%;">
                                        <div class="applicant" style="margin-top: 15px;">
                                            <p>{{strtoupper($patient->belongsToUser->fullname)}}</p><strong
                                                    style="border-top:1px solid #444; font-size: 11px;">RECEIVED
                                                BY</strong>
                                        </div>
                                        <p><strong>{{getTodayNepaliDate()}} {{ \Carbon\Carbon::now()->toTimeString() }}</strong></p>
                                    </div>


                                </div>

                                <div class="footer-content print-button-spot">
                                    <button class="btn btn-primary" onclick="printContent('printCertificate')">
                                        Print IPD Ticket
                                    </button>
                                </div>

                                <br>

                                <div class="footer-content">
                                    <p>Get Well Soon. Thank You.</p>
                                </div>

                            </div>
                        </div>

                    </div>


                </div>
            </div>

        </div>
        <br>
        <input class="stat" type="hidden" value="{{ $stat }}" />
        <input class="ids" type="hidden" value="{{ $id }}" />
    </section>

    <script>
        window.onload = function () {
            $('.print-button-spot, .main-footer, .title, .alert').hide();
            var stat = $('.stat').val();
            var ids = $('.ids').val();

            if (stat == '0') {
                window.print();
                var pr_ag = '/ip-enrollment/ipatient/' + ids + '/print-admit-invoice/' + 1;
                var url_pr = "{{ url('/') }}" + pr_ag;
                window.location.assign(url_pr);
            } else {
                //$('.hcopy').text('Hospital Copy');
                window.print();
                //$('.hcopy').text('');
               window.location.assign('{{URL::to('ip-enrollment/patients/create')}}');
            }
        }

        function printContent(el) {
            $('.print-button-spot, .main-footer, .alert').hide();
            window.print();
            window.print();
        }
    </script>
@endsection