@extends('backendlayout.master')
@extends('backendlayout.header')
@extends('backendlayout.leftmenu')
@extends('backendlayout.footer')
@section('userscontent')
@extends('backendlayout.flashmessagecollection')
<div class="container">
    @if(isset($details))
    <h2>Emergency patient details for {{ $query }}</h2>
    

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
                                $i = $details->firstItem();

                                ?>
                                @foreach($details as $key=>$user)

                                    <tr @if($user->id ==Session::get('patient_id')) style="background-color:#9fdfbf" @endif>
                                        <td>
                                            {{$i++}}.
                                        </td>

                                        <td>
                                            {{ucfirst($user->first_name)}}
                                           
                                           {{ucfirst($user->middle_name)}} 
                                            {{ucfirst($user->last_name)}}
                                            <br>
                                            {{$user->patient_code}}
                                            
                                        </td>
                                        <td>
                                            {{ date('Y-m-d h:i A',strtotime($user->created_at)) }}
                                        </td>
                                        <td>
                                            <a href="{{ URL::to('emergency/patient/' . $user->id . '/edit') }}"
                                               title="Edit Emergency Patient Details"
                                               data-rel="tooltip">
                                                <button type="button" class="btn btn-default btn-flat  ">
                                                    <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                                                </button>
                                            </a>
                                            <a href="{{URL::to('emergency/patient/' .$user->id)}}"
                                               title="View Emergency Patient Details"
                                               data-rel="tooltip">
                                                <button type="button" class="btn btn-default btn-flat ">
                                                    <span class="glyphicon glyphicon-zoom-in" aria-hidden="true"></span>
                                                </button>
                                            </a>
                                        </td>
                                        <td>
                                        @if($user->status=='Discharged')

                                            Discharged

                                            @else
                                            <a href="{{ URL::to('emergency/discharge/' . $user->id . '/discharge') }}"
                                               title="Print Patient Invoice"
                                               data-rel="tooltip">
                                                <button type="button" class="btn btn-default btn-flat ">
                                                    <span class="glyphicon glyphicon-print" aria-hidden="true"></span>
                                                    Discharge
                                                </button>

                                                <a href="{{url('discharge-without-bill',$user->id)}}">
                                                        Direct  Discharge
                                                        </a>


                                            </a>
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