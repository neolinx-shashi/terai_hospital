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
                  <li><a href="{{URL('usersetup')}}">User Configuration</a></li>
                  <li class="active">View Users</li>
              </ol>
          </div>
          <div class="col-md-2">
          @if(Auth::user()->user_type_id=='1' || Auth::user()->user_type_id=='2' || Auth::user()->user_type_id=='5' )
              <a href="{{url('usersetup/create')}}">
                <button type="button" class="btn btn-success btn-flat  pull-right ">
                  <span class="glyphicon glyphicon-user" aria-hidden="true"></span> Add User
                </button>
              </a> 
               @endif
          </div>
      </div>
  </div>

</section>
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box users-list">

        <div class="box-body">
         @if(count($user)>0)
         <table id="example1" class="table table-hover table-bordered table-striped">
          <thead>
            <tr>
              <th>S.N</th>
              <th colspan="2">User Details</th>
              <th>User Designation/Type</th>
              <th>Address</th>
              <th>Status</th>
              <th>Created At</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $i = $user->firstItem();

            ?>
            @foreach($user as $key=>$userdata)
            <tr>
              <td><br>{{$i++}}.
              </td>
              <td>
                @if($userdata->userimage_name!="")
                 <a href="{{URL::to('usersetup/' .$userdata->id)}}" title="View User Details"
                 data-rel="tooltip">
                <img src="{{url('uploads/users')}}/{{$userdata->userimage_name}}" width="50"
                class="thumbnails" alt="{{ucfirst($userdata->fullname)}}">
                </a>
                @else
                 <a href="{{URL::to('usersetup/' .$userdata->id)}}" title="View User Details"
                 data-rel="tooltip">
                <img src="{{URL::asset('UserDefaultImage/logo.jpg')}}" width="50"
                class="thumbnails">
                </a>
                @endif
              </td>
              <td>

                <a href="{{URL::to('usersetup/' .$userdata->id)}}" title="View User Details"
                 data-rel="tooltip">
                 <i class="glyphicon glyphicon-user"></i>&nbsp;
                 &nbsp;{{ucfirst($userdata->fullname)}}</a><br>
                 <i class="glyphicon glyphicon-envelope"></i>&nbsp;
                 &nbsp;{{$userdata->email}}
                 <br>
                 <i class="fa fa-phone" aria-hidden="true"></i>&nbsp;
                 &nbsp;{{$userdata->contact_no}}
               </td>
               <td>{{ucfirst($userdata->user_post)}}<br>

                <span class="label label-default">                             
                 {{ucfirst($userdata->userTypes->type_label)}}
               </span>


             </td>
             <td>{{ucfirst($userdata->address)}}</td>

             @if(Auth::user()->id==$userdata->id)
             <td>
              <span class="label label-default">Self</span>
            </td>
            @else
            <td>
              @if($userdata->status=='Active')
              <a href="{{URL::action('BackEndController\UsersController@UserStatus',array($userdata->id))}}">
                <span class="label label-success">Active</span>
              </a>

              @elseif($userdata->status=='Inactive')
              <a href="{{URL::action('BackEndController\UsersController@UserStatus',array($userdata->id))}}"
               class="label label-danger">
               <span class="label label-danger">Inactive</span>
             </a>
             @endif

           </td>

           @endif
<td><?php
        $todayDate= date('Y-m-d',strtotime($userdata->created_at));
        $localDate = str_replace("-", ",", $todayDate);
        $classes=explode(",",$localDate);  
        $a=$classes[0];
        $b=$classes[1];
        $c=$classes[2];
        echo eng_to_nep($a,$b,$c);
        echo  '&nbsp';
        echo date('h:i A',strtotime($userdata->created_at));
?></td>

           <td>


             <a href="{{ URL::to('usersetup/' . $userdata->id . '/edit') }}"  title="Edit User Details"
               data-rel="tooltip">
               <button type="button" class="btn btn-default btn-flat  ">
                <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
              </button>
            </a>
            <a href="{{URL::to('usersetup/' .$userdata->id)}}" title="View User Details"
             data-rel="tooltip">
             <button type="button" class="btn btn-default btn-flat ">
              <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>
            </button>
          </a>


          @if(Auth::user()->id == $userdata->id)

          @else
          <a href="{{URL::to('remove-user',array($userdata->id))}}"
          onclick="return confirm('Are you sure you want to delete this record?')" title="Delete User Details"
               data-rel="tooltip" >
           <button type="button" class="btn btn-danger btn-flat  ">
            <span class="glyphicon glyphicon-trash"
            aria-hidden="true"></span>
          </button>
        </a>
        @endif
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
{{$user->render()}}
@else
<div class="alert alert-danger">
  <strong style="padding-left: 300px"> Sorry ! No record found
  </strong>
</div>
@endif
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
@stop