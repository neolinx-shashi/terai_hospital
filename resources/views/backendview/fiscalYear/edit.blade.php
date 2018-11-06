<div class="panel panel-default department-add">
    <div class="panel-body">
        <form method="post"
              action="{{url('update-fiscal-year',array($edit->id))}}">

            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="form-group {{ ($errors->has('fiscal_year_start_date'))?'has-error':'' }}">
                <label for="fiscal_year_nepali">Fiscal Year <label class="text-danger">*</label></label>

                <input type="text" name="fiscal_year_start_date" class="form-control" 
                        id="fiscal_year_start_date" value="{{$edit->fiscal_year_start_date}}" 
                     
                       placeholder="Enter Fiscal Year Name">
                        @if ($errors->has('fiscal_year_start_date'))
                <span class="help-block" style="color: red">
                    <strong> * {{ $errors->first('fiscal_year_start_date') }}</strong>
                </span>
                @endif
            </div>
       
            <button type="submit" class="btn btn-success btn-flat"><i class="fa fa-refresh"></i> Update</button>
          <a href="{{URL::to('/fiscal-year')}}"> 
           <button type="button" class="btn btn-primary save btn-flat pull-right"><i class="fa fa-plus-circle"></i> Add New</button>
          </a>
            <label class="note" for="panel-body">Note:  Field With <span class="text-danger"> * </span> are  mandatory </label>        </form>
    </div>
</div>
