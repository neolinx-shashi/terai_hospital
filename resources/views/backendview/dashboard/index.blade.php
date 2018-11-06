@extends('backendlayout.master')
@extends('backendlayout.header')
@extends('backendlayout.leftmenu')
@extends('backendlayout.footer')
@section('userscontent')
<script src="{{URL::asset('backendtheme/plugins/jQuery/jQuery-2.1.4.min.js')}}"></script>
<script src="{{URL::asset('backendtheme/piechart/highcharts.js')}}"></script>

    <section id="dashboard" class="content" style="min-height: auto;">
    @if(Auth::user()->user_type_id=='1' || Auth::user()->user_type_id=='2' ||Auth::user()->user_type_id=='3')
        <div class="search">
            <div class="row">
                <div class="col-md-6 pull-right">
                <!-- date -->
                <?php

                    $todayDate= date("Y/n/j");

                    $localDate = str_replace("/", ",", $todayDate);

                    $classes=explode(",",$localDate);  
                    //print_r($classes); 

                    $a=$classes[0];
                    $b=$classes[1];
                    $c=$classes[2];

                   

                    echo "<div id='myDate'>".eng_to_nep_dashboard($a,$b,$c)."</div>";
                ?><!-- end of date -->
                </div>
            </div>
        </div>

        <div id="txtHint" class="title-color" style="padding-top:10px; padding-bottom: 10px;"></div>
        @endif

           <!-- dasboard of admin and superadmin
            --> 
            @include('backendview.dashboard.admindashboard')  


       
    <!-- dasboard of billing admin
 --> 
 
 @include('backendview.dashboard.billingdashboard')

 @include('backendview.dashboard.nursedashboard')

 @include('backendview.dashboard.receptiondashboard') 

 @include('backendview.dashboard.accountdashboard')  
<!-- dasboard of system admin
 -->
         
@include('backendview.dashboard.systemadmindashboard')



    </section>


    <section class="content" style="padding: 0px">
        <div class="row">
            <div class="col-md-4">

            </div>
            <div class="col-md-4">

            </div>
            {{--<div class="col-md-4">


                <script type="text/javascript"> <!--
                    var nc_width = 260;
                    var nc_height = 185;
                    var nc_api_id = 58220170427803; //-->
                </script>
                <script type="text/javascript" src="http://www.ashesh.com.np/calendarlink/nc.js"></script>
                <div id="ncwidgetlink">
                    <a href="http://www.ashesh.com.np/nepali-calendar/" id="nclink" title="Nepali calendar"
                       target="_blank"></a></div>
                <!-- End of nepali calendar widget -->

            </div>--}}
        </div>
    </section>


    <div class="modal fade" id="previewimage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Shift <?php
                        echo date("l");
                        ?></h4>
                </div>
                <div class="modal-body" id="imagepreviewdiv">


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                </div>
            </div>
        </div>
    </div>



    <script>
        $(document).ready(function () {
            $('.previewimage').click(function () {
                var url = $(this).attr("data-link");
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "GET",
                    dataType: 'html',
                    url: url,
                    beforeSend: function () {
                        $('#loading').html('<img src="{{URL::asset('Backend_asset/loading.gif')}}"/>').show();

                    },
                    success: function (response) {


                        $('#imagepreviewdiv').html(response);

                    },
                    error: function (e) {
                        $('#loading').html('<img src="{{URL::asset('Backend_asset/loading.gif')}}"/>').hide();
                        alert(e);
                    }
                });
            });
        });
    </script>

    {{--<script>
        $(document).ready(function () {
            $("#search").keyup(function () {
                var str = $("#search").val();
                if (str == "") {
                    $("#txtHint").html("<c style='margin-left: 30%;'></c>");
                } else {
                    $.get("{{ url('dashboard/search') }}/" + str, function (data) {
                        $("#txtHint").html(data);
                    });
                }
            });
        });
    </script>--}}

@stop