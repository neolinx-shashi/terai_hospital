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
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Admit IPD Patient
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
                        <form action="{{ url('ip-enrollment/search-patient') }}" method="post">
                            <div class="col-md-10"></div>
                            <div class="input-group col-md-2">
                                <span class="input-group-addon">TH-</span>
                                <input type="text" class="form-control" name="patient-code" value="{{{ $code or '' }}}">
                                {{ csrf_field() }}
                            </div>
                        </form>
                        <br>
                        <table id="example111" class="table table-hover table-bordered table-striped">
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
                            @foreach($iPatients as $key => $ipatient)
                                <?php $key++ ?>
                                <tr>
                                    <td>
                                        {{$key}}
                                    </td>

                                    <td>
                                        {{ucfirst($ipatient->first_name)}}
                                        {{ucfirst($ipatient->middle_name)}}
                                        {{ucfirst($ipatient->last_name)}}<br>
                                        <strong>{{$ipatient->patient_code}}</strong>
                                    </td>

                                    <td>
                                        Ward: <strong>{{$ipatient->isOfWard->ward_name}}</strong><br>
                                        @if($ipatient->isOfRoom->room_type)
                                            Room Type: <strong>{{ucfirst($ipatient->isOfRoom->room_type)}}</strong><br>
                                        @endif
                                        Room: <strong>{{ucfirst($ipatient->isOfRoom->room_name)}}</strong><br>
                                        Bed: <strong>{{ucfirst($ipatient->isOfBed->bed_name)}}</strong>
                                        <br>

                                        @if(!$ipatient->getDischargeDetail && $ipatient->status == "In Ward")
                                            <a href="{{ URL::to('ip-enrollment/patients/' . $ipatient->id . '/edit/1') }}"
                                               title="Edit Patient Details"
                                               data-rel="tooltip">
                                                <button type="button" class="btn btn-success btn-flat button">
                                                    <span class="fa fa-exchange" aria-hidden="true"> Bed Shift</span>
                                                </button>
                                            </a>
                                        @endif
                                    </td>

                                    <td>
                                        <?php
                                        $todayDate = date('Y-m-d', strtotime($ipatient->created_at));
                                        $localDate = str_replace("-", ",", $todayDate);
                                        $classes = explode(",", $localDate);
                                        $a = $classes[0];
                                        $b = $classes[1];
                                        $c = $classes[2];
                                        echo eng_to_nep($a, $b, $c);
                                        echo '&nbsp';
                                        echo date('h:i A', strtotime($ipatient->discharged_at));
                                        ?>
                                    </td>

                                    @if($ipatient->status == 'In Ward')
                                        <td><span class="label label-primary">In Ward</span></td>
                                    @else
                                        <td><span class="label label-danger">Discharged</span>
                                            on
                                            <strong> <?php
                                                $todayDate = date('Y-m-d', strtotime($ipatient->discharged_at));
                                                $localDate = str_replace("-", ",", $todayDate);
                                                $classes = explode(",", $localDate);
                                                $a = $classes[0];
                                                $b = $classes[1];
                                                $c = $classes[2];
                                                echo eng_to_nep($a, $b, $c);
                                                echo '&nbsp';
                                                echo date('h:i A', strtotime($ipatient->discharged_at));
                                                ?></strong>
                                        </td>
                                    @endif
                                    @if(Auth::user()->user_type_id=='7')
                                        <td>
                                            <a href="{{URL::to('ip-enrollment/patients/' .$ipatient->id)}}"
                                               title="View Patient Details"
                                               data-rel="tooltip">
                                                <button type="button" class="btn btn-default btn-flat ">
                                                    <span class="glyphicon glyphicon-zoom-in" aria-hidden="true"></span>
                                                </button>
                                            </a>

                                            <a href="{{ URL::to('ip-enrollment/patients/' . $ipatient->id . '/edit/0') }}"
                                               title="Edit Patient Details"
                                               data-rel="tooltip">
                                                <button type="button" class="btn btn-default btn-flat  ">
                                                    <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                                                </button>
                                            </a>

                                            <a href="{{ URL::to('ip-enrollment/patients/' . $ipatient->id . '/insert-doctor-detail') }}"
                                               title="Add Doctor Visit Charge"
                                               data-rel="tooltip">
                                                <button type="button" class="btn btn-success btn-flat button">
                                                    <span class="glyphicon glyphicon-plus"
                                                          aria-hidden="true">Charge</span>
                                                </button>
                                            </a>

                                            <a href="{{ URL::to('ip-enrollment/ipatient/' . $ipatient->id . '/insert-discharge-summary') }}"
                                               title="Insert Discharge Summary"
                                               data-rel="tooltip" style="padding-top: 10px">
                                                <button type="button" class="btn btn-primary btn-flat button">
                                                    <span class="glyphicon glyphicon-note" aria-hidden="true"></span>
                                                    Discharge Summary
                                                </button>
                                            </a>
                                        </td>
                                    @else
                                        <td>
                                            <a href="{{URL::to('ip-enrollment/patients/' .$ipatient->id)}}"
                                               title="View Patient Details"
                                               data-rel="tooltip">
                                                <button type="button" class="btn btn-default btn-flat ">
                                                    <span class="glyphicon glyphicon-zoom-in" aria-hidden="true"></span>
                                                </button>
                                            </a>

                                            <a href="{{ URL::to('ip-enrollment/patients/' . $ipatient->id . '/edit/0') }}"
                                               title="Edit Patient Details"
                                               data-rel="tooltip">
                                                <button type="button" class="btn btn-default btn-flat  ">
                                                    <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                                                </button>
                                            </a>

                                            @if ($ipatient->status == 'Discharged')
                                            <a href="{{ URL::to('ip-enrollment/ipatient/' . $ipatient->id . '/print-invoice/1') }}" class="btn btn-primary" title="Reprint"><span class="glyphicon glyphicon-print"></span> Reprint</a>
                                            @endif

                                            @if(!$ipatient->getDischargeDetail && $ipatient->status == "In Ward")
                                                <a href="{{ URL::to('ip-enrollment/patients/' . $ipatient->id . '/insert-doctor-detail') }}"
                                                   title="Add Doctor Visit Charge"
                                                   data-rel="tooltip">
                                                    <button type="button" class="btn btn-success btn-flat button">
                                                    <span class="glyphicon glyphicon-plus"
                                                          aria-hidden="true">Charge</span>
                                                    </button>
                                                </a>

                                                <a href="{{ URL::to('ip-enrollment/ipatient/' . $ipatient->id . '/print-admit-invoice') }}"
                                                   title="Print Admit Ticket"
                                                   data-rel="tooltip" style="padding-top: 10px">
                                                    <button type="button" class="btn btn-primary btn-flat button">
                                                        <span class="glyphicon glyphicon-print"
                                                              aria-hidden="true"></span>
                                                        Ticket
                                                    </button>
                                                </a>

                                                <a href="{{ URL::to('ip-enrollment/ipatient/' . $ipatient->id . '/print-invoice') }}"
                                                   title="Print Patient Invoice"
                                                   data-rel="tooltip" style="padding-top: 10px">
                                                    <button type="button" class="btn btn-primary btn-flat button">
                                                        <span class="glyphicon glyphicon-print"
                                                              aria-hidden="true"></span>
                                                        To Bill
                                                    </button>
                                                </a>

                                                {{--<a href="{{ URL::to('ip-enrollment/ipatient/' . $ipatient->id . '/add-deposit') }}"
                                                   title="Add Deposit Amount"
                                                   data-rel="tooltip" style="padding-top: 10px">
                                                    <button type="button" class="btn btn-success btn-flat button">
                                                        <span class="glyphicon glyphicon-plus"
                                                              aria-hidden="true"></span>
                                                        Add Deposit
                                                    </button>
                                                </a>--}}

                                                <button type="button" class="btn btn-success" data-toggle="modal"
                                                        data-target="#{{ $ipatient->id }}" style="margin: 0 0 5px 0">
                                                    Add Deposit
                                                </button>

                                                <div class="modal fade" id="{{ $ipatient->id }}" tabindex="-1"
                                                     role="dialog"
                                                     aria-labelledby="myModalLabel">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                        aria-label="Close">
                                                                    <span aria-hidden="true">×</span></button>
                                                                <h4 class="modal-title" id="myModalLabel">Add Deposit
                                                                    Amount on account of {{$ipatient->first_name}}</h4>
                                                            </div>
                                                            <div class="modal-body">

                                                                <table class="table table-striped">
                                                                    <thead>
                                                                    <tr>
                                                                        <th>Deposit Date</th>
                                                                        <th>Deposit Amount</th>
                                                                    </tr>
                                                                    </thead>

                                                                    <tbody>
                                                                    @if(!empty($deposits))
                                                                        <?php $total_deposit = 0; ?>
                                                                        @foreach($deposits as $key1 => $value)
                                                                            @if($key-1 == $key1)
                                                                                @foreach($value as $key2 => $deposit)
                                                                                    <tr>
                                                                                        @if (!empty($deposit['date']))
                                                                                            <td>{{ $deposit['date'] }}</td>
                                                                                        @endif
                                                                                            <td>{{ $deposit['amount'] }} <?php $total_deposit += $deposit['amount']; ?></td>
                                                                                    </tr>
                                                                                @endforeach
                                                                                <tr>
                                                                                    <td>Total:</td>
                                                                                    <td>{{ $total_deposit }}</td>
                                                                                </tr>
                                                                            @endif
                                                                        @endforeach
                                                                    @endif
                                                                    </tbody>
                                                                </table>

                                                                <form method="post" id="depositForm"
                                                                      action="{{URL('ip-enrollment/ipatient/'.$ipatient->id.'/store-deposit')}}">

                                                                    <input type="hidden" name="_token"
                                                                           value="{{ csrf_token() }}">

                                                                    <div class="form-group {{ $errors->has('deposit') ? ' has-error' : '' }}">
                                                                        <label for="deposit">Deposit Amount <label
                                                                                    class="text-danger">*</label></label>

                                                                        <input type="text" name="deposit"
                                                                               placeholder="Enter Deposit Amount"
                                                                               class="form-control"
                                                                               id="deposit<?php echo $ipatient->id; ?>">
                                                                        @if ($errors->has('deposit'))
                                                                            <span class="help-block" style="color: red">
                                                                                <strong>  {{ $errors->first('deposit') }}</strong>
                                                                            </span>
                                                                        @endif
                                                                    </div>
                                                                    <br>

                                                                    <button type="submit"
                                                                            class="btn btn-primary save btn-flat this-btn"
                                                                            onclick="return validateDeposit(<?php echo $ipatient->id; ?>)">
                                                                        <i class="fa fa-plus-circle"></i>Add
                                                                    </button>

                                                                    <label class="note" for="panel-body">Note: Field
                                                                        With <span class="text-danger"> * </span>
                                                                        are mandatory
                                                                    </label>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            @elseif($ipatient->status == 'In Ward')
                                                <a href="{{URL::to('ip-enrollment/' .$ipatient->id) . '/discharge-patient'}}"
                                                   title="Discharge Patient"
                                                   data-rel="tooltip"
                                                   onclick="return confirm('Are you sure you want to discharge the patient')">
                                                    <button type="button" class="btn btn-danger btn-flat button">
                                                        <span aria-hidden="true"><i class="fa fa-street-view"></i> Discharge</span>
                                                    </button>
                                                </a>
                                            @endif

                                            {{--@if($ipatient->status == 'In Ward')
                                                <a href="{{URL::to('ip-enrollment/' .$ipatient->id) . '/discharge-patient'}}"
                                                   title="Discharge Patient"
                                                   data-rel="tooltip"
                                                   onclick="return confirm('Are you sure you want to discharge the patient')">
                                                    <button type="button" class="btn btn-danger btn-flat ">
                                                        <span aria-hidden="true"><i class="fa fa-street-view"></i> Discharge</span>
                                                    </button>
                                                </a>
                                            @else
                                                <a href="{{URL::to('ip-enrollment/' .$ipatient->id) . '/cancel-discharge'}}"
                                                   title="Cancel Discharge"
                                                   data-rel="tooltip"
                                                   onclick="return confirm('Are you sure you want to cancel discharge?')">
                                                    <button type="button" class="btn btn-danger btn-flat ">
                                                        <span aria-hidden="true"><i class="fa fa-close"></i> Cancel Discharge</span>
                                                    </button>
                                                </a>

                                                <a href="{{ URL::to('ip-enrollment/ipatient/' . $ipatient->id . '/print-invoice') }}"
                                                   title="Print Patient Invoice"
                                                   data-rel="tooltip">
                                                    <button type="button" class="btn btn-primary btn-flat  "
                                                            style="margin-left: 10px;">
                                                        <span class="glyphicon glyphicon-print"
                                                              aria-hidden="true"></span>
                                                        Invoice
                                                    </button>
                                                </a>
                                            @endif--}}


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
                                    @endif
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="7">{{ $iPatients->links() }}</td>
                            </tr>
                            </tfoot>
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

        .button {
            font-size: 12px;
        }
    </style>
    <script>
        $(function () {
            $("#example").DataTable({});
        });

        $('.this-btn').click(function() {
            $('.this-btn').hide();
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

        function validateDeposit() {
            var id = arguments[0];
            if ($('#deposit'.concat(id)).val() == '') {
                alert('Please Enter Deposit Amount!');
                return false;
            }
        }
    </script>
@endsection