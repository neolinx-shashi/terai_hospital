@extends('backendlayout.master')
@extends('backendlayout.header')
@extends('backendlayout.leftmenu')
@extends('backendlayout.footer')
@section('userscontent')
    @extends('backendlayout.flashmessagecollection')
    <section class="content-header">
        <h1>
            Doctor
            <strong>{{ucfirst($doctor->first_name).' '.ucfirst($doctor->middle_name).' '.ucfirst($doctor->last_name)}}</strong>
            <a href="{{URL::action('BackEndController\DoctorController@index')}}">
                <button type="button" class="btn btn-primary btn-flat  pull-right ">
                    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> &nbsp;Back
                </button>
            </a>
        </h1>
    </section>
    <section class="content">
        <form action="{{url('assign/shift',array($id))}}" method="post">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="row">
                            <div class="col-md-12">

                                <div class="nav-tabs-custom">

                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    
                                    <ul class="nav nav-tabs" role="tablist">
                                        @foreach ($days as $key => $day)
                                        <li role="presentation" class="@if ($today == $day->name) active @endif"><a href="#{{ $day->name }}" aria-controls="{{ $day->name }}" role="tab" data-toggle="tab">{{ $day->name }}</a></li>
                                        @endforeach
                                    </ul>

                                    <div class="tab-content">
                                        @foreach ($data_list as $key => $data)
                                        <div role="tabpanel" class="tab-pane @if ($today == $data['day']) active @endif" id="{{ $data['day'] }}">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>S.No.</th>
                                                        <th>Start Time</th>
                                                        <th>End Time</th>
                                                        <th>Shift Type</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                @if (isset($data['shift']))
                                                    @foreach ($data['shift'] as $val)
                                                    <tr>
                                                        <td><input name="shift_id[]" type="checkbox" id="checkBox" value="{{ $val['shift_id'] }}" @if(isset($val['rel_stat'])) checked @endif></td>
                                                        <td>{{ $val['start_time'] }}</td>
                                                        <td>{{ $val['end_time'] }}</td>
                                                        <td>{{ $val['shift_type'] }}</td>
                                                    </tr>
                                                    @endforeach
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                        @endforeach
                                    </div>


                                </div>
                            </div>

                        </div>
                        <br>
                        <div class="col-md-12">
                            <br>
                            <button type="submit" class="col-md-2 col-lg-offset-0 btn btn-primary btn-flat">
                                Assign Shift
                            </button>

                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
@endsection