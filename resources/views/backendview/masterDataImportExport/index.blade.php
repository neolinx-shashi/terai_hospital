@extends('backendlayout.master')
@extends('backendlayout.header')
@extends('backendlayout.leftmenu')
@extends('backendlayout.footer')
@section('userscontent')
@extends('backendlayout.flashmessagecollection')
<section class="content-header">
<h1>
Master Data Import Export
</h1>
</section>
<section class="content">
    <form class="form-horizontal" method="post" action="{{url('master-data/patient/report')}}">
        <div class="box">
            <div class="shadow">
                <div class="row">
                    <div class="col-sm-2 col-md-6 col-lg-6">
                        <div class="dropdown fiscal-list">
                            <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Generate Report By Fiscal Year
                            <span class="caret"></span></button>
                            <ul class="dropdown-menu">
                                @foreach($fiscalYear as $fiscalYearData)
                                <li>
                                <a href="{{url('master-data/patient/report',$fiscalYearData->id)}}">{{$fiscalYearData->fiscal_year_start_date}}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</section>
@stop