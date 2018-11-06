@extends('backendlayout.master')
@extends('backendlayout.header')
@extends('backendlayout.leftmenu')
@extends('backendlayout.footer')
@section('userscontent')
    @extends('backendlayout.flashmessagecollection')
    <section class="content-header">
        <h1>
            Patient Details
            <a href="{{URL::to('/refund-view')}}">
                <button type="button" class="btn btn-warning btn-flat  pull-right ">
                    <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span> View Patients
                </button>
            </a>
        </h1>
    </section>
    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"></h3>
            </div>
            <div class="shadow">
                <div class="row">

                    <div class="col-md-5">
                        <div class="nav-tabs-custom">
                            <div class="tab-content">
                                <div class="active tab-pane" id="activity">
                                    <table class="table table-hover ">
                                        <tr>
                                            <th class="text-right col-lg-4">&nbsp; &nbsp;Full Name:</th>
                                            <td>{{ucfirst($patient->first_name)}}
                                                {{ucfirst($patient->middle_name)}}
                                                {{ucfirst($patient->last_name)}}
                                            </td>
                                        </tr>

                                        <tr>
                                            <th class="text-right col-lg-4">Gender/Age:</th>
                                            <td>
                                                @if($patient->gender == 'Male')
                                                    <i class="fa fa-male fa-1x" style="color: darkgreen"></i>
                                                    Male/{{$patient->age}}
                                                @endif
                                                @if($patient->gender == 'Female')
                                                    <i class="fa fa-female" style="color: red"></i>
                                                    Female/{{$patient->age}}
                                                @endif

                                                @if($patient->gender == 'Others')
                                                    Others/{{$patient->age}}
                                                @endif
                                            </td>
                                        </tr>

                                        <tr>
                                            <th class="text-right col-lg-4">&nbsp; &nbsp;Consulting Fee:</th>
                                            <td>Rs.&nbsp;{{$patient->doctor_fee}}</td>
                                        </tr>

                                        <tr>
                                            <th class="text-right col-lg-4">&nbsp; &nbsp;Department:</th>
                                            <td>{{ucfirst($patient->isInDepartment->name)}}</td>
                                        </tr>

                                        <tr>
                                            <th class="text-right col-lg-12" pull-left>Description:</th>
                                            <td>
                                                {{$patient->symptoms}}
                                            </td>
                                        </tr>

                                        <tr>
                                            <th class="text-right col-lg-3">Saved By:</th>
                                            <td><strong>{{ucfirst($patient->belongsToUser->fullname)}}</strong></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-5">
                        <div class="nav-tabs-custom">
                            <div class="tab-content">
                                <div class="active tab-pane" id="activity">
                                    <table class="table table-hover ">
                                        <tr>
                                            <th class="text-right col-lg-4">&nbsp; &nbsp;Phone/Mobile :</th>
                                            <td>{{$patient->phone}}</td>
                                        </tr>

                                        <tr>
                                            <th class="text-right col-lg-4">&nbsp; &nbsp;Address:</th>
                                            <td>{{ucfirst($patient->address)}}</td>
                                        </tr>

                                        <tr>
                                            <th class="text-right col-lg-4">&nbsp; &nbsp;Nationality:</th>
                                            <td>{{ucfirst($patient->isOfNationality->country_name)}}</td>
                                        </tr>

                                        <tr>
                                            <th class="text-right col-lg-4">&nbsp; &nbsp;Consulted To:
                                            </th>
                                            <td>{{ucfirst($patient->isConsultedToDoctor->first_name)}}
                                                {{ucfirst($patient->isConsultedToDoctor->middle_name)}}
                                                {{ucfirst($patient->isConsultedToDoctor->last_name)}}
                                            </td>
                                        </tr>

                                        <tr>
                                            <th class="text-right col-lg-4">&nbsp; &nbsp;Appointed on:
                                            </th>
                                            <td>
                                                {{ date('Y-m-d h:i A',strtotime($patient->appointment)) }}
                                            </td>
                                        </tr>

                                        <tr>
                                            <th class="text-right col-lg-3">Last Updated At:</th>
                                            <td>{{ date('Y-m-d h:i A',strtotime($patient->updated_at)) }}</td>
                                        </tr>

                                        <tr>
                                            <th class="text-right col-lg-3">Created At:</th>
                                            <td>{{ date('Y-m-d h:i A',strtotime($patient->created_at)) }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">

                        @if($patient->status == "Active")
                            <a href="{{ URL::to('refund-patient', $patient->id) }}"
                               onclick="return confirm('Are you sure you want to refund?')"
                               title="Refund Patient" data-rel="tooltip">
                                <button type="button" class="btn btn-success pull-right">
                                    <span class="glyphicon glyphicon-usd" aria-hidden="true"></span> Refund
                                </button>
                            </a>

                        @else
                            <a href="{{ URL::to('cancel-refund', $patient->id) }}"
                               onclick="return confirm('Are you sure you want to cancel refund?')"
                               title="Cancel Refund" data-rel="tooltip">
                                <button type="button" class="btn btn-danger pull-right">
                                    <span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Cancel Refund
                                </button>
                            </a>
                        @endif

                    </div>
                </div>
                <br>
            </div>
        </div>
    </section>

@endsection