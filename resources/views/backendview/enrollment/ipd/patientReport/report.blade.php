@extends('backendlayout.master')
@extends('backendlayout.header')
@extends('backendlayout.leftmenu')
@extends('backendlayout.footer')
@section('userscontent')
    @extends('backendlayout.flashmessagecollection')

    <section class="content" style="padding: 0;">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default" id="printCertificate" style="border-color: transparent !important;">

                    <style type="text/css">

                        .tax-invoice{
                            font-weight: bold;
                            /*padding: 0 20px;*/
                        }
                        .tax-invoice td{
                            padding: 3px 8px;
                        }
                        .tax-invoice table .first-row td{
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
                        .total-calculation ul li{
                            list-style: none;
                        }
                        /*.total-calculation .result{
                            border: 1px solid #000;
                            font-weight: bold;
                            width: 100%;
                            height: auto;
                            padding: 0 10px
                        }*/
                        .pan-no tr td{
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

                    </style>


                    <div class="panel-body" style="color: #000; line-height: 28px;"   >
                        <style>
                            .certificate_info{
                                color: #777;
                            }
                            .tax-invoice .body p{
                                font-weight: normal;
                                font-size: 16px;
                            }

                            .print-button {
                                display: inline-block;
                                margin-top: 20px;
                                margin-left: 15px;
                            }
                            .print-right strong{
                                float: left;
                            }
                            .print-right span {
                                border: 1px solid #333;
                                padding: 3px;
                                float: left;
                                line-height: 22px;
                                margin-bottom: 10px;
                            }
                        </style>
                        <div class="tax-invoice" >
                            <div class="logo text-center">
                                <div class="logo-bg">
                                    <img class="text-center" src="{{URL::asset('custom-images/logo-dim.png')}}" class="thumbnail"
                                         alt="User profile picture">
                                </div>
                                <div class="logo-area-text">
                                    <h2>TAX INVOICE</h2>
                                    <h4>Terai Hospital & Research Centre</h4>
                                    <span>Padam Road, Birgunj</span>
                                    <span>Reg No.1234 / PAN No: 601240803</span>
                                    <p>Ph: 01-478564</p>
                                </div>

                            </div>
                            <div class="body" style="margin-top: 30px; ">
                                <div class="print-left" style=" float: left; width: 45%;">

                                    <p><strong>Patient Code:</strong> {{$report->report_number}}</p>
                                    <p><strong>Patient Code:</strong> {{$report->ipatient_code}}</p>
                                    <p><strong>Name:</strong> {{$report->isOfPatient->first_name.'    '. $report->isOfPatient->middle_name. ' '. $report->isOfPatient->last_name}}</p>
                                    <p><strong>Doctor: </strong>{{$report->isOfDoctor->first_name.' '. $report->isOfDoctor->middle_name.' '. $report->isOfDoctor->last_name}}</p>
                                </div>

                                <div class="print-center" style=" float: left;">
                                    {{--<p><strong>Age: </strong>{{$patient->age}}</p>--}}
                                    {{--<p><strong>Gender: </strong>{{$patient->gender}}</p>--}}
                                    {{--<p><strong>Phone: </strong>   {{$patient->phone}} </p>--}}
                                </div>

                                <div class="print-right" style=" float: right;">

{{--                                    <p><strong>Invoice No: </strong> {{$report->getCurrentFiscalYear->fiscal_year_start_date}} -{{$report->id}}</p>--}}

                                    <p><strong>Date: </strong> <?php  $mytime = Carbon\Carbon::now();
                                        echo $mytime->toDateString();
                                        ?></p>

                                </div>

                                {{--<div class="table" style="float: none; clear: both; margin-top: 20px; display: inline-block; ">--}}
                                    {{--<div class="table-body">--}}
                                        {{--<table  border="1" style="width: 100%">--}}

                                            {{--<tr class="first-row">--}}
                                                {{--<td>S.N</td>--}}
                                                {{--<td>Description</td>--}}
                                                {{--<td>Unit Price(In Rs)</td>--}}
                                                {{--<td>Line Total</td>--}}
                                            {{--</tr>--}}
                                            {{--<tr>--}}
                                                {{--<td>1.</td>--}}
                                                {{--<td>Consulting Fees of {{ucfirst($patient->isInDepartment->name)}}--}}


                                                    {{--with {{ucfirst($patient->isConsultedToDoctor->first_name).' '. ucfirst($patient->isConsultedToDoctor->middle_name).' '. ucfirst($patient->isConsultedToDoctor->last_name)}}</td>--}}
                                                {{--<td>{{$patient->doctor_fee}}</td>--}}
                                                {{--<td>{{$patient->doctor_fee}}</td>--}}
                                            {{--</tr>--}}

                                        {{--</table>--}}
                                        {{--<p class="in-words"><strong>In Words:</strong> {{convert_number_to_words(round($patient->doctor_fee_with_tax,2))}}</p>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                <div class="print-bottom total-calculation">
                                    {{--<div class="print-bottom-left" style="float: left; width: 50%;">--}}
                                        {{--<div class="applicant" style="margin-top: 25px;">--}}
                                            {{--<p >{{strtoupper($patient->belongsToUser->fullname)}}</p><strong style="border-top:1px solid #444;">RECEIVED BY</strong>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                    {{--<div class="print-bottom-right" style="float: right; margin-top: -30px;">--}}
                                        {{--<table  border="1" style="width: 100%">--}}

                                            {{--<tr>--}}
                                                {{--<td style="padding: 3px 25px;">Sub Total</td>--}}
                                                {{--<td class="result" style="padding: 3px 25px;">--}}

                                                    {{--Rs.  {{$patient->doctor_fee}}--}}
                                                {{--</td>--}}
                                            {{--</tr>--}}
                                            {{--<tr>--}}
                                                {{--<td style="padding: 3px 25px;">Discount {{$patient->discount_percent}} %</td>--}}
                                                {{--<td class="result" style="padding: 3px 25px;"> Rs. {{round($patient->discounted_fee_value,2)}}  </td>--}}
                                            {{--</tr>--}}
                                            {{--<tr>--}}
                                                {{--<td style="padding: 3px 25px;">HST 5%</td>--}}
                                                {{--<td class="result" style="padding: 3px 25px;">Rs. {{ round($patient->doctor_tax_only,2) }}</td>--}}
                                            {{--</tr>--}}
                                            {{--<tr>--}}
                                                {{--<td style="padding: 3px 25px;">Total</td>--}}
                                                {{--<td class="result" style="padding: 3px 25px;">--}}
                                                    {{--Rs. {{round($patient->doctor_fee_with_tax,2)}}--}}

                                                {{--</td>--}}


                                        {{--</table>--}}

                                    {{--</div>--}}


                                </div>
                                <div class="row">
                                    <p><strong>Report:</strong> {{$report->doctor_report}}</p>
                                </div>

                                <div class="footer-content">
                                    <p>Get Well Soon. Thank You.</p>
                                </div>

                            </div>
                        </div>

                    </div>



                </div>
            </div>
            <!--  <div class="print-button">
                 <button class="btn btn-primary" onclick="printContent('printCertificate')">Print Patient Invoice
                 </button>
             </div> -->
        </div>
        <br>

    </section>

    <script>
        window.onload = function() {
            $('.print-button-spot, .main-footer, .title').hide();
            printContent('printCertificate');



//            function printContent(el) {
//                var restorepage = document.body.innerHTML;
//                var printcontent = document.getElementById(el).innerHTML;
//                document.body.innerHTML = printcontent;
//                $('.print-button-spot, .main-footer, .title').show();
//                window.print();
//
//                document.body.innerHTML = restorepage;
//            }
        }
    </script>
@endsection