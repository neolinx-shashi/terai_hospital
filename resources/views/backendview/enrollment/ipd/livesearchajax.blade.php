<script src="{{URL::asset('backendtheme/plugins/jQuery/jQuery-2.1.4.min.js')}}"></script>
<section class="content1">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-body">
                    @if(count($posts)>0)
                        <table id="example1" class="table table-hover table-bordered table-striped">
                            <thead>
                            <tr>
                                <th class="col-lg-1">S.N</th>
                                <th class="col-lg-4">Patient Full Name/Code</th>
                                
                                <th class="col-lg-2">Created On</th>
                                <th class="col-lg-2">Status</th>
                                <th class="col-lg-2">Discharged On</th>
                                
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($posts as $key=>$patientData)

                                <tr data-url="{{ URL::to('ip-enrollment/renew/patient/' . $patientData->id . '/edit') }}">
                                    <td>
                                        {{$key+1}}.
                                    </td>

                                    <td>
                                        {{ucfirst($patientData->first_name)}} {{ucfirst($patientData->middle_name)}}
                                        {{ucfirst($patientData->last_name)}}
                                        <br>
                                        <i class="fa fa-phone" aria-hidden="true"></i>&nbsp;
                                        {{$patientData->phone}}
                                        <br>
                                         <strong>{{$patientData->patient_code}}</strong>

                                    </td>

                                  

                                    <td>
                                       <?php
                                                $todayDate= date('Y-m-d',strtotime($patientData->created_at));
                                                $localDate = str_replace("-", ",", $todayDate);
                                                $classes=explode(",",$localDate);  
                                                $a=$classes[0];
                                                $b=$classes[1];
                                                $c=$classes[2];
                                                echo eng_to_nep($a,$b,$c);
                                                echo  '&nbsp';
                                               echo date('h:i A',strtotime($patientData->created_at));
                                            ?>
                                    </td>

                                    <td>
                                    @if($patientData->status=='Discharged')

                                    <span class="label label-success">Discharged</span>
                                    @else
                                        <span class="label label-primary">{{ $patientData->status }}</span>
                                    @endif
                                    
                                        
                                    </td>

                                    <td>
                                        <?php
                                                $todayDate= date('Y-m-d',strtotime($patientData->discharged_at));
                                                $localDate = str_replace("-", ",", $todayDate);
                                                $classes=explode(",",$localDate);  
                                                $a=$classes[0];
                                                $b=$classes[1];
                                                $c=$classes[2];
                                                echo eng_to_nep($a,$b,$c);
                                                echo  '&nbsp';
                                               echo date('h:i A',strtotime($patientData->created_at));
                                            ?>
                                    </td>

                                 <!--    <td>

                                        <a href="{{ URL::to('ip-enrollment/renew/patient/' . $patientData->id . '/edit') }}"
                                           title="Renew Patient Details"
                                           data-rel="tooltip">
                                            <button type="button" class="btn btn-default btn-flat ">
                                                <span class="fa fa-mail-reply" aria-hidden="true"> Re-Admit</span>
                                            </button>
                                        </a>

                                    </td> -->
                                </tr>

                            @endforeach
                            </tbody>
                        </table>


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
<script>
    $(function () {
        $('table.table tr').click(function () {
            window.location.href = $(this).data('url');
        });
    })
</script>