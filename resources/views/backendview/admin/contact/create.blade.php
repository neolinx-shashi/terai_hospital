<div class="panel panel-default department-add">
    <div class="panel-body">
        <form method="post"
              action="{{URL::action('BackEndController\ContactController@store')}}">


            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                <label for="name">Name <label class="text-danger">*</label></label>

                <input type="text" name="name" placeholder="Enter Contact Name" value="{{ old('name') }}"
                       class="form-control" id="name">
                @if ($errors->has('name'))
                    <span class="help-block" style="color: red">
                <strong>  {{ $errors->first('name') }}</strong>
            </span>
                @endif
            </div>

            <div class="form-group{{ $errors->has('contact') ? ' has-error' : '' }}">
                <label for="contact">Contact <label class="text-danger">*</label></label>

                <input type="text" name="contact" placeholder="Enter Contact Number" value="{{ old('contact') }}"
                       class="form-control" id="contact">
                @if ($errors->has('contact'))
                    <span class="help-block" style="color: red">
                <strong>  {{ $errors->first('contact') }}</strong>
            </span>
                @endif
            </div>

            <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
                <label for="type">Type <label class="text-danger">*</label></label>

                <select name="type" id="type" class="form-control">
                    <option value="">Select Contact Type</option>
                    <option value="doctor"
                    @if(old('type') == 'doctor')
                        <?php echo 'selected' ?>
                    @endif>
                        Doctor
                    </option>

                    <option value="staff"
                    @if(old('type') == 'staff')
                        <?php echo 'selected' ?>
                            @endif>
                        Staff
                    </option>

                    <option value="emergency" 
                    @if(old('type') == 'emergency')
                        <?php echo 'selected' ?>
                    @endif>
                        Emergency
                    </option>
                </select>

                @if ($errors->has('type'))
                    <span class="help-block" style="color: red">
                        <strong> * {{ $errors->first('type') }}</strong>
                    </span>
                @endif
            </div>

            <button type="submit" class="btn btn-primary save btn-flat"><i class="fa fa-plus-circle"></i>Add</button>

            <label class="note" for="panel-body">Note: Field With <span class="text-danger"> * </span> are mandatory
            </label>
        </form>
    </div>
</div>

