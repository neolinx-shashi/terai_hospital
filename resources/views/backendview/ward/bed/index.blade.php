@extends('backendlayout.master')
@extends('backendlayout.header')
@extends('backendlayout.leftmenu')
@extends('backendlayout.footer')
@section('userscontent')
    @extends('backendlayout.flashmessagecollection')
    <script src="{{URL::asset('backendtheme/plugins/jQuery/jQuery-2.1.4.min.js')}}"></script>

    <section class="content-header">
        <div class="search-breadcrumb-only">
            <div class="row">
                @if(\Request::segment(4)=='edit')
                    <div class="col-lg-12">
                        <ol class="breadcrumb">
                            <li><a href="{{url('dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                            <li><a href="{{URL('/ward/bed')}}">Bed List</a></li>
                            <li class="active">Edit Bed</li>
                        </ol>
                    </div>
                @else
                    <ol class="breadcrumb ">
                        <li><a href="{{url('dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                        <li><a href="{{URL('/ward/bed')}}">Bed List</a></li>
                        <li class="active">Create Bed</li>
                    </ol>
                @endif

            </div>
        </div>


    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-8">
                <div class="box">
                    <div class="box-header">
                    </div>
                    <div class="box-body">
                        @if(count($beds)>0)
                            <table id="example1" class="table table-hover table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th style="width:50px;">S.N</th>
                                    <th>Bed</th>
                                    <th>Room</th>
                                    <th>Room Type</th>
                                    <th>Ward</th>
                                    <th>Floor</th>
                                    <th>Availability</th>
                                    <th class="col-md-2">Actions</th>
                                </tr>
                                </thead>
                                <tbody>

                                <?php
                                $i = $beds->firstItem();
                                ?>
                                @foreach($beds as $key=>$bed)
                                    <?php  $segment2 = Request::segment(3);  ?>
                                    <tr @if($bed->id==$segment2) class="success" @endif>

                                        <td>{{$i++}}.
                                        </td>

                                        <td>
                                            {{ucfirst($bed->bed_name)}}
                                        </td>

                                        <td>
                                            {{ ucfirst($bed->isOfRoom->room_name) }}
                                        </td>

                                        <td>
                                            {{ ucfirst($bed->isOfRoom->room_type) }}
                                        </td>

                                        <td>
                                            {{ ucfirst($bed->isOfWard->ward_name) }}
                                        </td>

                                        <td>
                                            {{ ucfirst($bed->isOfRoom->floor) }}
                                        </td>

                                        <td>
                                            {{ ucfirst($bed->availability) }}
                                        </td>

                                        <td>
                                            <a href="{{ URL::to('ward/bed/' . $bed->id . '/edit') }}">
                                                <button type="button" class="btn btn-default btn-flat  ">
                                                    <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                                                </button>
                                            </a>

                                            <a href="{{URL::to('ward/delete-bed',array($bed->id))}}"
                                               onclick="return confirm('Are you sure you want to delete this record?')" hidden>
                                                <button type="button" class="btn btn-danger btn-flat">
                                                    <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                                </button>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                            {{ $beds->render() }}
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
                    @include('backendview/ward/bed/edit')
                @else
                    @include('backendview/ward/bed/create')
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

    {{--@if(isset($room_type))
        <script type="text/javascript">
            document.getElementById("room_type").style.display = "block";
        </script>
    @endif--}}

@stop
