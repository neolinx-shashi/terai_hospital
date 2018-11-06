@extends('backendlayout.master')
@extends('backendlayout.header')
@extends('backendlayout.leftmenu')
@extends('backendlayout.footer')
@section('userscontent')
    @extends('backendlayout.flashmessagecollection')
    <script src="{{URL::asset('backendtheme/plugins/jQuery/jQuery-2.1.4.min.js')}}"></script>

    <section class="content-header">
        <h1>
            Insert IPD Patient Update
        </h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                    </div>
                    <div class="box-body">
                        <form method="post"
                              action="{{URL::action('BackEndController\PatientHistoryController@store')}}">


                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group{{ $errors->has('doctor_name') ? ' has-error' : '' }}">
                                <label for="doctor_name">Doctor Name<label class="text-danger">*</label></label>

                                <input type="text" name="doctor_name" placeholder="Enter Doctor Name" value="{{ old('doctor_name') }}"
                                       class="form-control" id="doctor_name">
                                @if ($errors->has('doctor_name'))
                                    <span class="help-block" style="color: red">
                                    <strong> {{ $errors->first('doctor_name') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->has('doctor_fee') ? ' has-error' : '' }}">
                                <label for="department_code">Doctor Fee<label
                                            class="text-danger">*</label></label>

                                <input type="text" name="doctor_fee" placeholder="Enter Doctor Fee"
                                       value="{{ old('doctor_fee') }}" class="form-control" id="doctor_fee">
                                @if ($errors->has('doctor_fee'))
                                    <span class="help-block" style="color: red">
                                    <strong>  {{ $errors->first('doctor_fee') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->has('doctor_fee') ? ' has-error' : '' }}">
                                <label for="appointment">Appointment Date
                                <label class="text-danger">*</label></label>

                                <input type="text" name="appointment"
                                       value="{{ old('appointment') }}" class="form-control" id="appointment">
                                @if ($errors->has('appointment'))
                                    <span class="help-block" style="color: red">
                                    <strong>  {{ $errors->first('appointment') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                                <label for="department_code">Description</label>

                                <input type="text" name="description" placeholder="Enter Description"
                                       value="{{ old('description') }}" class="form-control" id="doctor_fee">
                                @if ($errors->has('description'))
                                    <span class="help-block" style="color: red">
                                    <strong>  {{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <input type="hidden" name="ipatient_id" value="{{ $patient->id }}" id="ipatient_id">

                            <button type="submit" class="btn btn-primary save btn-flat">Save</button>

                            <label for="panel-body">Note: Field With <label class="text-danger"> * </label> are
                                mandatory </label>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <style>
        a:link {
            text-decoration: none;
        }

        a:visited {
            text-decoration: none;
        }

        a:hover {
            text-decoration: none;
            color: green;
        }

        a:active {
            text-decoration: none;
        }
    </style>

    <script type="text/javascript">
        $(function() {
            $('input[name="appointment"]').daterangepicker({

                    locale: {
                        format: 'YYYY-MM-DD'
                    },
                    singleDatePicker: true,
                    showDropdowns: true
                },
                function(start, end, label) {
                    var years = moment().diff(start, 'years');

                });
        });
    </script>
@endsection