@extends('backendlayout.master')
@extends('backendlayout.header')
@extends('backendlayout.leftmenu')
@extends('backendlayout.footer')
@section('userscontent')
    @extends('backendlayout.flashmessagecollection')
    <script src="{{URL::asset('backendtheme/plugins/jQuery/jQuery-2.1.4.min.js')}}"></script>

    <div class="search" style="padding-top: 20px">
        <div class="row">
            <div class="col-lg-6 col-lg-offset-1">
                <div class="input-group">
                    <span class="input-group-addon"
                          style="color: white; background-color: #f39c12;  border-radius:4px; margin: -5px 0 -5px 0;">CREATE REPORT</span>
                    <input type="text" autocomplete="off" id="search"
                           style="border-radius:5px; font-size: 1em; padding: 5px 0 -5px 0;"
                           class="form-control input-lg"
                           placeholder="Patient code/Name/contact number">
                </div>
            </div>
        </div>
    </div>
    <div id="txtHint" class="title-color" style="padding-top:10px; "></div>
    <script>
        $(document).ready(function () {
            $("#search").keyup(function () {
                var str = $("#search").val();
                if (str == "") {
                    $("#txtHint").html("<b>Patient information will be listed here...</b>");
                    $('.content').show();
                } else {
                    $.get("{{ url('ip-enrollment/patient-search?id=') }}" + str, function (data) {
                        $("#txtHint").html(data);
                        $('.content').hide();
                    });
                }
            });
        });
    </script>


   

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h4>
                            Patient Report List
                            {{--<a href="{{url('ip-enrollment/patient-report/create')}}">--}}
                                {{--<button type="button" class="btn btn-success btn-flat  pull-right ">--}}
                                    {{--<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Create Report--}}
                                {{--</button>--}}
                            {{--</a>--}}
                        </h4>
                    </div>
                    <div class="box-body">
                        {{--From: <input type="date" id="datepicker" name="from">--}}
                        {{--To: <input type="date" id="datepicker" name="to">--}}
                        <table id="example1" class="table table-hover table-bordered table-striped">
                            <thead>
                            <tr>
                                <th style="width:30px;">S.N</th>
                                <th style="width:30px;">Report Number</th>
                                <th style="width:80px;">Patient Code</th>
                                <th style="width:150px;">Patient Full Name</th>
                                <th style="width:100px;">Report Created At</th>
                                <th>Status</th>
                                <th>Admitted</th>
                                <th>Discharged Date</th>
                                <th style="width:120px;">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($reports as $key=>$report)
                                <tr>
                                    <td>
                                        {{$key+1}}
                                    </td>
                                    <td>
                                        {{$report->report_number}}
                                    </td>
                                    <td>
                                        {{$report->ipatient_code}}
                                    </td>

                                    <td>
                                        {{ucfirst($report->isOfPatient->first_name). ' '. ucfirst($report->isOfPatient->middle_name). ' '. ucfirst($report->isOfPatient->last_name)}}
                                    </td>


                                    <td>
                                        {{ date('Y-m-d h:i A',strtotime($report->created_at)) }}
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td><a href="{{ URL::to('ip-enrollment/' . $report->id . '/print-report') }}" title="Print Patient Invoice"
                                           data-rel="tooltip">
                                            <button type="button" class="btn btn-primary btn-flat  "  style="margin-left: 10px;">
                                                <span class="glyphicon glyphicon-print" aria-hidden="true"></span>
                                                Report
                                            </button>
                                        </a></td>
                                    {{--<td>--}}
                                        {{--<a href="{{URL::to('ip-enrollment/patients/' .$ipatient->id)}}"--}}
                                           {{--title="View Patient Details"--}}
                                           {{--data-rel="tooltip">--}}
                                            {{--<button type="button" class="btn btn-success btn-flat ">--}}
                                                {{--<span class="glyphicon glyphicon-zoom-in" aria-hidden="true"></span>--}}
                                            {{--</button>--}}
                                        {{--</a>--}}

                                        {{--<a href="{{ URL::to('ip-enrollment/patients/' . $ipatient->id . '/edit') }}">--}}
                                            {{--<button type="button" class="btn btn-info btn-flat  ">--}}
                                                {{--<span class="glyphicon glyphicon-edit" aria-hidden="true"></span>--}}
                                            {{--</button>--}}
                                        {{--</a>--}}

                                        {{--<a href="{{URL::to('ip-enrollment/patients/' . $ipatient->id . '/remove-patient')}}"--}}
                                           {{--onclick="return confirm('Are you sure you want to delete this record?')">--}}
                                            {{--<button type="button" class="btn btn-danger btn-flat  ">--}}
                                        {{--<span class="glyphicon glyphicon-remove"--}}
                                              {{--aria-hidden="true"></span>--}}
                                            {{--</button>--}}
                                        {{--</a>--}}
                                    {{--</td>--}}
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <style>
   
    <script>
        $(document).ready(function () {
            // Setup - add a text input to each footer cell
            $('#revenue tfoot th').each(function () {
                var title = $(this).text();
                $(this).html('<input type="text" placeholder="Search ' + title + '" />');
            });

            // DataTable
            var table = $('#revenue').DataTable();

            // Apply the search
            table.columns().every(function () {
                var that = this;

                $('input', this.footer()).on('keyup change', function () {
                    if (that.search() !== this.value) {
                        that
                            .search(this.value)
                            .draw();
                    }
                });
            });
        });
    </script>
@endsection