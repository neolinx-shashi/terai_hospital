<div class="panel panel-default department-add">
    <div class="panel-body">
        <form method="post"
              action="{{url('update-admission-charge',array($edit->id))}}">

            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="form-group {{ ($errors->has('admission_charge'))?'has-error':'' }}">
                <label for="fiscal_year_nepali">Admission Charge <label class="text-danger">*</label></label>

                <input type="text" name="admission_charge" class="form-control"
                        id="admission_charge" value="{{$edit->admission_charge}}"
                     
                       placeholder="Enter Admission Charge">
                        @if ($errors->has('admission_charge'))
                <span class="help-block" style="color: red">
                    <strong> * {{ $errors->first('admission_charge') }}</strong>
                </span>
                @endif
            </div>
       
            <button type="submit" class="btn btn-success btn-flat"><i class="fa fa-refresh"></i> Update</button>
          <a href="{{URL::to('/admission-charge')}}">
           <button type="button" class="btn btn-primary save btn-flat pull-right"><i class="fa fa-plus-circle"></i> Add New</button>
          </a>
            <label class="note" for="panel-body">Note:  Field With <span class="text-danger"> * </span> are  mandatory </label>        </form>
    </div>
</div>
