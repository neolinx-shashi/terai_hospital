@extends('backendlayout.master')
@extends('backendlayout.header')
@extends('backendlayout.leftmenu')
@extends('backendlayout.footer')
@section('userscontent')
@extends('backendlayout.flashmessagecollection')
<div class="container">
    @if(isset($details))
    <h2>IPD Patient details {{$query }}</h2>
    <table id="example" class="table table-hover table-bordered table-striped">
                            <thead>
                            <tr>
                                <th style="width:40px;">S.N.</th>
                                <th class="col-md-2">Patient Name/ Code</th>
                                <th class="col-md-2">Ward Details</th>
                                <th>Admitted On</th>
                                <th style="width:150px;">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                                $i = $details->firstItem();

                                ?>
                            @foreach($details as $key=>$ipatient)
                                <tr>
                                    <td>
                                        {{$i++}}
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
                                        Bed: <strong>{{ucfirst($ipatient->isOfBed->bed_name)}}</strong>
                                    </td>

                                    <td>
                                        {{ date('Y-m-d h:i A',strtotime($ipatient->created_at)) }}
                                    </td>

                                   

                                   

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

                                         @if($ipatient->status == 'In Ward')
                                         <td>Not Discharged</td>
                                    @else
                                        <td>Discharged
                                            on <strong>{{ date('Y-m-d h:i A',strtotime($ipatient->discharged_at)) }}</strong></td>
                                    @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        {{$details->render()}}
    @endif
</div>

@endsection