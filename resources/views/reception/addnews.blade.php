@extends('backendlayout.master')
@extends('backendlayout.header')
@extends('backendlayout.leftmenu')
@extends('backendlayout.footer')
@section('userscontent')
@extends('backendlayout.flashmessagecollection')
<link rel="stylesheet" type="text/css" href="{{URL::asset('backendtheme/lib/nepali.datepicker.v2/css/bootstrap.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{URL::asset('backendtheme/lib/nepali.datepicker.v2/nepali.datepicker.v2.min.css')}}" />
<style>
    .no-padding {padding: 0;}
    .spacer {margin: 20px 0; clear: both;}
    .fat {font-weight: bold;}
    .right-align {text-align: right;}
    textarea.form-control.news-detail {
        max-width: 351px;
        min-height: 288px;
    }
</style>
<link href="{{ URL::asset('css/bootstrap-datetimepicker.css') }}">
<section class="content-header">
    <a href="{{ url('news') }}" class="btn btn-info pull-right"><span class="glyphicon glyphicon-th-list"></span> View List</a>
    <h1>News &amp; Events</h1>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    <div class="col-md-12 no-padding">
                        <form action="{{ url('news/'.$id) }}" id="news-form" method="post">
                            @if (isset($news))
                            {{ method_field('PATCH') }}
                            @endif
                            <div class="col-md-6">
                                <div class="col-md-3">
                                    <label for="title">Title: </label>
                                </div>
                                <div class="col-md-9">
                                    <input class="form-control news-title" name="news_title" type="text" value="{{ $news->news_title or '' }}" />
                                </div>

                                <div class="spacer"></div>
                                <div class="col-md-3">
                                    <label for="title">Description: </label>
                                </div>
                                <div class="col-md-9">
                                    <textarea name="news_detail" class="form-control news-detail">{{ $news->news_detail or '' }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="col-md-3">
                                    <label for="title">Date: </label>
                                </div>
                                <div class="col-md-9">
                                    <input class="form-control news-date" id="datefrom" name="news_date" type="text" value="{{ getTodayNepaliDate() }}" readonly="readonly" style="cursor: pointer;" />
                                </div>

                                <div class="spacer"></div>
                                <div class="col-md-3">
                                    <label for="title">Departments: </label>
                                </div>
                                <div class="col-md-9">
                                    <div class="list-group">
                                        @foreach ($departments as $dep)
                                        <a href="#" class="list-group-item department @if (in_array($dep->id, $news_arr)) active @endif" id="{{ $dep->id }}" >{{ $dep->name }}</a>
                                        @endforeach
                                        <input name="news_department" class="news-department" type="hidden" value="{{ $news->news_department or '' }}" />
                                    </div>
                                </div>
                            </div>
                            <div class="spacer"></div>
                            <div class="col-md-12">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <button class="btn btn-primary" type="submit" style="padding: 7px 45px;">Save</button> 
                                <button class="btn btn-warning" type="reset" style="padding: 7px 45px;">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="{{URL::asset('backendtheme/plugins/jQuery/jQuery-2.1.4.min.js')}}"></script>
<script>
$(function () {
    $('.department').click(function () {
        var id = $(this).attr('id');
        $(this).toggleClass('active');
        //var prev = $('.news-department').val();
        //$('.news-department').val(prev + ',' + id);
    });

    $('#news-form').submit(function () {
        var id = '';
        $('.list-group .active').each(function () {
            id += $(this).attr('id') + '-';
        });
        $('.news-department').val(id);
    });
});

CKEDITOR.replace('news_detail');
</script>

<script type="text/javascript">
         $(document).ready(function(){

        

        $('#datefrom').nepaliDatePicker({
            ndpEnglishInput: 'englishDate'
        });

     
        });
    </script>

@stop