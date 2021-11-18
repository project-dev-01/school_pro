<!-- ========== Left Sidebar Start ========== -->
<div class="left-side-menu">

    <div class="h-100" data-simplebar>

        <!-- User box -->
        <div class="user-box text-center">
            <img src="{{ asset('images/users/default.jpg') }}" alt="user-img" title="Mat Helme" class="rounded-circle avatar-md">
            <div class="dropdown">
                <a href="javascript: void(0);" class="text-dark dropdown-toggle h5 mt-2 mb-1 d-block" data-toggle="dropdown">Geneva Kennedy</a>
                <div class="dropdown-menu user-pro-dropdown">

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-user mr-1"></i>
                        <span>My Account</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-settings mr-1"></i>
                        <span>Settings</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-lock mr-1"></i>
                        <span>Lock Screen</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-log-out mr-1"></i>
                        <span>Logout</span>
                    </a>

                </div>
            </div>
            <p class="text-muted">Admin Head</p>
        </div>

        <!--- Sidemenu -->
        <div id="sidebar-menu">

            <ul id="side-menu">

                <li class="menu-title">Menu Details</li>

                @if(Auth::user()->role_id == '1')
                <li>
                    <a href="{{ route('super_admin.dashboard')}}" class="nav-link {{ (request()->is('super_admin/dashboard*')) ? 'active' : '' }}">
                        <i data-feather="airplay" class="icon-dual"></i>
                        <span> Dashboards </span>
                    </a>
                </li>
                <!-- <li>
                    <a href="{{ route('super_admin.classes')}}" class="nav-link {{ (request()->is('super_admin/classes*')) ? 'active' : '' }}">
                        <i data-feather="clipboard" class="icon-dual"></i>
                        <span> Classes </span>
                    </a>
                </li> -->
                <li>
                    <a href="#sidebarAcademic" data-toggle="collapse">
                        <i data-feather="home"></i>
                        <span> Academic </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarAcademic">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('super_admin.section')}}" class="nav-link {{ (request()->is('super_admin/section*')) ? 'active' : '' }}">
                                    <span> Section </span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('super_admin.classes')}}" class="nav-link {{ (request()->is('super_admin/classes*')) ? 'active' : '' }}">
                                    <span> Classes </span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('super_admin.section_allocation')}}" class="nav-link {{ (request()->is('super_admin/section_allocation*')) ? 'active' : '' }}">
                                    <span> Sections Allocation </span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('super_admin.assign_teacher')}}" class="nav-link {{ (request()->is('super_admin/assign_teacher*')) ? 'active' : '' }}">
                                    <span> Assign Class Teacher </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li>
                    <a href="{{ route('users.user')}}" class="nav-link {{ (request()->is('super_admin/users*')) ? 'active' : '' }}">
                        <i data-feather="user" class="icon-dual"></i>
                        <span> User List </span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('super_admin.settings')}}" class="nav-link {{ (request()->is('super_admin/settings*')) ? 'active' : '' }}">
                        <i data-feather="settings" class="icon-dual"></i>
                        <span> Settings </span>
                    </a>
                </li>
                @endif
                @if(Auth::user()->role_id == '2')
                <li>
                    <a href="{{ route('staff.dashboard')}}" class="nav-link {{ (request()->is('staff/dashboard*')) ? 'active' : '' }}">
                        <i data-feather="airplay" class="icon-dual"></i>
                        <span> Dashboards </span>
                    </a>
                </li>
                @endif
                @if(Auth::user()->role_id == '3')
                <li>
                    <a href="{{ route('teacher.dashboard')}}" class="nav-link {{ (request()->is('teacher/dashboard*')) ? 'active' : '' }}">
                        <i data-feather="airplay" class="icon-dual"></i>
                        <span> Dashboards </span>
                    </a>
                </li>
                @endif
                @if(Auth::user()->role_id == '4')
                <li>
                    <a href="{{ route('parent.dashboard')}}" class="nav-link {{ (request()->is('parent/dashboard*')) ? 'active' : '' }}">
                        <i data-feather="airplay" class="icon-dual"></i>
                        <span> Dashboards </span>
                    </a>
                </li>
                @endif
                @if(Auth::user()->role_id == '5')
                <li>
                    <a href="{{ route('student.dashboard')}}" class="nav-link {{ (request()->is('student/dashboard*')) ? 'active' : '' }}">
                        <i data-feather="airplay" class="icon-dual"></i>
                        <span> Dashboards </span>
                    </a>
                </li>
                @endif
            </ul>

        </div>
        <!-- End Sidebar -->

        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>
<!-- Left Sidebar End -->