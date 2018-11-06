<script src="{{URL::asset('backendtheme/plugins/jQuery/jQuery-2.1.4.min.js')}}"></script>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-body">
                @if(!empty($searchData))
                        <table id="example1" class="table table-hover table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>S.N.</th>
                                <th>Name</th>
                                <th>Age/Gender</th>
                                <th>Address</th>
                                <th>Phone</th>
                                <th>Doctor</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($searchData as $key=>$patient)

                                <tr data-url="{{ URL::to('renew/patient/' . $patient->p_id . '/edit') }}">
                                    <td>
                                        {{$key+1}}.
                                    </td>

                                    <td>{{ ucfirst($patient->p_fname).' '.ucfirst($patient->p_mname).' '.ucfirst($patient->p_lname) }}</td>
                                    <td>{{ $patient->p_age.'/'.ucfirst($patient->p_gender) }}</td>
                                    <td>{{ ucfirst($patient->p_address) }}</td>
                                    <td>{{ $patient->p_phone }}</td>
                                    <td>{{ ucfirst($patient->d_fname).' '.ucfirst($patient->d_mname).' '.ucfirst($patient->d_lname) }}</td>


                                    {{--<td><a data-toggle="tooltip" title="View Details"
                                           href="{{route('billing.homepage.show', $patient->p_id)}}">
                                            <i class="glyphicon glyphicon-eye-open"></i>
                                        </a>


                                        <a data-toggle="tooltip" title="Edit Detials" style="margin-left:10px"
                                           href="{{route('billing.edit', $patient->p_id)}}">
                                            <i class="glyphicon glyphicon-edit"></i>
                                        </a>


                                        <a data-toggle="tooltip" title="Delete" style="margin-left:10px"
                                           href="{{route('billing.confirm', $patient->p_id)}}">
                                            <i class="glyphicon glyphicon-trash"></i>
                                        </a>
                                    </td>--}}
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