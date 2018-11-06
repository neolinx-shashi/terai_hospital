  <section class="content" style="padding: 0 15px 15px 15px !important;">

        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Registered Emergency Patient Today - ({{count($registeredPatientToday)}})</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        @if(count($patients)>0)
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
                                $i = $patients->firstItem();

                                ?>
                                @foreach($patients as $patientData)

                                    <tr @if($patientData->id ==Session::get('patient_id')) style="background-color:#9fdfbf" @endif>
                                        <td>
                                            {{$i++}}.
                                        </td>

                                        <td>
                                            {{ucfirst($patientData->first_name)}}
                                           
                                           {{ucfirst($patientData->middle_name)}} 
                                            {{ucfirst($patientData->last_name)}}
                                            <br>
                                          <strong>{{$patientData->patient_code}}</strong>
                                            
                                            
                                        </td>
                                        <td>
                                            <!-- {{ date('Y-m-d h:i A',strtotime($patientData->created_at)) }} -->
                                             <?php

                                                $todayDate= date('Y-m-d',strtotime($patientData->created_at));

                                                $localDate = str_replace("-", ",", $todayDate);

                                                $classes=explode(",",$localDate);  
                                                //print_r($classes); 

                                                $a=$classes[0];
                                                $b=$classes[1];
                                                $c=$classes[2];


                                               echo eng_to_nep($a,$b,$c);
                                                echo  '&nbsp';

                                               echo date('h:i A',strtotime($patientData->created_at));
                                            ?>

                                            
                                                                    </td>
                                        <td>
                                            <a href="{{ URL::to('emergency/patient/' . $patientData->id . '/edit') }}"
                                               title="Edit Emergency Patient Details"
                                               data-rel="tooltip">
                                                <button type="button" class="btn btn-default btn-flat  ">
                                                    <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                                                </button>
                                            </a>
                                            <a href="{{URL::to('emergency/patient/' .$patientData->id)}}"
                                               title="View Emergency Patient Details"
                                               data-rel="tooltip">
                                                <button type="button" class="btn btn-default btn-flat ">
                                                    <span class="glyphicon glyphicon-zoom-in" aria-hidden="true"></span>
                                                </button>
                                            </a>
                                        </td>
                                        <td>

                                        @if($patientData->status=='Discharged')
                                        Discharged
                                        @else

                                            <a href="{{ URL::to('emergency/patient/' . $patientData->id . '/print-invoice/rep') }}"
                                               title="Print Emergency Invoice"
                                               data-rel="tooltip">
                                                <button type="button" class="btn btn-default btn-flat ">
                                                    <span class="glyphicon glyphicon-print" aria-hidden="true"></span>
                                                    Print Emergency Ticket
                                                </button>


                                            </a>
                                            @endif

                                         

                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {{$patients->render()}}
                        @else
                            <div class="alert alert-danger">
                                <strong style="padding-left: 350px"> Sorry ! No record found
                                </strong>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>