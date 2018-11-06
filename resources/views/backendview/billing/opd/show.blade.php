@extends('backendlayout.master')
@extends('backendlayout.header')
@extends('backendlayout.leftmenu')
@extends('backendlayout.footer')
@section('userscontent')
    @extends('backendlayout.flashmessagecollection')
    <script src="{{URL::asset('backendtheme/plugins/jQuery/jQuery-2.1.4.min.js')}}"></script>
    <div class="search-breadcrumb">
        <div class="row">
            <div class="col-lg-6">
                <!-- <div class="search input-group">
                    <span class="input-group-addon" style="color: white; background-color: #f39c12;">SEARCH PATIENT</span>
                    <input type="text" autocomplete="off" id="search" class="form-control input-lg" placeholder="Patient code/Name/contact number">
                </div> -->
            </div>

            <div class="col-lg-6">
                <ol class="breadcrumb">
                    <li><a href="{{url('dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                    <li><a href="{{URL('configuration/patient/create')}}">Create Patient</a></li>
                    <li class="active">View Patient</li>
                </ol>
            </div>
        </div>
    </div>
    <div id="txtHint" class="title-color" style="padding-top:10px; "></div>
    <script>
        $(document).ready(function () {
            $("#search").keyup(function () {
                var str = $("#search").val();
                if (str == "") {
                    $("#txtHint").html("");
                    $('.content').show();
                } else {
                    $.get("{{ url('renew/patient?id=') }}" + str, function (data) {
                        $("#txtHint").html(data);
                        $('.content').hide();
                        $('.content-header').hide();
                    });
                }
            });
        });
    </script>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">
                            @if(Auth::user()->user_type_id=='6')
                            @else
                                <a href="{{URL('configuration/patient/create')}}" class="btn btn-default btn-flat"><i
                                            class="fa fa-arrow-left"></i> Back</a>

                                <a href="{{ URL::to('configuration/patient/' . $patient->id . '/edit') }}"
                                   class="btn btn-primary  btn-flat"><i class="fa fa-edit"></i> Edit Information</a>
                            @endif
                        </h3>

                        <div class="box-tools">
                            <div class="input-group">

                            </div>
                        </div>

                    </div>

                    <div class="box-body table-responsive">

                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#tab_1" data-toggle="tab">Personal Information</a></li>
                                <li class=""><a href="#tab_2" data-toggle="tab">Contact Information</a></li>
                                @if(Auth::user()->user_type_id=='3')
                                @else
                                    <li class=""><a href="#tab_3" data-toggle="tab">Other Information</a></li>
                                @endif
                            </ul>

                            <div class="tab-content">
                                <div class="tab-pane active" id="tab_1">
                                    <table cellpadding="3" cellspacing="3" align="center" width="100%">
                                        <tbody>
                                        <tr>
                                            <td width="15%">Patient Code:</td>
                                            <td width="40%"><strong>{{$patient->patient_code}}</strong></td>

                                        </tr>
                                        <tr>
                                            <td width="5%">Full Name:</td>
                                            <td width="40%">{{ucfirst($patient->first_name)}}</td>

                                        </tr>

                                        <tr>
                                            <td width="5%">Age:</td>
                                            <td width="40%">{{$patient->age}} <strong>YRS</strong> {{$patient->gender}}
                                            </td>

                                        </tr>


                                        </tr>
                                        <tr>
                                            <td width="5%">Nationality:</td>
                                            <td width="40%">{{ucfirst($patient->isOfNationality->country_name)}}</td>

                                        </tr>


                                        </tbody>
                                    </table>
                                </div>

                                <div class="tab-pane" id="tab_2">
                                    <table cellpadding="3" cellspacing="3" align="center" width="100%">
                                        <tbody>

                                        <tr>
                                            <td width="21%">Phone/Mobile:</td>
                                            <td width="79%">{{$patient->phone}}</td>
                                        </tr>

                                        </tr>
                                        <tr>
                                            <td width="5%">Address:</td>
                                            <td width="40%">{{ucfirst($patient->permanent_address)}}</td>

                                        </tr>


                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane" id="tab_3">
                                    <table cellpadding="3" cellspacing="3" align="center" width="100%">
                                        <tbody>

                                        <tr>
                                            <td width="21%">Fiscal Year:</td>
                                            <td width="79%">
                                                <strong>{{$patient->getCurrentFiscalYear->fiscal_year_start_date}}</strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="21%">Department Name:</td>
                                            <td width="79%">{{ucfirst($patient->isInDepartment->name)}}</td>
                                        </tr>
                                        <tr>
                                            <td>Consulted With:</td>
                                            <td>{{ucfirst($patient->isConsultedToDoctor->first_name)}}
                                                {{ucfirst($patient->isConsultedToDoctor->middle_name)}}
                                                {{ucfirst($patient->isConsultedToDoctor->last_name)}}</td>
                                        </tr>


                                        <tr>
                                            <td>Doctor Fee:</td>
                                            <td>Rs .{{$patient->doctor_fee}}</td>
                                        </tr>

                                        <tr>
                                            <td>Discount @ {{$patient->discount_percent}} %:</td>
                                            <td>Rs .{{round($patient->discounted_fee_value)}}</td>
                                        </tr>

                                        <tr>
                                            <td>Doctor Fee With Tax:</td>
                                            <td>Rs .<strong>{{round($patient->doctor_fee_with_tax,2)}}</strong>
                                                <br>
                                                <strong>In
                                                    Words</strong>:&nbsp;{{convert_number_to_words(round($patient->doctor_fee_with_tax,2))}}
                                                Only
                                            </td>
                                        </tr>


                                        <tr>
                                            <td>Appointment Date:</td>
                                            <td>
                                                {{getTodayNepaliDate()}}
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>Last Updated On:</td>
                                            <td><?php
                                                $todayDate = date('Y-m-d', strtotime($patient->updated_at));
                                                $localDate = str_replace("-", ",", $todayDate);
                                                $classes = explode(",", $localDate);
                                                $a = $classes[0];
                                                $b = $classes[1];
                                                $c = $classes[2];
                                                echo eng_to_nep($a, $b, $c);
                                                echo '&nbsp';
                                                echo date('h:i A', strtotime($patient->created_at));
                                                ?></td>
                                        </tr>

                                        <tr>
                                            <td>Created By:</td>
                                            <td><strong>{{ucwords($patient->belongsToUser->fullname)}}</strong></td>
                                        </tr>


                                        <tr>
                                            <td>Description:</td>
                                            <td>{{ucwords($patient->symptoms)}}
                                            </td>
                                        </tr>

                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>

                    </div>
                    <div class="box-footer clearfix">

                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

