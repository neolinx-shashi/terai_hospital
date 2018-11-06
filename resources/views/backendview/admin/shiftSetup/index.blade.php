@extends('backendlayout.master')
@extends('backendlayout.header')
@extends('backendlayout.leftmenu')
@extends('backendlayout.footer')
@section('userscontent')
@extends('backendlayout.flashmessagecollection')
<section class="content-header">
  <div class="search-breadcrumb-only">
      <div class="row">
          <div class="col-md-10">
              <ol class="breadcrumb">
                  <li><a href="{{url('dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                  <li><a href="{{URL('department')}}">System Setup</a></li>
                  <li class="active">View Shift</li>
              </ol>
          </div>
          <div class="col-md-2">
              <a href="{{URL::action('BackEndController\DoctorShiftController@create')}}">
                <button type="button" class="btn btn-success btn-flat  pull-right ">
                  <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add Shift
                </button>
              </a> 
          </div>
      </div>
  </div>

</section>

<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">

       <div class="row">
        <div class="col-md-12">
          <!-- Custom Tabs -->
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">

              <?php $count =0; foreach($dayName as $key=>$dayData)  { ?>

              <li class=" <?php if (date('l') == $dayData->name){ echo 'active';}  ?> ">

                <a href="#tab_{{$key}}" data-toggle="tab"><strong>{{ucfirst($dayData->name)}}</strong></a>
              </li>
              <?php

              $count++;}?>

            </ul>
            <div class="tab-content">
             <?php $count =0; foreach($dayName as $key=>$dayData)  { ?>

             <div class="tab-pane <?php if (date('l') == $dayData->name){ echo 'active';}  ?>" id="tab_{{$key}}">
               <div class="box-body">

                 <table id="" class="table table-hover table-bordered table-striped">
                  <thead>
                    <tr>
<!--                       <th>S.N</th>
 -->                      <th>Start Time</th>
                      <th>End Time</th>
                      <th>Shift Type </th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>


                    @foreach($shiftTime as $key=> $shift)

                    @if($dayData->id==$shift->day_id)
                    <tr>

                      <!-- <td>
                        {{$key+1}}
                      </td> -->
                      <td>
                        <?php 
                        $time=$shift->start_time;
                        $d = new DateTime($time); 
                        echo $d->format( 'g:i A' );
                        ?>

                      </td>
                      <td>
                        <?php 
                        $time=$shift->end_time;
                        $d = new DateTime($time); 
                        echo $d->format( 'g:i A' );
                        ?>

                      </td>
                      <td>
                        {{ucfirst($shift->shift_type)}}
                      </td>


                      <td>
                        <a ">
                          <button type="button" class="btn btn-default btn-flat " data-toggle="modal" data-target="#myModal{{$shift->id}}">
                            <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                          </button>
                        </a>

                        <a href="{{URL::to('remove-shift-setup',array($shift->id))}}"
                          onclick="return confirm('Are you sure you want to delete this record?')">
                          <button type="button" class="btn btn-danger btn-flat  ">
                            <span class="glyphicon glyphicon-trash"
                            aria-hidden="true"></span>
                          </button>
                        </a>
                      </td>
                    </tr>

                    @endif


                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
            <?php                //}
            $count++;}?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
</section>

@foreach($shiftTime as $key=> $shift)
<div id="myModal{{$shift->id}}" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <form method="post" action="{{url('update-shift-setup',array($shift->id))}}">
     {!! csrf_field() !!}
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Edit Shift</h4>
        </div>

        <div class="modal-body">

          <table class="table table-hover table-bordered table-striped"> 
            <tr>
              <th>
                Start Time
              </th>
              <th>
                End Time
              </th>

              <th>
                Shift Type
              </th>
            </tr>

            <tr>
              <td>
              <input type="time" name="start_time" value="{{$shift->start_time}}" >      </td>
                <td>
                  <input type="time" name="end_time" value="{{$shift->end_time}}" >      </td>
                  <td>
                    <input type="text" name="shift_type" value="{{$shift->shift_type}}" >      </td>

                  </tr>    
                </table>
              </div>
              <div class="modal-footer">
               <button type="submit" class="col-md-3 col-lg-offset-7 btn btn-primary btn-flat">Update</button>
             </div>
           </div>
         </form>
       </div>
     </div>
     @endforeach
     @endsection