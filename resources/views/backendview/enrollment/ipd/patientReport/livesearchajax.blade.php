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
                                <th class="col-lg-4">Patient Full Name</th>
                                <th class="col-lg-2">Patient Code</th>
                                <th class="col-lg-2">Created At</th>
                                <th class="col-lg-2">Status</th>
                                <th class="col-lg-2">Discharged Date</th>
                                <th class="col-lg-2">Actions</th>
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

                                    </td>

                                    <td>
                                        <strong>{{$patientData->ipatient_code}}</strong>
                                    </td>

                                    <td>
                                        {{ date('Y-m-d h:i A',strtotime($patientData->created_at)) }}
                                    </td>

                                    <td>
                                        {{ $patientData->status }}
                                    </td>

                                    <td>
                                        {{ date('Y-m-d h:i A',strtotime($patientData->discharged_at)) }}
                                    </td>

                                    <td>

                                        <a href="{{ URL::to('ip-enrollment/' . $patientData->id . '/patient-report') }}"
                                           title="Create Patient Report"
                                           data-rel="tooltip">
                                            <button type="button" class="btn btn-default btn-flat ">
                                                <span class="fa fa-tasks" aria-hidden="true"> Create Report</span>
                                            </button>
                                        </a>

                                    </td>
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