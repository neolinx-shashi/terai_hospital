@extends('backendlayout.master')
@extends('backendlayout.header')
@extends('backendlayout.leftmenu')
@extends('backendlayout.footer')
@section('userscontent')
    @extends('backendlayout.flashmessagecollection')
    <section class="content-header">
        <h1>
            Nurse
            <strong>{{ucfirst($nurseName->first_name).' '.ucfirst($nurseName->middle_name).' '.ucfirst($nurseName->last_name)}}</strong>
            <a href="{{URL::action('BackEndController\NurseController@index')}}">
                <button type="button" class="btn btn-primary btn-flat  pull-right ">
                    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> &nbsp;Back
                </button>
            </a>
        </h1>
    </section>
    <section class="content">
        <form action="{{url('assign/shift/nurse',array($nurse_id))}}" method="post">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="row">
                            <div class="col-md-12">

                                <div class="nav-tabs-custom">

                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <ul class="nav nav-tabs">
                                        <?php $count = 0; foreach($dayName as $key=>$dayData)  { ?>
                                        <li class=" <?php if ($dayData->name == date('l')) {
                                            echo 'active';
                                        }  ?> ">
                                            <a href="#tab_{{$key}}"
                                               data-toggle="tab"><strong>{{ucfirst($dayData->name)}}</strong></a>
                                        </li>
                                        <?php
                                        $count++;}?>
                                    </ul>
                                    <div class="tab-content">
                                        <?php $count = 0; foreach($dayName as $key=>$dayData)  { ?>
                                        <div class="tab-pane <?php if ($dayData->name == date('l')) {
                                            echo 'active';
                                        }  ?>" id="tab_{{$key}}">
                                            <div class="box-body">

                                                <table id="" class="table table-hover table-bordered table-striped">
                                                    <thead>
                                                    <tr>
                                                        <th>S.N</th>
                                                        <th>Start Time</th>
                                                        <th>End Time</th>
                                                        <th>Shift Type</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($shiftTime as $key=> $shift)

                                                        @if($dayData->id==$shift->day_id)

                                                            <tr>
                                                                <td>


                                                                    <input id="checkBox" type="checkbox"
                                                                           name="shift_id[]"
                                                                           value="{{ ($shift->shiftId) }}" @if($shift->shiftId==$shift->ScheduleShiftId  && $shift->nurseId==$nurse_id) <?php echo 'checked' ?> @endif >

                                                                </td>
                                                                <td>
                                                                    <strong>
                                                                        <?php
                                                                        $time = $shift->start_time;
                                                                        $d = new DateTime($time);
                                                                        echo $d->format('g:i A');
                                                                        ?>
                                                                    </strong>
                                                                </td>
                                                                <td>
                                                                    <strong>
                                                                        <?php
                                                                        $time = $shift->end_time;
                                                                        $d = new DateTime($time);
                                                                        echo $d->format('g:i A');
                                                                        ?>
                                                                    </strong>
                                                                </td>
                                                                <td>
                                                                    {{ucfirst($shift->shift_type)}}
                                                                </td>
                                                            </tr>

                                                        @endif

                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <?php
                                        $count++;}?>
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