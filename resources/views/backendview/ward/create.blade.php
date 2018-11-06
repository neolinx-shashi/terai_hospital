<div class="panel panel-default department-add">
    <div class="panel-body">
        <form method="post" action="{{URL::action('BackEndController\WardController@store')}}">
            {!! csrf_field() !!}
            <div class="form-group">
                <label for="name">
                    Ward Name<span class=help-block" style="color: #b30000">&nbsp;* </span></label>
                    <input type="text" class="form-control" id="name" name="ward_name"
                           placeholder="Enter Ward name." value="{{ old('ward_name') }}">
                    @if ($errors->has('ward_name'))
                        <span class="help-block" style="color: red">
                            <strong> * {{ $errors->first('ward_name') }}</strong>
                        </span>
                    @endif
            </div>

            <div class="form-group">
                <label for="desc">
                    Ward Description<span class=help-block"
                                          style="color: #b30000">&nbsp;</span></label>
                                    <textarea class="form-control" id="desc" name="ward_desc" style="height:100px;"
                                              placeholder="Enter ward description."
                                              value="{{ old('ward_desc') }}"></textarea>
                    @if ($errors->has('ward_desc'))
                        <span class="help-block" style="color: red">
                                    <strong> * {{ $errors->first('ward_desc') }}</strong>
                                    </span>
                    @endif
            </div>
           <button type="submit" class="btn btn-primary save btn-flat"><i class="fa fa-plus-circle"></i>Add</button>

        <label class="note" for="panel-body">Note:  Field With <span class="text-danger"> * </span> are  mandatory </label>
        </form>
    </div>
</div>