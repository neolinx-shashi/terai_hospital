@extends('backendlayout.master')
@extends('backendlayout.header')
@extends('backendlayout.leftmenu')
@extends('backendlayout.footer')
@section('userscontent')
    @extends('backendlayout.flashmessagecollection')
    <link rel="stylesheet" type="text/css" href="{{URL::asset('backendtheme/lib/nepali.datepicker.v2/css/bootstrap.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{URL::asset('backendtheme/lib/nepali.datepicker.v2/nepali.datepicker.v2.min.css')}}" />
    <style>
        .no-padding {padding: 0;}
        .spacer {margin: 20px 0;}
    </style>
    <link href="{{ URL::asset('css/bootstrap-datetimepicker.css') }}">
    <section class="content-header">
        <h1>Patient History</h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body">
                        <div class="col-md-12 no-padding">


                            <div class="clearfix"></div><div class="spacer"></div>
                            <div class="col-md-6 pull-right">
                                <form action="{{ url('patient-history-detail') }}" method="post" onsubmit="return validate()">
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                    <div class="col-md-10">
                                        <div class="input-group">
                                            <span class="input-group-addon">Search</span>
                                            <input name="search" type="text" id="search" class="form-control" value="{{{ $search or '' }}}" placeholder="Patient Name or Patient Code">

                                        </div>
                                        <span class="error" style="color: red"></span>
                                    </div>


                                    <div class="col-md-2">
                                        <input name="submit" type="submit" class="btn btn-primary" value="Search">
                                    </div>
                                </form>
                            </div>


                            <div class="clearfix"></div><div class="spacer"></div>

                        </div>
                        <div class="col-md-12">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>S.No.</th>
                                        <th>Name</th>
                                        <th>Patient Code</th>
                                        <th>Type</th>
                                        <th>Status</th>
                                        <th>Joined Date</th>
                                        <th>Discharged</th>
                                    </tr>
                                </thead>
                                @if (isset($count) && $count > 0)
                                <tobdy>
                                    @foreach ($detail as $key => $val)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $val->first_name }}</td>
                                        <td>{{ $val->patient_code }}</td>
                                        <td>{{ $val->patient_type }}</td>
                                        <td>{{ $val->status }}</td>
                                        <td>{{ $val->created_at }}</td>
                                        <td>{{ $val->discharged_at }}</td>
                                    </tr>
                                    @endforeach

                                </tobdy>
                                @endif
                            </table>
                        </div>





                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="{{URL::asset('backendtheme/plugins/jQuery/jQuery-2.1.4.min.js')}}"></script>
    <script>
        function validate() {
            var search = $('#search').val();
            if (search == '') {
                $('#search').focus();
                $('.error').text("Please enter value");
                return false;
            } else {
                $('.error').text('');
            }
        }
    </script>
@stop