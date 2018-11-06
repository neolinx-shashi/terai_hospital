@extends('backendlayout.master')
@extends('backendlayout.header')
@extends('backendlayout.leftmenu')
@extends('backendlayout.footer')
@section('userscontent')
    @extends('backendlayout.flashmessagecollection')
    <script src="{{URL::asset('backendtheme/plugins/jQuery/jQuery-2.1.4.min.js')}}"></script>


    <section class="content-header">
        <h1>
            Patient Discharge Summary
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                    </div>
                    <div class="box-body">
                        <table>
                            <tr>
                                <td><b>Patient's
                                        Name: </b>{{$patient->first_name.' '.$patient->middle_name.' '.$patient->last_name}}
                                </td>
                                <td style="width: 76%; text-align: right"><b>Patient
                                        Code: </b>{{$patient->patient_code}}</td>
                            </tr>

                            <tr>
                                <td><b>Address: </b>{{$patient->permanent_address}}</td>
                                <td style="width: 76%; text-align: right"><b>Age/Sex: </b>{{$patient->age}}/{{ $patient->gender }}</td>
                            </tr>

                            <tr>
                                <td><b>Date of Admission: </b>{{$patient->created_at}}</td>
                                <td style="width: 76%; text-align: right"><b>Date of
                                        Discharge: </b>{{$patient->discharged_at}}</td>
                            </tr>
                        </table>
                        <br>

                        <div>
                            <b>Final Diagnosis:</b><span style="color: #b30000"> * </span><textarea
                                    class="form-control col-md-5" id="diagnosis"
                                    name="diagnosis" rows="3">{{{ $patient->diagnosis or '' }}}</textarea>
                            <br>
                            <b>Treatment:</b><span style="color: #b30000"> * </span><textarea
                                    class="form-control col-md-5" id="treatment" name="treatment"
                                    rows="3">{{{ $patient->treatment or '' }}}</textarea>
                            <br>
                            <b>Summary/Hospital Course:</b><span style="color: #b30000"> * </span><textarea
                                    class="form-control col-md-5"
                                    id="discharge_summary" name="discharge_summary"
                                    rows="3">{{{ $patient->discharge_summary or '' }}}</textarea>
                        </div>

                        <div>
                            <b>Follow Up:</b><input id="follow_up" name="follow_up" type="text" style="width: 90px" value="{{{ $patient->follow_up or '' }}}"/>
                            <br>
                            <b>Emergency Contact No:</b> {{$patient->phone}}
                            <br>
                            <b>Doctor
                                Name:</b> {{ $patient->isConsultedToDoctor->first_name.' '.$patient->isConsultedToDoctor->middle_name.' '.$patient->isConsultedToDoctor->last_name }}
                            <br>
                            <b>Doctor Signature:</b>
                        </div>

                        <div style=" text-align: center; padding-bottom: 55px; clear: both; float: none;"
                             class="print-button-spot">
                            <button id="button" class="btn btn-primary print-now"
                                    onclick="printContent('printCertificate')">
                                Save and Print
                            </button>
                        </div>
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

    <script type="text/javascript">
        $(function () {
            $('input[name="follow_up"]').daterangepicker({

                    locale: {
                        format: 'YYYY-MM-DD'
                    },
                    singleDatePicker: true,
                    showDropdowns: true
                },
                function (start, end, label) {
                    var years = moment().diff(start, 'years');

                });
        });

        function printContent(el) {
            /*var restorepage = document.body.innerHTML;
             var printcontent = document.getElementById(el).innerHTML;
             document.body.innerHTML = printcontent;
             window.print();
             document.body.innerHTML = restorepage;*/

            if ($("#diagnosis").val() == '' || $("#treatment").val() == '' || $("#discharge_summary").val() == '0') {
                alert('Fields with astericks (*) are mandatory!');
            } else {
                /*to avoid double click*/
                $('.print-now').attr('disabled', 'disabled');


                /* insert in table */
                var p_url = '{{ url("patient-discharge-summary-save") }}';
                var token = "{{csrf_token()}}";
                var pid = <?php echo $patient->id ?>;
                var diagnosis = $('#diagnosis').val();
                var treatment = $('#treatment').val();
                var dis_sum = $('#discharge_summary').val();
                var follow_up = $('#follow_up').val();

                $.post(p_url, {
                    _token: token,
                    pid: pid,
                    diagnosis: diagnosis,
                    treatment: treatment,
                    discharge_summary: dis_sum,
                    follow_up: follow_up
                }, function (res) {
                    console.log(res);
                });

                /*print invoice */
                $('.print-button-spot, .main-footer, .test-select, .rem').hide();
                window.print();
                window.location.assign('{{URL::to('/')}}/dashboard');
            }
        }
    </script>
@endsection