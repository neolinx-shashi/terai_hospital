
<div class="panel panel-default department-add">

    <div class="panel-body">
        <form  method="post" action="{{url('update-department',array($edit->id))}}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            
             <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                <label for="name">Department Name<label class="text-danger">*</label></label>
                <input type="text" name="name" placeholder="Enter Department."  class="form-control" id="name" value="{{$edit->name}}" required="required">
                @if ($errors->has('name'))
                <span class="help-block" style="color: red">
                    <strong>  {{ $errors->first('name') }}</strong>
                </span>
                @endif
            </div>



             <div class="form-group{{ $errors->has('department_code') ? ' has-error' : '' }}">
                <label for="department_code">Department Code<label class="text-danger">*</label></label>
                <input type="text" name="department_code" placeholder="Enter Department Code."  class="form-control" id="department_code" value="{{$edit->department_code}}" required="required">
                @if ($errors->has('department_code'))
                <span class="help-block" style="color: red">
                    <strong>  {{ $errors->first('department_code') }}</strong>
                </span>
                @endif
            </div>

            <button type="submit" class="btn btn-success btn-flat"><i class="fa fa-refresh"></i> Update</button>
            
            <a href="{{url('department')}}"><button type="button" class="btn btn-primary save btn-flat pull-right"><i class="fa fa-plus-circle"></i> Add New</button></a>
            <label class="note" for="panel-body">Note:  Field With <span class="text-danger"> * </span> are  mandatory </label>
        </form>
    </div>
</div>
