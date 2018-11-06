@extends('backendlayout.master')
@extends('backendlayout.header')
@extends('backendlayout.leftmenu')
@extends('backendlayout.footer')
@section('userscontent')
@extends('backendlayout.flashmessagecollection')

    <section class="content-header">
        <h1>
            Add Consulting Fee
            <a href="{{URL::action('BackEndController\ConsultingFeeController@index')}}">
                <button type="button" class="btn btn-warning btn-flat  pull-right ">
                    <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span> &nbsp;View Lists
                </button>
            </a>
        </h1>
    </section>

    <section class="content">
        <form class="form-horizontal" method="post"
              action="{{url('update-consulting-fee',array($edit->id))}}"
              enctype="multipart/form-data">
            {!! csrf_field() !!}
            <div class="box">
               
                <div class="shadow">
                    <div class="row">
                        <div class="col-sm-2 col-md-6 col-lg-6">

                           <br>
                           <br>
                            <div class="form-group{{ $errors->has('normal_hours') ? ' has-error' : '' }}">
                                <label for="normal_hours" class="col-sm-4 control-label">
                                    Normal Hours Fee<span class=help-block" style="color: #b30000">&nbsp;* </span></label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="normal_hours" name="normal_hours"
                                           placeholder="Enter Normal Hours Fee."  value="{{$edit->normal_hours}}">
                                    @if ($errors->has('normal_hours'))
                                        <span class="help-block" style="color: red">
                                        <strong> * {{ $errors->first('normal_hours') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>


                             <div class="form-group{{ $errors->has('emergency_hours') ? ' has-error' : '' }}">
                                <label for="emergency_hours" class="col-sm-4 control-label">
                                    Emergency Fee<span class=help-block" style="color: #b30000">&nbsp;* </span></label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="emergency_hours" name="emergency_hours"
                                           placeholder="Enter Emergency Hours Fee."  value="{{ $edit->emergency_hours}}">
                                    @if ($errors->has('emergency_hours'))
                                        <span class="help-block" style="color: red">
                                        <strong> * {{ $errors->first('emergency_hours') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-offset-4 col-sm-8">
                                    <button type="submit" class="btn btn-success">Update
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
@stop