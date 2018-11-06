<div class="panel panel-default department-add">
    <div class="panel-body">
        <form method="post" action="{{url('emergency-fee')}}" id="signupForm" >

            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="form-group {{ ($errors->has('emergency_fee'))?'has-error':'' }}">
                <label for="emergency-fee">Emergency Fee <label class="text-danger">*</label></label>

                <input type="text" name="emergency_fee" class="form-control" 
                id="emergency-fee_" value="{{old('emergency_fee')}}" 
                
                placeholder="Enter emergency-fee Name">
                @if ($errors->has('emergency_fee'))
                <span class="help-block" style="color: red">
                    <strong> * {{ $errors->first('emergency_fee') }}</strong>
                </span>
                @endif
            </div>
            
            <button type="submit" class="btn btn-primary save btn-flat"><i class="fa fa-plus-circle"></i>Add</button>

          <label class="note" for="panel-body">Note:  Field With <span class="text-danger"> * </span> are  mandatory </label>
        </form>
    </div>
</div>
