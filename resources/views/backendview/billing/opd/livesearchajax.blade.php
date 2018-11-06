
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
                                <th class="col-lg-4">Patient Full Name/Code</th>
                                <th class="col-lg-2">Contact No.</th>
                                <th class="col-lg-2">Created On</th>
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
                                    <strong>{{$patientData->patient_code}}</strong>
                                    
                                    
                                </td>

                                <td>
                                    <i class="fa fa-phone" aria-hidden="true"></i>&nbsp;
                                    {{$patientData->phone}}
                                </td>

                                <td>
                                   {{changeCreatedDateToNepali($patientData->created_at)}}
                                </td>

                                <td>

                                    <a href="{{ URL::to('re-admit/patient', $patientData->id) }}"
                                     title="Renew Patient Details"
                                     data-rel="tooltip">
                                     <button type="button" class="btn btn-default btn-flat ">
                                        <span class="glyphicon glyphicon-list" aria-hidden="true"> Renew</span>
                                    </button>
                                </a>

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