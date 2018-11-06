@extends('backendlayout.master')
@extends('backendlayout.header')
@extends('backendlayout.leftmenu')
@extends('backendlayout.footer')
@section('userscontent')
    @extends('backendlayout.flashmessagecollection')
    {{--<section class="content-header">--}}
        {{--<h1>--}}
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

                <!-- Default box -->
                <div class="box">
                    <div class="box-header with-border">
                        <h3>IP Referrer Form
                        {{--<div class="box-tools pull-right">--}}
                        {{--<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">--}}
                        {{--<i class="fa fa-minus"></i></button>--}}
                        {{--<button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">--}}
                        {{--<i class="fa fa-times"></i></button>--}}
                        {{--</div>--}}
                        </h3>
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
                                  action="{{ URL::to('ip-enrollment/' . $editPatients->id . '/addReferrer') }}">
                                {{ csrf_field() }}
                                <h4>Referrer's Details:</h4><br>
                                <div class="form-group row">
                                    {{--Patient Details--}}
                                    <label for="InstituteName" class="col-sm-1 form-control-label">Institute Name</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="InstituteName" placeholder="Institute Name">
                                    </div>
                                    <label for="RefAddress" class="col-sm-1 form-control-label">Address</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="RefAddress" placeholder="Institute Address">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="MedicName" class="col-sm-1 form-control-label">Medic Name</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="MedicName" placeholder="Medic Name">
                                    </div>
                                    <label for="RefDesig" class="col-sm-1 form-control-label">Designation</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="RefDesig" placeholder="Designation">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="RefReason" class="col-sm-1 form-control-label">Refer Reason</label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control" id="RefReason"></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="dob" class="col-sm-1 form-control-label">Entry Date
                                    </label>
                                    <div class="col-sm-4">
                                        <input type="date" class="form-control" id="dob" name="dob">
                                    </div>

                                    <label for="dob" class="col-sm-1 form-control-label">Release Date
                                    </label>
                                    <div class="col-sm-4">
                                        <input type="date" class="form-control" id="dob" name="dob">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="transLetter" class="form-control-label"  style="float: left; margin-left: 15px;width:150px;">Upload Transfer Letter</label>
                                    <div class="col-sm-2">
                                        <input id="transLetter" type="file" class="file">
                                    </div>
                                </div><hr>
                                <h4>Upload Documents:</h4><br>
                                <div class="form-group row">
                                    <label for="LabDoc" class="form-control-label"  style="float: left; margin-left: 15px;width:150px;">Laboratory Document</label>
                                    <div class="col-sm-2">
                                        <input id="LabDoc" type="file" class="file">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="RadioDetial" class="form-control-label"  style="float: left; margin-left: 15px; width:150px;">Radiology Details</label>
                                    <div class="col-sm-2">
                                        <input id="RadioDetial" type="file" class="file">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="SurgDetial" class="form-control-label"  style="float: left; margin-left: 15px;width:150px;">Surgeries Details</label>
                                    <div class="col-sm-2">
                                        <input id="SurgDetial" type="file" class="file">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="PreDetect" class="col-sm-1 form-control-label">Previous Detections</label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control" id="PreDetect"></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="PatHistory" class="col-sm-1 form-control-label">Patient History</label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control" id="PatHistory"></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="Presc" class="col-sm-1 form-control-label">Prescriptions</label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control" id="Presc"></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="DischargeSum" class="col-sm-1 form-control-label">Discharge Summary</label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control" id="DischargeSum"></textarea>
                                    </div>
                                </div>

                                <hr><br>
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <button type="button" class="col-md-1 col-lg-offset-8 btn btn-primary">Submit</button>
                                        <button type="button" class="col-md-1 btn btn-warning" style="margin-left: 10px;">Reset</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->

            </div>
        </div>
        </div>
        </div>
    </section>
@endsection
