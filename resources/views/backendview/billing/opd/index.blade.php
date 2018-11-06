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
            <!-- <div class="search input-group">
                <span class="input-group-addon" style="color: white; background-color: #f39c12;">SEARCH OPD PATIENT</span>
                <input type="text" autocomplete="off" id="search" class="form-control input-lg" placeholder="Patient code/Name/contact number">
            </div> -->
        </div>

        <div class="col-lg-6">
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li><a href="{{URL('configuration/patient/create')}}">Create Patient</a></li>
                <li class="active">View Patient</li>
            </ol>
        </div>
    </div>   
</div>  
<div id="txtHint" class="title-color" style="padding-top:10px; " ></div>  
<script>
    $(document).ready(function(){
     $("#search").keyup(function(){
         var str=  $("#search").val();
         if(str == "") {
              $( "#txtHint" ).html("");
             $('.content').show(); 
         }else {
             $.get( "{{ url('renew/patient?id=') }}"+str, function( data ) {
                 $( "#txtHint" ).html( data );
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
                    <div class="box-body">
                        @if(count($patients)>0)
                            <table  class="table table-hover table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th class="col-lg-1">S.N</th>
                                    <th class="col-lg-2">Patient Code</th>
                                    <th class="col-lg-4">Patient Full Name</th>
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
                                            <strong>{{$patientData->patient_code}}</strong>
                                        </td>
                                        <td>
                                            
                                                <a href="{{ URL::to('configuration/patient/' . $patientData->id . '/edit') }}">
                                                    {{ucfirst($patientData->first_name)}} {{ucfirst($patientData->middle_name)}}
                                                    {{ucfirst($patientData->last_name)}}
                                                </a>
                                           
                                        </td>

                                        

                                        <td>
                                            {{ date('Y-m-d h:i A',strtotime($patientData->created_at)) }}
                                        </td>

                                        <td>
                                            <a href="{{ URL::to('configuration/patient/' . $patientData->id . '/edit') }}"
                                               title="Edit Patient Details"
                                               data-rel="tooltip">
                                                <button type="button" class="btn btn-default btn-flat  ">
                                                    <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                                                </button>
                                            </a>


                                            <a href="{{URL::to('configuration/patient/' .$patientData->id)}}"
                                               title="View Patient Details"
                                               data-rel="tooltip">
                                                <button type="button" class="btn btn-default btn-flat ">
                                                    <span class="glyphicon glyphicon-zoom-in" aria-hidden="true"></span>
                                                </button>
                                            </a>


                                            {{--@if($patientData->status == "Active")
                                                <a href="{{URL::to('refund-patient',array($patientData->id))}}"
                                                   onclick="return confirm('Are you sure you want to Refund this patient?')"
                                                   title="Refund Patient"
                                                   data-rel="tooltip">
                                                    <button type="button" class="btn btn-default btn-flat  ">
                                                        <span class="glyphicon glyphicon-usd" aria-hidden="true"></span>
                                                    </button>
                                                </a>
                                            @else
                                                <a href="{{URL::to('cancel-refund', array($patientData->id))}}"
                                                   onclick="return confirm('Are you sure you want to cancel refund?')"
                                                   title="Cancel Refund"
                                                   data-rel="tooltip">
                                                    <button type="button" class="btn btn-default btn-flat  ">
                                                        <span class="glyphicon glyphicon-remove"
                                                              aria-hidden="true"></span>
                                                    </button>
                                                </a>
                                            @endif--}}

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
            </div>
        </div>
    </section>
@endsection