@if(Auth::user()->user_type_id=='3')
        <li @if(\Request::segment(1)=='configuration' && \Request::segment(2)=='patient' ) class="treeview" @endif>
        <a href="{{URL::to('/configuration/patient/create')}}">
        <i class="fa fa-hospital-o"></i> <span> Create OPD Patient </span></a>
        </li>

        <li @if(\Request::segment(2)=='print-test-invoice') class="treeview" @endif>
        <a href="{{URL::to('/configuration/print-test-invoice')}}">
        <i class="fa  fa-print"></i> <span>Create Pathology/Test</span></a>
        </li>

        <li @if(\Request::segment(1)=='test-invoice-list') class="treeview" @endif>
        <a href="{{URL::to('/test-invoice-list')}}">
        <i class="fa  fa-print"></i> <span>Pathology/Test Reprint</span></a>
        </li>

        <li {{ setActive('refund-view') }}>
        <a href="{{URL::to('/refund-view')}}">
        <i class="fa  fa-rupee"></i> <span>Refund</span></a>
        </li>


        <li @if(\Request::segment(1)=='ip-enrollment') class="treeview active  menu-open" @endif>
        <a><i class='fa fa-plus-square'></i> <span>IPD Section</span> <i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">
        <li @if(\Request::segment(1)=='ip-enrollment'
        &&\Request::segment(2)=='patients'
        &&\Request::segment(3)=='create') class="treeview" @endif>
        <a href="{{URL::to('/ip-enrollment/patients/create')}}"><i class="fa fa-building"></i>Create IPD Patient</a>
        </li>

        {{--<li {{ setActive('ip-enrollment/discharge-patient') }}>
        <a href="{{URL::to('/ip-enrollment/discharge-patient')}}"><i class="fa fa-times"></i>Discharge Patient</a>
        </li>--}}
        <li @if(\Request::segment(1)=='ip-enrollment'
        &&\Request::segment(2)=='patients') class="treeview" @endif>
            <a href="{{URL::to('/ip-enrollment/patients')}}"><i class="fa fa-wheelchair"></i>IPD Patients</a></li>
        </ul>
        </li>


        <li @if(\Request::segment(1)=='emergency') class="treeview active  menu-open" @endif>
        <a>
        <i class='fa fa-h-square'></i> <span>Emergency Section</span> 
        <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
        <li  @if(\Request::segment(3)=='create')
         class="treeview"
         @endif
         >
        <a href="{{URL::to('/emergency/patient/create')}}">
        <i class="fa fa-stethoscope"></i>Create Patient</a>
        </li>

       <!--  <li {{ setActive('emergency/discharge-patient') }}>
        <a href="{{URL::to('/emergency/discharge-patient')}}">
        <i class="fa fa-times"></i>Discharge Patient</a>
        </li> -->
        <li 
        @if(\Request::segment(3)=='create')

        @else
        {{ setActive('emergency/patient') }}

           @endif>
        <a href="{{URL::to('/emergency/patient')}}">
        <i class="fa fa-th-list"></i>View/Discharge Patient</a></li>
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