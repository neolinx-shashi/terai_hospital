<div class="panel panel-default department-add">
    <div class="panel-body">
        <form method="post"
              action="{{URL::action('BackEndController\BedController@store')}}">
            {!! csrf_field() !!}
            <div class="form-group">
                {{--<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">--}}
                <label for="name">
                    Bed Name/No.<span class=help-block" style="color: #b30000">&nbsp;* </span></label>
                <input type="text" class="form-control" id="name" name="bed_name"
                       placeholder="Enter Bed Name/No." value="{{ old('bed_name') }}">
                @if ($errors->has('bed_name'))
                    <span class="help-block" style="color: red">
                                    <strong> * {{ $errors->first('bed_name') }}</strong>
                                    </span>
                @endif
            </div>

            <div class="form-group ">
                <label for="ward">
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
                <select class="form-control" name="room_type" id="room_type1">
                    <option value=" ">Select Room Type</option>
                    <option value="deluxe" @if(old('room_type') == "deluxe") <?php echo 'selected' ?> @endif>Deluxe
                    </option>
                    <option value="one bed" @if(old('room_type') == "one bed") <?php echo 'selected' ?> @endif>One Bed
                    </option>
                    <option value="two bed" @if(old('room_type') == "two bed") <?php echo 'selected' ?> @endif>Two Bed
                    </option>
                </select>
                @if ($errors->has('room_type'))
                    <span class="help-block" style="color: red">
                                    <strong> * {{ $errors->first('room_type') }}</strong>
                                    </span>
                @endif
            </div>

            <div class="form-group">
                <label for="desc">
                    Room<span class=help-block"
                              style="color: #b30000">&nbsp;* </span></label>
                <div id="room">
                    <select class="form-control" name="room_id" id="rooms">
                        <option value=" ">Select Room</option>
                        @foreach($rooms as $room)
                            <option value="{{$room->id}}"
                            @if(old('room_id')==$room->id) <?php echo 'selected' ?> @endif>{{ucfirst($room->room_name)}}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('room_id'))
                        <span class="help-block" style="color: red">
                                    <strong> * {{ $errors->first('room_id') }}</strong>
                                    </span>
                    @endif
                </div>
            </div>
            {{--</div>--}}
            <button type="submit" class="btn btn-primary save btn-flat"><i class="fa fa-plus-circle"></i>Add</button>

            <label class="note" for="panel-body">Note: Field With <span class="text-danger"> * </span> are mandatory
            </label>
        </form>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('#ward_id').change(function () {
            var wid = $(this).val();
            //alert(wid)
            var url = '{{ url("get-ward/") }}/' + wid;
            $.get(url, function (res) {
                if (res == "Private") {
                    document.getElementById("room_type").style.display = "block";
                    $('#room_type1').change(function () {
                        var roomType = $(this).val();
                        $("#room").load({!! json_encode(url('/ward/private/getRooms')) !!}  +'/' + roomType + '/0');
                    });
                } else {
                    //alert(wid)
                    $("#room").load({!! json_encode(url('/ward/getRooms')) !!}  +'/' + wid + '/0');
                    document.getElementById("room_type").style.display = "none";
                }
            });
        });

        /*$(document).ready(function () {
            $('#ward_id').change(function () {
                var wid = $(this).val();
                var url = '{{ url("get-ward/") }}/' + wid;
                $.get(url, function (res) {
                    if (res == "Private") {
                        document.getElementById("room_type").style.display = "block";
                    } else {
                        document.getElementById("room_type").style.display = "none";
                    }
                });
            });
        });*/
    });
</script>