 
@if(Auth::user()->user_type_id=='4')
<style type="text/css">
     .box.side-box.doctors {
        max-height: 330px !important;
        height: 330px !important;
        overflow-y: auto !important;
    }
    #create-patient a:hover{
        font-weight: bold;
        text-decoration: none;
        -webkit-transition: all 0.4s;
        -moz-transition: all 0.4s;
        -o-transition: all 0.4s;
        transition: all 0.4s;
    }
    .inner {
        min-height: 122px;
    }

    .inner p {
        padding: 40px 10px;
    }

    table.table{
        color: #000;
    }
    .text-white{
        color: #fff;
    }
    .bg-cornflowerblue{
        background: cornflowerblue !important;
    }
    .bg-azure{
        background: azure;
        box-shadow: 0px 5px 10px #ccc;
        margin-top: 10px;
    }
    .small-box .icon{
        top: 0;
        font-size: 80px;
    }
    a, a:hover{
        color: #fff;
        text-decoration: none;
    }
 </style>
<div class="row">
    <div class="col-lg-4 col-xs-6">
        <a href="{{url('revenue/calculation')}}">
            <div class="small-box bg-aqua">
            
            <div class="inner">
             <h3>
              Rs. {{ round($revenue, 2) }}
             </h3>
              <p>Total Revenue Collected</p>
            </div>
           
            <div class="icon">
            <i class="fa fa-user-md fa-usd"></i>
            </div>
            <a href="{{url('revenue/total')}}" class="small-box-footer">More info <i
            class="fa fa-arrow-circle-right"></i></a>
            </div>
        </a>
    </div>

    <div class="col-lg-4 col-xs-6">
        <a href="{{url('eport-by-date')}}">
            <div class="small-box bg-cornflowerblue text-white">
            <div class="inner">
            <h3>
           

            </h3>
            <p>Total Billing Report</p>
            </div>
            <div class="icon">
            <i class="fa fa-credit-card fa-md"></i>
            </div>
            <a href="{{url('eport-by-date')}}" class="small-box-footer">More info <i
            class="fa fa-arrow-circle-right"></i></a>
            </div>
        </a>
    </div>


    <div class="col-lg-4 col-xs-6">
        <a href="{{url('doctor-report')}}">
            <div class="small-box bg-blue">
            <div class="inner">
            <h3>

            </h3>
            <p>Total Doctor Report</p>
            </div>
            <div class="icon">
            <i class="fa fa-stethoscope fa-md"></i>
            </div>
            <a href="{{url('doctor-report')}}" class="small-box-footer">More info <i
            class="fa fa-arrow-circle-right"></i></a>
            </div>
        </a>
    </div>
<!-- </div>
<div class="row"> -->

    <div class="col-lg-4 col-xs-6">
        <a href="{{url('revenue/by-user')}}">
            <div class="small-box bg-cadetblue">
            <div class="inner">
                <h3>
                </h3>
                <p>Total Billing By User </p>
            </div>
            <div class="icon">
            <i class="fa fa-user-o fa-md"></i>
            </div>
            <a href="{{url('revenue/by-user')}}" class="small-box-footer">More info <i
            class="fa fa-arrow-circle-right"></i></a>
            </div>
        </a>
    </div>


        <div class="col-lg-8 col-xs-12">
        <div class="small-box bg-azure">
            <table class="table">
            <thead>
              <tr>
                <th>Name</th>
                <th>Contact No.</th>
              </tr>
            </thead>
            <tbody>
            @foreach($emergencyContact as $contacts)
              <tr>
                <td>{{ucfirst($contacts->name)}}</td>
                <td>{{$contacts->contact}}</td>
              </tr>
             @endforeach
            
            </tbody>
          </table>
        </div>
    </div>
    

    
   <!--  <div class="col-lg-4 col-xs-6">
        <div class="box side-box">
        <div class="box-body">
        @if(count($doctorListToday)>0)
        <table class="table table-hover table-bordered table-striped">
        <thead>

        Available Doctors Today - <strong style="font-size: medium">({{ count($doctorListToday) }})</strong>
        <tr>
        <th>
        Doctors
        </th>
        <th class="col-lg-3">
        Actions
        </th>
        </tr>
        </thead>
        <tbody>
        @foreach($doctorListToday as $key=>$dayName)
        <tr>
        <td>
        <strong>
        {{ucfirst($dayName->first_name). ' '. ucfirst($dayName->middle_name). ' '. ucfirst($dayName->last_name) }}

        </strong>
        </td>
        <td>
        <a title="View Today Doctor Shift"
        data-rel="tooltip">


        <button type="button" class="btn btn-default btn-flat previewimage"
        data-toggle="modal" data-target="#previewimage"
        data-link="{{URL::to('shift/overview',$dayName->doctorId)}}">
        Preview
        </button>

        </a>
        </td>
        </tr>
        @endforeach
        </tbody>
        </table>

        @else
        <div class="alert alert-danger">
        <strong> Sorry ! No Doctor Available Today
        </strong>
        </div>
        @endif
        </div>
        </div>
        </div> -->

</div>
@endif