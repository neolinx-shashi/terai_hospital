@extends('backendlayout.master')
@extends('backendlayout.header')
@extends('backendlayout.leftmenu')
@extends('backendlayout.footer')
@section('userscontent')
    @extends('backendlayout.flashmessagecollection')

    <style type="text/css">

        .logo-area-text span, .logo-area-text p {
            font-size: 10px;
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
            font-size: 11px;
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

    </style>



    <section class="content" style="padding: 0;">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default" id="printCertificate" style="border-color: transparent !important;">


                    <div class="panel-body" style="color: #000; padding: 0;">

                        <div class="tax-invoice">
                            <div class="logo text-center" style="margin-bottom:8px;">

                                <div class="logo-area-text">
                                    <h4 style="font-size: 13px; margin: 0;">Terai Hospital & Research Centre
                                        Pvt.Ltd</h4>
                                    <span>Padam Road, Birgunj</span>
                                    <span>Reg No.80071/067-68 / PAN No: 601240803</span>
                                    <p>Ph: 051-419252</p>

                                    <span style="font-size: 13px; text-align: center;   ">Out Patient Ticket <span
                                                class="copy"></span></span>
                                </div>
                            </div>

                            <div class="body" style="margin-top: 0px; ">
                                <div class="print-left" style=" float: left; width: 60%; margin-right: 5px;">

                                    <p>Patient Code:<strong> {{$patient->patient_code}}</strong></p>
                                    <p>Name:<strong> {{strtoupper($patient->first_name)}}
                                            {{strtoupper($patient->middle_name)}}
                                            {{strtoupper($patient->last_name)}}</strong></p>
                                    <p>Age/Sex: <strong>{{$patient->age}}/{{$patient->gender['0']}}</strong></p>
                                    <p>Discount : <strong>
                                            @if($patient->discount_percent==NULL)

                                            @else

                                                {{$patient->discount_percent}}
                                                %
                                            @endif
                                        </strong></p>
                                    <p style="display:none">HST@ 5% : <strong>Rs.{{round($patient->doctor_tax_only,2)}} </strong></p>

                                </div>


                                <div class="print-right" style="float: right;">


                                    <p>Date:<strong>{{getTodayNepaliDate()}} {{ \Carbon\Carbon::now()->toTimeString() }}</strong></p>

                                    <p>Bill No:<strong> {{$patient->bill_number}}</strong></p>
                                    <p>Charge: <strong>&nbsp; Rs. {{$patient->doctor_fee}}</strong></p>
                                    <p>Total: <strong>&nbsp;
                                            Rs. {{$patient->doctor_fee-$patient->discounted_fee_value}}</strong></p>
                                    <p>G. Total: <strong>&nbsp; Rs. {{round($patient->doctor_fee_with_tax,2)}} </strong>
                                    </p>

                                </div>


                                <div class="print-bottom total-calculation">
                                    <p class="in-words">In
                                        Words:<strong> {{convert_number_to_words(round($patient->doctor_fee_with_tax,2))}}
                                            Only</strong></p>

                                    <p>Doctor:
                                        <strong>Dr. {{strtoupper($patient->isConsultedToDoctor->first_name).' '. strtoupper($patient->isConsultedToDoctor->middle_name).' '. strtoupper($patient->isConsultedToDoctor->last_name)}}</strong>
                                    </p>
                                    <p>Department: <strong>{{ucfirst($patient->isInDepartment->name)}}</strong></p>

                                    <div class="print-bottom-left" style="float: left; width: 37%;">
                                        <div class="applicant" style="margin-top: 15px;">
                                            <p>{{strtoupper($patient->belongsToUser->fullname)}}</p><strong
                                                    style="border-top:1px solid #444; font-size: 11px;">RECEIVED
                                                BY</strong>
                                        </div>
                                        <p><strong>
                                                <?php
                                                $todayDate = date('Y-m-d', strtotime($patient->created_at));
                                                $localDate = str_replace("-", ",", $todayDate);
                                                $classes = explode(",", $localDate);
                                                $a = $classes[0];
                                                $b = $classes[1];
                                                $c = $classes[2];
                                                echo eng_to_nep($a, $b, $c);
                                                echo '&nbsp';
                                                echo date('h:i A', strtotime($patient->created_at));
                                                ?>
                                                 </strong></p>
                                    </div>
                                    <div class="text-center" style="clear: both;">"Get Well Soon."</div>
                                </div>

                            </div>
                        </div>

                    </div>


                </div>
            </div>

        </div>
        <br>

    </section>

    <section class="content-header">
        <button class="btn btn-info" onclick="printPage(this)" copy="{{ $copy }}"><span
                    class="glyphicon glyphicon-print" aria-hidden="true"> Print </span></button>
        <h1>
            <a href="{{url('configuration/patient/create')}}">
                <button type="button" class="btn btn-warning btn-flat  pull-right ">
                    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Back
                </button>
            </a>

        </h1>

        <input name="patient_id" class="patient_id" type="hidden" value="{{ $patient->id }}">
        <input name="print_type" class="print_type" type="hidden" value="{{ $copy }}">
    </section>

    <script>
        function printPage(ctrl) {
            $('.print-button-spot, .main-footer, .title').hide();
            var copy = $(ctrl).attr('copy');
            if (copy == 'pat') {
                window.print();
                $(ctrl).attr('copy', 'hos');
            } else if (copy == 'hos') {
                $('.copy').text('Hospital Copy');
                window.print();
            } else if (copy == 'rep') {
                $('.copy').text('Copy Of Original');
                window.print();
            }
        }

        window.onload = function () {
            $('.print-button-spot, .main-footer, .title').hide();

            var copy = $('.print_type').val();

            if (copy == 'pat') {
                window.print();
                var pid = $('.patient_id').val();
                //var copy = "hos";
                //window.location = '/test-invoice/';
                window.location = '/configuration/patient/' + pid + '/print-invoice-hos/';
            } /*else if (copy == 'hos') {
                $('.copy').text('Hospital Copy');
                window.print();
            }*/ else if (copy == 'rep') {
                $('.copy').text('Reprint');
                window.print();
            }

            /*if (copy == 'hos') {
                $('.copy').text('Hospital Copy');
            } else {
                $('.copy').text('');
            }

            window.print();
            var pid = $('.patient_id').val();
            var copy = "hos";
            //window.location = '/test-invoice/';
            window.location = '/configuration/patient/' + pid + '/print-invoice/' + copy;*/

            /*//printContent('printCertificate');

            function printContent(el) {
                var restorepage = document.body.innerHTML;
                var printcontent = document.getElementById(el).innerHTML;
                document.body.innerHTML = printcontent;
                $('.print-button-spot, .main-footer, .title').show();
                window.print();
                window.location = '/test-invoice/';
                //document.body.innerHTML = restorepage;


            }*/
        }

    </script>
@endsection