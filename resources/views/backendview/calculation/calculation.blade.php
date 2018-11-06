@extends('backendlayout.master')
@extends('backendlayout.header')
@extends('backendlayout.leftmenu')
@extends('backendlayout.footer')
@section('userscontent')
    @extends('backendlayout.flashmessagecollection')
    <script src="{{URL::asset('backendtheme/plugins/jQuery/jQuery-2.1.4.min.js')}}"></script>
    <link rel="stylesheet" type="text/css"
          href="{{URL::asset('backendtheme/lib/nepali.datepicker.v2/css/bootstrap.min.css')}}"/>
    <link rel="stylesheet" type="text/css"
          href="{{URL::asset('backendtheme/lib/nepali.datepicker.v2/nepali.datepicker.v2.min.css')}}"/>
    <style type="text/css">
        .dataTables_paginat {
            margin: 0;
            white-space: nowrap;
            text-align: right;
            display: block;
        }

        #revenue input[type="text"], #revenue1 input[type="text"], #revenue2 input[type="text"], #revenue3 input[type="text"] {
            color: #000;
            width: 100%;
        }

        .modal-dialog {
            color: #000;
        }

        .modal-dialog td {
            background: none !important;
            color: #000 !important;
        }

        .box-body {
            padding: 0px;
        }

        tr:hover td {
            color: #fff !important;
        }

        /*#revenue_wrapper input[type="text"] {
            width: 100%;
        }*/
        a.gererate_excell {
            display: block;
            padding: 10px;
            color: #fff;
            background: #3c8dbc;
            margin-bottom: 10px;
            width: 330px;
        }

        select#daterange {
            height: 35px;
        }
    </style>
    <!--     <script src="{{URL::asset('backendtheme/plugins/jQuery/jQuery-2.1.4.min.js')}}"></script>
 -->
    <section class="content-header">
        <h1>
            {{$title}}
        </h1>
    </section>






    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">


                    <div class="col-md-12" style="padding: 10px 0 10px 0">
                        <form action="{{ url('/revenue/calculation/by-date') }}" method="post"
                              name="formuser" {{--onchange="formuser.submit()"--}}>
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            <div class="col-md-3">
                                <div class="input-group">
                                    <span class="input-group-addon">From</span>
                                    <input name="date_from" type="text" class="form-control"
                                           id="datefrom" value="{{$currentDate}}">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="input-group">
                                    <span class="input-group-addon">To</span>
                                    <input name="date_to" type="text" id="dateto" class="form-control"
                                           value="{{$currentDate}}"
                                    >
                                </div>
                            </div>

                            <div class="col-md-2">
                                <input name="submit" type="submit" class="btn btn-primary" value="Search">
                            </div>
                        </form>

                        <div>
                            <label for="daterange">Filter By:
                            </label>
                            <select name="revenue-range" id="daterange" onchange="location = this.value;">
                                <option value="">Date Range</option>
                                <option value="/revenue/calculation" @if(old('daterange')=='/revenue/calculation') <?php echo 'selected' ?> @endif>
                                    Today
                                </option>
                                <option value="/revenue/calculation/this-week" @if(old('daterange')=='/revenue/calculation/this-week') <?php echo 'selected' ?> @endif>
                                    This Week
                                </option>
                                <option value="/revenue/calculation/this-month" @if(old('daterange')=='/revenue/calculation/this/month') <?php echo 'selected' ?> @endif>
                                    This Month
                                </option>
                                <option value="/revenue/calculation/this-year" @if(old('daterange')=='/revenue/calculation/this-year') <?php echo 'selected' ?> @endif>
                                    This Year
                                </option>
                            </select>
                        </div>


                    </div>

                    <div class="box-body">

                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#opd">OPD Patients</a>

                                </li>
                                <li><a data-toggle="tab" href="#emr">Emergency Patients</a></li>
                                <li><a data-toggle="tab" href="#ipd">IPD Patients</a></li>
                                <li><a data-toggle="tab" href="#test">Test/Pathology Patients</a></li>
                            </ul>

                            <div class="tab-content">
                                <div id="opd" class="tab-pane fade in active">
                                    @if($reportData=='customsearch')
                                        <a href="{{url('revenue/report/custom-search/opd',$reportData.'/'.$from.'/'.$to)}}"
                                           class="gererate_excell">Generate Report OPD {{$reportData}}<i
                                                    class="fa fa-download" style="float: right; line-height: 20px;"></i></a>
                                    @else
                                        <a href="{{url('revenue/report/opd',$reportData)}}" class="gererate_excell">Generate
                                            Report {{$reportData}}<i class="fa fa-download"
                                                                     style="float: right; line-height: 20px;"></i></a>
                                    @endif
                                    @if(count($patients)>0)
                                        <table id="revenue" class="table table-hover table-bordered table-striped">

                                            <thead>
                                            <tr>
                                                <td class="col-md-2">Patient's Name/ Code</td>
                                                <td class="col-md-2">Doctor's Name</td>
                                                <td class="col-md-2">Created By</td>
                                                <td class="col-md-1">Doctor Fee</td>
                                                <td class="col-md-1">HST 5%</td>
                                                <td class="col-md-1">Amount (In Rs)</td>
                                            </tr>
                                            </thead>

                                            <thead>
                                            <tr>

                                                <th class="col-md-2">Patient's Name/ Code</th>
                                                <th class="col-md-2">Doctor's Name</th>
                                                <th class="col-md-2">Created By</th>
                                                <th class="col-md-1">Doctor Fee</th>
                                                <th class="col-md-1">HST 5%</th>
                                                <th class="col-md-1">Amount (In Rs)</th>
                                            </tr>
                                            </thead>

                                            <tfoot>
                                            <tr>

                                                <th class="col-md-2">Patient's Name/ Code</th>
                                                <th class="col-md-2">Doctor's Name</th>
                                                <th class="col-md-2">Created By</th>
                                                <th class="col-md-1">Doctor Fee</th>
                                                <th class="col-md-1">HST 5%</th>
                                                <th class="col-md-1">Amount (In Rs)</th>
                                            </tr>
                                            </tfoot>

                                            <tbody>
                                            @foreach($patients as $key=>$patientData)
                                                <tr>


                                                    <td>
                                                        {{ucfirst($patientData->first_name)}}
                                                        {{ucfirst($patientData->middle_name)}}
                                                        {{ucfirst($patientData->last_name)}}
                                                        <br>
                                                        <strong>{{$patientData->patient_code}}</strong>
                                                    </td>

                                                    <td>
                                                        Dr.
                                                        {{ucfirst($patientData->isConsultedToDoctor->first_name)}}
                                                        {{ucfirst($patientData->isConsultedToDoctor->middle_name)}}
                                                        {{ucfirst($patientData->isConsultedToDoctor->last_name)}}
                                                    </td>

                                                    {{--<td>
                                                       
                                                       {{$patientData->appointment}}
                                                    </td>--}}

                                                    <td>
                                                        {{$patientData->belongsToUser->fullname}}
                                                        <br>
                                                        <?php
                                                        $todayDate = date('Y-m-d', strtotime($patientData->created_at));
                                                        $localDate = str_replace("-", ",", $todayDate);
                                                        $classes = explode(",", $localDate);
                                                        $a = $classes[0];
                                                        $b = $classes[1];
                                                        $c = $classes[2];
                                                        echo eng_to_nep($a, $b, $c);
                                                        echo '&nbsp';
                                                        echo date('h:i A', strtotime($patientData->created_at));
                                                        ?>
                                                    </td>

                                                    <td>
                                                        {{ $patientData->doctor_fee }}
                                                    </td>

                                                    <td>
                                                        {{ round($patientData->doctor_tax_only,2) }}
                                                    </td>

                                                    <td>
                                                        {{$patientData->doctor_fee_with_tax}}
                                                    </td>
                                                </tr>

                                            @endforeach
                                            </tbody>
                                        </table>

                                    @else
                                        <div class="alert alert-danger">
                                            <strong style="padding-left: 300px"> Sorry ! No record found
                                            </strong>
                                        </div>
                                    @endif
                                </div>


                                <div id="emr" class="tab-pane fade">

                                    @if($reportData=='customsearch')
                                        <a href="{{url('revenue/report/custom-emergency/by-date',$reportData.'/'.$from.'/'.$to)}}"
                                           class="gererate_excell">Generate Report Emergency {{$reportData}}<i
                                                    class="fa fa-download" style="float: right; line-height: 20px;"></i></a>
                                    @else
                                        <a href="{{url('revenue/report/emergency',$reportData)}}"
                                           class="gererate_excell">Generate Report Emergency {{$reportData}}<i
                                                    class="fa fa-download" style="float: right; line-height: 20px;"></i></a>
                                    @endif
                                    @if(count($ePatients)>0)
                                        <table id="revenue3" class="table table-hover table-bordered table-striped">
                                            <thead>
                                            <tr>
                                                <td class="col-lg-2">Patient's Name/ Code</td>
                                                <td class="col-lg-2">Admitted/ Discharged Date</td>
                                                <td class="col-lg-2">Ward/Room/Bed</td>
                                                <td class="col-lg-2">Emergency Charge/HST 5%</td>
                                                <td class="col-lg-1">Emergency Item Charge/HST 5%</td>
                                                <td class="col-lg-1">Amount (In Rs.)</td>
                                            </tr>
                                            </thead>

                                            <thead>
                                            <tr>
                                                <th class="col-lg-2">Patient's Name/ Code</th>
                                                <th class="col-lg-2">Admitted/ Discharged Date</th>
                                                <th class="col-lg-2">Ward/Room/Bed</th>
                                                <th class="col-lg-2">Emergency Charge/HST 5%</th>
                                                <th class="col-lg-1">Emergency Item Charge/HST 5%</th>
                                                <th class="col-lg-1">Amount (In Rs.)</th>
                                            </tr>
                                            </thead>

                                            <tfoot>
                                            <tr>
                                                <th class="col-lg-2">Patient's Name/ Code</th>
                                                <th class="col-lg-2">Admitted/ Discharged Date</th>
                                                <th class="col-lg-2">Ward/Room/Bed</th>
                                                <th class="col-lg-2">Emergency Charge/HST 5%</th>
                                                <th class="col-lg-1">Emergency Item Charge/HST 5%</th>
                                                <th class="col-lg-1">Amount (In Rs.)</th>
                                            </tr>
                                            </tfoot>

                                            <tbody>
                                            @foreach($ePatients as $key=>$patientData)
                                                <tr>

                                                    <td>
                                                        {{ucfirst($patientData->first_name)}}
                                                        {{ucfirst($patientData->middle_name)}}
                                                        {{ucfirst($patientData->last_name)}}
                                                        <br>
                                                        <strong>{{$patientData->patient_code}}</strong>
                                                    </td>

                                                    <td>
                                                        <?php
                                                        $todayDate = date('Y-m-d', strtotime($patientData->created_at));
                                                        $localDate = str_replace("-", ",", $todayDate);
                                                        $classes = explode(",", $localDate);
                                                        $a = $classes[0];
                                                        $b = $classes[1];
                                                        $c = $classes[2];
                                                        echo eng_to_nep($a, $b, $c);
                                                        echo '&nbsp';
                                                        echo date('h:i A', strtotime($patientData->created_at));
                                                        ?>
                                                        <br>
                                                        <?php
                                                        $todayDate = date('Y-m-d', strtotime($patientData->discharged_at));
                                                        $localDate = str_replace("-", ",", $todayDate);
                                                        $classes = explode(",", $localDate);
                                                        $a = $classes[0];
                                                        $b = $classes[1];
                                                        $c = $classes[2];
                                                        echo eng_to_nep($a, $b, $c);
                                                        echo '&nbsp';
                                                        echo date('h:i A', strtotime($patientData->discharged_at));
                                                        ?>
                                                    </td>

                                                    <td>
                                                        {{ $patientData->isOfWard->ward_name.'/'.$patientData->isOfRoom->room_name.'/'.$patientData->isOfBed->bed_name }}
                                                    </td>

                                                    <td>
                                                        <?php
                                                        echo $patientData->doctor_fee . "/<br>" . $patientData->doctor_tax_only;
                                                        ?>
                                                    </td>

                                                    <td class="td" style="font-weight: bold">
                                                        {{$patientData->sub_total}}
                                                        <br>
                                                        {{$patientData->tax}}

                                                    </td>


                                                    <td class="td" style="font-weight: bold">
                                                        {{($patientData->doctor_fee_with_tax)+($patientData->grand_total)}}

                                                    </td>

                                                </tr>

                                            @endforeach
                                            </tbody>
                                        </table>

                                    @else
                                        <div class="alert alert-danger">
                                            <strong style="padding-left: 300px"> Sorry ! No record found
                                            </strong>
                                        </div>
                                    @endif

                                </div>


                                <div id="ipd" class="tab-pane fade">

                                    @if($reportData=='customsearch')
                                        <a href="{{url('revenue/report/custom-search/ipd',$reportData.'/'.$from.'/'.$to)}}"
                                           class="gererate_excell">Generate Report ipd {{$reportData}}<i
                                                    class="fa fa-download" style="float: right; line-height: 20px;"></i></a>
                                    @else
                                        <a href="{{url('revenue/report/ipd',$reportData)}}" class="gererate_excell">Generate
                                            Report IPD {{$reportData}}<i class="fa fa-download"
                                                                         style="float: right; line-height: 20px;"></i></a>
                                    @endif
                                    @if(count($iPatients)>0)
                                        <table id="revenue2" class="table table-hover table-bordered table-striped">
                                            <thead>
                                            <tr>

                                                <td class="col-lg-2">Patient's Name/ Code</td>
                                                <td class="col-lg-2">Admitted/ Discharged Date</td>
                                                <td class="col-lg-2">Ward/Room/Bed</td>
                                                <td class="col-lg-2">Bed Charge</td>
                                                <td class="col-lg-1">Doctor Charge</td>
                                                <td class="col-lg-1">HST 5%</td>
                                                <td class="col-lg-1">Total (In Rs.)</td>
                                            </tr>
                                            </thead>

                                            <thead>
                                            <tr>

                                                <th class="col-lg-2">Patient's Name/ Code</th>
                                                <th class="col-lg-2">Admitted/ Discharged Date</th>
                                                <th class="col-lg-2">Ward/Room/Bed</th>
                                                <th class="col-lg-2">Bed Charge</th>
                                                <th class="col-lg-1">Doctor Charge</th>
                                                <th class="col-lg-1">HST 5%</th>
                                                <th class="col-lg-1">Total (In Rs.)</th>
                                            </tr>
                                            </thead>

                                            <tfoot>
                                            <tr>

                                                <th class="col-lg-2">Patient's Name/ Code</th>
                                                <th class="col-lg-2">Admitted/ Discharged Date</th>
                                                <th class="col-lg-2">Ward/Room/Bed</th>
                                                <th class="col-lg-2">Bed Charge</th>
                                                <th class="col-lg-1">Doctor Charge</th>
                                                <th class="col-lg-1">HST 5%</th>
                                                <th class="col-lg-1">Total (In Rs.)</th>
                                            </tr>
                                            </tfoot>

                                            <tbody>
                                            @foreach($iPatients as $key=>$patientData)
                                                <tr>
                                                    <td>
                                                        {{ucfirst($patientData->first_name)}}
                                                        {{ucfirst($patientData->middle_name)}}
                                                        {{ucfirst($patientData->last_name)}}
                                                        <br>
                                                        <strong>{{$patientData->patient_code}}</strong>
                                                    </td>

                                                    <td>
                                                        <?php
                                                        $todayDate = date('Y-m-d', strtotime($patientData->created_at));
                                                        $localDate = str_replace("-", ",", $todayDate);
                                                        $classes = explode(",", $localDate);
                                                        $a = $classes[0];
                                                        $b = $classes[1];
                                                        $c = $classes[2];
                                                        echo eng_to_nep($a, $b, $c);
                                                        echo '&nbsp';
                                                        echo date('h:i A', strtotime($patientData->created_at));
                                                        ?>/
                                                        <br>
                                                        <?php
                                                        $todayDate = date('Y-m-d', strtotime($patientData->discharged_at));
                                                        $localDate = str_replace("-", ",", $todayDate);
                                                        $classes = explode(",", $localDate);
                                                        $a = $classes[0];
                                                        $b = $classes[1];
                                                        $c = $classes[2];
                                                        echo eng_to_nep($a, $b, $c);
                                                        echo '&nbsp';
                                                        echo date('h:i A', strtotime($patientData->discharged_at));
                                                        ?>
                                                    </td>

                                                    <td>
                                                        {{ $patientData->isOfWard->ward_name.'/'.$patientData->isOfRoom->room_name}}
                                                    </td>

                                                    <td>
                                                        @if($patientData->getDischargeDetail)
                                                            {{ $patientData->getDischargeDetail->room_charge }}
                                                        @else

                                                        @endif
                                                    </td>

                                                    <td class="td" style="font-weight: bold">
                                                        @if($patientData->getDischargeDetail)
                                                            {{ $patientData->getDischargeDetail->doctor_charge }}
                                                        @else

                                                        @endif
                                                    </td>

                                                    <td class="td" style="font-weight: bold">
                                                        {{ $patientData->hst }}
                                                    </td>

                                                    <td class="td" style="font-weight: bold">
                                                        {{ $patientData->total_after_tax }}

                                                    </td>
                                                </tr>

                                            @endforeach
                                            </tbody>
                                        </table>

                                    @else
                                        <div class="alert alert-danger">
                                            <strong style="padding-left: 300px"> Sorry ! No record found
                                            </strong>
                                        </div>
                                    @endif

                                </div>


                                <div id="test" class="tab-pane fade">
                                    @if($reportData=='customsearch')
                                        <a href="{{url('revenue/report/custom-search/test',$reportData.'/'.$from.'/'.$to)}}"
                                           class="gererate_excell">Generate Report Test {{$reportData}}<i
                                                    class="fa fa-download" style="float: right; line-height: 20px;"></i></a>
                                    @else

                                        <a href="{{url('revenue/report/test',$reportData)}}" class="gererate_excell">Generate
                                            Report Test {{$reportData}}<i class="fa fa-download"
                                                                          style="float: right; line-height: 20px;"></i></a>

                                    @endif
                                    @if(count($testPatients)>0)

                                        <table id="revenue1" class="table table-hover table-bordered table-striped">

                                            <thead>
                                            <tr>

                                                <td class="col-lg-2">Patient's Name/ Code</td>
                                                <td class="col-lg-2">Test's Name</td>
                                                <td class="col-lg-2">Referred By</td>
                                                <td class="col-lg-2">Consulted To</td>
                                                <td class="col-lg-1">Test Price</td>
                                                <td class="col-lg-1">HST 5%</td>
                                                <td class="col-lg-1">Amount (In Rs)</td>
                                            </tr>
                                            </thead>

                                            <thead>
                                            <tr>

                                                <th class="col-lg-2">Patient's Name/ Code</th>
                                                <th class="col-lg-2">Test</th>
                                                <th class="col-lg-2">Referred By</th>
                                                <th class="col-lg-2">Consulted To</th>
                                                <th class="col-lg-1">Test Price</th>
                                                <th class="col-lg-1">HST 5%</th>
                                                <th class="col-lg-1">Amount (In Rs)</th>
                                            </tr>
                                            </thead>

                                            <tfoot>
                                            <tr>

                                                <th class="col-lg-2">Patient's Name/ Code</th>
                                                <th class="col-lg-2">Test</th>
                                                <th class="col-lg-2">Referred By</th>
                                                <th class="col-lg-2">Consulted To</th>
                                                <th class="col-lg-1">Test Price</th>
                                                <th class="col-lg-1">HST 5%</th>
                                                <th class="col-lg-1">Amount (In Rs)</th>
                                            </tr>
                                            </tfoot>

                                            <tbody>
                                            @foreach($testPatients as $key=>$patientData)
                                                <tr>


                                                    <td>
                                                        {{ucfirst($patientData->belongsToPatient->first_name)}}
                                                        {{ucfirst($patientData->belongsToPatient->middle_name)}}
                                                        {{ucfirst($patientData->belongsToPatient->last_name)}}
                                                        <br>
                                                        <strong>{{$patientData->belongsToPatient->patient_code}}</strong>
                                                    </td>

                                                    <td>
                                                        <?php
                                                        $tests = DB::table('test_detail')
                                                            ->where('bid', $patientData->bid)
                                                            ->get();

                                                        if (count($tests) == 1) {
                                                            $test = $tests->first();
                                                            $category = DB::table('categories')
                                                                ->where('id', $test->test_id)
                                                                ->first();
                                                            echo $category->title;
                                                        } else {
                                                        $test = $tests->first();
                                                        $category = DB::table('categories')
                                                            ->where('id', $test->test_id)
                                                            ->first();
                                                        echo $category->title;
                                                        ?>
                                                        <br>
                                                        <button type="button" class="btn btn-success"
                                                                data-toggle="modal"
                                                                data-target="#{{ $patientData->bid }}"
                                                                style="font-size: 10px; padding: 2px 5px;">
                                                            View More...
                                                        </button>
                                                        <?php
                                                        }
                                                        ?>
                                                        <div class="modal fade" id="{{ $patientData->bid }}"
                                                             tabindex="-1"
                                                             role="dialog"
                                                             aria-labelledby="myModalLabel">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h4 class="modal-title" id="myModalLabel">Test
                                                                            Details</h4>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <table class="table table-striped">
                                                                            <thead>
                                                                            <tr>
                                                                                <th>Test Name</th>
                                                                                <th>Test Price</th>
                                                                                <th>HST 5%</th>
                                                                                <th>Total</th>
                                                                            </tr>
                                                                            </thead>

                                                                            <tbody>
                                                                            <?php
                                                                            $tests = DB::table('test_detail')
                                                                                ->where('bid', $patientData->bid)
                                                                                ->get();
                                                                            ?>
                                                                            @foreach ($tests as $test)
                                                                                <tr>
                                                                                    <td>
                                                                                        <?php
                                                                                        $category = DB::table('categories')
                                                                                            ->where('id', $test->test_id)
                                                                                            ->first();
                                                                                        echo $category->title;
                                                                                        ?>
                                                                                    </td>

                                                                                    <td>
                                                                                        <?php
                                                                                        $category = DB::table('categories')
                                                                                            ->where('id', $test->test_id)
                                                                                            ->first();
                                                                                        echo $category->price;
                                                                                        ?>
                                                                                    </td>

                                                                                    <td>
                                                                                        <?php
                                                                                        $hst = $category->price / 100 * 5;
                                                                                        echo $hst;
                                                                                        ?>
                                                                                    </td>

                                                                                    <td>
                                                                                        <?php
                                                                                        $hst = $category->price / 100 * 5;
                                                                                        $total = $hst + $category->price;
                                                                                        echo $total;
                                                                                        ?>
                                                                                    </td>
                                                                                </tr>
                                                                            @endforeach

                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        {{--{{ $patientData->isOfTest->belongsToCategory->title }}--}}
                                                    </td>

                                                    <td>
                                                        Dr.
                                                        {{ucfirst($patientData->referredByDoctor->first_name)}}
                                                        {{ucfirst($patientData->referredByDoctor->middle_name)}}
                                                        {{ucfirst($patientData->referredByDoctor->last_name)}}
                                                    </td>

                                                    <td>


                                                        @if($patientData->consultedToDoctor)
                                                            Dr.
                                                            {{ucfirst($patientData->consultedToDoctor->first_name)}}
                                                            {{ucfirst($patientData->consultedToDoctor->middle_name)}}
                                                            {{ucfirst($patientData->consultedToDoctor->last_name)}}

                                                        @else
                                                            ---
                                                        @endif
                                                    </td>

                                                    <td class="td" style="font-weight: bold">
                                                        {{$patientData->sub_total}}
                                                    </td>

                                                    <td class="td" style="font-weight: bold">
                                                        {{$patientData->tax}}
                                                    </td>

                                                    <td class="td" style="font-weight: bold">
                                                        {{$patientData->grand_total}}
                                                    </td>
                                                </tr>

                                            @endforeach
                                            </tbody>

                                        </table>

                                    @else
                                        <div class="alert alert-danger">
                                            <strong style="padding-left: 300px"> Sorry ! No record found
                                            </strong>
                                        </div>
                                    @endif

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <script>
        $(document).ready(function () {
            $('#revenue').DataTable({
                //"paginate": false,
                //"searching": true,
                "ordering": false,
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],

                "footerCallback": function (row, data, start, end, display) {
                    var api = this.api(), data;

                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '') * 1 :
                            typeof i === 'number' ?
                                i : 0;
                    };

                    // Total over all pages
                    total = api
                        .column(5)
                        .data()
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                    // Total over this page
                    pageTotal = api
                        .column(5, {page: 'current'})
                        .data()
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                    // Update footer
                    $(api.column(5).footer()).html(
                        'Rs. ' + pageTotal + '<br>' + 'Rs. ' + total
                        /*'Rs. ' + pageTotal*/
                    );

                    $(api.column(0).footer()).html(
                        ''
                    );

                    $(api.column(1).footer()).html(
                        ''
                    );

                    $(api.column(2).footer()).html(
                        ''
                    );

                    $(api.column(3).footer()).html(
                        ''
                    );

                    $(api.column(4).footer()).html(
                        '&nbsp;' +
                        'Table Total:' +
                        '<br>' +
                        '&nbsp;' +
                        'Grand Total:'
                    );
                }
            });


            // Setup - add a text input to each footer cell
            $('#revenue thead td').each(function () {
                var title = $(this).text();
                $(this).html('<input type="text" placeholder="Search ' + title + '" />');
            });

            // DataTable
            var table = $('#revenue').DataTable();

            // Apply the search
            table.columns().every(function () {
                var that = this;

                $("#revenue thead input").on('keyup change', function () {
                    if (that.search() !== this.value) {
                        table
                            .column($(this).parent().index() + ':visible')
                            .search(this.value)
                            .draw();
                    }
                });
            });
            $.fn.DataTable.ext.pager.numbers_length = 3;
        });

    </script>


    <script>
        $(document).ready(function () {
            //emergency
            $('#revenue3').DataTable({
                //"paginate": false,
                //"searching": true,
                "ordering": false,
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],

                "footerCallback": function (row, data, start, end, display) {
                    var api = this.api(), data;

                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '') * 1 :
                            typeof i === 'number' ?
                                i : 0;
                    };

                    // Total over all pages
                    total = api
                        .column(5)
                        .data()
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                    // Total over this page
                    pageTotal = api
                        .column(5, {page: 'current'})
                        .data()
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                    // Update footer
                    $(api.column(5).footer()).html(
                        'Rs. ' + pageTotal + '<br>' + 'Rs. ' + total
                        /*'Rs. ' + pageTotal*/
                    );

                    $(api.column(0).footer()).html(
                        ''
                    );

                    $(api.column(1).footer()).html(
                        ''
                    );

                    $(api.column(2).footer()).html(
                        ''
                    );

                    $(api.column(3).footer()).html(
                        ''
                    );

                    $(api.column(4).footer()).html(
                        '&nbsp;' +
                        'Table Total:' +
                        '<br>' +
                        '&nbsp;' +
                        'Grand Total:'
                    );
                }
            });


            // Setup - add a text input to each footer cell
            $('#revenue3 thead td').each(function () {
                var title = $(this).text();
                $(this).html('<input type="text" placeholder="Search ' + title + '" />');
            });

            // DataTable
            var table = $('#revenue3').DataTable();

            // Apply the search
            table.columns().every(function () {
                var that = this;

                $("#revenue3 thead input").on('keyup change', function () {
                    if (that.search() !== this.value) {
                        table
                            .column($(this).parent().index() + ':visible')
                            .search(this.value)
                            .draw();
                    }
                });
            });
        });
    </script>


    <script>
        $(document).ready(function () {
            //ipd
            $('#revenue2').DataTable({
                //"paginate": false,
                //"searching": true,
                "ordering": false,
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],

                "footerCallback": function (row, data, start, end, display) {
                    var api = this.api(), data;

                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '') * 1 :
                            typeof i === 'number' ?
                                i : 0;
                    };

                    // Total over all pages
                    total = api
                        .column(6)
                        .data()
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                    // Total over this page
                    pageTotal = api
                        .column(6, {page: 'current'})
                        .data()
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                    // Update footer
                    $(api.column(6).footer()).html(
                        'Rs. ' + pageTotal + '<br><br>' + 'Rs. ' + total
                        /*'Rs. ' + pageTotal*/
                    );

                    $(api.column(0).footer()).html(
                        ''
                    );

                    $(api.column(1).footer()).html(
                        ''
                    );

                    $(api.column(2).footer()).html(
                        ''
                    );

                    $(api.column(3).footer()).html(
                        ''
                    );

                    $(api.column(4).footer()).html(
                        ''
                    );

                    $(api.column(5).footer()).html(
                        '&nbsp;' +
                        'Table Total:' +
                        '<br>' +
                        '&nbsp;' +
                        'Grand Total:'
                    );
                }
            });
            $('#revenue2 thead td').each(function () {
                var title = $(this).text();
                $(this).html('<input type="text" placeholder="Search ' + title + '" />');
            });

            // DataTable
            var table = $('#revenue2').DataTable();

            // Apply the search
            table.columns().every(function () {
                var that = this;

                $("#revenue2 thead input").on('keyup change', function () {
                    if (that.search() !== this.value) {
                        table
                            .column($(this).parent().index() + ':visible')
                            .search(this.value)
                            .draw();
                    }
                });
            });
        });
    </script>

    <script>
        $(document).ready(function () {
            $('#revenue1').DataTable({
                //"paginate": false,
                //"searching": true,
                "ordering": false,
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],

                "footerCallback": function (row, data, start, end, display) {
                    var api = this.api(), data;

                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '') * 1 :
                            typeof i === 'number' ?
                                i : 0;
                    };

                    // Total over all pages
                    total = api
                        .column(6)
                        .data()
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                    // Total over this page
                    pageTotal = api
                        .column(6, {page: 'current'})
                        .data()
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                    // Update footer
                    $(api.column(6).footer()).html(
                        'Rs. ' + pageTotal + '<br><br>' + 'Rs. ' + total
                        /*'Rs. ' + pageTotal*/
                    );

                    $(api.column(0).footer()).html(
                        ''
                    );

                    $(api.column(1).footer()).html(
                        ''
                    );

                    $(api.column(2).footer()).html(
                        ''
                    );

                    $(api.column(3).footer()).html(
                        ''
                    );

                    $(api.column(4).footer()).html(
                        ''
                    );

                    $(api.column(5).footer()).html(
                        '&nbsp;' +
                        'Table Total:' +
                        '<br>' +
                        '&nbsp;' +
                        'Grand Total:'
                    );
                }
            });


            // Setup - add a text input to each footer cell
            $('#revenue1 thead td').each(function () {
                var title = $(this).text();
                $(this).html('<input type="text" placeholder="Search ' + title + '" />');
            });

            // DataTable
            var table = $('#revenue1').DataTable();

            // Apply the search
            table.columns().every(function () {
                var that = this;

                $("#revenue1 thead input").on('keyup change', function () {
                    if (that.search() !== this.value) {
                        table
                            .column($(this).parent().index() + ':visible')
                            .search(this.value)
                            .draw();
                    }
                });
            });
        });

    </script>



    <script>
        $(document).ready(function () {


            $('#datefrom').nepaliDatePicker({
                ndpEnglishInput: 'englishDate'
            });

            $('#dateto').nepaliDatePicker({
                onChange: function () {
                    var startDate = document.getElementById("datefrom").value;
                    var endDate = document.getElementById("dateto").value;

                    if ((Date.parse(startDate) > Date.parse(endDate))) {
                        alert("End date should be greater than Start date");
                        document.getElementById("datepicker1").value = "";
                    }
                }
            });
        });


    </script>



@stop

