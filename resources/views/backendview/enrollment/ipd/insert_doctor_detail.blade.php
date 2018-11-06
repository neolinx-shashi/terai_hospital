@extends('backendlayout.master')
@extends('backendlayout.header')
@extends('backendlayout.leftmenu')
@extends('backendlayout.footer')
@section('userscontent')
    @extends('backendlayout.flashmessagecollection')
    <link rel="stylesheet" type="text/css"
          href="{{URL::asset('backendtheme/lib/nepali.datepicker.v2/css/bootstrap.min.css')}}"/>
    <link rel="stylesheet" type="text/css"
          href="{{URL::asset('backendtheme/lib/nepali.datepicker.v2/nepali.datepicker.v2.min.css')}}"/>


    <section class="content-header">
        <h1>
            Doctor Visit Record
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                    </div>
                    <div class="box-body">

                        {{--@if(count($patientHistory))
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>Doctor Name</th>
                                    <th>Doctor Fee</th>
                                    <th width="200px">Appointment Date</th>
                                    <th width="200px">Description</th>
                                    <th width="200px">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($patientHistory as $data)
                                    <tr>
                                        <td>
                                            {{ $data->doctor_name }}
                                        </td>

                                        <td>
                                            {{ $data->doctor_fee }}
                                        </td>

                                        <td>
                                            {{ $data->appointment }}
                                        </td>

                                        <td>
                                            {{ $data->description }}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @else
                            <strong>No data available!</strong>
                        @endif--}}

                        <div class="row">
                            <div class="col-lg-12 margin-tb">
                                <div class="pull-right">
                                    <a href="{{url('ip-enrollment/patients')}}">
                                        <button type="button" class="btn btn-warning btn-flat  pull-right ">
                                            <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span> Back
                                        </button>
                                    </a>

                                    <button type="button" class="btn btn-success" data-toggle="modal"
                                            data-target="#create-item" style="margin: 0 0 5px 0">
                                        Add Doctor Visit
                                    </button>
                                </div>
                            </div>
                        </div>

                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Doctor Name</th>
                                <th>Doctor Fee</th>
                                <th width="200px">Appointment Date</th>
                                <th width="200px">Description</th>
                                <th width="200px">Action</th>
                            </tr>
                            </thead>

                            <tbody>
                            </tbody>
                        </table>

                        <ul id="pagination" class="pagination-sm"></ul>


                        <!-- Create Item Modal -->
                        <div class="modal fade" id="create-item" tabindex="-1" role="dialog"
                             aria-labelledby="myModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span></button>
                                        <h4 class="modal-title" id="myModalLabel">Add Doctor Visit</h4>
                                    </div>
                                    <div class="modal-body">

                                        <form data-toggle="validator"
                                              action="{{ URL::to('ip-enrollment/patients/doctor-detail-save') }}"
                                              method="POST">

                                            <div class="form-group{{ $errors->has('doctor_id') ? ' has-error' : '' }}">
                                                <label for="doctor_id">Doctor Name<label
                                                            class="text-danger">*</label></label>

                                                <select name="doctor_id" id="doctor_id" class="form-control">
                                                    <option value="">Select a Doctor</option>
                                                    @foreach($doctors as $doctor)
                                                        <option value="{{ $doctor->id }}" @if(old('doctor_id')==$doctor->id)
                                                            <?php echo 'selected' ?>
                                                                @endif>{{ ucwords($doctor->first_name).' '.ucwords($doctor->middle_name).' '.ucwords($doctor->last_name) }}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('doctor_id'))
                                                    <span class="help-block" style="color: red">
                                                    <strong> {{ $errors->first('doctor_id') }}</strong>
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="form-group{{ $errors->has('doctor_charge') ? ' has-error' : '' }}">
                                                <label for="doctor_charge">Charge Type<label
                                                            class="text-danger">*</label></label>

                                                <select name="doctor_charge" id="doctor_charge" class="form-control">
                                                    <option value="">Select a Charge Type</option>
                                                    @foreach($doctorCharges as $doctorCharge)
                                                        <option value="{{ $doctorCharge->id }}" @if(old('doctor_charge')==$doctorCharge->id)
                                                            <?php echo 'selected' ?>
                                                                @endif>{{ ucwords($doctorCharge->title) }}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('doctor_charge'))
                                                    <span class="help-block" style="color: red">
                                                    <strong> {{ $errors->first('doctor_charge') }}</strong>
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="form-group{{ $errors->has('doctor_fee') ? ' has-error' : '' }}">
                                                <label for="department_code">Doctor Fee<label
                                                            class="text-danger">*</label></label>

                                                <input type="text" name="doctor_fee" placeholder="Select a Doctor Charge From Above Menu"
                                                       class="form-control" id="doctor_fee" disabled>
                                                @if ($errors->has('doctor_fee'))
                                                    <span class="help-block" style="color: red">
                                                    <strong>  {{ $errors->first('doctor_fee') }}</strong>
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="form-group{{ $errors->has('doctor_fee') ? ' has-error' : '' }}">
                                                <label for="appointment">Appointment Date
                                                    <label class="text-danger">*</label></label>

                                                <input type="text" name="appointment" class="form-control"
                                                       id="appointment" value="{{ getTodayNepaliDate() }}">
                                                @if ($errors->has('appointment'))
                                                    <span class="help-block" style="color: red">
                                                    <strong>  {{ $errors->first('appointment') }}</strong>
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                                                <label for="department_code">Description</label>

                                                <input type="text" name="description" placeholder="Enter Description"
                                                       class="form-control"
                                                       id="description">
                                                @if ($errors->has('description'))
                                                    <span class="help-block" style="color: red">
                                                    <strong>  {{ $errors->first('description') }}</strong>
                                                    </span>
                                                @endif
                                            </div>

                                            {{--<input type="hidden" name="ipatient_id" value="{{ $patient->id }}" id="ipatient_id">

                                            <button type="submit" class="btn btn-primary save btn-flat">Save</button>--}}

                                            <label for="panel-body">Note: Field With <label class="text-danger">
                                                    * </label> are
                                                mandatory </label>
                                            <div class="form-group">
                                                <button type="submit" class="btn crud-submit btn-success"
                                                        onclick="validate()">Save
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- Edit Item Modal -->
                        <div class="modal fade" id="edit-item" tabindex="-1" role="dialog"
                             aria-labelledby="myModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span></button>
                                        <h4 class="modal-title" id="myModalLabel">Edit Detail</h4>
                                    </div>
                                    <div class="modal-body">

                                        <form data-toggle="validator" action="/doctor-detail-edit" method="put">
                                            <div class="form-group{{ $errors->has('doctor_id_edit') ? ' has-error' : '' }}">
                                                <label for="doctor_id_edit">Doctor Name<label
                                                            class="text-danger">*</label></label>

                                                <select name="doctor_id_edit" id="doctor_id_edit" class="form-control">
                                                    <option value="">Select a Doctor</option>
                                                    @foreach($doctors as $doctor)
                                                        <option value="{{ $doctor->id }}" @if(old('doctor_id_edit')==$doctor->id)
                                                            <?php echo 'selected' ?>
                                                                @endif>{{ ucwords($doctor->first_name).' '.ucwords($doctor->middle_name).' '.ucwords($doctor->last_name) }}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('doctor_id_edit'))
                                                    <span class="help-block" style="color: red">
                                                    <strong> {{ $errors->first('doctor_id_edit') }}</strong>
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="form-group{{ $errors->has('doctor_charge_edit') ? ' has-error' : '' }}">
                                                <label for="doctor_charge_edit">Charge Type<label
                                                            class="text-danger">*</label></label>

                                                <select name="doctor_charge_edit" id="doctor_charge_edit" class="form-control">
                                                    <option value="">Select a Charge Type</option>
                                                    @foreach($doctorCharges as $doctorCharge)
                                                        <option value="{{ $doctorCharge->id }}" @if(old('doctor_charge_edit')==$doctorCharge->id)
                                                            <?php echo 'selected' ?>
                                                                @endif>{{ ucwords($doctorCharge->title) }}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('doctor_charge_edit'))
                                                    <span class="help-block" style="color: red">
                                                    <strong> {{ $errors->first('doctor_charge_edit') }}</strong>
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="form-group{{ $errors->has('doctor_fee_edit') ? ' has-error' : '' }}">
                                                <label for="doctor_fee_edit">Doctor Fee<label
                                                            class="text-danger">*</label></label>

                                                <input type="text" name="doctor_fee_edit" placeholder="Enter Doctor Fee"
                                                       class="form-control" id="doctor_fee_edit">
                                                @if ($errors->has('doctor_fee_edit'))
                                                    <span class="help-block" style="color: red">
                                    <strong>  {{ $errors->first('doctor_fee_edit') }}</strong>
                                    </span>
                                                @endif
                                            </div>

                                            <div class="form-group{{ $errors->has('appointment_edit') ? ' has-error' : '' }}">
                                                <label for="appointment_edit">Appointment Date
                                                    <label class="text-danger">*</label></label>

                                                <input type="text" name="appointment_edit" class="form-control"
                                                       id="appointment_edit">
                                                @if ($errors->has('appointment_edit'))
                                                    <span class="help-block" style="color: red">
                                    <strong>  {{ $errors->first('appointment_edit') }}</strong>
                                    </span>
                                                @endif
                                            </div>

                                            <div class="form-group{{ $errors->has('description_edit') ? ' has-error' : '' }}">
                                                <label for="department_code">Description</label>

                                                <input type="text" name="description_edit"
                                                       placeholder="Enter Description"
                                                       class="form-control"
                                                       id="description_edit">
                                                @if ($errors->has('description_edit'))
                                                    <span class="help-block" style="color: red">
                                    <strong>  {{ $errors->first('description_edit') }}</strong>
                                    </span>
                                                @endif
                                            </div>

                                            {{--<input type="hidden" name="ipatient_id" value="{{ $patient->id }}" id="ipatient_id">

                                            <button type="submit" class="btn btn-primary save btn-flat">Save</button>--}}

                                            <label for="panel-body">Note: Field With <label class="text-danger">
                                                    * </label> are
                                                mandatory </label>
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-success crud-submit-edit"
                                                        onclick="validateUpdate()">Update
                                                </button>
                                            </div>
                                        </form>

                                        {{--Hidden Fields--}}
                                        <input type="text" class="patient-id" id="ipatient_id"
                                               value="{{ $patient->id }}" hidden>
                                        <input type="text" class="doctor_name" id="doctor_name" value="0" hidden>
                                        <div id="pid" hidden></div>

                                    </div>
                                </div>
                            </div>
                        </div>
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

        function validate() {
            if ($('#doctor_id').val() == '' || $('#doctor_fee').val() == '' || $('#appointment').val() == '') {
                alert('Fields with astericks (*) are mandatory!');
            }
        }

        function validateUpdate() {
            if ($('#doctor_id_edit').val() == '' || $('#doctor_fee_edit').val() == '' || $('#appointment_edit').val() == '') {
                alert('Fields with astericks (*) are mandatory!');
            }
        }

        $(document).ready(function () {
            $('#appointment').nepaliDatePicker({
                ndpEnglishInput: 'englishDate'
            });

            $('#appointment_edit').nepaliDatePicker({
                ndpEnglishInput: 'englishDate'
            });
        });

        /*$(function () {
            $('input[name="appointment"]').daterangepicker({

                    locale: {
                        format: 'YYYY-MM-DD'
                    },
                    singleDatePicker: true,
                    showDropdowns: true
                },
                function (start, end, label) {
                    var years = moment().diff(start, 'years');

                });
        });*/

        var page = 1;
        var current_page = 1;
        var total_page = 0;
        var is_ajax_fire = 0;

        manageData();

        /* manage data list */
        function manageData() {
            $.ajax({
                dataType: 'json',
                url: 'get-doctor-detail',
                data: {page: page}
            }).done(function (data) {

                total_page = data.last_page;
                current_page = data.current_page;

                $('#pagination').twbsPagination({
                    totalPages: total_page,
                    visiblePages: current_page,
                    onPageClick: function (event, pageL) {
                        page = pageL;
                        if (is_ajax_fire != 0) {
                            getPageData();
                        }
                    }
                });

                manageRow(data.data);
                is_ajax_fire = 1;
            });
            getPageData();
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        /* Get Page Data*/
        function getPageData() {
            $.ajax({
                dataType: 'json',
                url: 'get-doctor-detail',
                data: {page: page}
            }).done(function (data) {
                manageRow(data);
            });
        }

        /* Add new Item table row */
        function manageRow(data) {
            var rows = '';
            $.each(data, function (key, value) {
                rows = rows + '<tr>';
                rows = rows + '<td>' + value.doctor_name + '</td>';
                rows = rows + '<td>' + value.doctor_fee + '</td>';
                rows = rows + '<td>' + value.appointment + '</td>';
                rows = rows + '<td>' + value.description + '</td>';
                rows = rows + '<td data-id="' + value.id + '">';
                rows = rows + '<button data-toggle="modal" data-target="#edit-item" class="btn btn-primary edit-item">Edit</button> ';
                rows = rows + '<button class="btn btn-danger remove-item">Delete</button>';
                rows = rows + '</td>';
                rows = rows + '</tr>';
            });

            $("tbody").html(rows);
        }

        /* Create new Item */
        $(".crud-submit").click(function (e) {
            e.preventDefault();
            var form_action = $("#create-item").find("form").attr("action");
            var token = "{{csrf_token()}}";
            var ipatient_id = $('.patient-id').val();
            var doctor_id = $("#create-item").find("select[name='doctor_id']").val();
            var charge_id = $("#create-item").find("select[name='doctor_charge']").val();
            var doctor_fee = $("#create-item").find("input[name='doctor_fee']").val();
            var appointment = $("#create-item").find("input[name='appointment']").val();
            var description = $("#create-item").find("input[name='description']").val();

            $.ajax({
                dataType: 'json',
                type: 'POST',
                url: form_action,
                data: {
                    _token: token,
                    ipatient_id: ipatient_id,
                    doctor_id: doctor_id,
                    charge_id: charge_id,
                    doctor_fee: doctor_fee,
                    appointment: appointment,
                    description: description
                }
            }).done(function (data) {
                getPageData();
                $(".modal").modal('hide');
                toastr.success('Record Created Successfully.', 'Success Alert', {timeOut: 5000});
            });

        });

        /* Remove Item */
        $("body").on("click", ".remove-item", function () {
            var pid = $(this).parent("td").data('id');
            var c_obj = $(this).parents("tr");
            $.ajax({
                dataType: 'json',
                type: 'get',
                url: pid + '/doctor-detail-delete'
            }).done(function (data) {
                c_obj.remove();
                toastr.success('Record Deleted Successfully.', 'Success Alert', {timeOut: 5000});
                getPageData();
            });
        });

        /* Edit Item */
        $("body").on("click", ".edit-item", function () {
            var pid = $(this).parent("td").data('id');
            var theDiv = document.getElementById("pid");
            theDiv.innerHTML = pid;
            var doctor_id = $(this).parent("td").prev("td").prev("td").prev("td").prev("td").text();
            var doctor_fee = $(this).parent("td").prev("td").prev("td").prev("td").text();
            var appointment = $(this).parent("td").prev("td").prev("td").text();
            var description = $(this).parent("td").prev("td").text();
            $("#edit-item").find("input[name='doctor_name_edit']").val(doctor_id);
            $("#edit-item").find("input[name='doctor_fee_edit']").val(doctor_fee);
            $("#edit-item").find("input[name='appointment_edit']").val(appointment);
            $("#edit-item").find("input[name='description_edit']").val(description);
            //$("#edit-item").find("form").attr("action", pid + '/doctor-detail-edit');
        });

        /* Updated new Item */
        $(".crud-submit-edit").click(function (e) {
            e.preventDefault();
            var theDiv = document.getElementById("pid");
            var pid = theDiv.innerHTML;
            var token = "{{csrf_token()}}";
            var ipatient_id = $('.patient-id').val();
            var doctor_id = $("#edit-item").find("select[name='doctor_id_edit']").val();
            var doctor_fee = $("#edit-item").find("input[name='doctor_fee_edit']").val();
            var appointment = $("#edit-item").find("input[name='appointment_edit']").val();
            var description = $("#edit-item").find("input[name='description_edit']").val();

            $.ajax({
                dataType: 'json',
                type: 'PUT',
                url: pid + '/doctor-detail-update',
                data: {
                    _token: token,
                    ipatient_id: ipatient_id,
                    doctor_id: doctor_id,
                    doctor_fee: doctor_fee,
                    appointment: appointment,
                    description: description
                }
            }).done(function (data) {
                getPageData();
                $(".modal").modal('hide');
                toastr.success('Record Updated Successfully.', 'Success Alert', {timeOut: 5000});
            });
        });

        $(function () {
            $('#doctor_charge').change(function () {
                //$('.c-doc').addClass('ninja');
                var doc_charge_id = $(this).val();
                if (doc_charge_id != '') {
                    var url = '{{ url("/get-doctor-charge") }}/' + doc_charge_id;
                    $.get(url, function (res) {
                        $('#doctor_fee').val(res);

                    });
                } else {
                    $('#doctor_fee').val('Select a Doctor Charge From Above Menu');
                }
            });

            $('#doctor_charge_edit').change(function () {
                //$('.c-doc').addClass('ninja');
                var doc_charge_id = $(this).val();
                if (doc_charge_id != '') {
                    var url = '{{ url("/get-doctor-charge") }}/' + doc_charge_id;
                    $.get(url, function (res) {
                        $('#doctor_fee_edit').val(res);

                    });
                } else {
                    $('#doctor_fee_edit').val('Select a Doctor Charge From Above Menu');
                }
            });
        })
    </script>
@endsection