
 <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
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
    #accordion > div{
        height: auto !important;
    }

    #accordion > div > ul > li{
        color: #3c8dbc;
       /* font-weight: bold;*/
    }
    #accordion > div > ul > li:before{
        content: "\f055";
        font-family: "FontAwesome";
        margin-right: 5px;
        color: #3c8dbc;
    }
    #accordion > div > ul > li.add-icon:before{
        content: "\f056" !important;
    }

    #accordion ul{
        padding: 0px;
    }
    #accordion ul ul{
        padding-left: 20px;
        margin-left: 5px;
    }
    #accordion ul li{
        list-style: none;
    }
    #accordion li > ul{
        display: none;
        border-left: 1px solid #3c8dbc;
    }
    #accordion li ul li:before{
        content: "\f178";
        font-family: "FontAwesome";
        margin-right: 5px;
    }
    #accordion h3 {
        background: #d3e7fd;
        border-color: #d3e7fd;
        color: #000;
    }
 </style>
@if(Auth::user()->user_type_id=='6')
<style type="text/css">
    .inner{
        min-height: 122px;
        padding: 20px;
    }
    .inner-link{
        text-decoration: none !important;
        color: #fff !important;
    }
    /*.inner-link:hover{
        color: #fff;
    }*/
    .small-box.bg-green.contacts {
        height: 315px;
        overflow: auto;
        background: azure !important;
        color: #000 !important;
        box-shadow: 0px 5px 10px #ccc;
    }
    .small-box.bg-green.contacts th, .small-box.bg-green.contacts td{
        border-color: #000;
    }
    #accordion{
        height: 289px;
        overflow: auto;
    }
    h2.accordion-title {
        margin: 0px;
        font-size: 20px;
        font-weight: bold;
        background: #d3e7fd;
        padding: 10px;
        border-radius: 3px;
    }
    .book-oppointment{
        background: #0d94af;
        color: #fff;
    }
    .view-oppointment{
        background: #00db71;
        color: #fff;
    }
    .news-events{
        background: #25c4fe;
        color: #fff;
    }
</style>
<div class="row">
    <div class="col-lg-8">
        <div class="row">
            <div class="col-lg-6">
                <a href="#" class="inner-link">
                    <div class="small-box bg-aqua">
                        
                            <div class="inner">
                                <h3>
                                    {{ count($doctorListToday) }}
                                </h3>
                                <p>Total OPD Available Doctors</p>
                            </div>
                         
                        <div class="icon">
                            <i class="fa fa-user-md fa-md"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i
                        class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </a>
            </div>

            <div class="col-lg-6">
                <a href="{{url('appointment')}}" class="inner-link">
                    <div class="small-box book-oppointment">
                        <div class="inner">
                            <h3>
                           
                            </h3>
                            <p>Book Appointments</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-address-book-o fa-md"></i>
                        </div>
                        <a href="{{url('appointment')}}" class="small-box-footer">Book Appointment<i
                        class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </a>
            </div>
            <div class="col-lg-6">
                <a href="{{URL::to('appointment/patientlist',getTodayDate())}}" class="inner-link">
                    <div class="small-box view-oppointment">
                        <div class="inner">
                            <h3>
                           
                            </h3>
                            <p>View Appointments</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-calendar-check-o fa-md"></i>
                        </div>
                        <a href="{{URL::to('appointment/patientlist',getTodayDate())}}" class="small-box-footer">View Appointments <i
                        class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </a>
            </div>
            <div class="col-lg-6">
                <a href="{{URL::to('news')}}" class="inner-link">
                    <div class="small-box news-events">
                        <div class="inner">
                            <h3>
                           
                            </h3>
                            <p>Create News & Events</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-newspaper-o fa-md"></i>
                        </div>
                        <a href="{{URL::to('news')}}" class="small-box-footer">Create News & Events <i
                        class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </a>
            </div>
            <div class="col-lg-6">
                <div class="box side-box doctors">
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
            </div>
            <div class="col-lg-6">
                <h2 class="accordion-title">Wards/Rooms/Beds</h2>
                <div id="accordion">
                    @foreach($wardDetails as $ward)
                    <h3>{{$ward->ward_name}}</h3>
                    <div>
                        <ul class="panel-content">
                        @foreach($room as $rooms)
                        @if($ward->id==$rooms->ward_id)
                            <li>{{$rooms->room_name}}
                                <ul>
                                @foreach($beds as $bed)
                                @if($bed->room_id==$rooms->id)
                                    <li>{{$bed->bed_name}}&nbsp;&nbsp;{{$bed->availability}}</li>
                                    @endif
                                    @endforeach
                                </ul>
                            </li>
                            @endif

                            @endforeach
                           
                        </ul>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="small-box bg-green contacts">
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
</div>
@endif
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript">
    $( "#accordion" ).accordion();
    $('ul.panel-content > li').click(function(){
        $(this).find('ul').slideToggle();
        $(this).toggleClass('add-icon');
    })
</script>
