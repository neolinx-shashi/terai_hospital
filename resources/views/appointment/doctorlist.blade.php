@extends('backendlayout.master')
@extends('backendlayout.header')
@extends('backendlayout.leftmenu')
@extends('backendlayout.footer')
@section('userscontent')

    @extends('backendlayout.flashmessagecollection')
    <style>
        .no-padding {padding: 0;}
        .spacer {margin: 20px 0;}
        .fat {font-weight: bold;}
        .mright {margin-right: 10px;}
        .glyphicon {cursor: pointer;}
        a .glyphicon {color: #000;}
        #search-form{margin-bottom: 10px;}
        .panel-heading{padding: 0;}
        .panel-heading a{
            padding: 10px 15px;
            display: block;
            font-weight: 600;
        }
        .panel-heading a{
            position: relative;
            font-weight: 500;
        }
        .panel-heading a:before {
            content: "\f0f0";
            font-family: FontAwesome;
            margin-right: 5px;
        }
        .panel-heading a:after {
            content: "\f107";
            font-family: FontAwesome;
            position: absolute;
            right: 10px;
        }
        input.form-control.btn.btn-primary {
            text-transform: uppercase;
        }
        .panel-default>.panel-heading:hover{
            background-color: aliceblue;
        }
    </style>
    <link href="{{ URL::asset('css/bootstrap-datetimepicker.css') }}">
    <section class="content-header">
    <!--<a href="{{ url('news/create') }}" class="btn btn-warning pull-right"><span class="glyphicon glyphicon-plus-sign"></span> Add</a>-->
        <h1>Doctors</h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body">

                        <form action="{{ url('/searchDoctor') }}" method="post" class="pull-right form-inline" id="search-form">
                            {{ csrf_field() }}
                            <input name="keyword" id="keyword" type="text" class="form-control" value="{{ $keyword or '' }}" placeholder="Doctor Name" />
                            <select name="department" class="form-control">
                                <option value="0">All Departments</option>
                                @foreach ($departments as $val)
                                <option value="{{ $val->id }}" @if ($val->id == $department) selected @endif>{{ $val->name }}</option>
                                @endforeach
                            </select>
                            <input name="sumit" type="submit" value="search" class="form-control btn btn-primary" />
                        </form>

                        <div class="clearfix"></div>

                        @if(Session::has('message'))
                            <div class="alert alert-success" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                {{ Session::get('message') }}
                            </div>
                        @endif
                        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                            @if (!$doctors->isEmpty())
                                @foreach ($doctors as $key => $list)
                                    <div class="panel panel-default">
                                        <div class="panel-heading" role="tab" id="heading{{ $key }}">
                                            <h4 class="panel-title">
                                                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse{{ $key }}" aria-expanded="true" aria-controls="collapse{{ $key }}">
                                                    {{ ucfirst($list->first_name) }} {{ $list->middle_name or '' }} {{ $list->last_name }} [ {{ $list->name }} ]
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="collapse{{ $key }}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading{{ $key }}">
                                            <div class="panel-body">
                                                @foreach ($list['schedule'] as $val)
                                                    <div class="col-md-2">
                                                        {{ $days[$val->day_id] }}<br>
                                                        <b>Time:</b> {{ $val->start_time }} - {{ $val->end_time }}<br>
                                                        <b>Shift Type:</b> {{ $val->shift_type }}<br>
                                                        <a href="{{ url('/reserve/'.$val->doctor_id.'/'.$val->shift_id) }}" class="btn btn-info">Reserve</a>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                No Record Found.
                            @endif
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="{{URL::asset('backendtheme/plugins/jQuery/jQuery-2.1.4.min.js')}}"></script>

    <script>

    </script>

@stop