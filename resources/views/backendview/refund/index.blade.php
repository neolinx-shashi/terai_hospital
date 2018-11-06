@extends('backendlayout.master')
@extends('backendlayout.header')
@extends('backendlayout.leftmenu')
@extends('backendlayout.footer')
@section('userscontent')
    @extends('backendlayout.flashmessagecollection')
    <script src="{{URL::asset('backendtheme/plugins/jQuery/jQuery-2.1.4.min.js')}}"></script>

    <section class="content-header">
        <div id="bidsrefund">
        </div>
        <h1>
            <?php $tabName = Session::get('tabName'); ?>
            Refund
        </h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">

                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li id="opd-top" class="{{--{{ empty($tabName) || $tabName == 'opd' ? 'active' : '' }}--}}active"><a
                                        data-toggle="tab" href="#opd">OPD Patients</a></li>
                            <li id="test-top" {{--class="{{ empty($tabName) || $tabName == 'test' ? 'active' : '' }}"--}}><a
                                        data-toggle="tab" href="#test">Pathology/Test Patients</a></li>
                            {{--<li --}}{{--class="{{ empty($tabName) || $tabName == 'test' ? 'active' : '' }}"--}}{{--><a
                                        data-toggle="tab" href="#emr">Emergency Patients</a></li>--}}
                        </ul>

                        <div class="box-body">

                            <div class="tab-content">
                                <div id="opd"
                                     class="tab-pane fade in active active {{--{{ !empty($tabName) && $tabName == 'opd' ? 'active' : '' }}--}}">
                                    <div class="box-body">
                                        <div class="col-md-4 pull-right">
                                                <form method="post" action="{{ url('/search-opd-patient') }}">
                                                    {{ csrf_field() }}
                                                    <input name="opd_search" type="text" class="form-control" placeholder="Patients Code" value="{{{ $code or '' }}}">
                                                    <input name="search" type="submit" value="Search" style="display:none;">
                                                </form>
                                            </div>
                                        @if(count($patients)>0)
                                            
                                            
                                            <div class="clearfix"></div><br>
                                            <table id="example"
                                                   class="table table-hover table-bordered table-striped">
                                                <thead>
                                                <tr>
                                                    <th class="col-lg-1">S.N</th>
                                                    <th class="col-lg-4">Patient Full Name/Code</th>
                                                    <th class="col-lg-1">Fee</th>
                                                    <th class="col-lg-2">Created At</th>
                                                    <th class="col-lg-2">Actions</th>
                                                </tr>
                                                </thead>

                                                <tbody>

                                                <?php
                                                $i = $patients->firstItem();

                                                ?>

                                                @foreach($patients as $key=>$patientData)

                                                    <tr>
                                                        <td>
                                                            {{$i++}}.
                                                        </td>


                                                        <td>
                                                            <strong>
                                                                <a href="{{ URL::action('BackEndController\RefundController@refundPage', $patientData->id) }}">
                                                                    {{ucfirst($patientData->first_name)}}
                                                                    {{ucfirst($patientData->middle_name)}}
                                                                    {{ucfirst($patientData->last_name)}}
                                                                </a>
                                                                <br>
                                                                <strong>{{$patientData->patient_code}}</strong>
                                                            </strong>
                                                        </td>

                                                        <td>
                                                            Rs. {{ $patientData->doctor_fee_with_tax }}
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
                                                        </td>

                                                        <td>
                                                        @if($patientData->refund_status == "Active")
                                                            <!--
                                                                <a href="{{ URL::to('refund-patient', $patientData->id) }}"
                                                                   onclick="return confirm('Are you sure you want to refund?')"
                                                                   title="Refund Patient" data-rel="tooltip">
                                                                    <button type="button"
                                                                            class="btn btn-success pull-left">
                                                                    <span class="glyphicon glyphicon-usd"
                                                                          aria-hidden="true"></span>
                                                                        Refund
                                                                    </button>
                                                                </a>
                                                            -->
                                                                <button type="button" class="btn btn-success pull-left"
                                                                        onclick="refundPatient({{ $patientData->id }},0)">
                                                                    <span class="glyphicon glyphicon-usd"
                                                                          aria-hidden="true"></span> Refund
                                                                </button>

                                                            @else
                                                                <span class="label label-danger">Refunded</span>

                                                            @endif
                                                        </td>
                                                    </tr>

                                                @endforeach
                                                </tbody>
                                            </table>
                                            {{$patients->render()}}


                                        @else
                                            <div class="alert alert-danger">
                                                <strong style="padding-left: 300px"> Sorry ! No record found
                                                </strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div id="test" class="tab-pane fade ">
                                    <div class="box-body">
                                        <div class="col-md-4 pull-right">
                                                <form method="post" action="{{ url('/search-test-patient') }}">
                                                    {{ csrf_field() }}
                                                    <input name="test_search" type="text" class="form-control" placeholder="Patient Code" value="{{{ $code or '' }}}">
                                                    <input name="search" type="submit" value="Search" style="display:none;">
                                                </form>
                                            </div>

                                        @if (count($testPatients) > 0)
                                        <table id="example3" class="table table-hover table-bordered table-striped">
                                            <thead>
                                            <tr>
                                                <th class="col-lg-1">S.N</th>
                                                <th class="col-lg-4">Patient Full Name/Code</th>
                                                <th class="col-lg-1">Fee</th>
                                                <th class="col-lg-2">Created At</th>
                                                <th class="col-lg-2">Actions</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $j = $testPatients->firstItem();

                                            ?>

                                            @foreach($testPatients as $key=>$patientData)
                                                <tr>
                                                    <td>
                                                        {{$j++}}.
                                                    </td>

                                                    <td>
                                                        <strong>

                                                            {{ ucfirst(@$patientData->belongsToPatient->first_name)}}


                                                        </strong>
                                                        <br>
                                                        <strong>{{ @$patientData->belongsToPatient->patient_code }}</strong>
                                                    </td>

                                                    <td>
                                                        {{ $patientData->grand_total }}
                                                    </td>

                                                    <td>
                                                        {{ changeCreatedDateToNepali($patientData->created_at) }}
                                                    </td>

                                                    <td>
                                                    @if($patientData->status == "Active")
                                                        <!--
                                                            <form id="testStatus">

                                                            <input type="hidden" name="billingId" id="billingId" value="{{$patientData->bid}}">

                                                                <div id="submitBtn">
                                                                <button  type="submit" class="btn btn-success pull-left">
                                                                <span class="glyphicon glyphicon-usd" aria-hidden="true"></span>
                                                                Refund
                                                                </button>
                                                                </div>
                                                                       
                                                                   
                                                            </form>
                                                        -->
                                                            <button type="submit" class="btn btn-success pull-left"
                                                                    onclick="refundPatient({{ $patientData->bid }},1)">
                                                                <span class="glyphicon glyphicon-usd"
                                                                      aria-hidden="true"></span>
                                                                Refund
                                                            </button>
                                                            <div id="refundedMessage"></div>

                                                        @else

                                                            <span class="label label-danger">Refunded</span>
                                                        @endif
                                                    </td>
                                                </tr>

                                            @endforeach
                                            </tbody>
                                        </table>
                                        {{$testPatients->render()}}
                                            @endif

                                    </div>
                                </div>

                                {{--Emergency--}}
                                <div id="emr" class="tab-pane fade ">
                                    <div class="box-body">

                                        @if(count($emrPatients)>0)
                                            <table id="emr-table"
                                                   class="table table-hover table-bordered table-striped">
                                                <thead>
                                                <tr>
                                                    <th class="col-lg-1">S.N</th>
                                                    <th class="col-lg-4">Patient Full Name /Code</th>
                                                    <th class="col-lg-3">Fee</th>
                                                    <th class="col-lg-2">Created At</th>
                                                    <th class="col-lg-2">Actions</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                $i = $emrPatients->firstItem();
                                                ?>
                                                @foreach($emrPatients as $patientData)

                                                    <tr @if($patientData->id ==Session::get('patient_id')) style="background-color:#9fdfbf" @endif>
                                                        <td>
                                                            {{$i++}}.
                                                        </td>

                                                        <td>
                                                            {{ucfirst($patientData->first_name)}}

                                                            {{ucfirst($patientData->middle_name)}}
                                                            {{ucfirst($patientData->last_name)}}
                                                            <br>
                                                            {{ucfirst($patientData->patient_code)}}
                                                        </td>

                                                        <td>
                                                            {{ $patientData->doctor_fee_with_tax }}
                                                        </td>

                                                        <td>
                                                            <?php

                                                            $todayDate = date('Y-m-d', strtotime($patientData->created_at));

                                                            $localDate = str_replace("-", ",", $todayDate);

                                                            $classes = explode(",", $localDate);
                                                            //print_r($classes);

                                                            $a = $classes[0];
                                                            $b = $classes[1];
                                                            $c = $classes[2];


                                                            echo eng_to_nep($a, $b, $c);
                                                            echo '&nbsp';

                                                            echo date('h:i A', strtotime($patientData->created_at));
                                                            ?>
                                                        </td>

                                                        <td>
                                                        @if($patientData->refund_status == "Active")
                                                            <!--
                                                            <form id="testStatus">

                                                            <input type="hidden" name="billingId" id="billingId" value="{{$patientData->bid}}">

                                                                <div id="submitBtn">
                                                                <button  type="submit" class="btn btn-success pull-left">
                                                                <span class="glyphicon glyphicon-usd" aria-hidden="true"></span>
                                                                Refund
                                                                </button>
                                                                </div>


                                                            </form>
                                                        -->
                                                                <button type="submit" class="btn btn-success pull-left"
                                                                        onclick="refundPatient({{ $patientData->id }},1)">
                                                                <span class="glyphicon glyphicon-usd"
                                                                      aria-hidden="true"></span>
                                                                    Refund
                                                                </button>
                                                                <div id="refundedMessage"></div>

                                                            @else

                                                                <span class="label label-danger">Refunded</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                            {{$emrPatients->render()}}
                                        @else
                                            <div class="alert alert-danger">
                                                <strong style="padding-left: 350px"> Sorry ! No record found
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
        </div>
    </section>

    @if ($srch == 'test')
    <script type="text/javascript">
        $('#opd-top').removeClass('treeview active');
        $('#opd').removeClass('active in');
        $('#test-top').addClass('treeview active');
        $('#test').addClass('active in');
    </script>
    @else
    <script type="text/javascript">
        $('#test-top').removeClass('treeview active');
        $('#test').removeClass('active in');
        $('#opd-top').addClass('treeview active');
        $('#opd').addClass('active in');
    </script>
    @endif

    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Refund Remark</h4>
                </div>
                <div class="modal-body">
                    <textarea class="form-control" id="refund-remark"></textarea>
                    <input type="hidden" id="pid"/>
                    <input type="hidden" id="n"/>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" onclick="clearRefund()">Close
                    </button>
                    <button type="button" class="btn btn-primary" onclick="saveRefund()">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(function () {
            $("#example").DataTable({});
            $("#example3").DataTable({});
            $("#emr-table").DataTable({});
        });

        $("#testStatus").on("submit", function (e) {
            e.preventDefault();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            $.ajax({
                type: "GET",
                url: "{{ url('/refund-test-patient')}}/" + $("#billingId").val(),
                data: $(this).serialize(),
                success: function (data) {
                    console.log(data);
                    $('#testStatus').hide();

                    $('#bidsrefund').html('<div class="alert alert-success col-sm-12" >' + data.msg + '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button></div>');
                    $('#refundedMessage').html('<span class="label label-danger">' + data.refund + '</span>');
                    $('#errorDiv').css({"display": "none"});
                },
                error: function (xhr, ajaxOptions, thrownError) {
                }
            });
        });

        function refundPatient(pid, n) {
            $('#pid').val(pid);
            $('#n').val(n);
            $('#myModal').modal();
        }

        function clearRefund() {
            $('#pid, #refund-remark').val('');
        }

        function saveRefund() {
            var pid = $('#pid').val();
            var n = $('#n').val();
            var remark = $('#refund-remark').val();
            var url = "{{ url('/refund-patient') }}";
            var token = "{{ csrf_token() }}";

            if (remark == '') {
                alert('Refund Remark is Required!');
            } else {
                $.post(url, {pid: pid, remark: remark, n: n, _token: token}, function (res) {
                    if (res === '1') {
                        location.reload();
                    }

                });
            }

        }
    </script>
@endsection