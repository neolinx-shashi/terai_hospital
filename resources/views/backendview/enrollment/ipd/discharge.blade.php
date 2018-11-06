@extends('backendlayout.master')
@extends('backendlayout.header')
@extends('backendlayout.leftmenu')
@extends('backendlayout.footer')
@section('userscontent')
    @extends('backendlayout.flashmessagecollection')
    <div class="col-md-6" style="margin-top:8px;">
        <h3>
            Discharge Patient
            
        </h3>
    </div>
    <div class="col-lg-6">
        <ol class="breadcrumb pull-right" style="margin-top:20px;">
            <li><a href="{{url('dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="{{URL('ip-enrollment/patients/')}}">Patient List</a></li>
            <li class="active">Discharge Patient</li>
        </ol>
    </div>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                    </div>
                    <div class="box-body">
                        <table id="example" class="table table-hover table-bordered table-striped">
                            <thead>
                            <tr>
                                <th style="width:40px;">S.N.</th>
                                <th style="width:200px;">Patient Name/Code</th>
                                <th>Ward Details</th>
                                <th>Admitted On</th>
                                <th>Discharged At</th>
                                <th style="width:80px;">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $key = 0; ?>
                            @foreach($patients as $ipatient)
                                <?php $key++ ?>
                                <tr>
                                    <td>
                                        {{ $key }}
                                    </td>

                                    <td>
                                        {{ucfirst($ipatient->first_name)}}
                                        {{ucfirst($ipatient->middle_name)}}
                                        {{ucfirst($ipatient->last_name)}}<br>
                                        <strong>{{$ipatient->patient_code}}</strong>
                                    </td>

                                    <td>
                                        Ward: <strong>{{$ipatient->isOfWard->ward_name}}</strong><br>
                                        Room: <strong>{{ucfirst($ipatient->isOfRoom->room_name)}}</strong><br>
                                        Bed: <strong></strong>
                                    </td>

                                    <td>
                                        {{ date('Y-m-d h:i A',strtotime($ipatient->created_at)) }}
                                    </td>
                                    <td>
                                    @if($ipatient->status == 'In Ward')
                                       Not Discharged
                                    @else
                                       
                                        {{ date('Y-m-d h:i A',strtotime($ipatient->discharged_at)) }}
                                        
                                    @endif
                                    </td>

                                    <td>
                                        @if($ipatient->status == 'In Ward')
                                            <a href="{{URL::to('ip-enrollment/' .$ipatient->id) . '/discharge-patient'}}"
                                               title="Discharge Patient"
                                               data-rel="tooltip"
                                               onclick="return confirm('Are you sure you want to discharge the patient')">
                                                <button type="button" class="btn btn-danger btn-flat ">
                                                    <span aria-hidden="true"><i class="fa fa-street-view"></i> Discharge</span>
                                                </button>
                                            </a>
                                        @else
                                           <!--  <a href="{{URL::to('ip-enrollment/' .$ipatient->id) . '/cancel-discharge'}}"
                                               title="Cancel Discharge"
                                               data-rel="tooltip"
                                               onclick="return confirm('Are you sure you want to cancel discharge?')">
                                                <button type="button" class="btn btn-danger btn-flat ">
                                                    <span aria-hidden="true"><i class="fa fa-close"></i> Cancel Discharge</span>
                                                </button>
                                            </a>
 -->
                                            <a href="{{ URL::to('ip-enrollment/ipatient/' . $ipatient->id . '/print-invoice') }}"
                                               title="Print Patient Invoice"
                                               data-rel="tooltip">
                                                <button type="button" class="btn btn-primary btn-flat  "
                                                        style="margin-left: 10px;">
                                                    <span class="glyphicon glyphicon-print" aria-hidden="true"></span>
                                                    Invoice
                                                </button>
                                            </a>
                                        @endif
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

    <script>
        $(function () {
            $("#example").DataTable({});
        });
    </script>
@endsection