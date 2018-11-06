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
   <!--         <div class="search input-group">
<span class="input-group-addon"
style="color: white; background-color: #f39c12;">SEARCH PATIENT</span>
<input type="text" autocomplete="off" id="search" class="form-control input-lg"
placeholder="Patient code/Name/contact number">
</div> -->
        </div>

        <div class="col-lg-6">
            <ol class="breadcrumb">
                <li><a href="{{url('dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li><a href="{{URL('emergency/patient')}}">Emergency Patient</a></li>
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
             $.get( "{{ url('live-emergency/patient?id=') }}"+str, function( data ) {
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
    <div class="col-md-12">
     <div class="box">
        <div class="box-header">
            <h3 class="box-title">
            @if(Auth::user()->user_type_id=='6')
                        @else
                <a href="{{URL('emergency/patient/create')}}" class="btn btn-default btn-flat"><i class="fa fa-arrow-left"></i> Back</a>   
                
                <a href="{{ URL::to('emergency/patient/' . $patient->id . '/edit') }}" class="btn btn-primary  btn-flat"><i class="fa fa-edit"></i> Edit Information</a>
                @endif
            </h3>

            <div class="box-tools">
                <div class="input-group">

                </div>
            </div>

        </div>

        <div class="box-body table-responsive">

            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_1" data-toggle="tab">Personal Information</a></li>
                    <li class=""><a href="#tab_2" data-toggle="tab">Contact Information</a></li>
                    <li class=""><a href="#tab_3" data-toggle="tab">Other Information</a></li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane active" id="tab_1">
                        <table cellpadding="3" cellspacing="3" align="center" width="100%">
                            <tbody>
                                <tr>
                                    <td width="15%">Patient Code:</td>
                                    <td width="40%"><strong>{{$patient->patient_code}}</strong></td>

                                </tr>
                                <tr>
                                    <td width="5%">Full Name:</td>
                                    <td width="40%">{{ucfirst($patient->first_name)}}</td>

                                </tr>

                            </tr>
                            <tr>
                                <td width="5%">Age:</td>
                                <td width="40%">{{$patient->age}} <strong>YRS</strong> {{$patient->gender}}</td>

                            </tr>
                        </tr>

                        <tr>
                            <td width="5%">Nationality:</td>
                            <td width="40%">{{ucfirst($patient->isOfNationality->country_name)}}</td>

                        </tr>

                        <tr>
                            <td width="5%">Blood Group:</td>
                            <td width="40%">
                            @if($patient->bloodGroup_id==NULL)
                            Not known
                            @else
                            {{ucfirst($patient->bloodGroup_id)}}
                            @endif</td>

                        </tr>

                        <tr>
                            <td width="5%">Room :</td>
                            <td width="40%">{{ucfirst($patient->isOfRoom->room_name)}}</td>

                        </tr>

                        <tr>
                            <td width="5%">Bed No:</td>
                            <td width="40%">{{ucfirst($patient->isOfBed->bed_name)}}</td>

                        </tr>




                    </tbody></table>
                </div>

                <div class="tab-pane" id="tab_2">
                    <table cellpadding="3" cellspacing="3" align="center" width="100%">
                     <tbody>

                         <tr>
                            <td width="21%">Phone/Mobile:</td>
                            <td width="79%">{{$patient->phone}}</td>
                        </tr>

                    </tr>
                    <tr>
                        <td width="5%">Address:</td>
                        <td width="40%">{{ucfirst($patient->permanent_address)}}</td>

                    </tr>


                </tbody></table>
            </div>
            <div class="tab-pane" id="tab_3">
                <table cellpadding="3" cellspacing="3" align="center" width="100%">
                 <tbody>

                 <tr>
                        <td width="21%">Fiscal Year:</td>
                        <td width="79%"><strong>{{$patient->getCurrentFiscalYear->fiscal_year_start_date}}</strong> </td>
                    </tr>
                     <tr>
                        <td width="21%">Department Name:</td>
                        <td width="79%">{{ucfirst($patient->isInDepartment->name)}}</td>
                    </tr>
                    <tr>
                        <td>Consulted With:</td>
                        <td>{{ucfirst($patient->isConsultedToDoctor->first_name)}}
                            {{ucfirst($patient->isConsultedToDoctor->middle_name)}}
                            {{ucfirst($patient->isConsultedToDoctor->last_name)}}</td>
                        </tr>


                        <tr>
                            <td>Emergency Charge :</td>
                            <td>Rs .{{$patient->doctor_fee}}
                            <br>
                            <strong>HST @ 5%</strong>:&nbsp;{{$patient->doctor_tax_only}}
                            </td>
                        </tr>

                             <tr>
                            <td>Emergency Charge With Tax:</td>
                            <td>Rs .<strong>{{round($patient->doctor_fee_with_tax)}}</strong>
                            <br>
                            <strong>In Words</strong>:&nbsp;{{convert_number_to_words(round($patient->doctor_fee_with_tax))}} Only
                            </td>
                        </tr>


                        

                        <tr>
                            <td>Last Updated On:</td>
                            <td><?php

                                                $todayDate= date('Y-m-d',strtotime($patient->updated_at));

                                                $localDate = str_replace("-", ",", $todayDate);

                                                $classes=explode(",",$localDate);  
                                                //print_r($classes); 

                                                $a=$classes[0];
                                                $b=$classes[1];
                                                $c=$classes[2];


                                               echo eng_to_nep($a,$b,$c);
                                                echo  '&nbsp';

                                               echo date('h:i A',strtotime($patient->updated_at));
                                            ?></td>
                        </tr>

                             <tr>
                            <td>Created By:</td>
                            <td><strong>{{ucwords($patient->belongsToUser->fullname)}}</strong></td>
                        </tr>


                        <tr>
                            <td>Description:</td>
                            <td>{{ucwords($patient->description)}}
                            </td>
                        </tr>

                    </tbody></table>
                </div>

            </div>
        </div>

    </div>
    <div class="box-footer clearfix">

    </div>
</div>
</div>
</div>
</section>

@endsection

