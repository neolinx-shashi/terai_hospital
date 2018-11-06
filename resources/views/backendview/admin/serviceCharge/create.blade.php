@extends('backendlayout.master')
@extends('backendlayout.header')
@extends('backendlayout.leftmenu')
@extends('backendlayout.footer')
@section('userscontent')
    @extends('backendlayout.flashmessagecollection')
    <section class="content-header">
        <h1>
            Add Service Charges
            <a href="{{ route('service-charge.index') }}">
                <button type="button" class="btn btn-warning btn-flat  pull-right ">
                    <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span> &nbsp;View Service Charges
                </button>
            </a>
        </h1>
    </section>

    <section class="content">
        <form class="form-horizontal" method="post"
              action="{{ route('service-charge.store') }}"
              enctype="multipart/form-data">
            {!! csrf_field() !!}
            <div class="box">

                <div class="shadow">
                    <div class="row">
                        <div class="col-sm-2 col-md-6 col-lg-6">

                            <br>
                            <br>
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="col-sm-4 control-label">
                                    Service Charge Name<span class=help-block"
                                                             style="color: #b30000">&nbsp;* </span></label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="name" name="name"
                                           placeholder="Enter Service Charge Name." value="{{ old('name') }}">
                                    @if ($errors->has('name'))
                                        <span class="help-block" style="color: red">
                                        <strong> * {{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>


                            <div class="form-group{{ $errors->has('percent') ? ' has-error' : '' }}">
                                <label for="percent" class="col-sm-4 control-label">
                                    Percentage<span class=help-block" style="color: #b30000">&nbsp;* </span></label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="percent" name="percent"
                                           placeholder="Enter Percentage in Number." value="{{ old('percent') }}">
                                    @if ($errors->has('percent'))
                                        <span class="help-block" style="color: red">
                                        <strong> * {{ $errors->first('percent') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>


                            <div class="form-group">
                                <div class="col-sm-offset-4 col-sm-8">
                                    <button type="submit" class="btn btn-success">
                                        Submit
                                    </button>
                                    <button type="reset" class="btn btn-default">Reset</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
@stop