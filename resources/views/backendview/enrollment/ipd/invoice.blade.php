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

        .ipd-invoice-total tr:hover td {
            background: none;
            color: #000;
        }

        .ipd-invoice .form-control {
            height: 30px;
            font-size: 11px;
        }

        .border-none {
            border-color: transparent;
            -webkit-box-shadow: none;
            -moz-box-shadow: none;
            box-shadow: none;
        }

        .ipd-invoice.tax-invoice table .first-row td {
            font-weight: 800;
        }

        .glyphicon {
            margin-right: 5px;
        }

        .ipd-invoice.tax-invoice .ipd-invoice-total td {
            padding: 0px 8px;
        }
    </style>

    <section class="content-header">

    </section>

    <section class="content" style="padding: 0;">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default" id="printCertificate"
                     style="border-color: transparent !important; margin-top: -15px;">
                    <div class="panel-body" style="color: #000; padding: 0;">
                        <div class="tax-invoice ipd-invoice">
                            <div class="logo text-center" style="margin-bottom:8px;">
                                <div class="logo-area-text">
                                    <h4 style="font-size: 11px; margin: 0;">Terai Hospital & Research Centre Pvt.
                                        Ltd.</h4>
                                    <span>Padam Road, Birgunj</span>
                                    <span>Reg No.: 80071/067-68 / PAN No: 601240803</span>
                                    <p>Ph: 051-419252</p>
                                    <span style="font-size: 11px; text-align: center;   ">Discharge Invoice</span>
                                    @if ($stat == '1') <span style="font-size: 11px; text-align: center;   ">Reprint</span> @endif
                                </div>
                            </div>
                            <div class="body" style="margin-top: 0px; ">
                                <div class="print-left" style=" float: left; width: 45%;">
                                    <p>
                                        <strong>Name:</strong> {{strtoupper($patient->first_name).'    '. strtoupper($patient->middle_name). ' '. strtoupper($patient->last_name)}}
                                    </p>
                                    <p><strong>Age: </strong>{{$patient->age}}</p>
                                    <p><strong>Gender: </strong>{{$patient->gender}}</p>
                                    <p><strong>Phone: </strong> {{$patient->phone}} </p>
                                    <p>
                                        <strong>Doctor:</strong>
                                        Dr. {{strtoupper($patient->isConsultedToDoctor->first_name).' '.strtoupper($patient->isConsultedToDoctor->middle_name).' '.strtoupper($patient->isConsultedToDoctor->last_name)}}
                                    </p>
                                    <p><b>Bill No.: </b>{{ $patient->bill_number }}</p>
                                </div>
                                <div class="print-right" style="float: right;">
                                    <p>
                                        <strong>Patient Code:</strong> {{$patient->patient_code}}
                                    </p>

                                    <p>
                                        <strong>Bill No:</strong> {{ $currentBillNumber }}
                                    </p>

                                    <p>
                                        <strong>Invoice
                                            Date:</strong>

                                        <?php
                                        $todayDate = date("Y/n/j");

                                        $localDate = str_replace("/", ",", $todayDate);
                                        $classes = explode(",", $localDate);
                                        $a = $classes[0];
                                        $b = $classes[1];
                                        $c = $classes[2];
                                        echo eng_to_nep($a, $b, $c);
                                        // echo  '&nbsp';
                                        // echo date('h:i A',strtotime($patient->created_at));
                                        ?>
                                    </p>

                                    <p><strong>Admitted
                                            On:</strong> <?php
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

                                    </p>

                                    <p hidden><strong>Discharged
                                            On:</strong> <?php
                                        $todayDate = date('Y-m-d', strtotime($patient->discharged_at));
                                        $localDate = str_replace("-", ",", $todayDate);
                                        $classes = explode(",", $localDate);
                                        $a = $classes[0];
                                        $b = $classes[1];
                                        $c = $classes[2];
                                        echo eng_to_nep($a, $b, $c);
                                        echo '&nbsp';
                                        echo date('h:i A', strtotime($patient->discharged_at));
                                        ?>
                                    </p>
                                </div>

                                <div class="col-md-10 col-md-offset-2 test-select" style="padding: 10px 0;">
                                    <div class="col-md-2" style="text-align: left;">
                                        <strong style="padding: 6px 0; display: inline-block; font-size:11px; float: right">Add
                                            Items: </strong>
                                    </div>

                                    <div class="col-md-6 test-area">
                                        <select name="test" class="form-control" id="tests" onchange="getTestDetail()" @if ($stat == '1') disabled="disabled" @endif>
                                            <option value="0">Select Test</option>
                                            @foreach($tests as $test)
                                                <option value="{{ $test->id }}">{{ $test->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                {{--<table border="1" style="width: 100%" class="test-list">
                                    <tr class="first-row">
                                        <!-- <td style="padding: 3px 25px;">Item Code</td> -->
                                        <td style="padding: 3px 25px;">Description</td>
                                        <!-- <td style="padding: 3px 25px;">Quantity</td> -->
                                        <td style="padding: 3px 25px;">Price</td>
                                        <!-- <td style="padding: 3px 25px;">Total</td> -->
                                        <td class="rem">Remove</td>
                                    </tr>
                                </table>--}}

                                <div class="table"
                                     style="font-size: 9px; ">
                                    <div class="table-body">
                                        <?php $i = 1 ?>
                                        <table class="test-list table table-striped" style="width: 100%;table-layout: fixed;">
                                            <tr class="first-row">
                                                <td>S.N</td>
                                                <td>Desc.</td>
                                                <td>Rate</td>
                                                <td>Qty</td>
                                                <td>Subtotal</td>
                                                <td>Dis(%)</td>
                                                <td>Total</td>
                                            </tr>
                                            @if(isset($room_data))
                                                @foreach($room_data as $key => $data)
                                                    <tr class="ward">
                                                        <td>{{ $i++ }}.</td>
                                                        <td class="ward-id" hidden>{{ $data['room_id'] }}</td>
                                                        <td>{{ $data['room_name'] }}</td>
                                                        <td>{{ $data['room_charge'] }}</td>
                                                        <td>
                                                            <script>
                                                                var sn = <?php echo $i - 1; ?>;
                                                            </script>
                                                            <input name="room_days" type="text"
                                                                   class="room-days<?php echo $i - 1; ?> border-none"
                                                                   style=" width:45px; height: 15px; padding-left:0;"
                                                                   onkeyup="getTotalRoomCharge(<?php echo $i - 1; ?>, <?php echo $data['room_charge']; ?>)"
                                                                   value="1" @if ($stat == '1') disabled="disabled" @endif>
                                                        </td>

                                                        <td class="total-room-charge-trf<?php echo $i - 1; ?>">
                                                            {{ $data['room_charge'] }}
                                                        </td>

                                                        <td>
                                                            <select class="form-control bed-discount<?php echo $i - 1; ?>"
                                                                    style="width: 65px;height: 15px;font-size: 9px;padding: 0;"
                                                                    name="bed-discount"
                                                                    onchange="getBedDiscountAmount(<?php echo $i - 1; ?>)" @if ($stat == '1') disabled="disabled" @endif>
                                                                <option value="0">0</option>
                                                                @foreach ($discount_type as $dis)
                                                                    <option value="{{ $dis->dis_percent }}">{{ $dis->d_type }}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>

                                                        <td class="line-total bed-charge-after-dis<?php echo $i - 1; ?> bed-chrg-total">
                                                            {{ $data['room_charge'] }}
                                                        </td>

                                                        <script>
                                                            $(document).ready(function () {
                                                                var sn = <?php echo(json_encode($i - 1)); ?>;
                                                                $('.sn').html(sn);
                                                                //alert($(".sn").html())
                                                            });
                                                        </script>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td>{{ $i++ }}.</td>
                                                    <td>{{ $roomName }}</td>
                                                    <td>{{ $roomRate }}</td>
                                                    <td>
                                                        <input name="test_id" type="text" class="border-none"
                                                               style=" width:45px; height: 15px; padding-left:0;"
                                                               onkeyup="getTotalCharge()"
                                                               value="{{ $daysInHospital }}">
                                                    </td>

                                                    <td class="total-room-charge">
                                                        {{ $roomCharge }}
                                                    </td>

                                                    <td>
                                                        {{--<input name="bed-discount-single" type="text"
                                                               class="bed-discount-single border-none"
                                                               style=" width:75px; height: 15px; padding-left:0;"
                                                               onkeyup="getBedDiscountAmountSingle()"
                                                               placeholder="Enter Discount" hidden>--}}

                                                        <select class="form-control bed-discount-single"
                                                                style="width: 65px;height: 15px;font-size: 9px;padding: 0;"
                                                                name="bed-discount0-single"
                                                                onchange="getBedDiscountAmountSingle()">
                                                            <option value="0">0</option>
                                                            @foreach ($discount_type as $dis)
                                                                <option value="{{ $dis->dis_percent }}">{{ $dis->d_type }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>

                                                    <td class="line-total bed-charge-after-dis-single">
                                                        {{ $roomCharge }}
                                                    </td>

                                                    <script>
                                                        $(document).ready(function () {
                                                            var sn = <?php echo(json_encode($i - 1)); ?>;
                                                            $('.sn').html(sn);
                                                            //alert($(".sn").html())
                                                        });
                                                    </script>
                                                </tr>
                                            @endif

                                            @if(count($patient->hasHistory))
                                                @foreach($docs as $doctorVisit)
                                                    <tr>
                                                        <td>{{ $i++ }}.</td>

                                                        <td>{{ $doctorVisit->full_name. ' ('. $doctorVisit->description. ')' }}</td>

                                                        <td> {{ round($doctorVisit->doctor_fee, 2) }} </td>

                                                        <td>{{ $doctorVisit->count }}</td>

                                                        <td class="line-total">{{ round($doctorVisit->charge, 2) }}</td>

                                                        <td>0</td>

                                                        <td class="line-total-1">{{ round($doctorVisit->charge, 2) }}</td>

                                                        <script>
                                                            $(document).ready(function () {
                                                                var sn = <?php echo(json_encode($i - 1)); ?>;
                                                                $('.sn').html(sn);
                                                                //alert($('.sn').html())
                                                            });
                                                        </script>
                                                    </tr>
                                                @endforeach
                                            @endif

                                            @if (!empty($test_list))
                                                            @foreach ($test_list as $key => $val)
                                                            <tr>
                                                                <td>{{ $i++ }}</td>
                                                                <td>{{ $val->title }}</td>
                                                                <td>{{ round($val->price, 2) }}</td>
                                                                <td>{{ $val->quantity }}</td>
                                                                <td>{{ round($val->test_price, 2) }}</td>
                                                                <td>0</td>
                                                                <td>{{ round($val->test_price, 2) }}</td>
                                                            </tr>
                                                            @endforeach
                                            @endif
                                        </table>
                                    </div>
                                </div>

                                <div class="ipd-invoice-total pull-right">
                                    <table class="bottom_right_table"
                                           style="width: 100%; text-align: right; margin-top: -15px; font-size: 10px; ">

                                        <tr>
                                            <td>Sub Total</td>
                                            <td class="semi">:</td>
                                            <td class="result table-total">
                                                {{ $subTotal }}.00
                                            </td>
                                        </tr>

                                        <tr hidden>
                                            <td>Discount(%)</td>
                                            <td class="semi">:</td>
                                            <td class="result">
                                                <input type="text" value="0" id="discount" class="discount border-none"
                                                       name="discount"
                                                       onkeyup="getDiscount()"
                                                       style="width: 50px; text-align: right;">
                                            </td>
                                        </tr>

                                        <tr hidden>
                                            <td>Discount Amount</td>
                                            <td class="semi">:</td>
                                            <td class="discount-amount">0.00</td>
                                        </tr>

                                        <tr hidden>
                                            <td>Total after Discount</td>
                                            <td class="semi">:</td>
                                            <td class="result subtotal">
                                                {{ $subTotal }}
                                            </td>

                                            <td class="sn" hidden>
                                            </td>
                                        </tr>

                                        <tr style="display:none">
                                            <td>HST 5%</td>
                                            <td class="semi">:</td>
                                            <td class="result hst">
                                                {{ $hst }}</td>
                                        </tr>

                                        <tr>
                                            <td>Total after Tax</td>
                                            <td class="semi">:</td>
                                            <td class="result total">
                                                {{--Rs. {{ $total }}--}}
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>Deposit</td>
                                            <td class="semi">:</td>
                                            <td class="result">
                                                {{{ $deposit_amount or 0 }}}.00
                                            </td>
                                        </tr>

                                        @if($subTotal > $deposit_amount)
                                            <tr>
                                                <td class="grand-total-label">Due Amount</td>
                                                <td class="semi">:</td>
                                                <td class="result grand-total">
                                                    {{--Rs. {{ $due }}--}}
                                                </td>
                                            </tr>
                                        @else
                                            <tr>
                                                <td class="grand-total-label">Returned Amount</td>
                                                <td class="semi">:</td>
                                                <td class="result grand-total">
                                                {{--Rs. {{ $return }}</td>--}}
                                            </tr>
                                        @endif
                                    </table>
                                </div>

                                <div class="print-bottom total-calculation">
                                    <p class="in-words" style="text-align: left; width: 100%;"><strong></strong></p>

                                    <div class="print-bottom-left" style="float: left; width: 50%;">
                                        <div class="applicant" style="margin-top: 20px;">
                                            <p>{{ Auth::user()->fullname }}</p>
                                            <strong
                                                    style="border-top:1px solid #444; font-size:9px;">RECEIVED
                                                BY</strong>
                                        </div>
                                        <p><strong>{{getTodayNepaliDate()}} {{ \Carbon\Carbon::now()->toTimeString() }}</strong></p>
                                    </div>


                                    {{--hidden fields--}}
                                    <input type="text" class="patient-id" id="patient-id"
                                           value="{{ $patient->id }}"
                                           hidden>

                                    <input type="text" class="total-after-tax"
                                           name="total-after-tax"
                                           value="{{ $subTotal }}" hidden>

                                    <input type="text" class="room-charge-total"
                                           name="room-charge-total" hidden>

                                    <input type="text" class="doctor-charge"
                                           name="doctor-charge"
                                           value="{{ $doctorVisitCharge }}" hidden>

                                    <input type="text" class="gtotal"
                                           name="gtotal" value="test" hidden>

                                    <input type="text" class="room-charge"
                                           name="room-charge" hidden>

                                    <input type="text" class="total-discount"
                                           name="total-discount" value="0" hidden>

                                </div>

                                <div class="footer-content print-button-spot">
                                    <button class="btn btn-primary"
                                            onclick="printContent('printCertificate')">
                                        Print Invoice
                                    </button>
                                </div>

                                <br>

                                {{--<div class="footer-section">
                                    <h1>
                                        @if($patient->status == 'In Ward')
                                            <a href="{{url('ip-enrollment/' .$patient->id . '/discharge-patient')}}">
                                                <button type="button" class="btn btn-warning btn-danger  pull-left ">
                                                    <span aria-hidden="true"></span> Discharge
                                                </button>
                                            </a>
                                        @else
                                            <span class="label label-danger" style="font-size: medium">Discharged</span>
                                        @endif

                                        <a href="{{url('ip-enrollment/discharge-patient')}}">
                                            <button type="button" class="btn btn-warning btn-flat  pull-right ">
                                                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Back
                                            </button>
                                        </a>
                                    </h1>
                                </div>--}}

                                <div class="footer-content" style="margin-top: 10px;">
                                    <p>Get Well Soon. Thank You.</p>
                                </div>

                                <br><br>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        $(window).on('load', function () {
            $('.discount').removeClass('border-none');
        })

        function printContent(el) {
            /*var restorepage = document.body.innerHTML;
             var printcontent = document.getElementById(el).innerHTML;
             document.body.innerHTML = printcontent;
             $('.print-button-spot, .main-footer, .title').show();
             window.print();

             document.body.innerHTML = restorepage;*/
             var r = confirm('Print and Discharge Patient?');
             if (r == true) {

            /* insert in table */
            var p_url = '{{ url("discharge-invoice-save") }}';
            var token = "{{csrf_token()}}";
            var ipatient_id = $('.patient-id').val();
            var room_charge = $('.room-charge-total').val();
            var doctor_charge = <?php echo(json_encode($doctorVisitCharge)); ?>;
            var discount = $('.total-discount').val();
            var subtotal_after_discount = $('.subtotal').text();
            var total_after_tax = $('.total').text();
            var hst = $('.hst').text();
            var total = '';
            var tid = '';
            var quantity = '';
            $('.test-list tr').each(function () {
                var t = parseFloat($(this).find('.test-price').html());
                var id = $(this).find('.test-id').val();
                var q = $(this).find('.quantity').val();
                if (!isNaN(t)) {
                    total += '-' + t;
                    tid += '-' + id;
                    quantity += '-' + q;
                }
            });
            var price = total.substr(1);
            var test_id = tid.substr(1);
            var test_quantity = quantity.substr(1);
            if ($('.grand-total-label').html() == 'Returned Amount') {
                var returned_amount = $('.grand-total').html();
                var received_amount = '';
            } else {
                var received_amount = $('.grand-total').html();
                var returned_amount = '';
            }
            /*store individual room id and charge*/
            var room_id = '';
            var room_charge = '';
            $('.test-list tr').each(function () {
                var id = $(this).find('.ward-id').html();
                var charge = parseFloat($(this).find('.bed-chrg-total').html());
                if (!isNaN(id)) {
                    if (room_id == '') {
                        room_id = id;
                        room_charge = charge;
                    } else {
                        room_id += '-' + id;
                        room_charge += '-' + charge;
                    }
                }
            });

            $.post(p_url, {
                _token: token,
                ipatient_id: ipatient_id,
                doctor_charge: doctor_charge,
                discount: discount,
                subtotal_after_discount: subtotal_after_discount,
                total_after_tax: total_after_tax,
                hst: hst,
                test_price: price,
                test_id: test_id,
                test_quantity: test_quantity,
                returned_amount: returned_amount,
                received_amount: received_amount,
                room_id: room_id,
                room_charge: room_charge
            }, function (res) {
                $('.print-button-spot, .test-select, .footer-section, .main-footer').hide();
                $('.discount').addClass('border-none');
                $('.remove-test').removeClass('glyphicon glyphicon-remove');
                window.print();

                /*window.location.assign('{{URL::to('/ip-enrollment/patients')}}');*/
                var d_url = "{{ url('ip-enrollment') }}/" + ipatient_id + "/discharge-patient";
                window.location.assign(d_url);
                //location.reload();
            });
            } else {
                window.location.assign('{{URL::to('/ip-enrollment/patients')}}');
            }
        }

        $(document).ready(function () {
            var discountPercent = $('#discount').val();
            var deposit = <?php echo(json_encode($deposit_amount)); ?>;
            var subTotal = <?php echo(json_encode($subTotal)); ?>;
            var discount = discountPercent / 100 * subTotal;
            var total = subTotal - discount;
            var hst = 0 / 100 * total;
            $('.hst').html(hst.toFixed(2));
            var grandTotal = total + hst;
            $('.total').html(grandTotal.toFixed(2));

            if (grandTotal > deposit) {
                var final = grandTotal - deposit;
                $('.grand-total-label').html('Due Amount');
                $('.grand-total').html(final.toFixed(2));
            } else {
                $('.grand-total-label').html('Returned Amount');
                var final = deposit - grandTotal;
                $('.grand-total').html(final.toFixed(2));
            }

            var p_url = '{{ url("get-total-in-words") }}';
            var token = "{{csrf_token()}}";
            $.post(p_url, {
                _token: token,
                total: final
            }, function (res) {
                $('.in-words').html(res);
            });
        });

        $(function () {
            /* get subcat */
            $('#test-category').change(function () {
                var cat_id = $(this).val();
                var url = '{{ url("/manageSubcategory") }}/' + cat_id;
                $.get(url, function (res) {
                    var content = '<select name="subcategory" class="form-control" id="test_subcat" onchange="getTests()"><option value="0">Select Sub Category</option>';
                    $.each(res, function (ind, val) {
                        content += '<option value="' + val.id + '">' + val.title + '</option>';
                    });
                    content += '</select>';
                    $('.subcat-test').html(content);
                });
            });
        });

        function getTests() {
            var sid = $('#test_subcat').val();
            var url = '{{ url("/manageTests") }}/' + sid;
            $.get(url, function (res) {
                var content = '<select name="test" class="form-control" id="tests" onchange="getTestDetail()"><option value="0">Select Test</option>';
                $.each(res, function (ind, val) {
                    content += '<option value="' + val.id + '">' + val.title + '</option>';
                });
                content += '</select>';
                $('.test-area').html(content);
            });
        }

        function getTestDetail() {
            var sn = $('.sn').html()
            sn++;
            $('.sn').html(sn);
            //alert($('.sn').html())
            var tid = $('#tests').val();
            var url = '{{ url("/getTestDetail") }}/' + tid;
            $.get(url, function (val) {
                var title = val.title;
                var price = val.price;
                var id = val.id;

                var content = '<tr>';
                content += '<td class="js-sn">' + $('.sn').html() + '.</td>';
                content += '<td><span style="color: darkred;" class="glyphicon glyphicon-remove remove-test" onclick="removeTest(this)"></span>' + val.title + '<input name="test_id" type="hidden" class="test-id" value="' + id + '"></td>';
                //content += '<td style="padding: 3px 25px;">' + val.price + '</td>';
                content += '<td><input style=" width:80px; height: 10px; padding-left:0;" type="text" class="rate form-control border-none" value="' + val.price + '" onkeyup="getTotalFromRate(this)"></td>';
                content += '<td><input style=" width:45px; height: 10px; padding-left:0;" type="text" class="quantity form-control border-none" value="1" onkeyup="getTotal(this, ' + val.price + ')"></td>';
                content += '<td  class="line-total test-price">' + val.price + '</td>';
                content += '<td>0</td>';
                content += '<td  class="line-total-1 test-price-1">' + val.price + '</td>';
                content += '</tr>';
                $('.test-list').append(content);

                grand();
            });
        }

        function getTotal(ctrl, price) {
            var rate = $(ctrl).parent().parent().find('.rate').val();
            //var total = ctrl.value * price;
            var total = ctrl.value * rate;
            ctrl.parentNode.nextSibling.innerHTML = total.toFixed(2);
            ctrl.parentNode.nextSibling.nextSibling.nextSibling.innerHTML = total.toFixed(2);

            grand();
        }

        function getTotalFromRate(ctrl) {
            var rate = $(ctrl).val();
            var qty = $(ctrl).parent().parent().find('.quantity').val();
            var total = rate * qty;
            $(ctrl).parent().parent().find('.test-price').text(total.toFixed(2));
            $(ctrl).parent().parent().find('.test-price-1').text(total.toFixed(2));
            grand();
        }

        function getTotalCharge() {
            var qty = $('.test-id').val();
            var rate = <?php echo(json_encode($roomRate)); ?>;
            var charge = qty * rate;
            $('.total-room-charge').html(charge.toFixed(2));
            $('.bed-charge-after-dis-single'.concat(sn)).text(charge.toFixed(2));

            /*Assign value to hidden field*/
            var charge_tax = 0/100 * charge;
            var charge_with_tax = charge + charge_tax;
            $('.room-charge-total').val(charge_with_tax.toFixed(2));

            /*reset discount percent value*/
            $('.bed-discount-single').val('0');

            grand();
        }

        function getTotalRoomCharge() {
            var sn = arguments[0];
            var rate = arguments[1];
            var qty = $('.room-days'.concat(sn)).val();
            var charge = qty * rate;
            $('.total-room-charge-trf'.concat(sn)).html(charge.toFixed(2));
            $('.bed-charge-after-dis'.concat(sn)).text(charge.toFixed(2));

            /*Assign value to hidden field*/
            var charge_tax = 0/100 * charge;
            var charge_with_tax = charge + charge_tax;
            $('.room-charge-total').val(charge_with_tax.toFixed(2));

            /*reset discount percent value*/
            $('.bed-discount'.concat(sn)).val('0');

            grand();
        }

        function getBedDiscountAmount() {
            var sn = arguments[0];
            var dis_per = $('.bed-discount'.concat(sn)).val();
            var before_dis = $('.total-room-charge-trf'.concat(sn)).text();
            var dis_amt = dis_per / 100 * before_dis;
            var after_dis = before_dis - dis_amt;
            $('.bed-charge-after-dis'.concat(sn)).text(after_dis.toFixed(2));

            /*store total discount in hidden field*/
            discount = $('.total-discount').val();
            dis_amt += parseInt(discount);
            $('.total-discount').val(dis_amt.toFixed(2));

            grand();
        }

        function getBedDiscountAmountSingle() {
            var dis_per = $('.bed-discount-single').val();
            var before_dis = $('.total-room-charge').text();
            var dis_amt = dis_per / 100 * before_dis;
            var after_dis = before_dis - dis_amt;
            $('.bed-charge-after-dis-single').text(after_dis.toFixed(2));

            /*store total discount in hidden field*/
            discount = $('.total-discount').val();
            dis_amt += parseInt(discount);
            $('.total-discount').val(dis_amt.toFixed(2));

            grand();
        }

        function grand(dis = 0) {
            var amount = 0;
            $('.line-total').each(function () {
                amount += parseFloat($(this).html());
            });
            $('.table-total').html(amount.toFixed(2));
            var discountPercent = $('#discount').val();
            var deposit = <?php echo(json_encode($deposit_amount)); ?>;
            var subTotal = $('.table-total').text();
            var discount = discountPercent / 100 * subTotal;
            $('.discount-amount').html(discount.toFixed(2));
            var total = subTotal - discount;
            $('.subtotal').html(total.toFixed(2));
            var hst = 0 / 100 * total;
            $('.hst').html(hst.toFixed(2));
            var grandTotal = total + hst;
            $('.total').html(grandTotal.toFixed(2));
            var totalAfterTax = document.getElementsByName('total-after-tax');
            totalAfterTax.value = grandTotal;

            if (grandTotal > deposit) {
                var final = grandTotal - deposit;
                $('.grand-total-label').html('Due Amount');
                $('.grand-total').html(final.toFixed(2));
            } else {
                $('.grand-total-label').html('Returned Amount');
                var final = deposit - grandTotal;
                $('.grand-total').html(final.toFixed(2));
            }

            var p_url = '{{ url("get-total-in-words") }}';
            var token = "{{csrf_token()}}";
            $.post(p_url, {
                _token: token,
                total: final
            }, function (res) {
                $('.in-words').html(res);
            });
        }

        function getDiscount() {
            var discountPercent = $('#discount').val();
            var deposit = <?php echo(json_encode($deposit_amount)); ?>;
            var subTotal = $('.table-total').text();
            var discount = discountPercent / 100 * subTotal;
            $('.discount-amount').html(discount.toFixed(2));
            var total = subTotal - discount;
            $('.subtotal').html(total.toFixed(2));
            var hst = 0 / 100 * total;
            $('.hst').html(hst.toFixed(2));
            var grandTotal = total + hst;
            $('.total').html(grandTotal.toFixed(2));
            var totalAfterTax = document.getElementsByName('total-after-tax');
            totalAfterTax.value = grandTotal;

            if (grandTotal > deposit) {
                var final = grandTotal - deposit;
                $('.grand-total-label').html('Due Amount');
                $('.grand-total').html(final.toFixed(2));
            } else {
                $('.grand-total-label').html('Returned Amount');
                var final = deposit - grandTotal;
                $('.grand-total').html(final.toFixed(2));
            }

            var p_url = '{{ url("get-total-in-words") }}';
            var token = "{{csrf_token()}}";
            $.post(p_url, {
                _token: token,
                total: final
            }, function (res) {
                $('.in-words').html(res);
            });
        }

        function removeTest(ctrl) {
            var sn = $('.sn').html()
            sn--;
            $('.sn').html(sn);
            var price = $(ctrl).parent().siblings('.line-total').html();
            $(ctrl).parent().parent().remove();
            var sub_total = parseFloat($('.table-total').html()) - price;
            $('.table-total').html(sub_total.toFixed(2));
            var discountPercent = $('#discount').val();
            var deposit = <?php echo(json_encode($deposit_amount)); ?>;
            var subTotal = $('.table-total').text();
            var discount = discountPercent / 100 * subTotal;
            $('.discount-amount').html(discount.toFixed(2));
            var total = subTotal - discount;
            $('.subtotal').html(total.toFixed(2));
            var hst = 0 / 100 * total;
            $('.hst').html(hst.toFixed(2));
            var grandTotal = total + hst;
            $('.total').html(grandTotal.toFixed(2));
            var totalAfterTax = document.getElementsByName('total-after-tax');
            totalAfterTax.value = grandTotal;

            if (subTotal > deposit) {
                var final = grandTotal - deposit;
                $('.grand-total').html(final.toFixed(2));
            } else {
                var final = deposit - grandTotal;
                $('.grand-total').html(final.toFixed(2));
            }

            var p_url = '{{ url("get-total-in-words") }}';
            var token = "{{csrf_token()}}";
            $.post(p_url, {
                _token: token,
                total: final
            }, function (res) {
                $('.in-words').html(res);
            });
        }
    </script>
@endsection