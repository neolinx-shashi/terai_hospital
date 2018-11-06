<div class="panel panel-default department-add">

    <div class="panel-body">
        <form method="post" action="{{url('ward/room')}}">
            {!! csrf_field() !!}
            <div class="form-group">
                {{--<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">--}}
                <label for="name">
                    Room Name/No.<span class=help-block" style="color: #b30000">&nbsp;* </span></label>
                <input type="text" class="form-control" id="name" name="room_name"
                       placeholder="Enter Room Name" value="{{ old('room_name') }}">
                @if ($errors->has('room_name'))
                    <span class="help-block" style="color: red">
                                    <strong> * {{ $errors->first('room_name') }}</strong>
                                    </span>
                @endif
            </div>

            <div class="form-group">
                <label for="ward_id">
                    Ward<span class=help-block"
                              style="color: #b30000">&nbsp;* </span></label>
                <select class="form-control" name="ward_id" id="ward_id">
                    <option value=" ">Select Ward</option>
                    @foreach($wards as $ward)
                        <option value="{{$ward->id}}"
                        @if(old('ward_id')==$ward->id) <?php echo 'selected' ?> @endif>{{ucfirst($ward->ward_name)}}</option>
                    @endforeach
                </select>
                @if ($errors->has('ward_id'))
                    <span class="help-block" style="color: red">
                                    <strong> * {{ $errors->first('ward_id') }}</strong>
                                    </span>
                @endif
            </div>

            <div class="form-group room_type" id="room_type" hidden>
                <label for="room_type">
                    Room Type<span class=help-block"
                                   style="color: #b30000">&nbsp;* </span></label>
                <select class="form-control" name="room_type" id="room_type">
                    <option value=" ">Select Room Type</option>
                    <option value="deluxe" @if(old('room_type') == "deluxe") <?php echo 'selected' ?> @endif>Deluxe</option>
                    <option value="one bed" @if(old('room_type') == "one bed") <?php echo 'selected' ?> @endif>One Bed</option>
                    <option value="two bed" @if(old('room_type') == "two bed") <?php echo 'selected' ?> @endif>Two Bed</option>
                </select>
                @if ($errors->has('room_type'))
                    <span class="help-block" style="color: red">
                                    <strong> * {{ $errors->first('room_type') }}</strong>
                                    </span>
                @endif
            </div>

            <div class="form-group">
                <label for="desc">
                    Floor<span class=help-block"
                               style="color: #b30000">&nbsp;* </span></label>
                <select class="form-control" name="floor" id="floor">
                    <option value=" ">Select Floor</option>
                    <option value="1st Floor" @if(old('floor')=='1st Floor') <?php echo 'selected' ?> @endif>
                        1st Floor
                    </option>
                    <option value="2nd Floor" @if(old('floor')=='2nd Floor') <?php echo 'selected' ?> @endif>
                        2nd Floor
                    </option>
                    <option value="Ground Floor" @if(old('floor')=='Ground Floor') <?php echo 'selected' ?> @endif>
                        Ground Floor
                    </option>
                </select>
                @if ($errors->has('floor'))
                    <span class="help-block" style="color: red">
                                    <strong> * {{ $errors->first('floor') }}</strong>
                                    </span>
                @endif
            </div>

            <div class="form-group">
                {{--<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">--}}
                <label for="name">
                    Room Rate<span class=help-block" style="color: #b30000">&nbsp;* </span></label>
                <input type="number" class="form-control" id="name" name="room_rate"
                       placeholder="Enter Room Rate" value="{{ old('room_rate') }}" required="required" min="0">
                @if ($errors->has('room_rate'))
                    <span class="help-block" style="color: red">
                    <strong> * {{ $errors->first('room_rate') }}</strong>
                    </span>
                @endif
            </div>

            <button type="submit" class="btn btn-primary save btn-flat"><i class="fa fa-plus-circle"></i>Add</button>

            <label class="note" for="panel-body">Note: Field With <span class="text-danger"> * </span> are mandatory
            </label>
        </form>
    </div>

</div>