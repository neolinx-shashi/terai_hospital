@extends('backendlayout.master')
@extends('backendlayout.header')
@extends('backendlayout.leftmenu')
@extends('backendlayout.footer')
@section('userscontent')
 <script src="{{URL::asset('backendtheme/plugins/jQuery/jQuery-2.1.4.min.js')}}"></script>
    <div class="search">
        <h3 class="text-center title-color">Renew patient</h3>
        <p>&nbsp;</p>
        <div class="row">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="input-group">
                    <span class="input-group-addon" style="color: white; background-color: rgb(124,77,255);">SEARCH PATIENT</span>
                    <input type="text" autocomplete="off" id="search" class="form-control input-lg" placeholder="Enter patient code Here">
                </div>
            </div>
        </div>
    </div>
<div id="txtHint" class="title-color" style="padding-top:50px; " ></div>
     
<script>
$(document).ready(function(){
   $("#search").keyup(function(){
       var str=  $("#search").val();
       if(str == "") {
               $( "#txtHint" ).html("<b>Patient information will be listed here...</b>"); 
       }else {
               $.get( "{{ url('renew/patient?id=') }}"+str, function( data ) {
                   $( "#txtHint" ).html( data );
            });
       }
   });  
}); 
</script>
@stop
