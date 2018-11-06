@extends('backendlayout.master')
@extends('backendlayout.header')
@extends('backendlayout.leftmenu')
@extends('backendlayout.footer')
@section('userscontent')
    @extends('backendlayout.flashmessagecollection')

    @if(\Request::segment(3)=='edit')
        <div class="search-breadcrumb-only">
            <div class="row">
                <div class="col-lg-12">
                    <ol class="breadcrumb">
                        <li><a href="{{url('dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                        <li><a href="{{URL('admission-charge')}}">IPD Admission Charge</a></li>
                        <li class="active">Edit IPD Admission Charge</li>
                    </ol>
                </div>
            </div>
        </div>
    @else
        <div class="search-breadcrumb-only">
            <div class="row">
                <div class="col-lg-12">
                    <ol class="breadcrumb">
                        <li><a href="{{url('dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                        <li><a href="{{URL('admission-charge')}}">IPD Admission Charge</a></li>
                        <li class="active">Add IPD Admission Charge</li>
                    </ol>
                </div>
            </div>
        </div>
    @endif

    <section class="content">
        <div class="row">
            <div class="col-md-8">
                <div class="box">
                    <div class="box-body">
                        <table class="table table-hover table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>S.N</th>
                                <th>Admission Charge</th>
                                <th>Running Admission Charge</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($admissionCharges as $key=>$admissionCharge)
                                <?php  $segment2 = Request::segment(2);  ?>
                                <tr @if($admissionCharge->id==$segment2) class="success" @endif>
                                    <td>
                                        {{$key+1}}.
                                    </td>

                                    <td>
                                        {{$admissionCharge->admission_charge}}
                                    </td>

                                    <td>
                                        @if($admissionCharge->current_admission_charge=='Y')
                                            <a href="{{url('admission-charge/change-status', [$admissionCharge->id])}}"
                                               class="label label-success"> Yes</a>
                                        @else
                                            <a href="{{url('admission-charge/change-status', [$admissionCharge->id])}}"
                                               class="label label-danger"> No</a>
                                        @endif
                                    </td>

                                    <td>

                                        <a href="{{ URL::to('admission-charge/' . $admissionCharge->id . '/edit') }}">
                                            <button type="button" class="btn btn-default btn-flat  ">
                                                <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                                            </button>
                                        </a>
                                        <a href="{{URL::to('remove-admission-charge',array($admissionCharge->id))}}"
                                           onclick="return confirm('Are you sure you want to delete this record?')">
                                            <button type="button" class="btn btn-danger btn-flat  ">
                                        <span class="glyphicon glyphicon-trash"
                                              aria-hidden="true"></span>
                                            </button>
                                        </a>
                                    </td>
                                </tr>

                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                @if(\Request::segment(3)=='edit')
                    @include('backendview/admin/IPDAdmissionCharge/edit')
                @else
                    @include('backendview/admin/IPDAdmissionCharge/create')
                @endif
            </div>
        </div>
    </section>

    <script type="text/javascript">
        // $.validator.setDefaults( {
        //     submitHandler: function () {
        //         alert( "submitted!" );
        //     }
        // } );

        $(document).ready(function () {
            $("#signupForm").validate({
                rules: {
                    fiscal_year_start_date: "required",
                    lastname: "required",
                    username: {
                        required: true,
                        minlength: 2
                    },
                    password: {
                        required: true,
                        minlength: 5
                    },
                    confirm_password: {
                        required: true,
                        minlength: 5,
                        equalTo: "#password"
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    agree: "required"
                },
                messages: {
                    fiscal_year_start_date: "Please enter your Fiscal Year",
                    lastname: "Please enter your lastname",
                    username: {
                        required: "Please enter a username",
                        minlength: "Your username must consist of at least 2 characters"
                    },
                    password: {
                        required: "Please provide a password",
                        minlength: "Your password must be at least 5 characters long"
                    },
                    confirm_password: {
                        required: "Please provide a password",
                        minlength: "Your password must be at least 5 characters long",
                        equalTo: "Please enter the same password as above"
                    },
                    email: "Please enter a valid email address",
                    agree: "Please accept our policy"
                },
                errorElement: "em",
                errorPlacement: function (error, element) {
                    // Add the `help-block` class to the error element
                    error.addClass("help-block");

                    if (element.prop("type") === "checkbox") {
                        error.insertAfter(element.parent("label"));
                    } else {
                        error.insertAfter(element);
                    }
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).parents(".form-group").addClass("has-error").removeClass("has-success");
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).parents(".form-control").addClass("form-group").removeClass("has-error");
                }
            });


        });
    </script>
@stop