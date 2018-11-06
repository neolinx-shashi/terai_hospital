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
    .fat {font-weight: bold;}
    .mright {margin-right: 10px;}
    .glyphicon {cursor: pointer;}
    a .glyphicon {color: #000;}
    h4.no-doctor-alert{font-weight: bold;color: red;}
    .panel-default>.panel-heading{
        color: #f9f9f9;
        background-color: #3c8dbc;
    }
    input#date-appointment {
        cursor: pointer;
    }
</style>
<link href="{{ URL::asset('css/bootstrap-datetimepicker.css') }}">
<section class="content-header">
    <!--<a href="{{ url('news/create') }}" class="btn btn-warning pull-right"><span class="glyphicon glyphicon-plus-sign"></span> Add</a>-->
    <h1>Appointment List</h1>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">

                    <form method="post" class="form-group" onsubmit="return submitForm();">

                        <div class="form-group">
                            <div class="col-md-9"></div>
                            <div class="col-md-2"> 
                                <input name="date" id="date-appointment" type="text"  value="{{ getTodayNepaliDate() }}" class="form-control" readonly />
                            </div>
                            <div class="col-md-1"><input name="submit" class="btn btn-info search-btn" type="submit" value="Search" /></div>
                        </div>
                        
                    </form>

                    <div class="clearfix"></div><br><br>

                    <div class="col-md-12">
                        @if ($patient_list)
                            @foreach ($patient_list as $val)
                            <div class="col-md-4">
                                <div class="panel panel-default">
                                    <div class="panel-heading">{{ $val[0]['doctor'] }}</div>
                                    <div class="panel-body">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>S.No.</th>
                                                    <th>Patient</th>
                                                    <th>Time</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($val as $ky => $pat)
                                                <tr>
                                                    <td>{{ $ky + 1 }}</td>
                                                    <td>{{ $pat['patient'] }}</td>
                                                    <td>{{ $pat['start_time'] }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @else
                            <center><h4 class="no-doctor-alert">No Appointments</h4></center>
                        @endif
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-md-12">
                        <button class="btn btn-info pull-right" id="print-page"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

<script src="{{URL::asset('backendtheme/plugins/jQuery/jQuery-2.1.4.min.js')}}"></script>

<script>
function submitForm() {
    var date = $('#date-appointment').val();
    var url = "{{ url('/appointment/patientlist') }}/" + date;
    window.location = url;
    return false;
}

$(function() {
    $('#print-page').click(function() {
        $('#print-page, .search-btn').hide();
        window.print();
        $('#print-page, .search-btn').show();
    });
});
</script>

 <script type="text/javascript">
         $(document).ready(function(){
        $('#date-appointment').nepaliDatePicker({
            ndpEnglishInput: 'englishDate'
        });

         $('#dateto').nepaliDatePicker({
            ndpEnglishInput: 'englishDate'
        });

        });
    </script>

@stop