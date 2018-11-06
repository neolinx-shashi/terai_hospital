@if(Auth::user()->user_type_id=='7')

    <li @if(\Request::segment(1)=='ip-enrollment') class="treeview active  menu-open" @endif>
        <a><i class='fa fa-plus-square'></i> <span>IPD Section</span> <i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">
            <li @if(\Request::segment(1)=='ip-enrollment'
        &&\Request::segment(2)=='patients'
        &&\Request::segment(3)=='create') class="treeview" @endif>
                {{--<a href="{{URL::to('/ip-enrollment/patients/create')}}"><i class="fa fa-building"></i>Create IPD Patient</a>--}}
            </li>

            {{--<li {{ setActive('ip-enrollment/discharge-patient') }}>
            <a href="{{URL::to('/ip-enrollment/discharge-patient')}}"><i class="fa fa-times"></i>Discharge Patient</a>
            </li>--}}
            <li @if(\Request::segment(1)=='ip-enrollment'
        &&\Request::segment(2)=='patients') class="treeview" @endif>
                <a href="{{URL::to('/ip-enrollment/patients')}}"><i class="fa fa-wheelchair"></i>IPD Patients</a></li>
        </ul>
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