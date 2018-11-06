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
    .ninja {display: none;}
</style>
<link href="{{ URL::asset('css/bootstrap-datetimepicker.css') }}">
<section class="content-header">
    <h1>{{{ $title or '' }}} Report</h1>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    <div class="col-md-12"></div>
                    
                        <form name="pathology-report" method="post" action="{{ url('/operate-general-report') }}">
                            {{ csrf_field() }}

                            <div class="col-md-2"></div>

                            <div class="form-group col-md-3">
                                <label class="sr-only" for="fromDate">From Date</label>
                                <div class="input-group">
                                    <div class="input-group-addon">From</div>
                                    <input name="datefrom" id="datefrom" type="text" class="form-control" value="{{{ $date_from or getTodayNepaliDate()}}}" />
                                </div>
                            </div>

                            <div class="form-group col-md-3">
                                <label class="sr-only" for="toDate">To Date</label>
                                <div class="input-group">
                                    <div class="input-group-addon">To</div>
                                    <input name="dateto" id="dateto" type="text" class="form-control" value="{{{ $date_to or getTodayNepaliDate()}}}" />
                                </div>
                            </div>

                            <div class="form-group col-md-3">
                                <label class="sr-only" for="category">Test</label>
                                <div class="input-group">
                                    <div class="input-group-addon">Test</div>
                                    <select class="form-control" name="category" id="category">
                                        <option value="0">- Select Test -</option>
                                        @foreach ($category as $cate)
                                        <option value="{{ $cate->id }}" @if ($cate->id == $cat) selected @endif>{{ $cate->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-1"><input name="submit" id="submit" type="submit" value="View" class="btn btn-info"/></div>
                        </form>
                    <div class="clearfix"></div><br>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="{{ url('js/jquery-3.2.1.min.js') }}"></script>
<!--<script src="{{URL::asset('backendtheme/plugins/jQuery/jQuery-2.1.4.min.js')}}"></script>-->
<script>
    $(function () {
        $('#datetimepicker1').datetimepicker({
            userCurrent: true
        });

        
    });
</script>

  <script type="text/javascript">
        $(document).ready(function(){
            $('#datefrom').nepaliDatePicker({
                ndpEnglishInput: 'englishDate'
            });

            $('#dateto').nepaliDatePicker({
                ndpEnglishInput: 'englishDate'
            });


            $('#category').change(function() {
                var cat = $(this).val();
                if (cat === "0") {
                    alert('Choose Test');
                    $('#submit').attr('disabled', 'disabled');
                } else {
                    $('#submit').removeAttr('disabled');
                }
            });
        });
    </script>
@stop



@section('footerscripts')


<!-- excel export -->
<script type="text/javascript" src="{{ URL::asset('js/xl/tableExport.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/xl/jquery.base64.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/xl/html2canvas.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/xl/jspdf/libs/sprintf.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/xl/jspdf/jspdf.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/xl/jspdf/libs/base64.js') }}"></script>

@stop