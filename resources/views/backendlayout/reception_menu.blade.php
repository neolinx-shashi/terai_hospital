@if(Auth::user()->user_type_id=='6')
  <li {{ setActive('appointment') }}>
        <a href="{{URL::to('appointment')}}">
            <i class="fa fa-calendar-check-o"></i> <span>Appointment</span></a>
    </li>

    <li @if(\Request::segment(1)=='appointment' && \Request::segment(2)=='patientlist' ) class="treeview" @endif>
        <a href="{{URL::to('appointment/patientlist',getTodayNepaliDate())}}">
            <i class="fa fa-calendar-check-o"></i> <span>View Appointments</span></a>
    </li>

    <li {{ setActive('news') }}>
        <a href="{{URL::to('news')}}">
            <i class="fa fa-newspaper-o"></i> <span>News & Events</span></a>
    </li>

  <li {{ setActive('contact') }}>
      <a href="{{URL::to('/contact-view')}}">
          <i class="fa fa-phone"></i> <span>Contacts</span></a>
  </li>
        

        <li {{ setActive('usersetup') }}>
        <a href="{{URL::to('/usersetup')}}">
        <i class="fa fa-users"></i>
        <span>User
        @if(Auth::user()->user_type_id=='1' || Auth::user()->user_type_id=='2'|| Auth::user()->user_type_id=='5')
        Configuration
        @else
        Profile
        @endif
        </span>
        </a>
        </li>


@endif