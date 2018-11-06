@if(Auth::user()->user_type_id=='5')
    <style>
        .bg-pink{
            background-color: pink;
            color: #fff;
        }
        .bg-darkred{
            background-color: darkred;
            color: #fff;
        }
        .table-bordered>tbody>tr>td,.table-bordered>tbody>tr>th{
            border-color: #999 !important;
        }
        .inner{
            min-height: 122px;
            padding: 20px;
        }
        .inner-link{
            text-decoration: none !important;
            color: #fff !important;
        }
        .modal-body {
            height: 400px;
            overflow: auto;
        }
    </style>
            <div class="row">
                <div class="col-lg-4 col-xs-6">
                    <a href="{{URL::to('/configuration/doctor/create')}}" class="inner-link">
                        <div class="small-box bg-aqua">
                            <div class="inner">
                                <h3>{{$getAllDoctors}}</h3>
                                <p>Total Doctors</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-user-md fa-md"></i>
                            </div>
                            <a href="{{URL::to('/configuration/doctor/create')}}" class="small-box-footer">Doctor Setup&nbsp;<i
                                        class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-xs-6">
                    <!-- small box -->
                    <a href="{{URL::to('/configuration/nurse/create')}}" class="inner-link">
                        <div class="small-box bg-pink">
                            <div class="inner">
                                <h3>{{count($nurseListToday)}}</h3>
                                <p>Total Nurse</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-female fa-md"></i>
                            </div>
                            <a href="{{URL::to('/configuration/nurse/create')}}" class="small-box-footer">Nurse Setup&nbsp;<i
                                        class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-xs-6">
                    <a href="{{URL::to('/department')}}" class="inner-link">
                        <div class="small-box bg-green">
                            <div class="inner">
                                <h3>
                                    {{$getAllDepartments}}
                                </h3>
                                <p>Total Departments</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-hospital-o fa-md"></i>
                            </div>
                            <a href="{{URL::to('/department')}}" class="small-box-footer">Department Setup&nbsp;<i
                                        class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </a>
                </div><!-- ./col -->
                <div class="col-lg-4 col-xs-6">
                    <!-- small box -->
                    <a href="{{URL::to('/category-tree-view')}}" class="inner-link">
                        <div class="small-box bg-darkred">
                            <div class="inner">
                                <h3>{{count($tests)}}</h3>
                                <p>Total Test</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-flask fa-md"></i>
                            </div>
                            <a href="{{URL::to('/category-tree-view')}}" class="small-box-footer">Test Setup&nbsp;<i
                                        class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-xs-6">
                    <!-- small box -->
                    <a href="{{URL::to('/contact')}}" class="inner-link">
                        <div class="small-box bg-cadetblue">
                            <div class="inner">
                                <h3>{{count($contacts)}}</h3>
                                <p>Contact Setup</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-phone fa-md"></i>
                            </div>
                            <a href="{{URL::to('/contact')}}" class="small-box-footer">Contact Setup&nbsp;<i
                                        class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-xs-6">
                    <!-- small box -->
                    <a href="{{URL::to('/usersetup')}}" class="inner-link">
                        <div class="small-box bg-yellow">
                            <div class="inner">
                                <h3>{{$getAllUsers}}</h3>
                                <p>Registered Users</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-users fa-md"></i>
                            </div>
                            <a href="{{URL::to('/usersetup')}}" class="small-box-footer">User Setup&nbsp;<i
                                        class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </a>
                </div>
                <div class="col-lg-6">
                    <div class="box side-box doctors">
                        <div class="box-body">
                           
                            <table class="table table-hover table-bordered table-striped">
                                <thead>
                                <strong style="font-size: medium;">User Log Details</strong>
                                <tr>
                                    <th>
                                        S.N
                                    </th>
                                    <th>
                                        Full name
                                    </th>
                                    <th>
                                        User Log Details
                                    </th>
                                </tr>
                                </thead>
                                <tbody><?php
                            $i = $users->firstItem();
                            ?>

                                @foreach($users as $key=> $user)
                                    <tr>
                                    <td>
                                    {{ $i++}}.
                                     </td>                
                                            <td>
                                            <strong>
                                   
                                   {{ucfirst($user->fullname)}}
                                            </strong>
                                            <br>
                                            {{ucfirst($user->userTypes->type_label)}}

                                        </td>
                                        <td>
                 <button href="#myModal{{$user->id}}" id="openBtn" data-toggle="modal" class="btn btn-primary">View</button>

                    <div class="modal fade" id="myModal{{$user->id}}" style="color: #000 !important;">
                    <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                              <h3 class="modal-title">User History {{ucfirst($user->fullname)}} </h3>
                            </div>
                            <div class="modal-body">
                              <table class="table table-striped" id="tblGrid">
                                <thead id="tblHead">
                                  <tr>
                             <!--        <th>S.N</th> -->
                                    <th>Login Time</th>
                                     <th>Logout Time</th>
                                    <th class="text-right">Total Time</th>
                                  </tr>
                                </thead>
                                <tbody>

                                 @foreach($userHistory as $key=> $history)
                                  @if($user->id==$history->user_id)
                                  <tr>
                                  <?php
                                  $startTime=strtotime($history->login_date_time);

                                  $endTimeHs=date('Y-m-d h:i A',strtotime($history->logout_date_time));

                                  ?>
                                  <!-- <td>{{$key+1}}</td> -->
                                    <td>{{ date('Y-m-d h:i A',strtotime($history->login_date_time)) }}</td>
                                    <td>
                                    @if($history->logout_date_time=='0000-00-00 00:00:00')
                                    Currently Login
                                    @else
                                    {{ date('Y-m-d h:i A',strtotime($history->logout_date_time)) }}
                                    @endif</td>
                                    <td>
                                        <?php
                                  $startTime=strtotime($history->login_date_time);

                                  $endTimeHs=strtotime($history->logout_date_time);
                                 
                               $diff = ($endTimeHs)-($startTime);


                               $init = $diff;
                                $hours = floor($init / 3600);
                                $minutes = floor(($init / 60) % 60);
                                $seconds = $init % 60;

                                if($history->logout_date_time=='0000-00-00 00:00:00')
                               echo  'Currently login';
                                else

                                echo "$hours:Hours $minutes:Min $seconds Sec";
                                


                            //      $diff_in_hours = $startTime->diffInHours($endTimeHs);
                            // echo($diff_in_hours);
                                  ?>
                                    </td>
                                  </tr>
                                  @endif
                                  @endforeach
                                </tbody>
                              </table>
                             
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-default " data-dismiss="modal">Close</button>
                            </div> 
                          </div>
                        </div>
                      </div>
                    </td>
                            </tr>
                            @endforeach
                        </tbody>
                        </table>
                            {{$users->render()}}
                        </div>
                    </div>
                </div>
            <!-- <div class="row">
                
            </div> -->
@endif