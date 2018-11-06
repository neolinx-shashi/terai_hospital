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
                <!--  <div class="search input-group">
                     <span class="input-group-addon"
                           style="color: white; background-color: #f39c12;">SEARCH PATIENT</span>
                     <input type="text" autocomplete="off" id="search" class="form-control input-lg"
                            placeholder="Patient code/Name/contact number">
                 </div> -->
            </div>

            <div class="col-lg-6">
                <ol class="breadcrumb">
                    <li><a href="{{url('dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                    <li><a href="{{URL('emergency/patient/create')}}">Emergency Patient</a></li>
                    <li class="active">Create Patient</li>
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
                    $.get("{{ url('live-emergency/patient?id=') }}" + str, function (data) {
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
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Total Emergency Patient - ({{count($patients)}})</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        @if(count($patients)>0)
                            <table class="table table-hover table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th class="col-lg-1">S.N</th>
                                    <th class="col-lg-4">Patient Full Name /Code</th>
                                    <th class="col-lg-2">Created On</th>
                                    <th class="col-lg-2">Actions</th>
                                    <th class="col-lg-3">Print</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $i = $patients->firstItem();
                                ?>
                                @foreach($patients as $patientData)

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
                                            <a href="{{ URL::to('emergency/patient/' . $patientData->id . '/edit') }}"
                                               title="Edit Emergency Patient Details"
                                               data-rel="tooltip">
                                                <button type="button" class="btn btn-default btn-flat  ">
                                                    <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                                                </button>
                                            </a>
                                            <a href="{{URL::to('emergency/patient/' .$patientData->id)}}"
                                               title="View Emergency Patient Details"
                                               data-rel="tooltip">
                                                <button type="button" class="btn btn-default btn-flat ">
                                                    <span class="glyphicon glyphicon-zoom-in" aria-hidden="true"></span>
                                                </button>
                                            </a>
                                        </td>
                                        <td>
                                            @if($patientData->status=='Discharged')

                                                <span class="label label-danger">Discharged</span>

                                            @else
                                                <a href="{{ URL::to('emergency/discharge/' . $patientData->id . '/discharge') }}"
                                                   title="Print Patient Invoice"
                                                   data-rel="tooltip">
                                                    <button type="button" class="btn btn-default btn-flat ">
                                                        <span class="glyphicon glyphicon-print"
                                                              aria-hidden="true"></span>
                                                        Discharge
                                                    </button>

                                                    <a href="{{url('discharge-without-bill',$patientData->id)}}">
                                                        Direct Discharge
                                                    </a>

                                                </a>
                                            @endif

                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {{$patients->render()}}
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
    </section>

@endsection