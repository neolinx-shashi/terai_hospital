@extends('backendlayout.master')
@extends('backendlayout.header')
@extends('backendlayout.leftmenu')
@extends('backendlayout.footer')
@section('userscontent')
 @extends('backendlayout.flashmessagecollection')
    <section class="content-header">
        <h1>
            View Users

                <a href="{{URL::action('BackEndController\ConsultingFeeController@create')}}">
                    <button type="button" class="btn btn-success btn-flat  pull-right ">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add Consulting Fee
                    </button>
                </a> 
        </h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                    </div>
                    <div class="box-body">
                        <table id="example1" class="table table-hover table-bordered table-striped">
                            <thead>
                            <tr>
                                <th class="col-lg-1">S.N</th>
                                <th >Normal Hours</th>
                                <th>Emergency Hours</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($consultingFee as $key=>$fee)
                                    <tr>
                                        <td><br>{{$key+1}}.
                                        </td>
                                        <td>
                                        {{$fee->normal_hours}}
                                        </td>


                                            <td>
                                        {{$fee->emergency_hours}}
                                        </td>
                                    <td>
                                    {{ date('Y-m-d h:i A',strtotime($fee->created_at)) }}
                                    </td>

                                        <td>
                                            <a href="{{ URL::to('configuration/consulting-fee/' . $fee->id . '/edit') }}">
                                                <button type="button" class="btn btn-info btn-flat  ">
                                                    <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                                                </button>
                                            </a>

                                                <a href="{{URL::to('remove-consulting-fee',array($fee->id))}}"
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
@stop