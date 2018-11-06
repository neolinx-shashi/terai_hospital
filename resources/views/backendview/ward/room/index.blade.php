@extends('backendlayout.master')
@extends('backendlayout.header')
@extends('backendlayout.leftmenu')
@extends('backendlayout.footer')
@section('userscontent')
    @extends('backendlayout.flashmessagecollection')

    <section class="content-header">
        <div class="search-breadcrumb-only">
            <div class="row">
                @if(\Request::segment(4)=='edit')
                    <div class="col-lg-12">
                        <ol class="breadcrumb">
                            <li><a href="{{url('dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                            <li><a href="{{URL('/ward/room')}}">Room List</a></li>
                            <li class="active">Edit Room</li>
                        </ol>
                    </div>
                @else
                    <ol class="breadcrumb ">
                        <li><a href="{{url('dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                        <li><a href="{{URL('/ward/room')}}">Room List</a></li>
                        <li class="active">Create Room</li>
                    </ol>
                @endif

            </div>
        </div>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-8">
                <div class="box">
                    <div class="box-header">
                    </div>
                    <div class="box-body">
                        @if(count($rooms)>0)
                            <table id="example1" class="table table-hover table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th style="width:50px;">S.N</th>
                                    <th>Room Name</th>
                                    <th>Room Type</th>
                                    <th>Ward</th>
                                    <th>Room Rate</th>
                                    <th>No. Of Beds</th>
                                    <th style="width:100px;">Actions</th>
                                </tr>
                                </thead>
                                <tbody>

                                <?php
                                $i = $rooms->firstItem();
                                ?>
                                @foreach($rooms as $key=>$room)
                                    <?php  $segment2 = Request::segment(3);  ?>
                                    <tr @if($room->id==$segment2) class="success" @endif>
                                        <td>
                                            {{$i++}}.
                                        </td>

                                        <td>
                                            {{ucfirst($room->room_name)}}
                                        </td>

                                        <td>
                                            {{ucfirst($room->room_type)}}
                                        </td>

                                        <td>
                                            {{ ucfirst($room->isOfWard->ward_name) }}
                                        </td>

                                        <td>
                                          Rs.  {{ $room->room_rate }}
                                        </td>

                                        <td>
                                            <?php $bedCount = 0; ?>
                                            @foreach($beds as $bed)
                                                @if($bed->isOfRoom->id == $room->id)
                                                    <?php $bedCount++ ?>
                                                @endif
                                            @endforeach
                                            {{ $bedCount }}
                                        </td>

                                        <td>
                                            <a href="{{ URL::to('ward/room/' . $room->id . '/edit') }}"
                                               data-toogle="tooltip" data-placement="top" title="Edit Room Details">
                                                <button type="button"
                                                        class="btn btn-default btn-flat">
                                                    <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                                                </button>
                                            </a>

                                            <a href="{{URL::to('ward/delete-room/'. $room->id)}}"
                                               onclick="return confirm('Are you sure you want to delete this record?')"
                                               data-toogle="tooltip" data-placement="top" title="Delete Room Details" hidden>
                                                <button type="button" class="btn btn-danger btn-flat">
                                                    <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                                </button>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                            {{ $rooms->render() }}
                        @else
                            <div class="alert alert-danger">
                                <strong style="padding-left: 150px"> Sorry ! No record found
                                </strong>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                @if(\Request::segment(4)=='edit')
                    @include('backendview/ward/room/edit')
                @else
                    @include('backendview/ward/room/create')
                @endif
            </div>
        </div>
    </section>

    {{--<script>
        $(document).ready(function () {
            $('#ward_id').change(function () {
                var wid = $(this).val();
                var url = '{{ url("ward/get-ward/") }}/' + wid;
                $.get(url, function (res) {
                    if (res == "Private") {
                        document.getElementById("room_type").style.display = "block";
                    } else {
                        document.getElementById("room_type").style.display = "none";
                    }
                });
            });
        });
    </script>--}}

    {{--@if(old('ward_id'))
        <script>
            var wid = <?php echo old('ward_id') ?>;
            var url = '{{ url("ward/get-ward/") }}/' + wid;
            $.get(url, function (res) {
                if (res == "Private")
                {
                    document.getElementById("room_type").style.display = "block";
                }
            })
        </script>
    @endif--}}

    {{--@if(isset($edit->room_type))
        <script type="text/javascript">
            document.getElementById("room_type").style.display = "block";
        </script>
    @endif--}}
@stop