@extends('backendlayout.master')
@extends('backendlayout.header')
@extends('backendlayout.leftmenu')
@extends('backendlayout.footer')
@section('userscontent')
    @extends('backendlayout.flashmessagecollection')

    <div class="search-breadcrumb-only">
        <div class="row">
            <div class="col-lg-12">
                <ol class="breadcrumb">
                    <li><a href="{{url('dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                    <li class="active">Contact</li>
                </ol>
            </div>
        </div>
    </div>

    <div style="margin: 5px 0 0 20px">
        <a href="contact">
            <button type="button" class="btn btn-primary manage-contact" style="border-radius: 0; background: #3c8dbc; border-color: #3c8dbc;">
                <i class="fa fa-gear"></i>Manage Contacts
            </button>
        </a>
    </div>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">

                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#doctors">Doctors</a></li>
                            <li><a data-toggle="tab" href="#staffs">Staffs</a></li>
                            <li><a data-toggle="tab" href="#emergency">Emergency</a></li>
                        </ul>

                        <div class="tab-content">
                            <div id="doctors" class="tab-pane fade in active">
                                <div class="box-body">
                                    @if(count($doctors)>0)
                                        <table id="example0" class="table table-hover table-bordered table-striped">
                                            <thead>
                                            <tr>
                                                <th>S.N</th>
                                                <th>Contact Name</th>
                                                <th>Contact Number</th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            @foreach($doctors as $key=>$doctor)
                                                <?php  $segment2 = Request::segment(2);  ?>
                                                    <tr>
                                                        <td>
                                                            {{ $key+1 }}.
                                                        </td>

                                                        <td>
                                                            {{ ucfirst($doctor->first_name) }}
                                                            {{ ucfirst($doctor->middle_name) }}
                                                            {{ ucfirst($doctor->last_name) }}
                                                        </td>

                                                        <td>
                                                            {{ $doctor->contact_no }}
                                                        </td>
                                                    </tr>
                                            @endforeach

                                            </tbody>
                                        </table>

                                    @else
                                        <div class="alert alert-danger">
                                            <strong style="padding-left: 150px"> Sorry ! No record found
                                            </strong>
                                        </div>
                                    @endif

                                </div>
                            </div>


                            <div id="staffs" class="tab-pane fade">
                                <div class="box-body">
                                    @if(count($contacts)>0)
                                        <table id="example2" class="table table-hover table-bordered table-striped">
                                            <thead>
                                            <tr>
                                                <th>S.N</th>
                                                <th>Contact Name</th>
                                                <th>Contact Number</th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            @foreach($contacts as $key1=>$contact)
                                                <?php  $segment2 = Request::segment(2);  ?>
                                                @if($contact->type == 'staff')
                                                    <tr>
                                                        <td>
                                                            {{ $key1+1 }}.
                                                        </td>

                                                        <td>
                                                            {{ ucfirst($contact->name) }}
                                                        </td>

                                                        <td>
                                                            {{ $contact->contact }}
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach

                                            </tbody>
                                        </table>

                                    @else
                                        <div class="alert alert-danger">
                                            <strong style="padding-left: 150px"> Sorry ! No record found
                                            </strong>
                                        </div>
                                    @endif

                                </div>
                            </div>

                            <div id="emergency" class="tab-pane fade">
                                <div class="box-body">
                                    @if(count($contacts)>0)
                                        <table id="example3" class="table table-hover table-bordered table-striped">
                                            <thead>
                                            <tr>
                                                <th>S.N</th>
                                                <th>Contact Name</th>
                                                <th>Contact Number</th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            @foreach($contacts as $key2=>$contact)
                                                <?php  $segment2 = Request::segment(2);  ?>
                                                @if($contact->type == 'emergency')
                                                    <tr>
                                                        <td>
                                                            {{ $key2+1 }}.
                                                        </td>

                                                        <td>
                                                            {{ ucfirst($contact->name) }}
                                                        </td>

                                                        <td>
                                                            {{ $contact->contact }}
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach

                                            </tbody>
                                        </table>

                                    @else
                                        <div class="alert alert-danger">
                                            <strong style="padding-left: 150px"> Sorry ! No record found
                                            </strong>
                                        </div>
                                    @endif

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            $(function () {
                $("#example0").DataTable({
                });

                $("#example2").DataTable({
                });

                $("#example3").DataTable({
                });
            });
        </script>
    </section>
@stop
