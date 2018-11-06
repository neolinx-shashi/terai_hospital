<!-- <div class="light-skin modal fade" id="loginModal" tabindex="-1" role="form" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Login here</h4>
      </div>
      <div class="modal-body">
    
                                @if(Session::get('patient_id'))
                                        
                                         <a href="{{ URL::to('configuration/patient/' . Session::get('patient_id') . '/print-invoice') }}" title="Print Patient Invoice"
                                                 data-rel="tooltip">
                                                 <button type="button" class="btn btn-primary btn-flat  "  style="margin-left: 10px;">
                                                    <span class="glyphicon glyphicon-print" aria-hidden="true"></span>
                                                    Invoice
                                                </button>
                                            </a>

                                            <a href="{{ URL::to('configuration/patient/' . Session::get('patient_id') . '/print-sticker') }}"
                                             title="Print Patient Sticker"
                                             data-rel="tooltip"  style="margin-left: 10px;">
                                             <button type="button" class="btn btn-primary btn-flat  ">
                                                Sticker
                                            </button>
                                        </a>


                                        <a href="{{URL::action('Billing\PatientController@create')}}">
                                                <button type="button" class="btn btn-success btn-flat"  style="margin-left: 10px;">
                                                    <span class="fa fa-user-plus" aria-hidden="true"></span> New Patient
                                                </button>
                                            </a>
                             @endif

      </div>
    </div>
    </div>
    </div>
<!--modal information when saved data -->
<?php $error = Session::get('patient_id');  ?>
@if(!empty($error) )
<script>
$(function() {
    $('#loginModal').modal('show');
});
</script>
@endif -->