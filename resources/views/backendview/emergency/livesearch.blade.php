
 <style type="text/css">
   #example1.t-patient tr{
    cursor: pointer;
}
</style>
<section class="content1" style="padding-left: 15px; padding-right: 15px;">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-body">
                    @if(count($posts)>0)
                    <table id="example1" class="table table-hover table-bordered table-striped t-patient">
                        <thead>
                            <tr>
                                <th class="col-lg-1">S.N</th>
                                <th class="col-lg-4">Patient Full Name</th>
                                <th class="col-lg-2">Patient Code</th>
                                <th class="col-lg-2">Created At</th>
                                <th class="col-lg-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($posts as $key=>$patientData)

                            <tr data-url="{{ URL::to('renew/patient/' . $patientData->id . '/edit') }}">
                                <td>
                                    {{$key+1}}.
                                </td>

                                <td>
                                 
                                    
                                    {{ucfirst($patientData->first_name)}} {{ucfirst($patientData->middle_name)}}
                                    {{ucfirst($patientData->last_name)}}
                                    <br>
                                    <i class="fa fa-phone" aria-hidden="true"></i>&nbsp;
                                    {{$patientData->phone}}
                                    
                                </td>

                                <td>
                                    <strong>{{$patientData->patient_code}}</strong>
                                </td>

                                <td>
                                    {{ date('Y-m-d h:i A',strtotime($patientData->created_at)) }}
                                </td>

                                <td>

                                    @if($patientData->status=='Discharged')

                                            Discharged

                                            @else
                                            <a href="{{ URL::to('emergency/discharge/' . $patientData->id . '/discharge') }}"
                                               title="Print Patient Invoice"
                                               data-rel="tooltip">
                                                <button type="button" class="btn btn-default btn-flat ">
                                                    <span class="glyphicon glyphicon-print" aria-hidden="true"></span>
                                                    Discharge
                                                </button>

                                                <a href="{{url('discharge-without-bill',$patientData->id)}}">
                                                        Direct  Discharge
                                                        </a>


                                            </a>
                                            @endif

                            </td>
                        </tr>

                        @endforeach
                    </tbody>
                </table>


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
<script>
    $(function () {
        $('table.table tr').click(function () {
            window.location.href = $(this).data('url');
        });
    })
</script>