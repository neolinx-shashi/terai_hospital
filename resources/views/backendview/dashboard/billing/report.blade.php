@extends('backendlayout.master')
@extends('backendlayout.header')
@extends('backendlayout.leftmenu')
@extends('backendlayout.footer')
@section('userscontent')
    <style type="text/css">

        .tax-invoice {
            font-weight: bold;
            padding: 0 20px;
        }

        .tax-invoice td {
            padding: 3px 25px;
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

        .spacer {
            height: 10px;
        }

    </style>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">


                    <div class="panel-body" style="color: #000; line-height: 15px;" id="printCertificate">
                        <style>
                            .certificate_info {
                                color: #777;
                            }

                            .tax-invoice .body p {
                                font-weight: normal;
                                font-size: 12px;
                            }
                        </style>
                        <div class="tax-invoice">
                            <div class="logo text-center"
                                 style="background-image: url({{ URL::asset('custom-images/logo-dim.png')}}); background-repeat: no-repeat; background-position: center; margin-bottom: 30px;">

                                <h2>DAILY INVOICE REPORT</h2>
                                <h4>Terai Hospital & Research Centre Pvt. Ltd</h4>
                                <span>Padam Road, Birgunj /</span>
                                <span>Reg No.80071/067-68 / PAN No: 601240803</span>
                                <p>Ph: 051-419252</p>
                            </div>
                            <div class="body" style="margin-top:100px;">
                                <div class="print-left" style=" float: left; width: 40%;">

                                    <p><strong>Name:</strong> {{ Auth::user()->fullname }} </p>

                                    <div class="spacer"></div>

                                    <h4> OPD</h4>
                                    <p><strong>No. of OPD Patients:</strong> {{$countPatients}}</p>
                                    <p><strong>No. of OPD Refunds:</strong> {{ $refundedOPDPatientsToday }}
                                        (Rs. {{ $refundedOPDPatientsTotal }})</p>
                                    <p><strong>OPD Collection:</strong> Rs. {{ round($opdPatient,2) }}</p>

                                    <br>

                                    <h4> IPD</h4>
                                    <p><strong>IPD Patient:</strong> {{ $ipdCount }}</p>
                                    <p><strong>Total Admission Collection:</strong>
                                        Rs. {{ round($ipdadmissionData, 2) }}</p>
                                    <p><strong>Total Deposit Collection:</strong> Rs. {{ round($total_deposit, 2) }}</p>
                                </div>


                                <div class="print-center" style=" float: left;">
                                    <p><strong>User Post:</strong> {{Auth::user()->userTypes->type_name }}</p>

                                    <div class="spacer"></div>

                                    <h4> Pathology/Test</h4>
                                    <p><strong>No. of Tests:</strong> {{ count($testPatients) }}</p>
                                    <p><strong>No. of Tests Refunds:</strong> {{ $refundedTestPatientsToday }}
                                        (Rs. {{ $refundedTestPatientsTotal }})</p>
                                    <p><strong>Tests Collection:</strong> Rs. {{ round($testTotal, 2) }}</p>

                                    <br>

                                    <h4> IPD Discharge</h4>
                                    <p><strong>IPD Discharge Patient:</strong> {{ $ipdDischargeCount }}</p>
                                    <p><strong>Total Received on Discharge:</strong> Rs. {{ $ipd_discharge_received }}
                                    </p>
                                    <p><strong>Total Returned on Discharge:</strong> Rs. {{ $ipd_discharge_returned }}
                                    </p>
                                </div>


                                <div class="print-right" style=" float: right;">
                                    <p><strong>Date: </strong> @include('backendview.billing.opd.nepali_calendar')</p>

                                    <div class="spacer"></div>

                                    <h4> Emergency</h4>
                                    <p><strong>Emergency Patient:</strong> {{$emergencyCount }}</p>
                                    <p><strong>Total Collection:</strong> Rs. {{ round($emergencyPatientData, 2) }}</p>
                                    <br>
                                </div>


                                <div class="print-bottom-left" style="float: left; width: 100%;">
                                    <div class="applicant" style="margin-top: 25px;">
                                        <p><b>Total Collected:</b> Rs. {{round($totalCollection, 2)}}</p>

                                        <p class="in-words"><b>In
                                                Words:</b> {{convert_number_to_words(round($totalCollection, 2))}} Only
                                        </p>

                                        <br>

                                        <strong style="border-top:1px dotted #444; padding-top: 2px;">
                                            VERIFIED BY <br>
                                        </strong>
                                        {{ Auth::user()->fullname }}
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div style=" text-align: center; padding-bottom: 30px; clear: both; float: none;">
                        <button class="btn btn-primary" onclick="printContent('printCertificate')">Print Report

                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        function printContent(el) {
            var restorepage = document.body.innerHTML;
            var printcontent = document.getElementById(el).innerHTML;
            document.body.innerHTML = printcontent;
            window.print();
            document.body.innerHTML = restorepage;
        }
    </script>
@endsection