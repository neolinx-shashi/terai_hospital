@section('headercontent')
    <header class="main-header">
        <a href="{{url('/dashboard')}}" class="logo">
        <span class="logo-mini"><b>
          Terai Hospital 
      </b></span>
            <div class="logo-pms">
                <img src="{{URL::asset('custom-images/faviconlogo.jpg')}}" height="40"> Terai Hospital
            </div>
        </a>
        <nav class="navbar navbar-static-top" role="navigation">
            
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            @if(Auth::user()->user_type_id=='5' || Auth::user()->user_type_id=='4')
            @else
            <form class="header_search" action="/search" method="POST" role="search" >
                {{ csrf_field() }}
                <div class="input-group">
                    <input type="text" class="form-control" name="q"
                    placeholder="Search  By Patient Name/Phone number/Patient Code"> 
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-default">
                            <span class="glyphicon glyphicon-search"></span>
                        </button>
                    </span>
                </div>
            </form>
            @endif



            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">


                            @if(Auth::user()->userimage_name!="")

                                <img src="{{url('uploads/users')}}/{{Auth::user()->userimage_name}}"
                                     class="user-image" alt="{{ucfirst(Auth::user()->fullname)}}">
                            @else
                                <img src="{{URL::asset('UserDefaultImage/male.jpg')}}" class="user-image"
                                     alt="User Image">

                            @endif
                            <span class="hidden-xs">

                        {{ucfirst(Auth::user()->fullname)}}

                    </span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="user-header">
                                @if(Auth::user()->userimage_name!="")
                                    <img src="{{url('uploads/users')}}/{{Auth::user()->userimage_name}}"
                                         class="img-circle " alt="{{ucfirst(Auth::user()->fullname)}}">
                                @else
                                    <img src="{{URL::asset('UserDefaultImage/male.jpg')}}"
                                         class="img-circle" alt="User Image">

                                @endif
                                <p>
                                    {{ucfirst(Auth::user()->fullname)}} <br>
                                  {{changeCreatedDateToNepali(Auth::user()->created_at)}}

                                </p>
                            </li>


                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="{{URL::to('my-profile/' .Auth::user()->id)}}"
                                       class="btn btn-default btn-flat">Profile</a>
                                </div>
                                <div class="pull-right">


                                    <a href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();" class="btn btn-default btn-flat">
                                        Logout
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                          style="display: none;">
                                        {{ csrf_field() }}
                                    </form>

                                </div>
                            </li>
                        </ul>
                    </li>

                </ul>
            </div>

        </nav>
    </header>
@stop