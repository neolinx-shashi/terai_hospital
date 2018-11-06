<div class="panel panel-default department-add">
    <div class="panel-body">
        <form method="post" action="{{url('fiscal-year')}}" id="signupForm" >

            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="form-group {{ ($errors->has('fiscal_year_start_date'))?'has-error':'' }}">
                <label for="fiscal_year_start_date">Fiscal Year <label class="text-danger">*</label></label>

                <input type="text" name="fiscal_year_start_date" class="form-control" 
                id="fiscal_year_start_date" value="{{old('fiscal_year_start_date')}}" 
                
                placeholder="Enter Fiscal Year Name">
                @if ($errors->has('fiscal_year_start_date'))
                <span class="help-block" style="color: red">
                    <strong> * {{ $errors->first('fiscal_year_start_date') }}</strong>
                </span>
                @endif
            </div>
            
            <button type="submit" class="btn btn-primary save btn-flat"><i class="fa fa-plus-circle"></i>Add</button>

          <label class="note" for="panel-body">Note:  Field With <span class="text-danger"> * </span> are  mandatory </label>
        </form>
    </div>
</div>
