<div class="panel panel-default department-add">
    <div class="panel-body">
        <form method="post"
              action="{{URL::action('Admin\DepartmentController@store')}}">


            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                <label for="name">Department Name <label class="text-danger">*</label></label>
                <input type="text" name="name" placeholder="Enter Department." value="{{ old('name') }}"
                       class="form-control" id="name">
                @if ($errors->has('name'))
                    <span class="help-block" style="color: red">
                <strong>  {{ $errors->first('name') }}</strong>
            </span>
                @endif
            </div>

            <div class="form-group{{ $errors->has('department_code') ? ' has-error' : '' }}">
                <label for="department_code">Department Code <label class="text-danger">*</label></label>

                <input type="text" name="department_code" placeholder="Enter Department Code."
                       value="{{ old('department_code') }}" class="form-control" id="department_code">
                @if ($errors->has('department_code'))
                    <span class="help-block" style="color: red">
                <strong>  {{ $errors->first('department_code') }}</strong>
            </span>
                @endif
            </div>

            <button type="submit" class="btn btn-primary save btn-flat"><i class="fa fa-plus-circle"></i>Add</button>

            <label class="note" for="panel-body">Note: Field With <span class="text-danger"> * </span> are mandatory
            </label>
        </form>
    </div>
</div>

