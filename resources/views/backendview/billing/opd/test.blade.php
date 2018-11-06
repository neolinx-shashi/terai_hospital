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
            border: none; /* If you want to remove the border as well */
            background: none;
        }
    </style>
    <section class="content-header">
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
                            <!-- <div class="logo text-center">

                                <div class="logo-area-text">
                                    <h4 style="font-size: 11px; margin: 0;">Terai Hospital & Research Centre Pvt.
                                        Ltd.</h4>
                                    <span>Padam Road, Birgunj</span>
                                    <span>Reg No.: 80071/067-68 / PAN No: 601240803</span>
                                    <p>Ph: 051-525252</p>

                                    <span style="font-size: 11px; text-align: center;   ">Pathology/Test</span>
                                </div>

                            </div> -->
                            <div class="body" style="margin-top: 30px; ">
                                <div class="create-test-left" style=" float: left; width: 45%;">
                                    <strong>Patient Code:</strong>
                                    <div class="input-group">

                                        <span class="input-group-addon" id="basic-addon1"
                                              style="padding: 6px 1px 6px 1px;font-size: 11px;border: 1px solid #999;border-radius: 0px !important;   font-weight: 800;background: #eee;cursor: none;">TH-</span>
                                        <input name="patient_code" id="patient-code" type="text" style="width: 144px;"/>
                                        <input name="patient_id" class="patient_id" type="hidden">
                                        <input name="pid" class="pid" type="hidden" value="{{ $pId }}">
                                    </div>

                                    <div class="spacer"></div>

                                    <strong>Patient Name: <a style="color: #ff0000;">*</a></strong>
                                    <div class="input-group">
                                        <input class="patient-name form-control fld" type="text" id="name" name="name">
                                    </div>
                                    <div class="spacer"></div>

                                    <strong>Address: <a style="color: #ff0000;">*</a></strong>
                                    <div class="input-group">
                                        <input class="patient-address form-control fld" type="text" id="address"
                                               name="address">
                                    </div>

                                    <div class="spacer"></div>

                                    <strong>Referral Doctor: <a style="color: #ff0000;">*</a></strong>
                                    <div class="input-group">
                                        <select class="doctor-name form-control" id="doctor"
                                                style="font-size: 11px;min-width: 169px;">
                                            <option value="0">Choose a doctor</option>
                                            @foreach ($doctors as $val)
                                                <option value="{{ $val->id }}">{{ ucfirst($val->first_name) }} {{{ $val->middle_name or '' }}} {{ ucfirst($val->last_name) }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="spacer"></div>
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


                                <div class="create-test-right" style="float: right; width: 45%;">
                                    <strong style="float: left; width: 24%;">Age: <a
                                                style="color: #ff0000;">*</a></strong>
                                    <input class="patient-age fld" type="text" id="age">


                                    <div class="spacer"></div>

                                    <strong style="float: left; width: 24%;">Gender: <a
                                                style="color: #ff0000;">*</a></strong>
                                    <div class="input-group">
                                        <select class="patient-gender form-control fld" id="gender"
                                                style="font-size: 11px;min-width: 147px;">
                                            <option value="0">Select Gender</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                            <option value="Others">Other</option>
                                        </select>
                                    </div>


                                    {{--<div class="col-md-8"><input class="patient-gender fld" type="text"></div>--}}

                                    <div class="spacer"></div>

                                    <strong style="float: left; width: 24%;">Phone: <a
                                                style="color: #ff0000;">*</a></strong><input class="patient-phone fld"
                                                                                             type="text" id="phone">
                                    <div class="spacer"></div>
                                    <strong style="float: left; width: 24%;">Date: </strong><span
                                            style="font-size: 11px;border: 1px solid #999;padding: 10px 47px; background: #eee;""> {{ getTodayNepaliDate() }}</span>

                                    <div class="spacer"></div>

                                    <strong style="float: left; width: 24%;" class="c-doc ninja">Consulting Doctor: <a
                                                style="color: #ff0000;">*</a></strong>
                                    <div class="input-group c-doc ninja consulting-doctor">
                                        <select class="consulting-doctor-name form-control" id="consulting-doctor-name"
                                                style="font-size: 11px;">
                                            <option value="0">Choose a doctor</option>
                                        </select>
                                    </div>
                                </div>

                            <!-- <div class="col-md-3">
                                    <div class="col-md-4"><strong>Date: </strong></div>
                                    <div class="col-md-8">{{ $today }}</div>
                                    {{--<p><strong>Invoice No:</strong> {{$patient->patient_code.'-'. $patient->id}}</p>--}}

                                    </div> -->
                            </div>
                            <br class="all">
                            <div class="spacer"></div>
                        <!--
                            <div class="col-md-12 nopadding test-select">
                                <div class="col-md-1 nopadding" style="text-align: left;"><strong>Tests: <a
                                                style="color: #ff0000;">*</a></strong>
                                </div>
                                
                                <div class="col-md-3">
                                    <select id="test-category" class="form-control">
                                        <option value="0">Select Category</option>
                                        @foreach ($test_category as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->title }}</option>
                                        @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 subcat-test">
                                <select id="test-subcategory" class="form-control" disabled="disabled">
                                    <option value="0">Select Sub Category</option>
                                </select>
                            </div>

                            <div class="col-md-4 test-area">
                                <select id="test" class="form-control" disabled="disabled">
                                    <option value="0">Select Test</option>
                                </select>
                            </div>


                             <div class="col-md-3 test-area">
                                <select id="tests" class="form-control" onchange="getTestDetail()">
                                    <option value="0">Select Test</option>
@foreach ($tests as $val)
                            <option value="{{ $val->id }}">{{ $val->title }}</option>
                                        @endforeach
                                </select>
                            </div>

                            <div class="col-md-4">
                                <input class="fomr-control" id="test-name" />
                            </div>

                            <div class="col-md-4 test-list-here">

                            </div>
                        </div>
-->
                            <br clear="all"> <br>
                            <div class="table">
                                <div class="table-body">
                                    <table border="1" style="width: 100%" class="test-list">
                                        <tr class="first-row">
                                            <!-- <td style="padding: 3px 25px;">Item Code</td> -->
                                            <td style="padding: 3px 25px;">Item Description</td>
                                            <!-- <td style="padding: 3px 25px;">Quantity</td> -->
                                            <td style="padding: 3px 25px;">Amount (Rs.)</td>
                                            <td style="padding: 3px 25px;">Discount (Rs.)</td>
                                            <td style="padding: 3px 25px;">Net Amount (Rs.)</td>
                                            <td class="rem" style="width: 100px;text-align: center;">Remove</td>
                                        </tr>
                                        <tbody class="list-here">
                                        <tr class="original">
                                            <td>
                                                <select id="tests" class="form-control" onchange="getTestDetails(this)">
                                                    <option value="0">Select Test</option>
                                                    @foreach ($tests as $val)
                                                        <option value="{{ $val->id }}">{{ $val->title }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td class="amount"></td>
                                            <td class="discount">
                                                <!--<input class="form-control discount_per" type="text" placeholder="%" onblur="getNetPrice(this)" />--></td>
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
                                        {{--                                            <p >{{strtoupper($patient->belongsToUser->fullname)}}</p><strong style="border-top:1px dotted #444;">RECEIVED BY</strong>--}}
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

                                        <tr style="display: none">
                                            <td style="padding: 3px 25px;">HST <span class="tax">0</span>%</td>
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
                    <button id="button" class="btn btn-primary print-now" onclick="printContent('printCertificate')"
                            disabled>
                        Save and Continue
                    </button>
                </div>
            </div>
        </div>
    </section>

    <script src="{{URL::asset('backendtheme/plugins/jQuery/jQuery-2.1.4.min.js')}}"></script>

    <script>


        /*$(document).ready(function () {
            if ($("#name").val() == '' || $("#address").val() == '' || $("#doctor").val() == '0' ||
                $("#age").val() == '' || $("#phone").val() == '' || $("#gender").val() == '0' ||
                $("#test-category").val() == '0' || $("#test-subcategory").val() == '0' || $("#test").val() == '0')

                $(button).attr('disabled', 'disabled')
        });*/

        $('#name').bind('keyup click blur change', function (e) {
            if ($("#name").val() == '')
            /*$(button).attr('disabled', 'disabled'),*/
                document.getElementById("name").style.borderColor = "red"
            else /*$(button).removeAttr('disabled'),*/
                document.getElementById("name").style.borderColor = "green"

            /*if ($("#name").val() == '' || $("#address").val() == '' || $("#doctor").val() == '0' ||
                $("#age").val() == '' || $("#phone").val() == '' || $("#gender").val() == '0' ||
                $("#test-category").val() == '0' || $("#test-subcategory").val() == '0' || $("#test").val() == '0')
                $(button).attr('disabled', 'disabled')
            else $(button).removeAttr('disabled')*/
        });

        $('#address').bind('keyup click blur', function (e) {
            if ($("#address").val() == '')
            /*$(button).attr('disabled', 'disabled'),*/
                document.getElementById("address").style.borderColor = "red"
            else /*$(button).removeAttr('disabled'),*/
                document.getElementById("address").style.borderColor = "green"
        });

        $('#doctor').bind('click blur', function (e) {
            if ($("#doctor").val() == '0')
            /*$(button).attr('disabled', 'disabled'),*/
                document.getElementById("doctor").style.borderColor = "red"
            else /*$(button).removeAttr('disabled'),*/
                document.getElementById("doctor").style.borderColor = "green"
        });

        $('#age').bind('keyup click blur', function (e) {
            if ($("#age").val() == '')
            /*$(button).attr('disabled', 'disabled'),*/
                document.getElementById("age").style.borderColor = "red"
            else /*$(button).removeAttr('disabled'),*/
                document.getElementById("age").style.borderColor = "green"
        });

        $('#phone').bind('keyup click blur', function (e) {
            if ($("#phone").val() == '')
            /*$(button).attr('disabled', 'disabled'),*/
                document.getElementById("phone").style.borderColor = "red"
            else /*$(button).removeAttr('disabled'),*/
                document.getElementById("phone").style.borderColor = "green"
        });

        $('#gender').bind('click blur', function (e) {
            if ($("#gender").val() == '0')
            /*$(button).attr('disabled', 'disabled'),*/
                document.getElementById("gender").style.borderColor = "red"
            else /*$(button).removeAttr('disabled'),*/
                document.getElementById("gender").style.borderColor = "green"
        });

        $('#test-category').bind('blur', function (e) {
            if ($("#test-category").val() == '0')
            /*$(button).attr('disabled', 'disabled'),*/
                document.getElementById("test-category").style.borderColor = "red"
            else /*$(button).removeAttr('disabled'),*/
                document.getElementById("test-category").style.borderColor = "green"
        });

        $('#test_subcat').bind('click blur', function (e) {
            //alert(("#test_subcat").val())
            if ($('#test_subcat').val() == '0')
            /*$(button).attr('disabled', 'disabled'),*/
                document.getElementById("test_subcat").style.borderColor = "red"
            else /*$(button).removeAttr('disabled'),*/
                document.getElementById("test_subcat").style.borderColor = "green"
        });

        $('#tests').bind('click blur', function (e) {
            if ($("#tests").val() == '0')
            /*$(button).attr('disabled', 'disabled'),*/
                document.getElementById("tests").style.borderColor = "red"
            else /*$(button).removeAttr('disabled'),*/
                document.getElementById("tests").style.borderColor = "green"
        });

        if ($("#address").val() == '')
        /*function OpenDialog1() {
       $(button).attr('disabled', 'disabled'),
       document.getElementById("address").style.borderColor = "red"
       else $(button).removeAttr('disabled'),
       document.getElementById("address").style.borderColor = "green"
       }*/

            function printContent(el) {

                /*var restorepage = document.body.innerHTML;
                 var printcontent = document.getElementById(el).innerHTML;
                 document.body.innerHTML = printcontent;
                 window.print();
                 document.body.innerHTML = restorepage;*/

                if ($("#name").val() == '' || $("#address").val() == '' || $("#doctor").val() == '0' ||
                    $("#age").val() == '' || $("#phone").val() == '' || $("#gender").val() == '0' || $("#tests").val() == '0') {
                    alert('Fields with astericks (*) are mandatory!');
                } else if (!$('.c-doc').hasClass('ninja') && $('#consulting-doctor-name').val() == 0) {
                    alert('Fields with astericks (*) are mandatory!');
                } else {
                    /*to avoid double click*/
                    $('.print-now').attr('disabled', 'disabled');
                    /* remove empty row */
                    removeEmptyRows();

                    var consulting_charge = 0;
                    $('.list-here .ultra').each(function (index) {
                        var charge = $(this).find('.net-amount').text();
                        consulting_charge += parseFloat(charge);
                    });

                    /* insert in table */
                    var p_url = '{{ url("patient-bill-save") }}';
                    var token = "{{csrf_token()}}";
                    var pid = $('.patient_id').val();
                    var total = '';
                    var tid = '';
                    var ind_dis = '';
                    $('.list-here tr').each(function () {
                        var t = parseFloat($(this).find('.net-amount').html());
                        var id = $(this).find('#tests').val();
                        var idis = parseFloat($(this).find('.discount').text());
                        if (!isNaN(t)) {
                            total += '-' + t;
                            tid += '-' + id;
                            ind_dis += '-' + idis;
                        }
                    });
                    var price = total.substr(1);
                    var test_id = tid.substr(1);
                    var test_discount = ind_dis.substr(1);
                    var stotal = $('.sub-total').html();
                    var tax = $('.tax-amt').html();
                    var dis = $('.discount-amount').val();
                    var discount = $('.tot-discount').html();
                    var gtotal = $('.grand-total').html();

                    /* patient personal detail */
                    var name = $('.patient-name').val();
                    var age = $('.patient-age').val();
                    var address = $('.patient-address').val();
                    var gender = $('.patient-gender').val();
                    var phone = $('.patient-phone').val();
                    var code = 'TH-' + $('#patient-code').val();
                    var doc_id = $('.doctor-name').val();
                    var con_doc_id = $('.consulting-doctor-name').val();

                    $.post(p_url, {
                        _token: token,
                        pid: pid,
                        doc_id: doc_id,
                        test_id: test_id,
                        price: price,
                        test_discount: test_discount,
                        stotal: stotal,
                        tax: tax,
                        gtotal: gtotal,
                        name: name,
                        age: age,
                        address: address,
                        gender: gender,
                        phone: phone,
                        code: code,
                        discount: discount,
                        con_doc_id: con_doc_id,
                        con_doc_rate: consulting_charge
                    }, function (res) {
                        console.log(res);
                        window.location = '/test-invoice/' + res + '/orig';
                    });
                }
            }

        $(function () {
            $('#patient-code').bind('keyup', function (e) {
                var code = 'TH-' + $(this).val();
                var url = '{{ url("/patient-detail") }}/' + code;
                $.get(url, function (res) {
                    if (res.length == 0) {
                        $('.fld').val('');
                        $('.patient_id').val('');
                    } else {
                        $.each(res, function (ind, val) {
                            var fname = val.first_name;
                            if (val.middle_name !== null)
                                fname += ' ' + val.middle_name;
                            fname += ' ' + val.last_name;
                            $('.patient-name').val(fname);
                            $('.patient-address').val(val.permanent_address);
                            //$('.doctor-name').val(val.dfn + ' ' + val.dmn + ' ' + val.dln);
                            $('.patient-age').val(val.age);
                            $('.patient-gender').val(val.gender);
                            $('.patient-phone').val(val.phone);
                            $('.patient_id').val(val.id);

                            var doc_id = val.doctor_id;
                            //$('.doctor-name option:contains("' + doc_id + '")').attr('selected', 'selected');
                        });
                    }
                });
            });

            /* get subcat */
            $('#test-category').change(function () {
                $('.c-doc').addClass('ninja');
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

            /* show consulting doctor if tid is of ultra sound */
            if (sid === '180') {
                //alert('a')
                $('.c-doc').removeClass('ninja');
                var d_url = '{{ url("/get-consulting-doctor") }}/' + sid;

                $.get(d_url, function (res) {
                    var content = '<select class="consulting-doctor-name form-control" id="consulting-doctor-name" style="font-size: 11px;"><option value="0">Select Doctor</option>';
                    $.each(res, function (ind, val) {
                        content += '<option value="' + val.id + '">' + val.first_name + ' ' + val.middle_name + ' ' + val.last_name + '</option>';
                    });
                    content += '</select>';
                    $('.consulting-doctor').html(content);
                });
            } else {
                $('.c-doc').addClass("ninja");
            }
            /**/

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
            var tax_rate = (tax / 100 * amt_after_dis);
            var grand_total = amt_after_dis + tax_rate;

            $('.sub-total').html(amount.toFixed(2));
            $('.tax-amt').html(tax_rate.toFixed(2));
            $('.grand-total').html(grand_total.toFixed(2));
        }

        /*
        function removeTest(ctrl) {
            var price = $(ctrl).parent().siblings('.total').html();
            $(ctrl).parent().parent().remove();
            var sub_total = parseFloat($('.sub-total').html()) - price;
            var tax_amount = 5 / 100 * sub_total;
            var grand_total = sub_total + tax_amount;
            $('.sub-total').html(sub_total);
            $('.tax-amt').html(tax_amount);
            $('.grand-total').html(grand_total);

            if ($('table.test-list tr').length == 1) { 
                $('.print-now').attr('disabled', 'disabled');
            }
        }
        */


        function getDiscount() {
            var dis = $('.discount-amount').val();
            grand(dis);
        }

        $(".print-now").on("click", function () { //the print button has the class .print-now
            event.preventDefault(); // prevent normal button action 
            //$('.form-control').removeClass('form-control'); // remove the form-control class
            // window.print(); // print the page
            //$('input').addClass('form-control'); // return the class after printing
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

                    if (parent_id == 179) {
                        $('.c-doc').removeClass('ninja');
                        $(ctrl).parent().parent().addClass('ultra');

                        var d_url = '{{ url("/get-consulting-doctor") }}/' + id;

                        $.get(d_url, function (res) {
                            var content = '<select class="consulting-doctor-name form-control" id="consulting-doctor-name" style="font-size: 11px;"><option value="0">Select Doctor</option>';
                            $.each(res, function (ind, val) {
                                content += '<option value="' + val.id + '">' + val.first_name + ' ' + val.middle_name + ' ' + val.last_name + '</option>';
                            });
                            content += '</select>';
                            $('.consulting-doctor').html(content);
                        });
                    } else {
                        $(ctrl).parent().parent().removeClass('ultra');
                    }
                });

                var url = "{{ url('/getTestPrice') }}";
                var token = "{{ csrf_token() }}";

                $.post(url, {id: id, _token: token}, function (res) {
                    $(ctrl).parent().siblings('.amount').text(res);

                    /* get discount type */
                    var d_type = $('#discount-type').val();
                    if (d_type == 0) {
                        $(ctrl).parent().siblings('.discount').text(0);
                        $(ctrl).parent().siblings('.net-amount').text(res);

                        /* update grand total */
                        grandTotal(res, 0);
                    } else {
                        var d_url = "{{ url('/getdiscount') }}/" + d_type + '/' + id;
                        $.get(d_url, function (res1) {
                            var dis_per = res1;
                            var dis_amt = (dis_per / 100) * res;
                            var net = res - dis_amt;
                            $(ctrl).parent().siblings('.discount').text(dis_amt.toFixed(2));
                            $(ctrl).parent().siblings('.net-amount').text(net.toFixed(2));

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
            var dis_amount = (dis / 100) * price;
            var net_price = price - dis_amount;
            $(ctrl).parent().siblings('.net-amount').text(net_price.toFixed(2));


        }

        function grandTotal(total, dis) {
            /*
            var grand_total = parseFloat($('.grand-total').text());
            grand_total += net_price;
            $('.grand-total').text(grand_total);
            */
            // var sub_total = parseFloat($('.sub-total').text());
            //sub_total += parseFloat(total); 
            // var hst = ( 5 / 100 ) * sub_total;
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
            var hst = (0 / 100) * sub_total;
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
            var hst = ( 5 / 100 ) * sub_total;
            var grand_total = sub_total + hst;
            */

            /* remove row */
            $(ctrl).parent().parent().remove();

            /* remove consulting doctor if ultrasound is removed from the test list */
            var tid = $(ctrl).parent().parent().find('#tests').val();
            if (tid == '180') {
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
            var hst = (0 / 100) * sub_total;
            var grand_total = sub_total + hst;

            $('.sub-total').text(sub_total.toFixed(2));
            $('.tot-discount').text(parseFloat(discount).toFixed(2));
            $('.tax-amt').text(hst.toFixed(2));
            $('.grand-total').text(grand_total.toFixed(2));


            /*
            $(ctrl).parent().parent().remove();
            var sub_total = parseFloat($('.sub-total').html()) - price;
            var tax_amount = 5 / 100 * sub_total;
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

    <style>
        .nopadding {
            padding: 0 !important;
            margin: 0 !important;
        }

        input.quantity {
            width: 80px;
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

        #test-name {
            font-weight: normal;
        }

        .test-list-here {
            font-size: 12px;
            font-weight: normal;
        }

        .test-list-here ul li {
            text-decoration: none;
            background: #CCC;
            list-style-type: none;
            margin: 1px 0;
        }
    </style>
@endsection