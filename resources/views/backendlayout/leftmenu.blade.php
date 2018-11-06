@section('leftmenucontent')
    <script src="{{URL::asset('backendtheme/plugins/jQuery/jquery-3.2.1.min.js')}}"></script>
    <aside class="main-sidebar">
        <section class="sidebar">
            <div class="user-panel">
                <div class="pull-left image">
                    @if(Auth::user()->userimage_name!="")
                        <img src="{{url('uploads/users')}}/{{Auth::user()->userimage_name}}" class="img-circle"
                             alt="{{ucfirst(Auth::user()->fullname)}}"
                             style="width: 40px; height: 40px;border: 2px solid #3c8dbc">
                    @else
                        <img src="{{URL::asset('UserDefaultImage/male.jpg')}}"
                             class="img-circle alt="{{ucfirst(Auth::user()->fullname)}}">
                    @endif
                </div>
                <div class="pull-left info">
                    <p>Welcome, <br>{{ucfirst(Auth::user()->email)}}</p>
                </div>
            </div>

            <ul class="sidebar-menu">
                <li {{ setActive('dashboard') }}>
                    <a href="{{URL::to('/dashboard')}}">
                        <i class="fa fa-tachometer"></i> <span>Dashboard</span>
                    </a>
                </li>
                <li><a href="{{ url('/patient-history') }}">Patient History</a></li>


                <!-- This menu id for hospital admin and super admin -->
                @if(Auth::user()->user_type_id=='1' ||
                 Auth::user()->user_type_id=='2')
                    <li @if(\Request::segment(1)=='revenue'
                            ||\Request::segment(1)=='billing-report'
                            ||\Request::segment(1)=='doctor-report'
                            ||\Request::segment(1)=='operate-doctor-report'
                            ||\Request::segment(1)=='pathology-report'
                            ||\Request::segment(1)=='general-report'
                            ||\Request::segment(1)=='operate-general-report'
                            ||\Request::segment(1)=='generate-ipd-report'
                            ||\Request::segment(1)=='ipd-report'
                            ||\Request::segment(1)=='revenue'
                            ||\Request::segment(2)=='total'
                            ||\Request::segment(1)=='operateTotalRevenue'
                            ) class="treeview active  menu-open" @endif>
                        <a>
                            <i class='fa fa-bars'></i> <span>Report Section</span> <i
                                    class="fa fa-angle-left pull-right"></i></a>
                        <ul class="treeview-menu">

                            <li {{ setActive('revenue') }} {{ setActive('operateTotalRevenue') }}>
                                <a href="{{URL::to('/revenue/total')}}">
                                    <i class="fa fa-money"></i> <span>Total Revenue Collected </span></a>
                            </li>

                            {{--<li {{ setActive('revenue/calculation') }}>
                                <a href="{{URL::to('/revenue/calculation')}}">
                                    <i class="fa fa-money"></i> <span>Total Revenue Collected </span></a>
                            </li>--}}

                            <li {{ setActive('pathology-report') }}>
                                <a href="{{URL::to('/pathology-report')}}">
                                    <i class="fa fa-flask"></i> <span>Pathology Report</span></a>
                            </li>

                            {{--<li {{ setActive('billing-report') }}>
                                <a href="{{URL::to('billing-report')}}">
                                    <i class="fa fa-credit-card"></i> <span>Billing Report</span></a>
                            </li>--}}

                            <li {{ setActive('doctor-report') }} {{ setActive('operate-doctor-report') }}>
                                <a href="{{URL::to('/doctor-report')}}">
                                    <i class="fa fa-stethoscope"></i> <span>Doctor Report</span></a>
                            </li>
                            <li {{ setActive('operate-general-report')  }} {{ setActive('general-report')  }}>
                                <a href="{{URL::to('/general-report')}}">
                                    <i class="fa fa-credit-card"></i> <span>Overall Report</span></a>
                            </li>
                            <li {{ setActive('generate-ipd-report')  }} {{ setActive('ipd-report')  }}>
                                <a href="{{URL::to('/ipd-report')}}">
                                    <i class="fa fa-credit-card"></i> <span>IPD Report</span></a>
                            </li>
                            <li {{ setActive('revenue/by-user') }}>
                                <a href="{{URL::to('/revenue/by-user')}}">
                                    <i class="fa fa-user"></i> <span>Revenue By User</span></a>
                            </li>
                        </ul>
                    </li>


                    <li {{ setActive('configuration/patient/create') }}>
                        <a href="{{URL::to('/configuration/patient/create')}}">
                            <i class="fa fa-hospital-o"></i> <span> Create OPD Patient </span></a>
                    </li>

                    <li {{ setActive('configuration/print-test-invoice') }} >
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

                    @if(Auth::user()->user_type_id=='1' || Auth::user()->user_type_id=='2')
                        <li @if(\Request::segment(1)=='ward') class="treeview active  menu-open" @endif>
                            <a><i class='fa fa-university'></i> <span>Ward Setup</span>
                                <i class="fa fa-angle-left pull-right"></i></a>
                            <ul class="treeview-menu">
                                <li {{ setActive('ward/ward-details') }}><a href="{{URL::to('/ward/ward-details')}}"><i
                                                class="fa fa-building"></i>Ward Details</a></li>
                                <li {{ setActive('ward/room') }}><a href="{{URL::to('/ward/room')}}"><i
                                                class="fa fa-university"></i>Room Details</a></li>
                                <li {{ setActive('ward/bed') }}><a href="{{URL::to('/ward/bed')}}"><i
                                                class="fa fa-bed"></i>Bed Details</a></li>
                            </ul>
                        </li>
                    @endif



                    <li @if(\Request::segment(1)=='ip-enrollment') class="treeview active  menu-open" @endif>
                        <a><i class='fa fa-h-square'></i> <span>IPD</span> <i
                                    class="fa fa-angle-left pull-right"></i></a>
                        <ul class="treeview-menu">
                            <li {{ setActive('ip-enrollment/patients') }}><a
                                        href="{{URL::to('/ip-enrollment/patients/create')}}"><i
                                            class="fa fa-building"></i>Admit Patient</a></li>
                            {{--<li {{ setActive('ip-enrollment/discharge-patient') }}><a
                                        href="{{URL::to('/ip-enrollment/discharge-patient')}}"><i
                                            class="fa fa-minus-square"></i>Discharge Patient</a></li>--}}
                            {{--<li><a href="{{URL::to('/ip-enrollment/patient-report')}}"><i class="fa phpdebugbar-fa-newspaper-o"></i>Patient Report</a></li>--}}
                            {{--<li><a href="{{URL::to('/ip-enrollment/patient-history')}}"><i class="fa phpdebugbar-fa-newspaper-o"></i>Patient History</a></li>--}}

                            <li {{ setActive('ip-enrollment/ipatient') }}>
                                <a href="{{URL::to('/ip-enrollment/patients')}}"><i
                                            class="fa fa-bed"></i>IPD Patients</a></li>

                        </ul>
                    </li>

                    <li @if(\Request::segment(1)=='emergency') class="treeview active  menu-open" @endif>
                        <a>
                            <i class='fa fa-h-square'></i> <span>Emergency Section</span>
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li @if(\Request::segment(3)=='create')
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



                    <li @if(\Request::segment(2)=='doctor'
                            ||\Request::segment(2)=='nurse'
                            ||\Request::segment(1)=='fiscal-year'
                            ||\Request::segment(1)=='discount-type'
                            ||\Request::segment(1)=='discount'
                            ||\Request::segment(1)=='emergency-fee'
                            ||\Request::segment(1)=='admission-charge'
                            ||\Request::segment(1)=='contact'
                            ||\Request::segment(2)=='shift-setup'
                            ||\Request::segment(1)=='department'
                            ||\Request::segment(1)=='nationality-setup'
                            ||\Request::segment(1)=='category-tree-view'
                            ||\Request::segment(2)=='assign'
                            ||\Request::segment(1)=='doctor-charge'
                            ) class="treeview active  menu-open" @endif>
                        <a><i class='fa fa-cog'></i> <span>System Setup</span> <i
                                    class="fa fa-angle-left pull-right"></i></a>
                        <ul class="treeview-menu">
                            <li {{ setActive('configuration/doctor') }}>
                                <a href="{{URL::to('/configuration/doctor')}}">
                                    <i class="fa fa-user-md"></i> <span>Doctor Setup</span></a>
                            </li>

                            <li {{ setActive('configuration/nurse') }}>
                                <a href="{{URL::to('/configuration/nurse')}}">
                                    <i class="fa fa-female"></i> <span>Nurse Setup</span></a>
                            </li>

                            <li {{ setActive('configuration/shift-setup') }}>
                                <a href="{{URL::to('/configuration/shift-setup')}}">
                                    <i class="fa fa-clock-o"></i> <span>Shift Setup</span>
                                </a>
                            </li>

                            <li {{ setActive('department') }}>
                                <a href="{{ route('department.index') }}">
                                    <i class="fa fa-building-o"></i> <span>Department Setup</span></a>
                            </li>

                            <li {{ setActive('nationality-setup') }}>
                                <a href="{{URL::to('/nationality-setup')}}">
                                    <i class="fa fa-flag-o"></i> <span>Nationalities Setup</span></a>
                            </li>


                            <li {{ setActive('category-tree-view') }}>
                                <a href="{{URL::to('/category-tree-view')}}">
                                    <i class="fa fa-flask"></i> <span>Test Setup</span></a>
                            </li>

                            <li {{ setActive('fiscal-year') }}>
                                <a href="{{URL::to('/fiscal-year')}}">
                                    <i class="fa fa-calendar"></i> <span>Fiscal Year Setup</span></a>
                            </li>

                            <li {{ setActive('emergency-fee') }}>
                                <a href="{{URL::to('/emergency-fee')}}">
                                    <i class="fa fa-ambulance"></i> <span>Emergency Charge Setup</span></a>
                            </li>

                            <li {{ setActive('admission-charge') }}>
                                <a href="{{URL::to('/admission-charge')}}">
                                    <i class="fa fa-dollar"></i> <span>Admission Charge Setup</span></a>
                            </li>

                            <li {{ setActive('contact') }}>
                                <a href="{{URL::to('/contact')}}">
                                    <i class="fa fa-phone"></i> <span>Contact Setup</span></a>
                            </li>

                            <li {{ setActive('discount') }}>
                                <a href="{{URL::to('/discount')}}">
                                    <i class="fa fa-dollar"></i> <span>Discount Setup</span></a>
                            </li>

                            <li {{ setActive('discount-type') }}>
                                <a href="{{URL::to('/discount-type')}}">
                                    <i class="fa fa-dollar"></i> <span>Discount Type Setup</span></a>
                            </li>

                            <li {{ setActive('doctor-charge') }}>
                                <a href="{{URL::to('/doctor-charge')}}">
                                    <i class="fa fa-dollar"></i> <span>Doctor Charge Setup</span></a>
                            </li>
                        </ul>
                    </li>
                <!--
                    <li {{ setActive('master-data/backup') }}>
                        <a href="{{URL::to('/master-data/backup')}}">
                            <i class="fa fa-database"></i> <span>Data BackUp</span></a>
                    </li> -->

                    @if(Auth::user()->user_type_id=='1')
                        <li><a href="http://localhost/dbbackup/index.php" target="_blank"><i class="fa fa-database"></i>
                                <span>Data BackUp</span></a></li>
                    @endif

                @endif
            <!-- This menu id for hospital admin and super admin it ends hhere  -->


                <!-- This menu is for system setup admin to setup only  -->

                @if(Auth::user()->user_type_id=='5')

                    <li {{ setActive('news') }}>
                        <a href="{{URL::to('news')}}">
                            <i class="fa fa-newspaper-o"></i> <span>News & Events</span></a>
                    </li>

                    <li @if(\Request::segment(1)=='ward') class="treeview active  menu-open" @endif>
                        <a><i class='fa fa-university'></i> <span>Ward Setup</span>
                            <i class="fa fa-angle-left pull-right"></i></a>
                        <ul class="treeview-menu">
                            <li {{ setActive('ward/ward-details') }}><a href="{{URL::to('/ward/ward-details')}}"><i
                                            class="fa fa-building"></i>Ward Details</a></li>
                            <li {{ setActive('ward/room') }}><a href="{{URL::to('/ward/room')}}"><i
                                            class="fa fa-university"></i>Room Details</a></li>
                            <li {{ setActive('ward/bed') }}><a href="{{URL::to('/ward/bed')}}"><i class="fa fa-bed"></i>Bed
                                    Details</a></li>
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


                    <li @if(\Request::segment(2)=='doctor'
                            ||\Request::segment(1)=='fiscal-year'
                            ||\Request::segment(2)=='shift-setup'
                            ||\Request::segment(1)=='department'
                            ||\Request::segment(1)=='contact'
                            ||\Request::segment(1)=='nationality-setup'
                            ||\Request::segment(1)=='category-tree-view'
                            ||\Request::segment(2)=='assign'
                            ||\Request::segment(1)=='emergency-fee'
                            ||\Request::segment(1)=='admission-charge'
                            ||\Request::segment(2)=='nurse'
                            ||\Request::segment(1)=='discount-type'
                            ||\Request::segment(1)=='discount'
                            ||\Request::segment(1)=='doctor-charge'
                            ) class="treeview active  menu-open" @endif>
                        <a><i class='fa fa-cog'></i> <span>System Setup</span> <i
                                    class="fa fa-angle-left pull-right"></i></a>
                        <ul class="treeview-menu">
                            <li {{ setActive('configuration/doctor') }}>
                                <a href="{{URL::to('/configuration/doctor')}}">
                                    <i class="fa fa-user-md"></i> <span>Doctor Setup</span></a>
                            </li>
                            <li {{ setActive('configuration/nurse') }}>
                                <a href="{{URL::to('/configuration/nurse')}}">
                                    <i class="fa fa-female"></i> <span>Nurse Setup</span></a>
                            </li>

                            <li {{ setActive('configuration/shift-setup') }}>
                                <a href="{{URL::to('/configuration/shift-setup')}}">
                                    <i class="fa fa-clock-o"></i> <span>Shift Setup</span>
                                </a>
                            </li>

                            <li {{ setActive('department') }}>
                                <a href="{{ route('department.index') }}">
                                    <i class="fa fa-building-o"></i> <span>Department Setup</span></a>
                            </li>

                            <li {{ setActive('nationality-setup') }}>
                                <a href="{{URL::to('/nationality-setup')}}">
                                    <i class="fa fa-flag-o"></i> <span>Nationalities Setup</span></a>
                            </li>


                            <li {{ setActive('category-tree-view') }}>
                                <a href="{{URL::to('/category-tree-view')}}">
                                    <i class="fa fa-flask"></i> <span>Test Setup</span></a>
                            </li>

                            <li {{ setActive('fiscal-year') }}>
                                <a href="{{URL::to('/fiscal-year')}}">
                                    <i class="fa fa-calendar"></i> <span>Fiscal Year Setup</span></a>
                            </li>
                            <li {{ setActive('emergency-fee') }}>
                                <a href="{{URL::to('/emergency-fee')}}">
                                    <i class="fa fa-ambulance"></i> <span>Emergency Charge Setup</span></a>
                            </li>

                            <li {{ setActive('admission-charge') }}>
                                <a href="{{URL::to('/admission-charge')}}">
                                    <i class="fa fa-dollar"></i> <span>Admission Charge Setup</span></a>
                            </li>

                            <li {{ setActive('contact') }}>
                                <a href="{{URL::to('/contact')}}">
                                    <i class="fa fa-phone"></i> <span>Contact Setup</span></a>
                            </li>

                            <li {{ setActive('discount') }}>
                                <a href="{{URL::to('/discount')}}">
                                    <i class="fa fa-dollar"></i> <span>Discount Setup</span></a>
                            </li>

                            <li {{ setActive('discount-type') }}>
                                <a href="{{URL::to('/discount-type')}}">
                                    <i class="fa fa-dollar"></i> <span>Discount Type Setup</span></a>
                            </li>

                            <li {{ setActive('doctor-charge') }}>
                                <a href="{{URL::to('/doctor-charge')}}">
                                    <i class="fa fa-dollar"></i> <span>Doctor Charge Setup</span></a>
                            </li>
                        </ul>
                    </li>

                    <li><a href="http://localhost/dbbackup/index.php" target="_blank"><i class="fa fa-database"></i>
                            <span>Data BackUp</span></a></li>

                    <li {{ setActive('my-profile') }}>
                        <a href="{{URL::to('/my-profile',Auth::user()->id)}}">
                            <i class="fa fa-users" aria-hidden="true"></i> <span>Users Profile</span></a>
                    </li>




                @endif
            <!-- This menu id for system admin ends here-->


                <!-- This menu id for account and billing and reception -->
                @include('backendlayout.billing_menu')
            <!-- This menu id for account and billing and reception ends here -->

                <!-- This menu id for nurse -->
                @include('backendlayout.nurse_menu')
            <!-- This menu id for nurse ends here -->

                @include('backendlayout.reception_menu')
            <!-- This menu id for account  and reception -->

                @if(Auth::user()->user_type_id=='4')

                    <li @if(\Request::segment(1)=='revenue'
                            ||\Request::segment(1)=='billing-report'
                            ||\Request::segment(1)=='general-report'
                            ||\Request::segment(1)=='operate-general-report'
                            ||\Request::segment(1)=='pathology-report'
                            ||\Request::segment(1)=='doctor-report'
                            ||\Request::segment(1)=='operate-doctor-report'
                            ||\Request::segment(1)=='revenue'
                            ||\Request::segment(1)=='operateTotalRevenue'
                            ) class="treeview active  menu-open" @endif>

                        <a>
                            <i class='fa fa-bars'></i> <span>Report Section</span> <i
                                    class="fa fa-angle-left pull-right"></i></a>
                        <ul class="treeview-menu">

                            <li {{ setActive('revenue') }} {{ setActive('operateTotalRevenue') }}>
                                <a href="{{URL::to('/revenue/total')}}">
                                    <i class="fa fa-money"></i> <span>Total Revenue Collected</span></a>
                            </li>

                            <li {{ setActive('pathology-report') }}>
                                <a href="{{URL::to('/pathology-report')}}">
                                    <i class="fa fa-flask"></i> <span>Pathology Report</span></a>
                            </li>


                            {{--<li {{ setActive('revenue/calculation') }}>
                                <a href="{{URL::to('/revenue/calculation')}}">
                                    <i class="fa fa-money"></i> <span>Total Revenue Collected </span></a>
                            </li>

                            <li {{ setActive('billing-report') }}>
                                <a href="{{URL::to('billing-report')}}">
                                    <i class="fa fa-credit-card"></i> <span>Billing Report</span></a>
                            </li>--}}

                            <li {{ setActive('doctor-report') }} {{ setActive('operate-doctor-report') }}>
                                <a href="{{URL::to('/doctor-report')}}">
                                    <i class="fa fa-stethoscope"></i> <span>Doctor Report</span></a>
                            </li>
                            <li {{ setActive('operate-general-report')  }} {{ setActive('general-report')  }}>
                                <a href="{{URL::to('/general-report')}}">
                                    <i class="fa fa-credit-card"></i> <span>Overall Report</span></a>
                            </li>
                            <li {{ setActive('generate-ipd-report')  }} {{ setActive('ipd-report')  }}>
                                <a href="{{URL::to('/ipd-report')}}">
                                    <i class="fa fa-credit-card"></i> <span>IPD Report</span></a>
                            </li>
                            <li>
                                <a href="{{ URL::to('/ipd-deposit-report') }}"><i class="fa fa-credit-card"></i> <span>IPD Patient Deposit Report</span></a></a>
                            </li>
                            <li {{ setActive('revenue/by-user') }}>
                                <a href="{{URL::to('/revenue/by-user')}}">
                                    <i class="fa fa-users"></i> <span>Revenue By Users</span></a>
                            </li>
                            <li>
                                <a href="{{ URL::to('/deposit-report-date') }}"><i class="fa fa-credit-card"></i> <span>IPD Deposit Report</span></a></a>
                            </li>
                            <li>
                                <a href="{{ URL::to('/discharge-report-date') }}"><i class="fa fa-credit-card"></i> <span>IPD Discharge Report</span></a></a>
                            </li>
                        </ul>
                    </li>

                    <li {{ setActive('refund-view') }}>
                        <a href="{{URL::to('/refund-view')}}">
                            <i class="fa  fa-rupee"></i> <span>Refund</span></a>
                    </li>

                    <li {{ setActive('contact-view') }}>
                        <a href="{{URL::to('/contact-view')}}">
                            <i class="fa fa-phone"></i> <span>Contacts</span></a>
                    </li>

                    <li {{ setActive('my-profile') }}>
                        <a href="{{URL::to('/my-profile',Auth::user()->id)}}">
                            <i class="fa fa-users"></i>
                            <span>Users
                                @if(Auth::user()->user_type_id=='1' || Auth::user()->user_type_id=='2'|| Auth::user()->user_type_id=='5')
                                    Configuration
                                @else
                                    Profile
                                @endif
                                </span>
                        </a>
                    </li>


            @endif
            <!-- This menu id for account and billing and reception ends here -->


                <li class="leftmenu-logout">

                    <a href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();" class="btn btn-default btn-flat">
                        <i class="fa fa-sign-out"></i> Logout
                    </a>

                    {{--<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>--}}

                </li>
            </ul>
        </section>
    </aside>
    <style type="text/css">
        li.treeview {
            background-color: #ececec;
        }
    </style>

    <script type="text/javascript">
        $(document).ready(function () {
            $(".sidebar-menu  ul li a").on("click", function () {
                $(".sidebar-menu  ul li").find(".treeview active  menu-open").removeClass("treeview menu-open");
                $(this).parent().addClass("treeview active  menu-open");
            });
        });


        $(document).ready(function () {
            $(".nav a").on("click", function () {
                $(".nav").find(".treeview").removeClass("treeview");
                $(this).parent().addClass("treeview");
            });
        });

    </script>
@stop