@extends('backendlayout.master')
@extends('backendlayout.header')
@extends('backendlayout.leftmenu')
@extends('backendlayout.footer')
@section('userscontent')
    @extends('backendlayout.flashmessagecollection')
    {{--<section class="content-header">--}}
    {{--<h1>--}}
    {{--In Patient Enrollment--}}
    {{--<a href="{{url('configuration/patient')}}">--}}
    {{--<button type="button" class="btn btn-warning btn-flat  pull-right ">--}}
    {{--<span class="glyphicon glyphicon-th-list" aria-hidden="true"></span> View Patients--}}
    {{--</button>--}}
    {{--</a>--}}
    {{--</h1>--}}
    {{--</section>--}}

    <section class="content">
        <div class="row">
            <div class="col-md-12 ">
                <div class="box">
                    <div class="box-header with-border">
                        <h3>IP Guardian Form
                        </h3>
                        {{--<div class="box-tools pull-right">--}}
                        {{--<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">--}}
                        {{--<i class="fa fa-minus"></i></button>--}}
                        {{--<button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">--}}
                        {{--<i class="fa fa-times"></i></button>--}}
                        {{--</div>--}}
                    </div>
                    <div class="box-body">
                        {{--nav tabs--}}
                        {{--<ul class="nav nav-tabs">--}}
                        {{--<li class="nav-item">--}}
                        {{--<a class="nav-link active" href="{{url('ip-enrollment/create')}}">Patient's Detail</a>--}}
                        {{--</li>--}}
                        {{--<li class="nav-item">--}}
                        {{--<a class="nav-link" href="{{url('/ip-enrollment/guardian')}}">Guardian's Detail</a>--}}
                        {{--</li>--}}
                        {{--<li class="nav-item">--}}
                        {{--<a class="nav-link" href="{{url('/ip-enrollment/referrer')}}">Referrer's Detail</a>--}}
                        {{--</li>--}}
                        {{--</ul>--}}
                        {{--                        {{ trans('adminlte_lang::message.logged') }}. Start creating your amazing application!--}}
                        <div class="container">
                            <form method="post"
                                  action="{{ URL::to('ip-enrollment/' . $editPatients->id . '/addGuardian') }}">
                                {{ csrf_field() }}
                                <h4>Guardian's Details:</h4><br>
                                {{--Guardian Details--}}
                                <div class="form-group row">
                                    <label for="guardian_name" class="col-sm-1 form-control-label">Local
                                        Guardian</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="guardian_name"
                                               placeholder="Local Guardian Name" name="guardian_name">
                                    </div>
                                    <label for="inputmname" class="col-sm-1 form-control-label">Relation</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="inputmname" placeholder="Relation"
                                               name="guardian_relation">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="guardian_phone" class="col-sm-1 form-control-label">Phone/Mobile</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="guardian_phone"
                                               placeholder="Phone/Mobile" name="guardian_phone">
                                    </div>

                                    <label for="inputdob" class="col-sm-1 form-control-label">Address</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="inputlname"
                                               placeholder="Guardian Address" name="guardian_address">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="parent_name" class="col-sm-1 form-control-label">Parent's Name</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="parent_name"
                                               placeholder="Parent's Name" name="parent_name">
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="checkbox">
                                            <label><input type="checkbox" name="local_guardian"
                                                          onchange="copyTextValue(this);">Is Local Guardian</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="parent_phone" class="col-sm-1 form-control-label">Phone/Mobile</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="parent_phone"
                                               placeholder="Phone/Mobile" name="parent_phone">
                                    </div>
                                    <label for="GuardEmail" class="col-sm-1 form-control-label">Email</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="GuardEmail" placeholder="Email"
                                               name="parent_email">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="Paddress" class="col-xs-1 form-control-label">Permanent Address</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="Paddress"
                                               placeholder="Permanent Address" name="parent_address">
                                    </div>
                                    <label for="GuardOccupation" class="col-sm-1 form-control-label">Occupation</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="GuardOccupation"
                                               placeholder="Occupation" name="parent_occupation">
                                    </div>
                                </div>
                                <hr>
                                <br>
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <button type="submit" class="col-md-1 col-lg-offset-8 btn btn-primary">Submit
                                        </button>
                                        <button type="reset" class="col-md-1 btn btn-warning"
                                                style="margin-left: 10px;">Reset
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
        </div>
        </div>
        </div>
    </section>

@endsection
