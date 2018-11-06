<div class="panel panel-default department-add">
    <!-- <div class="panel-heading">
        <div class="panel-title"><a href="{{URL::to('/nationality-setup')}}"><i class="fa fa-plus-circle"></i> Add Nationality</a></div>
    </div> -->
    <div class="panel-body">
    <form  method="post" action="{{url('update-nationality',array($edit->id))}}">
    {!! csrf_field() !!}
   
     <div class="form-group{{ $errors->has('short_form_name') ? ' has-error' : '' }}">
        <label for="short_form_name">
            Short Form<label class="text-danger"> *</label></label>
        <input type="text" class="form-control" id="short_form_name" name="short_form_name"
                placeholder="Enter Nationality Short Form."  value="{{$edit->short_form_name }}" required="required">
                @if ($errors->has('short_form_name'))
                <span class="help-block" style="color: red">
                    <strong> * {{ $errors->first('short_form_name') }}</strong>
                </span>
                @endif
        </div>


    <div class="form-group{{ $errors->has('country_name') ? ' has-error' : '' }}">
        <label for="country_name">
            Country Name<label class="text-danger"> *</label></label>
                <input type="text" class="form-control" id="country_name" name="country_name"
                placeholder="Enter Country Name."  value="{{$edit->country_name}}" required="required">
                @if ($errors->has('country_name'))
                <span class="help-block" style="color: red">
                    <strong> * {{ $errors->first('country_name') }}</strong>
                </span>
                @endif
        </div>



    <div class="form-group{{ $errors->has('calling_code') ? ' has-error' : '' }}">
        <label for="calling_code" >
            Calling Code<label class="text-danger"> *</label></label>
                <input type="text" class="form-control" id="calling_code" name="calling_code"
                placeholder="Enter Calling Code."  value="{{$edit->calling_code}}" required="required">
                @if ($errors->has('calling_code'))
                <span class="help-block" style="color: red">
                    <strong> * {{ $errors->first('calling_code') }}</strong>
                </span>
                @endif
        </div>
             <button type="submit" class="btn btn-success btn-flat"><i class="fa fa-refresh"></i> Update</button>
            <a href="{{url('nationality-setup')}}"><button type="button" class="btn btn-primary save btn-flat pull-right"><i class="fa fa-plus-circle"></i> Add New</button></a>
            <label class="note" for="panel-body">Note:  Field With <span class="text-danger"> * </span> are  mandatory </label>
    </form>
   </div>
        </div>