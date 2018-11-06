@extends('backendlayout.master')
@extends('backendlayout.header')
@extends('backendlayout.leftmenu')
@extends('backendlayout.footer')
@section('userscontent')
@extends('backendlayout.flashmessagecollection')
<section class="content-header">
 <div class="search-breadcrumb-only">
      <div class="row">
          <div class="col-md-10">
              <ol class="breadcrumb">
                  <li><a href="{{url('dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                  <li><a href="{{URL('configuration/shift-setup')}}">System Setup</a></li>
                  <li class="active">Add Shift</li>
              </ol>
          </div>
          <div class="col-md-2">
              <a href="{{URL::action('BackEndController\DoctorShiftController@index')}}">
                <button type="button" class="btn btn-warning btn-flat  pull-right ">
                  <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span> View Shifts
                </button>
              </a> 
          </div>
      </div>
  </div>


</section>
<section class="content">
    <form class="form-horizontal" method="post"
    action="{{URL::action('BackEndController\DoctorShiftController@store')}}">
    {!! csrf_field() !!}
<div class="box">
<div class="shadow">
<div class="row">
<div class="col-lg-12">
<br>
    <div class="form-group {{ $errors->has('day_id') ? ' has-error' : '' }}">
        <label for="inputlname" class="col-sm-2 form-control-label" style="margin-left: 15px;">Day
            Name <label class="text-danger">*</label></label>
            <div class="col-sm-3">
            
                <select class="form-control" id="gender" name="day_id">
                    <option value=" ">Select Day</option>
                    @foreach($dayName as $dayData)
                    <option value="{{$dayData->id}}" @if(old('id')==$dayData->id) <?php echo 'selected' ?>  @endif >
                       {{ucfirst($dayData->name)}}
                   </option>
                   @endforeach
               </select>
               @if($errors->has('day_id'))
               <span class="help-block" style="color: red">
                <strong> * {{ $errors->first('day_id') }}</strong>
            </span>
            @endif
        </div>
    </div>
<table class="table table-bordered table-hover" id="tableAddRow" style="border: 1px solid #ddd;">
<thead>
<tr style="background-color: #d9edf7">
<th>Start Time <label class="text-danger">*</label></th>
<th>End Time <label class="text-danger">*</label></th>
<th>Shift Name <label class="text-danger">*</label></th>
<th style="width:10px"><span class="glyphicon glyphicon-plus addBtn"
 id="addBtn_0"></span></th>
</tr>
</thead>
<tbody>

<tr id="tr_0">
<td {{ ($errors->has('start_time.0'))?'has-error':'' }}>
<div class='input-group date col-sm-3' id='datetimepickerstart'>
    <input type="text" name="start_time[0]"  value="{{old('start_time')?old('start_time')[0]:null}}" class="input"/>
    <span class="input-group-addon">
       <span class="glyphicon glyphicon-time"></span>
   </span>
   {!! $errors->first('start_time.0', '<span class="text-danger">:message</span>') !!}
</div>                       
</td>
<td {{ ($errors->has('end_time.0'))?'has-error':'' }}>
<div id="datetimepickerend" class='input-group date col-sm-3'>
<input type="text" name="end_time[0]" value="{{old('end_time')?old('end_time')[0]:null}}"/>
<span class="input-group-addon">
<span class="glyphicon glyphicon-time"></span> </span>
{!! $errors->first('end_time.0', '<span class="text-danger">:message</span>') !!}
</div>
</td>
<td {{ ($errors->has('shift_type.0'))?'has-error':'' }}>
<div  class="input-append">
<input  type="text" name="shift_type[0]" id="userName" style="border: 1px solid #999999; padding:3px 2px 3px 2px; margin-left: -4px;" value="{{old('shift_type')?old('shift_type')[0]:null}}">
{!! $errors->first('shift_type.0', '<span class="text-danger">:message</span>') !!}
</div>
</td>
<td>
</td>
</tr>
</tbody>
</table>
</div>

<div class="form-group row">
<div class="col-md-12">
<button type="submit" class="col-md-1 col-lg-offset-9 btn btn-primary btn-flat">
Save
</button>
<button type="reset" class="col-md-1 btn btn-warning btn-flat"
style="margin-left: 1px;">
Reset
</button>
</div>
</div>

    <p class="pull-right" style="padding-right:45px"><label>Note: Field With <label class="text-danger">
        * </label> are mandatory </label>
    </p>
</div>


</div>
</div>

</form>
</section>
<script type="text/javascript">
    $(function () {
        $('#datetimepickerstart').datetimepicker({
            format: 'LT'
        });
        $('#datetimepickerend').datetimepicker({
            format: 'LT'
        });

    });
</script>
<script src="{{URL::asset('backendtheme/plugins/jQuery/jQuery-2.1.4.min.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('.addBtn').on('click', function () {
            //var trID;
            //trID = $(this).closest('tr'); // table row ID
            addTableRow();
        });

        $('.addBtnRemove').click(function () {
            $(this).closest('tr').remove();
        })


        var i = 1;
        var j = 1;
        function addTableRow() {
            var tempTr = $('<tr><td><div id="datetimepicker'+ i +'" class="input-group date col-sm-3"><input type="text" name="start_time[]" id="userName_' + i + '"/><span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span></td></div><td><div id="datetimepickerendOnly'+ j +'" class="input-group date col-sm-3"><input type="text" name="end_time[]" id="email_' + i + '"/><span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span></div></td><td><input  type="text" name="shift_type[]" id="userName" style="border: 1px solid #999999; padding:3px 2px 3px 2px; margin-left: -4px;"></td><td><span class="glyphicon glyphicon-trash addBtnRemove" id="addBtn_' + i + '" style="color:red";></span></td></tr>').on('click', function () {

                // $(this).closest('tr').remove();
                $('.addBtnRemove').click(function () {
                    $(this).closest('tr').remove();
                })
                $(document.body).on('click', '.TreatmentHistoryRemove', function (e) {
                    $(this).closest('tr').remove();
                });
            });
            $("#tableAddRow").append(tempTr)
            
            $('#datetimepicker' + i++ +'').datetimepicker({
                format: 'LT'
            });
            i++;

            $('#datetimepickerendOnly' + j++ +'').datetimepicker({
                format: 'LT'
            });
            j++;
        }
    });


</script>
@stop





