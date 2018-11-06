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
            <a href="{{url('configuration/print-test-invoice')}}">
                <button type="button" class="btn btn-warning btn-flat pull-right ">
                    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Back
                </button>
            </a>

        </h1>
    </section>

    <section class="content" style="padding: 0;">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default" id="printCertificate"
                     style="border-color: transparent !important; margin-top: -50px;">


                    <div class="panel-body" style="color: #000; padding: 0;">

                        <div class="tax-invoice">
                            <div class="logo text-center" style="margin-bottom:8px;">

                                <div class="logo-area-text">
                                    <h4 style="font-size: 11px; margin: 0;">Terai Hospital & Research Centre Pvt.
                                        Ltd.</h4>
                                    <span>Padam Road, Birgunj</span>
                                    <span>Reg No.: 80071/067-68 / PAN No: 601240803</span>
                                    <p>Ph: 051-419252</p>

                                    <span style="font-size: 11px; text-align: center;   ">Pathology/Test<span
                                                class="copy"></span>Hospital Copy</span>
                                </div>


                            </div>

                            <div class="body" style="margin-top: 0px; ">
                                <div class="print-left" style=" float: left; width: 60%; margin-right: 5px;">

                                    <p>Patient Code:<strong> {{$patient->patient_code}}</strong></p>

                                    <p>Name:<strong> {{strtoupper($patient->first_name)}} &nbsp;
                                            {{strtoupper($patient->middle_name)}}&nbsp;
                                            {{strtoupper($patient->last_name)}}</strong></p>

                                    <p>Referral Doctor:
                                        <strong>Dr. {{ucfirst($doctor->first_name).' '.ucfirst($doctor->middle_name).' '.ucfirst($doctor->last_name)}}</strong>
                                    </p>

                                    @if(isset($con_doctor))
                                        <p>Consulting Doctor:
                                            <strong>Dr. {{ucfirst($con_doctor->first_name).' '.ucfirst($con_doctor->middle_name).' '.ucfirst($con_doctor->last_name)}}</strong>
                                        </p>
                                    @endif

                                </div>


                                <div class="print-right" style="float: right;">

                                    <p>Date:<strong> @include('backendview.billing.opd.nepali_calendar')</strong></p>

                                    <p>Bill No:<strong> {{$billingDetail->bill_number}}</strong></p>

                                    <p>Phone:<strong> {{ $patient->phone }}</strong></p>

                                    <p>Age/Sex: <strong>{{$patient->age}}/{{$patient->gender['0']}}</strong></p>

                                </div>


                                <table class="table table-striped" style="font-size: 10px;">
                                    <thead>
                                    <tr>
                                        <th>S.N.</th>
                                        <th>Description</th>
                                        <th>Amount in Rs.</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($testDetails as $key => $testDetail)
                                        <tr>
                                            <td>
                                                {{ $key+1 }}
                                            </td>

                                            <td>
                                                <?php
                                                $test = DB::table('categories')
                                                    ->where('id', $testDetail->test_id)
                                                    ->first();
                                                echo $test->title;
                                                ?>
                                            </td>

                                            <td>
                                                <?php
                                                $test = DB::table('categories')
                                                    ->where('id', $testDetail->test_id)
                                                    ->first();
                                                echo $test->price;
                                                ?>
                                            </td>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>

                                <div class="test-invoice-total pull-right" style="margin-right:18px;">
                                    <p>Sub Total: <strong>&nbsp; Rs. {{ round($billingDetail->sub_total + $billingDetail->discount, 2) }} </strong></p>

                                    <p>Discount : <strong>
                                            @if($billingDetail->discount == 0)

                                            @else

                                                Rs. {{ round($billingDetail->discount, 2) }}
                                            @endif
                                        </strong></p>

                                    {{--@if($billingDetail->discount == 0)
                                        <p>Total: <strong>
                                                Rs. {{ $testCharge }} </strong></p>
                                    @else
                                        <p>Total: <strong>&nbsp;
                                                Rs. {{ $testCharge - $billingDetail->discount }} </strong></p>
                                    @endif--}}

                                    <p>Total: <strong>
                                            Rs. {{ round($billingDetail->sub_total, 2) }} </strong></p>

                                    <p>HST@ 5% : <strong>Rs.{{ round($hst, 2) }} </strong></p>


                                    <p>G. Total: <strong>&nbsp; Rs. {{ round($total, 2) }} </strong>
                                    </p>
                                </div>


                                <div class="print-bottom total-calculation">
                                    <p class="in-words">In
                                        Words:<strong> {{convert_number_to_words($total)}}
                                            Only</strong></p>

                                    <div class="print-bottom-left" style="float: left; width: 37%;">
                                        <div class="applicant" style="margin-top: 15px;">
                                            <p>{{strtoupper($user->fullname)}}</p><strong
                                                    style="border-top:1px solid #444; font-size: 11px;">RECEIVED
                                                BY</strong>
                                        </div>
                                        <p><strong>{{getTodayNepaliDate()}} <br> {{ \Carbon\Carbon::now()->toTimeString() }}</strong></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <input name="print_type" class="print_type" type="hidden" value="{{ $data }}">

        <div class="back-button">
            {{--<a href="{{url('configuration/print-test-invoice')}}">
                <button type="button" class="btn btn-warning btn-flat pull-right ">
                    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Back
                </button>
            </a>--}}
        </div>
        <br>

    </section>

    <script>
        window.onload = function () {
            $('.print-button-spot, .main-footer, .title, .back-button, .footer-section').hide();

            window.print();
            window.location.assign('{{URL::to('/configuration/print-test-invoice')}}');
        }
    </script>
@endsection