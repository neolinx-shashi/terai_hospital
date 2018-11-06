@extends('backendlayout.master')
@extends('backendlayout.header')
@extends('backendlayout.leftmenu')
@extends('backendlayout.footer')
@section('userscontent')

@extends('backendlayout.flashmessagecollection')
<style>
    .no-padding {padding: 0;}
    .spacer {margin: 20px 0;}
    .fat {font-weight: bold;}
    .mright {margin-right: 10px;}
    .glyphicon {cursor: pointer;}
    a .glyphicon {color: #000;}
    thead.news-head {
        background: #3c8dbc;
        color: #fff;
    }
</style>
<link href="{{ URL::asset('css/bootstrap-datetimepicker.css') }}">
<section class="content-header">
    <a href="{{ url('news/create') }}" class="btn btn-warning pull-right"><span class="glyphicon glyphicon-plus-sign"></span> Add</a>
    <h1>News &amp; Events</h1>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    @if(Session::has('message'))
                    <div class="alert alert-success" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        {{ Session::get('message') }}
                    </div>
                    @endif

                    <table class="table table-striped">
                        <thead class="news-head">
                            <tr>
                                <td>S. No.</td>
                                <td>Title</td>
                                <td>Description</td>
                                <td>Date</td>
                                <td>Actions</td>
                            </tr>
                        </thead>
                        <tbody>
                            @if (!empty($list))
                            @foreach ($list as $key => $val)
                            <tr>
                                <td>{{ ($key + 1) }}</td>
                                <td>{{ $val->news_title }}</td>
                                <td>{{ str_limit(strip_tags($val->news_detail), 20) }}</td>
                                <td>{{ $val->news_date }}</td>
                                <td>
                                    <a href="{{ url('/news/'.$val->news_id.'/edit') }}" title="Edit" class="mright"><span class="glyphicon glyphicon-edit"></span></a>
                                    <span title="Delete" onclick="delRecord({{ $val->news_id }})" class="glyphicon glyphicon-remove"></span>
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="5">No Data Found.</td>
                            </tr>
                            @endif
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5">{{ $list->links() }}</td>
                            </tr>
                        </tfoot>
                    </table>

                </div>
            </div>
        </div>
    </div>
</section>

<script src="{{URL::asset('backendtheme/plugins/jQuery/jQuery-2.1.4.min.js')}}"></script>

<script>
                                        $(function () {
                                        $('#datetimepicker1').datetimepicker({
                                        userCurrent: true
                                        });
                                        });
                                        function delRecord(id) {
                                        var c = confirm("Delete this record?");
                                        var p = '{{ url("/deletenews") }}/' + id;
                                        if (c === true) {
                                        window.location = p;
                                        }
                                        }
</script>

@stop