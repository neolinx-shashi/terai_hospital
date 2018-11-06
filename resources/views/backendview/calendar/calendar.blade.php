@extends('backendlayout.master')
@extends('backendlayout.header')
@extends('backendlayout.leftmenu')
@extends('backendlayout.footer')
@section('userscontent')

    <section class="content">

        <div class="row">
            <div class="col-md-3">




            </div><!-- /.col -->
            <div class="col-md-12">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#activity" data-toggle="tab"  >Nepali Calendar</a></li>


                    </ul>
                    <div class="tab-content">
                        <div class="active tab-pane" id="activity">
                            <!-- Post -->

                            <script type="text/javascript"> <!--
                                var nc_width = 'responsive';
                                var nc_height = 595;
                                var nc_api_id = "851161f477"; //-->
                            </script>
                            <script type="text/javascript" src="http://www.ashesh.com.np/nepali-calendar/js/ncf.js"></script>

                        </div><!-- /.tab-pane -->
                        <div class="tab-pane" id="timeline">

                            <!-- Start of nepali calendar widget -->

                            <!-- End of nepali calendar widget -->

                        </div><!-- /.tab-pane -->


                    </div><!-- /.tab-content -->
                </div><!-- /.nav-tabs-custom -->
            </div><!-- /.col -->
        </div><!-- /.row -->



    </section>



@stop