@extends('backendlayout.master')
@extends('backendlayout.header')
@extends('backendlayout.leftmenu')
@extends('backendlayout.footer')
@section('userscontent')
    @extends('backendlayout.flashmessagecollection')
    <script src="{{URL::asset('backendtheme/plugins/jQuery/jQuery-2.1.4.min.js')}}"></script>
    <style type="text/css">
        .search-title {
            text-align: center;
            text-transform: uppercase;
            padding: 20px;
            color: #337ab7;
            text-shadow: 0px 1px 2px;
        }

        #search-table {
            height: 400px;
            overflow: auto;
            box-shadow: 0 5px 10px #ccc;
        }
    </style>
    <div class="container" style="max-width: 1170px;width: 100%;">
        @if(isset($details))
            <h3 class="search-title">Search Result "{{ $query }}"</h3>
            <div id="search-table">
                <table id="example1" class="table table-hover table-bordered table-striped" style="margin-bottom: 40px;">
                    <thead>
                    <tr>
                        <th class="col-lg-1">S.N</th>
                        <th class="col-lg-3">Patient Full Name/ Code</th>
                        <th class="col-lg-2">Patient Details</th>
                        <th class="col-lg-2">Created Date</th>
                        <th class="col-lg-3" style="width: 15%;">Actions</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($details as $key=>$user)

                        <tr>
                            <td>
                                {{$key+1}}.
                            </td>

                            <td>

                                <a href="{{ URL::to('configuration/patient/' . $user->id . '/edit') }}">
                                    {{ucfirst($user->first_name)}} {{ucfirst($user->middle_name)}}
                                    {{ucfirst($user->last_name)}}
                                </a>
                                <br>
                                <strong>{{$user->patient_code}}</strong>
                            </td>

                            <td>
                                {{$user->phone}}
                                <br>
                                <strong>{{$user->patient_type}}</strong>
                                <br>
                                @if($user->patient_type=='IPD')

                                    {{ $user->isOfWard->ward_name.'/'.$user->isOfRoom->room_name}}
                                @else
                                @endif
                            </td>


                            <td>
                                <?php
                                $todayDate = date('Y-m-d', strtotime($user->created_at));
                                $localDate = str_replace("-", ",", $todayDate);
                                $classes = explode(",", $localDate);
                                $a = $classes[0];
                                $b = $classes[1];
                                $c = $classes[2];
                                echo eng_to_nep($a, $b, $c);
                                echo '&nbsp';
                                echo date('h:i A', strtotime($user->created_at));
                                ?>
                            </td>


                            <td>
                                @if($user->patient_type=='OPD')

                                    @if(Auth::user()->user_type_id=='6')
                                    @else
                                        <a href="{{ URL::to('configuration/patient/' . $user->id . '/edit') }}"
                                           title="Edit Patient Details"
                                           data-rel="tooltip">
                                            <button type="button" class="btn btn-default btn-flat  ">
                                                <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                                            </button>
                                        </a>
                                    @endif


                                    <a href="{{URL::to('configuration/patient/' .$user->id)}}"
                                       title="View Patient Details"
                                       data-rel="tooltip">
                                        <button type="button" class="btn btn-primary btn-flat ">
                                            <span class="glyphicon glyphicon-zoom-in" aria-hidden="true"></span>
                                        </button>
                                    </a>


                                @elseif($user->patient_type=='IPD')
                                    @if(Auth::user()->user_type_id=='6')
                                    @else
                                        <a href="{{ URL::to('ip-enrollment/patients/' . $user->id . '/edit') }}"
                                           title="Edit Patient Details"
                                           data-rel="tooltip">
                                            <button type="button" class="btn btn-default btn-flat  ">
                                                <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                                            </button>
                                        </a>
                                    @endif
                                    <a href="{{URL::to('ip-enrollment/patients/' .$user->id)}}"
                                       title="View Patient Details"
                                       data-rel="tooltip">
                                        <button type="button" class="btn btn-primary btn-flat ">
                                            <span class="glyphicon glyphicon-zoom-in" aria-hidden="true"></span>
                                        </button>
                                    </a>


                                @elseif($user->patient_type=='Emergency')
                                    @if(Auth::user()->user_type_id=='6')
                                    @else
                                        <a href="{{ URL::to('emergency/patient/' . $user->id . '/edit') }}"
                                           title="Edit Emergency Patient Details"
                                           data-rel="tooltip">
                                            <button type="button" class="btn btn-default btn-flat  ">
                                                <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                                            </button>
                                        </a>
                                    @endif
                                    <a href="{{URL::to('emergency/patient/' .$user->id)}}"
                                       title="View Emergency Patient Details"
                                       data-rel="tooltip">
                                        <button type="button" class="btn btn-primary btn-flat ">
                                            <span class="glyphicon glyphicon-zoom-in" aria-hidden="true"></span>
                                        </button>
                                    </a>
                                @endif

                                @if(Auth::user()->user_type_id=='6')
                                @else
                                    <a href="{{URL::to('re-admit/patient/' .$user->id)}}"
                                       title="Readmit Patient"
                                       data-rel="tooltip">
                                        <button type="button" class="btn btn-success btn-flat ">
                                            <span>Renew</span>
                                        </button>
                                    </a>
                                @endif


                            </td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>

        @endif
    </div>

    <script type="text/javascript">
        $(function () {
            $("#example2").DataTable({});
            $("#example1").DataTable({});
        });
    </script>
@endsection
