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
</style>
<link href="{{ URL::asset('css/bootstrap-datetimepicker.css') }}">
<section class="content-header">
    <!--<a href="{{ url('news/create') }}" class="btn btn-warning pull-right"><span class="glyphicon glyphicon-plus-sign"></span> Add</a>-->
    <h1>Appointment</h1>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    <form action="{{ url('operate_appointment') }}" method="post" class="form-group">
                        <div class="form-group">
                            <div class="col-md-2">
                                <label for="code">Patient Name: </label>
                            </div>
                            <div class="col-md-3">
                                <input name="patient_name" id="patient-name" class="form-control" type="text">
                            </div>
                        </div>
                        <div class="clearfix"></div><br>
                        <div class="form-group">
                            <div class="col-md-2">
                                <label for="code">Contact Number: </label>
                            </div>
                            <div class="col-md-3">
                                <input name="patient_contact" id="patient-contact" class="form-control" type="text">
                            </div>
                        </div>
                        <div class="clearfix"></div><br>
                        <div class="form-group">
                            <div class="col-md-2">
                                <label for="code">Date: </label>
                            </div>
                            <div class="col-md-3">
                                <input name="appointment_date" id="appointment-date" class="form-control" type="text" value="{{ getTodayNepaliDate()}}" readonly>
                            </div>
                        </div>
                        <div class="clearfix"></div><br>
                        <div class="form-group">
                            <div class="col-md-2">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input name="doc_id" type="hidden" value="{{ $doc_id }}" />
                                <input name="shift_id" type="hidden" value="{{ $shift_id }}" />
                            </div>
                            <div class="col-md-2">
                                <input name="submit" type="submit" class="btn btn-primary" value="Save" />
                            </div>
                        </div>
                    </form>


                </div>
            </div>
        </div>
    </div>
</section>

<script src="{{URL::asset('backendtheme/plugins/jQuery/jQuery-2.1.4.min.js')}}"></script>

<script>

</script>
<script type="text/javascript">
         $(document).ready(function(){
        $('#appointment-date').nepaliDatePicker({
            ndpEnglishInput: 'englishDate'
        });

         $('#dateto').nepaliDatePicker({
            ndpEnglishInput: 'englishDate'
        });

        });
    </script>

@stop