 <div class="col-lg-4">
        <div class="panel panel-default">
           

            <div class="panel-body" id="containers" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto">
                <script type="text/javascript" src="{{ URL::asset('assets/piechart/jquery.min.js') }}"></script>
                <style type="text/css">
                    ${demo.css}
                </style>
                <script type="text/javascript">
                    $(function () {
                        // Create the chart
                        $('#containers').highcharts({
                            chart: {
                                type: 'column'
                            },
                            title: {
                                text: 'Total Approved Members'
                            },

                            xAxis: {
                                type: 'category'
                            },
                            yAxis: {
                                title: {
                                    text: 'Total number of Members '
                                }

                            },
                            legend: {
                                enabled: false
                            },
                            plotOptions: {
                                series: {
                                    borderWidth: 0,
                                    dataLabels: {
                                        enabled: false,
                                        format: ''
                                    }
                                }
                            },

//                            tooltip: {
//                                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
//                                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b></b> <br/>'
//                            },

                            series: [{
                                name: 'Approved Members',
                                colorByPoint: true,
                                <?php
                                    //SELECT app_memtype_id,member_types.name,count(*) as cnt
                                    // FROM `membership_applications`,member_types WHERE app_memtype_id = member_types.id group by app_memtype_id

                                    ?>
                                data: <?php echo json_encode($approvalArray); ?>
                            }],
                            drilldown: {
                                series: [{
                                    name: 'Approved Members',
                                    <?php
                                     //SELECT app_memtype_id,member_types.name,count(*) as cnt
                                     // FROM `membership_applications`,member_types WHERE app_memtype_id = member_types.id group by app_memtype_id

                                     ?>
                                    data: <?php echo json_encode($approvalArray); ?>

                                }]
                            }
                        });
                    });
                </script>

                <script src="{{ URL::asset('assets/piechart/highcharts.js') }}"></script>
                <script src="{{ URL::asset('assets/piechart/data.js') }}"></script>
                <script src="{{ URL::asset('assets/piechart/drilldown.js') }}"></script>





            </div>

        </div>
    </div>