@extends('backendlayout.master')
@extends('backendlayout.header')
@extends('backendlayout.leftmenu')
@extends('backendlayout.footer')
@section('userscontent')
    @extends('backendlayout.flashmessagecollection')
    <style>
        .certificate_info {
            color: #777;
        }

        #printCertificate {
            width: 500px;
            margin-bottom: 20px;
            display: inline-block;
            background: #fff;
            padding: 20px;
        }

        .print-left {
            float: left;
            width: 50%;
            margin-right: 6px;
        }

        .print-left p, .print-right p {
            font-weight: normal;
            font-size: 13px;
            margin: 0 0 5px;
        }

        .print-right {
            /*float: right;*/
            width: 35%;
        }
    </style>
    <section class="content-header">
        <h1>
            <a href="{{url('configuration/patient/create')}}">
                <button type="button" class="btn btn-warning btn-flat  pull-right ">
                    <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span> Back
                </button>
            </a>

            <a href="{{ URL::to('configuration/patient/' . $patient->id . '/print-invoice') }}"
               title="Print Patient Invoice" data-rel="tooltip">
                <button type="button" class="btn btn-primary btn-flat pull-right ">
                    <span class="glyphicon glyphicon-print" aria-hidden="true"></span>
                    Invoice
                </button>
            </a>
        </h1>
    </section>

    <section class="content">

        <div class="tax-invoice print-invoice">

            <div class="body" id="printCertificate" style="width: 400px; ">
                <div class="print-left" style=" float: left; width: 90%; margin-left: 25px; margin-top: 15px;">
                    <p>Department:{{strtoupper($patient->isInDepartment->name)}}</p>
                    <p>Patient Id: <strong>{{$patient->patient_code}}</strong></p>
                    <p>Name:
                        <strong>{{strtoupper($patient->first_name).'    '. strtoupper($patient->middle_name). ' '. strtoupper($patient->last_name)}}</strong>
                    </p>
                    <p>Age/Sex: <strong>{{$patient->age}} Yrs&nbsp;

                            {{substr($patient->gender, 0, 1)}}</strong></p>
                    <p>Address: {{ucfirst($patient->address)}}</p>

                    <p>
                        Doctor:{{ucfirst($patient->isConsultedToDoctor->first_name).' '. ucfirst($patient->isConsultedToDoctor->middle_name).' '. ucfirst($patient->isConsultedToDoctor->last_name)}}</p>
                    <p>Date/Time:<?php  $mytime = Carbon\Carbon::now();
                        echo $mytime->toDateString();
                        ?>&nbsp;&nbsp; User Name: {{strtoupper($patient->belongsToUser->email)}}</p>
                </div>

            </div>

            <div class="print-button">
                <button class="btn btn-primary" onclick="printContent('printCertificate')">Print Patient Sticker
                </button>
            </div>
        </div>
        </div>

        </div>

    </section>
    <style type="text/css">
        .tax-invoice {
            font-weight: bold;
            padding: 0 20px;
        }

        .tax-invoice td {
            padding: 15px;
        }

        .tax-invoice table .first-row td {
            font-weight: bold;
        }

        .total-calculation {
            margin-top: 15px;
        }

        .total-calculation ul li {
            list-style: none;
        }

        .total-calculation .result {
            border: 1px solid #000;
            font-weight: bold;
            width: 100%;
            height: auto;
            padding: 0 10px
        }
    </style>
    <script>
        //      window.onload = function() {

        //         printContent('printCertificate');
        // $('.print-button-spot, .main-footer, .title').hide();

        //                 }
        function printContent(el) {
            var restorepage = document.body.innerHTML;
            var printcontent = document.getElementById(el).innerHTML;
            document.body.innerHTML = printcontent;
            window.print();
            document.body.innerHTML = restorepage;
        }
    </script>
@endsection