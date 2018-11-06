<div class="panel panel-default department-add">
    <div class="panel-body">
        <form method="post"
              action="{{url('update-emergency-fee',array($edit->id))}}">

            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="form-group {{ ($errors->has('emergency_fee'))?'has-error':'' }}">
                <label for="fiscal_year_nepali">Emergency Fee <label class="text-danger">*</label></label>

                <input type="text" name="emergency_fee" class="form-control" 
                        id="emergency_fee" value="{{$edit->emergency_fee}}" 
                     
                       placeholder="Enter Fiscal Year Name">
                        @if ($errors->has('emergency_fee'))
                <span class="help-block" style="color: red">
                    <strong> * {{ $errors->first('emergency_fee') }}</strong>
                </span>
                @endif
            </div>
       
            <button type="submit" class="btn btn-success btn-flat"><i class="fa fa-refresh"></i> Update</button>
          <a href="{{URL::to('/emergency-fee')}}"> 
           <button type="button" class="btn btn-primary save btn-flat pull-right"><i class="fa fa-plus-circle"></i> Add New</button>
          </a>
            <label class="note" for="panel-body">Note:  Field With <span class="text-danger"> * </span> are  mandatory </label>        </form>
    </div>
</div>
