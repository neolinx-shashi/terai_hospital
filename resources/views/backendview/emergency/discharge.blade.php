@extends('backendlayout.master')
@extends('backendlayout.header')
@extends('backendlayout.leftmenu')
@extends('backendlayout.footer')
@section('userscontent')
    @extends('backendlayout.flashmessagecollection')
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

        /*.tax-invoice .table{
            width: 100%;
            height: auto;
            position: relative;
        }*/
        .total-calculation {
            margin-top: 15px;
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

        .ninja {
            display: none;
        }

    </style>

    <style type="text/css" media="print">
        select {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            border: none;
            background: none;
        }
    </style>
    <section class="content-header">
        <h1>
            <a href="{{url('emergency/patient')}}">
                <button type="button" class="btn btn-warning btn-flat  pull-right ">
                    <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span> View Patients
                </button>
            </a>
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">


                    <div class="panel-body" style="color: #000; line-height: 28px;" id="printCertificate">
                        <style>
                            .certificate_info {
                                color: #777;
                            }

                            .tax-invoice .body p {
                                font-weight: normal;
                                font-size: 16px;
                            }
                        </style>
                        <div class="tax-invoice">

                            <div class="body" style="margin-top: 30px; ">
                                <div class="discharge-title" style="text-align: center;">
                                    <h4>Discharge: {{ucfirst($patient->first_name).' ' .
                                ucfirst($patient->middle_name). ' ' .
                                ucfirst($patient->last_name)}}</h4>

                                    <p>Admitted On:

                                        <?php

                                        $todayDate = date('Y-m-d', strtotime($patient->created_at));

                                        $localDate = str_replace("-", ",", $todayDate);

                                        $classes = explode(",", $localDate);
                                        //print_r($classes);

                                        $a = $classes[0];
                                        $b = $classes[1];
                                        $c = $classes[2];


                                        echo eng_to_nep($a, $b, $c);
                                        echo '&nbsp';

                                        echo date('h:i A', strtotime($patient->created_at));
                                        ?>
                                    </p>
                                </div>

                                <div class="create-test-left" style=" float: left; width: 45%;">
                                    <strong>Referral Doctor: <a style="color: #ff0000;">*</a></strong>
                                    <div class="input-group">
                                        <select class="doctor-name form-control" id="doctor-name"
                                                style="font-size: 11px;min-width: 169px;">
                                            <option value="0">Choose a doctor</option>
                                            @foreach ($doctors as $val)
                                                <option value="{{ $val->id }}">{{ ucfirst($val->first_name) }} {{{ $val->middle_name or '' }}} {{ ucfirst($val->last_name) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="create-test-left" style=" float: left; width: 45%;">
                                    <strong style="float: left; width: 24%;" class="c-doc ninja">Consulting Doctor:
                                        <a style="color: #ff0000;">*</a></strong>
                                    <div class="input-group c-doc ninja consulting-doctor">
                                        <select class="consulting-doctor-name form-control"
                                                id="consulting-doctor-name"
                                                style="font-size: 11px;">
                                            <option value="0">Choose a doctor</option>
                                        </select>
                                    </div>

                                    <strong>Discount Type: </strong>
                                    <div class="input-group">
                                        <select class="form-control" style="font-size: 11px;min-width: 169px;"
                                                id="discount-type">
                                            <option value="0">Choose discount type</option>
                                            @foreach ($discount_type as $dis)
                                                <option value="{{ $dis->d_id }}">{{ $dis->d_type }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>


                                <br class="all">
                                <div class="col-md-12 nopadding test-select">
                                    <input name="pid" class="pid" type="hidden" value="{{ $patient->id }}">
                                    <input name="doctor_id" class="doctor_id" type="hidden"
                                           value="{{ $patient->doctor_id }}">

                                    {{--<div class="col-md-3">

                                        <input value="{{ $test_category->title }}" disabled="disabled" class="form-control">
                                    </div>
                                    <div class="col-md-4 subcat-test">
                                        <select  name="subcategory" class="form-control" id="test_subcat" onchange="getTests()">
                                            <option value="0">Select Sub Category </option>
                                            @foreach($subcategories as $subcat)
                                            <option value="{{$subcat->id}}">{{ $subcat->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4 test-area">
                                        <select id="test" class="form-control" disabled="disabled">
                                            <option value="0">Select Test </option>
                                        </select>
                                    </div>
                                </div>



                                <br clear="all"> <br>
                                <div class="table">
                                    <div class="table-body">
                                        <table border="1" style="width: 100%" class="test-list">
                                            <tr class="first-row">
                                                <!-- <td style="padding: 3px 25px;">Item Code</td> -->
                                                <td style="padding: 3px 25px;">Description</td>
                                                <td style="padding: 3px 25px;">Quantity</td>
                                                <td style="padding: 3px 25px;">Unit Price(Rs.)</td>
                                                <td style="padding: 3px 25px;">Total In(Rs.)</td>
                                                <td class="rem">Remove</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <div class="print-bottom total-calculation">
                                    <div class="print-bottom-left" style="float: left; width: 50%;">

                                    </div>
                                    <div class="print-bottom-right" style="float: right;">
                                        <table border="1" style="width: 100%">

                                            <tr>
                                                <td style="padding: 3px 25px;">Sub Total</td>
                                                <td class="result sub-total" style="padding: 3px 25px;">0</td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 3px 25px;">Discount %</td>
                                                <td class="result discount" style="padding: 3px 25px;"><input
                                                            class="discount-amount form-control"  maxlength="2" value="0"
                                                            style="width: 55px;"   onkeyup="getDiscount()"></td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 3px 25px;">HST <span class="tax">5</span>%</td>
                                                <td class="result tax-amt" style="padding: 3px 25px;"></td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 3px 25px;">Total</td>
                                                <td class="result grand-total" style="padding: 3px 25px;">0</td>

                                            </tr>

                                        </table>
                                    </div>

                                </div>--}}

                                    <br clear="all"> <br>
                                    <div class="table">
                                        <div class="table-body">
                                            <table border="1" style="width: 100%" class="test-list">
                                                <tr class="first-row">
                                                    <td style="padding: 3px 25px;">Item Description</td>
                                                    <td style="padding: 3px 25px;">Amount (Rs.)</td>
                                                    <td style="padding: 3px 25px;">Discount (Rs.)</td>
                                                    <td style="padding: 3px 25px;">Quantity</td>
                                                    <td style="padding: 3px 25px;">Net Amount (Rs.)</td>
                                                    <td class="rem" style="width: 100px;text-align: center;">Remove</td>
                                                </tr>
                                                <tbody class="list-here">
                                                <tr class="original">
                                                    <td>
                                                        <select id="tests" class="form-control"
                                                                onchange="getTestDetails(this)">
                                                            <option value="0">Select Test</option>
                                                            @foreach ($result as $val)
                                                                <option value="{{ $val->id }}">{{ $val->title }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td class="amount"></td>
                                                    <td class="discount">
                                                        <!--<input class="form-control discount_per" type="text" placeholder="%" onblur="getNetPrice(this)" />--></td>
                                                    <td class="qty" hidden>1</td>
                                                    <td class="quantity">
                                                        <input type="text" class="qty" value="1" onkeyup="getNetPriceWithQty(this)">
                                                    </td>
                                                    <td class="net-amount"></td>
                                                    <td class="remove"><span class="glyphicon glyphicon-remove"
                                                                             onclick="removeTest(this)"
                                                                             style="color:red"></span></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="print-bottom total-calculation">
                                        <div class="print-bottom-left" style="float: left; width: 50%;">
                                            <div class="applicant" style="margin-top: 25px;">
                                                {{-- <p >{{strtoupper($patient->belongsToUser->fullname)}}</p><strong style="border-top:1px dotted #444;">RECEIVED BY</strong>--}}
                                            </div>
                                        </div>
                                        <div class="print-bottom-right" style="float: right;">
                                            <table border="1" style="width: 100%">

                                                <tr>
                                                    <td style="padding: 3px 25px;">Sub Total</td>
                                                    <td class="result sub-total" style="padding: 3px 25px;">0</td>
                                                </tr>

                                                <tr>
                                                    <td style="padding: 3px 25px;">Total Discount</td>
                                                    <td class="result tot-discount" style="padding: 3px 25px;">0</td>
                                                </tr>

                                                <tr style="display:none">
                                                    <td style="padding: 3px 25px;">HST <span class="tax">5</span>%</td>
                                                    <td class="result tax-amt" style="padding: 3px 25px;"></td>
                                                </tr>

                                                <tr>
                                                    <td style="padding: 3px 25px;">Total</td>
                                                    <td class="result grand-total" style="padding: 3px 25px;">0</td>
                                                    {{--                                                <td class="result" style="padding: 3px 25px;">{{$patient->doctor_fee}}</td>--}}
                                                </tr>

                                            </table>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style=" text-align: center; padding-bottom: 55px; clear: both; float: none;"
                             class="print-button-spot">
                            <button id="button" class="btn btn-primary print-now"
                                    onclick="printContent('printCertificate')" disabled="disabled">
                                Save and Continue
                            </button>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="{{URL::asset('backendtheme/plugins/jQuery/jQuery-2.1.4.min.js')}}"></script>
    <script>

        function printContent(el) {

            if ($("#doctor").val() == '0') {
                alert('Fields with astericks (*) are mandatory!');
            } else if (!$('.c-doc').hasClass('ninja') && $('#consulting-doctor-name').val() == 0) {
                alert('Fields with astericks (*) are mandatory!');
            } else {
                /*to avoid double click*/
                $('.print-now').attr('disabled', 'disabled');
                /* remove empty row */
                removeEmptyRows();

                /* insert in table */
                var p_url = '{{ url("bill-save") }}';
                var token = "{{csrf_token()}}";
                var total = '';
                var pid = $('.pid').val();
                var doctorId = $('.doctor-name').val();
                var conDoctorId = $('.consulting-doctor-name').val();

                /*var tid = '';
                var urate = '';
                var qty = '';
                $('.test-list tr').each(function () {
                    var t = parseFloat($(this).find('.total').html());
                    var id = $(this).find('.test-id').val();
                    var r = parseFloat($(this).find('.rate').html());
                    var q = $(this).find('.quantity').val();

                    if (!isNaN(t)) {
                        total += '-' + t;
                        tid += '-' + id;
                        urate += '-' + r;
                        qty += '-' + q;

                    }
                });
                var price = total.substr(1);
                var rate = urate.substr(1);
                var qty = qty.substr(1);
                var test_id = tid.substr(1);
                var stotal = $('.sub-total').html();
                var tax = $('.tax-amt').html();
                var dis = $('.discount-amount').val();
                var discount = dis / 100 * stotal;
                var gtotal = $('.grand-total').html();*/

                var total = '';
                var tid = '';
                var ind_dis = '';
                var quantity = '';
                $('.list-here tr').each(function () {
                    var t = parseFloat($(this).find('.net-amount').html());
                    var id = $(this).find('#tests').val();
                    var idis = parseFloat($(this).find('.discount').text());
                    var qty = parseFloat($(this).find('.qty').text());
                    if (!isNaN(t)) {
                        total += '-' + t;
                        tid += '-' + id;
                        ind_dis += '-' + idis;
                        quantity += '-' + qty;
                    }
                });
                var price = total.substr(1);
                var test_id = tid.substr(1);
                var test_discount = ind_dis.substr(1);
                var test_qty = quantity.substr(1);
                var stotal = $('.sub-total').html();
                var tax = $('.tax-amt').html();
                var dis = $('.discount-amount').val();
                var discount = $('.tot-discount').html();
                var gtotal = $('.grand-total').html();

                /* patient personal detail */


                $.post(p_url, {
                    _token: token,
                    pid: pid,
                    test_id: test_id,
                    price: price,
                    stotal: stotal,
                    tax: tax,
                    gtotal: gtotal,
                    discount: discount,
                    //rate: rate,
                    qty: test_qty,
                    doctorId: doctorId,
                    conDoctorId: conDoctorId,
                    test_discount: test_discount,
                }, function (res) {
                    console.log(res);
                    //debugger;
                    //window.open('/emergency-invoice/' + pid);
                    window.location = '/emergency-invoice/' + pid;
                });

            }
        }

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

            $('#test_subcat').change(function () {
                if ($("#test_subcat").val() == '0')
                    $(button).attr('disabled', 'disabled');
                else
                    $(button).removeAttr('disabled');


            });

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


            var tid = $('#tests').val();
            var url = '{{ url("/getTestDetail") }}/' + tid;
            $.get(url, function (val) {
                var title = val.title;
                var price = val.price;
                var id = val.id;


                var content = '<tr>';
                //content += '<td style="padding: 3px 25px;"></td>';
                content += '<td style="padding: 3px 25px;">' + val.title + '<input name="test_id" type="hidden" class="test-id" value="' + id + '"></td>';
                content += '<td style="padding: 3px 25px;"><input type="text" class="quantity"  value="1" onkeyup="getTotal(this, ' + val.price + ')"></td>';
                content += '<td style="padding: 3px 25px;" class="rate">' + val.price + '</td>';
                content += '<td style="padding: 3px 25px;" class="total">' + val.price + '</td>';
                content += '<td class="rem"><span class="glyphicon glyphicon-remove" onclick="removeTest(this)" style="color:red"></span></td>';
                content += '</tr>';
                $('.test-list').append(content);

                grand();
                enableButton();
            });
        }

        function getTotal(ctrl, price) {
            var total = ctrl.value * price;
            ctrl.parentNode.nextSibling.nextSibling.innerHTML = total;

            grand();
        }

        function grand(dis = 0) {
            var amount = 0;
            $('.total').each(function () {
                amount += parseFloat($(this).html());
            });
            var discount = (dis / 100 * amount);
            var amt_after_dis = amount - discount;
            var tax = parseFloat($('.tax').html().replace(' %', ''));
            var tax_rate = (0 / 100 * amt_after_dis);
            var grand_total = amt_after_dis + tax_rate;

            $('.sub-total').html(amount);
            $('.tax-amt').html(tax_rate.toFixed(2));
            $('.grand-total').html(grand_total.toFixed(2));
        }

        function removeTest(ctrl) {
            var price = $(ctrl).parent().siblings('.total').html();
            $(ctrl).parent().parent().remove();
            var sub_total = parseFloat($('.sub-total').html()) - price;
            var tax_amount = 0 / 100 * sub_total;
            var grand_total = sub_total + tax_amount;
            $('.sub-total').html(sub_total);
            $('.tax-amt').html(tax_amount);
            $('.grand-total').html(grand_total);
        }

        function getDiscount() {
            var dis = $('.discount-amount').val();
            grand(dis);
        }

        $(".print-now").on("click", function () {
            event.preventDefault();
            $('.form-control').removeClass('form-control');

            $('input').addClass('form-control');
        });


        /* */
        $(function () {
            $('#test-name').keyup(function () {
                var test = $('#test-name').val();
                var url = "{{ url('/testslist') }}";
                var token = "{{ csrf_token() }}";
                if (test.length >= 1) {
                    $.post(url, {test: test, _token: token}, function (res) {
                        var content = '<ul>';
                        $.each(res, function (i, val) {
                            content += '<li onclick="getTestsDetail(' + val.id + ')">' + val.title + '</li>';
                        });
                        content += '</ul>';

                        $('.test-list-here').html(content);
                    });
                }
            });
        });

        function getTestsDetail(tid) {
            //var tid = $('#tests').val();
            var url = '{{ url("/getTestDetail") }}/' + tid;
            $.get(url, function (val) {
                var title = val.title;
                var price = val.price;
                var id = val.id;

                var content = '<tr>';
                //content += '<td style="padding: 3px 25px;"></td>';
                content += '<td style="padding: 3px 25px;">' + val.title + '<input name="test_id" type="hidden" class="test-id" value="' + id + '"></td>';
                //content += '<td style="padding: 3px 25px;"><input type="text" class="quantity form-control input-sm" value="1" onkeyup="getTotal(this, ' + val.price + ')"></td>';
                //content += '<td style="padding: 3px 25px;">' + val.price + '</td>';
                content += '<td style="padding: 3px 25px;" class="total">' + val.price + '</td>';
                content += '<td class="rem"><span class="glyphicon glyphicon-remove" onclick="removeTest(this)" style="color:red"></span></td>';
                content += '</tr>';
                $('.test-list').append(content);

                grand();
            });

            /* enable save button */
            $('.print-now').removeAttr('disabled');
        }

        /****************************/
        function getTestDetails(ctrl) {
            $(ctrl).blur(function () {
                var id = $(ctrl).val();

                var xurl = "{{ url('/get-subcategory') }}/" + id;
                var parent_id = 0;
                $.get(xurl, function (res) {
                    parent_id = res;

                    if (parent_id == 326) {
                        $('.c-doc').removeClass('ninja');

                        var d_url = '{{ url("/get-consulting-doctor") }}/' + id;

                        $.get(d_url, function (res) {
                            var content = '<select class="consulting-doctor-name form-control" id="consulting-doctor-name" style="font-size: 11px;"><option value="0">Select Doctor</option>';
                            $.each(res, function (ind, val) {
                                content += '<option value="' + val.id + '">' + val.first_name + ' ' + val.middle_name + ' ' + val.last_name + '</option>';
                            });
                            content += '</select>';
                            $('.consulting-doctor').html(content);
                        });
                    }
                });

                var url = "{{ url('/getTestPrice') }}";
                var token = "{{ csrf_token() }}";

                $.post(url, {id: id, _token: token}, function (res) {
                    $(ctrl).parent().siblings('.amount').text(res);
                    var qty = $(ctrl).parent().siblings('.qty').text();
                    var rate = res;

                    /* get discount type */
                    var d_type = $('#discount-type').val();
                    if (d_type == 0) {
                        var total = rate * qty;
                        $(ctrl).parent().siblings('.discount').text(0);
                        $(ctrl).parent().siblings('.net-amount').text(total.toFixed(2));

                        /* update grand total */
                        grandTotal(res, 0);
                    } else {
                        var d_url = "{{ url('/getdiscount') }}/" + d_type + '/' + id;
                        $.get(d_url, function (res1) {
                            var dis_per = res1;
                            var dis_amt = ( dis_per / 100 ) * res;
                            var net = res - dis_amt;
                            var total = net * qty;
                            $(ctrl).parent().siblings('.discount').text(dis_amt.toFixed(2));
                            $(ctrl).parent().siblings('.net-amount').text(total.toFixed(2));

                            /* update grand total */
                            grandTotal(net, dis_amt);
                        });
                    }


                });


            });
        }

        function getNetPrice(ctrl) {
            var dis = $(ctrl).val();
            if (dis == '') {
                dis = 0;
            }
            dis = parseFloat(dis);

            var price = parseFloat($(ctrl).parent().siblings('.amount').text());
            var dis_amount = ( dis / 100 ) * price;
            var net_price = price - dis_amount;
            $(ctrl).parent().siblings('.net-amount').text(net_price.toFixed(2));


        }

        function getNetPriceWithQty(ctrl) {
            var qty = $(ctrl).val();
            var price = parseFloat($(ctrl).parent().siblings('.amount').text());
            var net_price = price * qty;
            $(ctrl).parent().siblings('.net-amount').text(net_price.toFixed(2));
            $(ctrl).parent().siblings('.qty').text(qty);

            /*update totalling*/
            var discount = 0;
            var sub_total = 0;
            $('.list-here tr').each(function (index) {
                /* sub-total */
                var stotal = $(this).find('.net-amount').text();
                if (stotal == '') {
                    stotal = 0;
                }
                sub_total += parseFloat(stotal);

                /* discount */
                var dis = $(this).find('.discount').text();
                if (dis == '') {
                    dis = 0;
                }
                discount += parseFloat(dis);
            });
            var hst = ( 0 / 100 ) * sub_total;
            var grand_total = sub_total + hst;
            //discount += dis;
            $('.sub-total').text(parseFloat(sub_total).toFixed(2));
            $('.tot-discount').text(parseFloat(discount).toFixed(2));
            $('.tax-amt').text(parseFloat(hst).toFixed(2));
            $('.grand-total').text(parseFloat(grand_total).toFixed(2));
        }

        function grandTotal(total, dis) {
            /*
            var grand_total = parseFloat($('.grand-total').text());
            grand_total += net_price;
            $('.grand-total').text(grand_total);
            */
            // var sub_total = parseFloat($('.sub-total').text());
            //sub_total += parseFloat(total);
            // var hst = ( 0 / 100 ) * sub_total;
            // var grand_total = sub_total + hst;
            //var discount = parseFloat($('.discount').text());
            var discount = 0;
            var sub_total = 0;
            $('.list-here tr').each(function (index) {
                /* sub-total */
                var stotal = $(this).find('.net-amount').text();
                if (stotal == '') {
                    stotal = 0;
                }
                sub_total += parseFloat(stotal);

                /* discount */
                var dis = $(this).find('.discount').text();
                if (dis == '') {
                    dis = 0;
                }
                discount += parseFloat(dis);
            });
            var hst = ( 0 / 100 ) * sub_total;
            var grand_total = sub_total + hst;
            //discount += dis;
            $('.sub-total').text(parseFloat(sub_total).toFixed(2));
            $('.tot-discount').text(parseFloat(discount).toFixed(2));
            $('.tax-amt').text(parseFloat(hst).toFixed(2));
            $('.grand-total').text(parseFloat(grand_total).toFixed(2));


            /* add another row */
            $('.original:first').clone().appendTo('.list-here').find('.amount, .net-amount, .discount').text('');

            /* enable save button */
            $('.print-now').removeAttr('disabled');
        }

        function removeTest(ctrl) {
            var price = $(ctrl).parent().siblings('.net-amount').text();

            /* update grand total */
            /*
            var sub_total = parseFloat($('.sub-total').text());
            sub_total -= price;
            var hst = ( 0 / 100 ) * sub_total;
            var grand_total = sub_total + hst;
            */

            /* remove row */
            $(ctrl).parent().parent().remove();

            /* remove consulting doctor if ultrasound is removed from the test list */
            var tid = $(ctrl).parent().parent().find('#tests').val();
            if (tid == '327') {
                //alert('c')
                $('.c-doc').addClass('ninja');
            }

            /* grand total */
            var discount = 0;
            var sub_total = 0;
            $('.list-here tr').each(function (index) {
                /* sub-total */
                var stotal = $(this).find('.net-amount').text();
                if (stotal == '') {
                    stotal = 0;
                }
                sub_total += parseFloat(stotal);

                /* discount */
                var dis = $(this).find('.discount').text();
                if (dis == '') {
                    dis = 0;
                }
                discount += parseFloat(dis);
            });
            var hst = ( 0 / 100 ) * sub_total;
            var grand_total = sub_total + hst;

            $('.sub-total').text(sub_total.toFixed(2));
            $('.tot-discount').text(parseFloat(discount).toFixed(2));
            $('.tax-amt').text(hst.toFixed(2));
            $('.grand-total').text(grand_total.toFixed(2));


            /*
            $(ctrl).parent().parent().remove();
            var sub_total = parseFloat($('.sub-total').html()) - price;
            var tax_amount = 0 / 100 * sub_total;
            var grand_total = sub_total + tax_amount;
            $('.sub-total').html(sub_total);
            $('.tax-amt').html(tax_amount);
            $('.grand-total').html(grand_total);
            */

            /**/
            if ($('table.test-list tr').length == 1) {
                $('.print-now').attr('disabled', 'disabled');
            }
        }

        function removeEmptyRows() {
            $('.list-here tr').each(function () {
                var vx = $(this).find('#tests').val();
                if (vx == '0') {
                    $(this).remove();
                }
            });
        }
    </script>

    <script type="text/javascript">

        function enableButton() {
            $('#button').removeAttr('disabled');
        }


    </script>

    <style>
        .nopadding {
            padding: 0 !important;
            margin: 0 !important;
        }

        input.quantity {
            width: 80px;
            color: #000;
        }

        .spacer {
            clear: both;
            padding: 10px 0;
        }

        @media print {
            input,
            textarea {
                border: none !important;
                box-shadow: none !important;
                outline: none !important;
            }

            .patient-test-select-box {
                border: none;
                -webkit-appearance: none;
                -ms-appearance: none;
                appearance: none;
            }
        }
    </style>



@endsection