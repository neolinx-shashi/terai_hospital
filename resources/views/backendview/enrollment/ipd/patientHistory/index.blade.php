@extends('backendlayout.master')
@extends('backendlayout.header')
@extends('backendlayout.leftmenu')
@extends('backendlayout.footer')
@section('userscontent')
    @extends('backendlayout.flashmessagecollection')
    <script src="{{URL::asset('backendtheme/plugins/jQuery/jQuery-2.1.4.min.js')}}"></script>

    <section class="content-header">
        <h1>
            In Patient List
            <a href="{{url('ip-enrollment/patients/create')}}">
                <button type="button" class="btn btn-success btn-flat  pull-right ">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> New Admission
                </button>
            </a>
        </h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                    </div>
                    <div class="box-body">
                        {{--From: <input type="date" id="datepicker" name="from">--}}
                        {{--To: <input type="date" id="datepicker" name="to">--}}
                        <table id="example1" class="table table-hover table-bordered table-striped">
                            <thead>
                            <tr>
                                <th style="width:40px;">S.N.</th>
                                <th class="col-md-2">Patient Name/ Code</th>
                                <th class="col-md-2">Ward Details</th>
                                <th>Admitted On</th>
                                <th>Status</th>
                                <th style="width:150px;">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $key = 0; ?>
                            @foreach($iPatients as $ipatient)
                                <?php $key++ ?>
                                <tr>
                                    <td>
                                        {{$key}}
                                    </td>

                                    <td>
                                        {{ucfirst($ipatient->first_name)}}
                                        {{ucfirst($ipatient->middle_name)}}
                                        {{ucfirst($ipatient->last_name)}}<br>
                                        <strong>{{$ipatient->ipatient_code}}</strong>
                                    </td>

                                    <td>
                                        Ward: <strong>{{$ipatient->isOfWard->ward_name}}</strong><br>
                                        Room: <strong>{{ucfirst($ipatient->isOfRoom->room_name)}}</strong><br>
                                        Bed: <strong>{{ucfirst($ipatient->isOfBed->bed_name)}}</strong>
                                    </td>

                                    <td>
                                        {{ date('Y-m-d h:i A',strtotime($ipatient->created_at)) }}
                                    </td>

                                    @if($ipatient->status == 'In Ward')
                                        <td>Not Discharged</td>
                                    @else
                                        <td>Discharged
                                            on <strong>{{ date('Y-m-d h:i A',strtotime($ipatient->discharged_at)) }}</strong></td>
                                    @endif

                                    {{--@if($ipatient->status == 'In Ward')
                                        <td>Not Discharged</td>
                                    @else
                                        <td>{{ date('Y-m-d h:i A',strtotime($ipatient->discharged_at)) }}</td>
                                    @endif--}}

                                    <td>

                                        <a href="{{URL::to('ip-enrollment/patients/' .$ipatient->id)}}"
                                           title="View Patient Details"
                                           data-rel="tooltip">
                                            <button type="button" class="btn btn-default btn-flat ">
                                                <span class="glyphicon glyphicon-zoom-in" aria-hidden="true"></span>
                                            </button>
                                        </a>

                                        <a href="{{ URL::to('ip-enrollment/patients/' . $ipatient->id . '/edit') }}"
                                           title="Edit Patient Details"
                                           data-rel="tooltip">
                                            <button type="button" class="btn btn-default btn-flat  ">
                                                <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                                            </button>
                                        </a>

                                        <a href="{{ URL::to('ip-enrollment/patients/' . $ipatient->id . '/insert-doctor-detail') }}"
                                           title="Insert Patient Update"
                                           data-rel="tooltip">
                                            <button type="button" class="btn btn-default btn-flat  ">
                                                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                                            </button>
                                        </a>


                                        {{--<a href="{{URL::to('ip-enrollment/patients/' . $ipatient->id . '/remove-patient')}}"
                                           onclick="return confirm('Are you sure you want to delete this record?')"
                                           title="Delete Patient Details"
                                           data-rel="tooltip">
                                            <button type="button" class="btn btn-danger btn-flat  ">
                                        <span class="glyphicon glyphicon-remove"
                                              aria-hidden="true"></span>
                                            </button>
                                        </a>--}}
                                    </td>
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