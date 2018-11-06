@extends('backendlayout.master')
@extends('backendlayout.header')
@extends('backendlayout.leftmenu')
@extends('backendlayout.footer')
@section('userscontent')
    @extends('backendlayout.flashmessagecollection')
    <script src="{{URL::asset('backendtheme/plugins/jQuery/jQuery-2.1.4.min.js')}}"></script>

    <section class="content-header">
        <h1>
            Test Patient Reprint List
            <a href="{{url('configuration/print-test-invoice')}}">
                <button type="button" class="btn btn-success btn-flat  pull-right ">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Create Pathology/Test
                </button>
            </a>
        </h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">

                            <form action="{{ url('search-test-invoice-list') }}" method="post" onsubmit="return validate()">
                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                <div class="col-md-4 pull-right">
                                    <input type="text" name="search" id="search" class="form-control" placeholder="Search by Patient Code">
                                </div>
                            </form>


                    </div>
                    <div class="box-body">

                        <table id="examples" class="table table-hover table-bordered table-striped">
                            <thead>
                            <tr>

                                <th class="col-lg-2">Patient's Name/ Code</th>
                                <th class="col-lg-2">Test</th>
                                {{--<th class="col-lg-2">Referred By</th>
                                <th class="col-lg-2">Consulted To</th>--}}
                                {{--<th class="col-lg-1">Test Price</th>
                                <th class="col-lg-1">HST 5%</th>--}}
                                <th class="col-lg-1">Amount (In Rs)</th>
                                <th class="col-lg-1">Created At</th>
                                <th class="col-lg-1">Action</th>
                            </tr>
                            </thead>

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

                                    {{--<td>
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
                                    </td>--}}

                                    {{--<td class="td" style="font-weight: bold">
                                        {{$patientData->sub_total}}
                                    </td>--}}

                                    <td class="td" style="font-weight: bold">
                                        {{$patientData->grand_total}}
                                    </td>

                                    <td class="td" style="font-weight: bold">
                                        {{$patientData->created_at}}
                                    </td>

                                    <td class="td" style="font-weight: bold">
                                        <a href="{{ URL::to('test-invoice/' . $patientData->bid. '/rep') }}"
                                           title="Reprint Test Invoice"
                                           data-rel="tooltip">
                                            <button type="button" class="btn btn-default btn-flat  ">
                                                <span class="glyphicon glyphicon-print" aria-hidden="true"> Reprint</span>
                                            </button>
                                        </a> {{--test-invoice/4--}}
                                    </td>
                                </tr>

                            @endforeach


                            </tbody>
                            <tfoot><tr><td colspan="5" align="right">{{ $testPatients->links() }}</td></tr></tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <style>
        a:link {
            text-decoration: none;
        }

        a:visited {
            text-decoration: none;
        }

        a:hover {
            text-decoration: none;
            color: green;
        }

        a:active {
            text-decoration: none;
        }
    </style>
    <script>
        $(function () {
            $("#example").DataTable({});
        });

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

        function validate() {
            var search = $('#search').val();
            if (search == '') {
                alert('Can not be empty.');
                return false;
            }
        }
    </script>
@endsection