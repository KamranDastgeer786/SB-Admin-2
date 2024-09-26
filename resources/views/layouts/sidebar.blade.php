<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion " id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center {{ request()->is('*/dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">SB Admin
            <sup>2</sup>
        </div>
    </a>

    @php
       // Get the current role name from session or authenticated user's role
       $roleName = currentRole();
    
      // Retrieve the role model based on the role name
      $role = \Spatie\Permission\Models\Role::where('name', $roleName)->first();
    @endphp
   
    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link {{ request()->is('*/dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Interface
    </div>

    <!-- Nav Item - Pages Collapse Menu -->

    {{-- users --}}
    @if (auth()->user()->hasRole(currentRole()) &&   $role->hasAnyPermission(['show_users', 'create_users', 'edit_users', 'delete_users', 'create_roles', 'show_roles',
        'edit_roles', 'delete_roles', 'create_permissions', 'show_permissions', 'edit_permissions','delete_permissions'
        ]))
        @php
            $isActive = request()->is('*/users/*') || request()->is('*/users') || request()->is('*/roles/*') || request()->is('*/roles') || request()->is('*/permissions/*');
        @endphp

        <li class="nav-item {{ $isActive ? 'active' : '' }} ">
            <a class="nav-link collapsed active  {{ request()->is('*/users/*') ? 'active' : '' }}" href="#user" data-toggle="collapse"  data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
               {{-- <i class="fas fa-fw fa-cog"></i> --}}
               <i class="fas fa-fw fa-users"></i>
               <span>User</span>
            </a>
            <div id="collapseTwo" class="collapse {{ $isActive ? 'show' : '' }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded  {{ request()->is('*/users/*') || request()->is('*/users') || request()->is('*/roles/*') || request()->is('*/roles') || request()->is('*/permissions/*') ? 'show' : '' }}" id="users">
                    <h6 class="collapse-header">Custom Components:</h6>
                
                    @if (auth()->user()->hasRole(currentRole()) && $role->hasAnyPermission(['show_users', 'create_users', 'edit_users', 'delete_users']))
                        <a class="collapse-item {{ request()->is('*/users') || request()->is('*/users/*') ? 'active' : '' }}" href="{{ route('users.index') }}">
                            🙋🏻‍♂️  User
                        </a>
                    @endif


                    @if (auth()->user()->hasRole(currentRole()) && $role->hasAnyPermission(['create_roles', 'show_roles', 'edit_roles', 'delete_roles']))
                        <a class="collapse-item  {{ Request::is('*/roles') || request()->is('*/roles/*') ? 'active' : '' }}" href="{{ route('roles.index') }}">
                            📝 Role
                        </a>
                    @endif

                    @if (auth()->user()->hasRole(currentRole()) && $role->hasAnyPermission(['create_permissions', 'show_permissions', 'edit_permissions','delete_permissions']))
                        <a class="collapse-item  {{ Request::is('*/Permissions') || request()->is('*/Permissions/*') ? 'active' : '' }}" href="{{ route('permissions.index') }}">
                            ✅ Permissions
                        </a>
                    @endif

                </div>
            </div>
        </li>
    
    @endif
    {{-- End users --}}

    <!-- Nav Item - Utilities Collapse Menu -->
    @if (auth()->user()->hasRole(currentRole()) && $role->hasAnyPermission(['create_drivers', 'edit_drivers', 'delete_drivers', 'show_drivers']))
        @php
            $isActive = request()->is('*/drivers/*') || request()->is('*/drivers');
        @endphp
        <li class="nav-item {{ $isActive ? 'active' : '' }} ">
            <a class="nav-link collapsed {{ $isActive ? 'active' : '' }}" href="driversSidebar" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
               {{-- <i class="fas fa-fw fa-wrench"></i> --}}
               <i class="fas fa-fw fa-car"></i>
               
               <span>Driver Information</span>
            </a>
        
            <div id="collapseUtilities" class="collapse {{ $isActive ? 'show' : '' }}" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Driver File:📁</h6>
                    <a class="collapse-item {{ request()->is('*/drivers/*') ? 'active' : '' }}" href="{{ route('drivers.create') }}">👮🏻‍♂️ Add New Driver</a>
                    <a class="collapse-item {{ request()->is('*/drivers/*') ? 'active' : '' }}" href="{{ route('drivers.index') }}"> 📝 Driver</a>
                </div>
            </div>
        </li>
    @endif

    <!-- Nav Item - Media Uoload Menu -->
    @if (auth()->user()->hasRole(currentRole()) && $role->hasAnyPermission(['create_media', 'edit_media', 'delete_media', 'show_media']))
        @php
            $isActive = request()->is('*/media_uploads/*') || request()->is('*/media_uploads');
        @endphp
        <li class="nav-item {{ $isActive ? 'active' : '' }}">
            <a class="nav-link collapsed {{ $isActive ? 'active' : '' }}" href="media" data-toggle="collapse" data-target="#collapseMedia" aria-expanded="true" aria-controls="collapseMedia">
                {{-- <i class="fas fa-fw fa-wrench"></i> --}}
                <i class="fas fa-fw fa-image"></i>
                <span>Media File</span>
            </a>
        
            <div id="collapseMedia" class="collapse {{ $isActive ? 'show' : '' }}" aria-labelledby="headingMedia" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Media File:</h6>
                    {{-- <a class="collapse-item  {{ request()->is('*/media_uploads') || request()->is('*/media_uploads/*') ? 'active' : '' }}" href="{{ route('media_uploads.create') }}">📷 New Upload Media</a> --}}
                    <a class="collapse-item  {{ request()->is('*/media_uploads') || request()->is('*/media_uploads/*') ? 'active' : '' }}" href="{{ route('media_uploads.index') }}"> 📁 Upload Media File</a>
                </div>
            </div>
        </li>
    @endif

    <!-- Nav Item - Incident Report Submission Menu -->
    @if (auth()->user()->hasRole(currentRole()) && $role->hasAnyPermission(['create_incidentReports', 'edit_incidentReports', 'delete_incidentReports', 'show_incidentReports']))
        @php
            $isActive = request()->is('*/incident_reports/*') || request()->is('*/incident_reports');
        @endphp
        <li class="nav-item {{ $isActive ? 'active' : '' }}">
            <a class="nav-link collapsed {{ $isActive ? 'active' : '' }}" href="#/incidentReports" data-toggle="collapse" data-target="#collapseReport" aria-expanded="true" aria-controls="collapseReport">
                {{-- <i class="fas fa-fw fa-wrench"></i> --}}
                <i class="fas fa-fw fa-flag"></i>
                <span>Incident Report</span>
            </a>
        
            <div id="collapseReport" class="collapse {{ $isActive ? 'show' : '' }}" aria-labelledby="headingReport" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Incident Report:</h6>
                    {{-- <a class="collapse-item {{ request()->is('*/incident_reports/*') ? 'active' : '' }}" href="{{ route('incident_reports.create') }}"> 📝 Add New Report</a> --}}
                    <a class="collapse-item {{ request()->is('*/incident_reports') || request()->is('*/incident_reports/*') ? 'active' : '' }}" href="{{ route('incident_reports.index') }}">  👨‍⚖️ Report Submissstion</a>
                </div>
            </div>
        </li>
    @endif

    <!-- Nav Item - Incident Report Submission Menu -->
    @if (auth()->user()->hasRole(currentRole()) && $role->hasAnyPermission(['show_ppeEquipments', 'create_ppeEquipments', 'edit_ppeEquipments', 'delete_ppeEquipments', 'show_assignmentRecords','create_assignmentRecords', 'edit_assignmentRecords', 'delete_assignmentRecords', 'show_onboardingRecords', 'create_onboardingRecords', 'edit_onboardingRecords', 'delete_onboardingRecords']))
        @php
            $isActive = request()->is('*/ppe/*') || request()->is('*/ppe') || request()->is('*/assignment-records/*') || request()->is('*/assignment-records') || request()->is('*/onboarding-records/*') || request()->is('*/onboarding-records');
        @endphp
        <li class="nav-item {{ $isActive ? 'active' : '' }}">
            <a class="nav-link collapsed {{ $isActive ? 'active' : '' }}" href="#PPE & Onboarding" data-toggle="collapse" data-target="#collapseOnboarding" aria-expanded="true" aria-controls="collapseOnboarding">
                {{-- <i class="fas fa-fw fa-wrench"></i> --}}
                <i class="fas fa-fw fa-briefcase"></i>
                <span>PPE & Onboarding</span>
            </a>
        
            <div id="collapseOnboarding" class="collapse {{ $isActive ? 'show' : '' }}" aria-labelledby="headingOnboarding" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Incident Report:</h6>
                    @if (auth()->user()->hasRole(currentRole()) && $role->hasAnyPermission(['show_ppeEquipments', 'create_ppeEquipments', 'edit_ppeEquipments', 'delete_ppeEquipments']))
                        {{-- <a class="collapse-item {{ request()->is('*/ppeEquipments/*') ? 'active' : '' }}" href="{{ route('ppe.create') }}"> 👷‍♂️ Add PpeEquipment</a> --}}
                        <a class="collapse-item {{ request()->is('*/ppe') || request()->is('*/ppe/*') ? 'active' : '' }}" href="{{ route('ppe.index') }}">  ⛑ PpeEquipment</a>
                    @endif
                    
                    @if (auth()->user()->hasRole(currentRole()) && $role->hasAnyPermission(['show_assignmentRecords', 'create_assignmentRecords', 'edit_assignmentRecords', 'delete_assignmentRecords']))
                        {{-- <a class="collapse-item {{ request()->is('*/assignmentRecords/*') ? 'active' : '' }}" href="{{ route('assignment-records.create') }}">✍ Add assignment</a> --}}
                        <a class="collapse-item  {{ request()->is('*/assignment-records') || request()->is('*/assignment-records/*') ? 'active' : '' }}" href="{{ route('assignment-records.index') }}">📒 Assignment-records</a>
                    @endif 
                    @if (auth()->user()->hasRole(currentRole()) && $role->hasAnyPermission(['show_onboardingRecords', 'create_onboardingRecords', 'edit_onboardingRecords', 'delete_onboardingRecords']))
                       {{-- <a class="collapse-item {{ request()->is('*/onboardingRecords/*') ? 'active' : '' }}" href="{{ route('onboarding-records.create') }}"> 🚀 Add onboarding</a> --}}
                       <a class="collapse-item {{ request()->is('*/onboarding-records') || request()->is('*/onboarding-records/*') ? 'active' : '' }}" href="{{ route('onboarding-records.index') }}">  🛤 Onboarding-records</a>
                    @endif 
                </div>
            </div>
        </li>
    @endif



    <!-- Nav Item - Driver Management Menu -->
    @if (auth()->user()->hasRole(currentRole()) && $role->hasAnyPermission(['show_driver_profiles', 'create_driver_profiles', 'edit_driver_profiles', 'delete_driver_profiles', 'show_assignments', 'create_assignments', 'edit_assignments', 'delete_assignments' , 'show_performance_records', 'create_performance_records', 'edit_performance_records', 'delete_performance_records' ]))
        @php
            $isActive = request()->is('*/driverprofiles/*') || request()->is('*/driverprofiles') || request()->is('*/assignments/*') || request()->is('*/assignments') || request()->is('*/performance-records/*') || request()->is('*/performance-records');
        @endphp
        <li class="nav-item {{ $isActive ? 'active' : '' }}">
            <a class="nav-link collapsed {{ $isActive ? 'active' : '' }}" href="#driver_profiles" data-toggle="collapse" data-target="#collapseDriverProfiles" aria-expanded="true" aria-controls="collapseDriverProfiles">
                {{-- <i class="fas fa-fw fa-wrench"></i> --}}
                <i class="fas fa-fw fa-user-tie"></i>
                <span>Driver Profiles</span>
            </a>
        
            <div id="collapseDriverProfiles" class="collapse {{ $isActive ? 'show' : '' }}" aria-labelledby="headingDriverProfiles" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Driver Profiles:</h6>
                    @if (auth()->user()->hasRole(currentRole()) && $role->hasAnyPermission(['show_driver_profiles', 'create_driver_profiles', 'edit_driver_profiles', 'delete_driver_profiles']))
                        {{-- <a class="collapse-item {{ request()->is('*/driver_profiles/*') ? 'active' : '' }}" href="{{ route('driverprofiles.create') }}"> Add Driver Profiles</a> --}}
                        <a class="collapse-item {{ request()->is('*/driverprofiles') || request()->is('*/driverprofiles/*') ? 'active' : '' }}" href="{{ route('driverprofiles.index') }}"> 👮 Driver Profiles</a>
                    @endif

                    @if (auth()->user()->hasRole(currentRole()) && $role->hasAnyPermission(['show_assignments', 'create_assignments', 'edit_assignments', 'delete_assignments']))
                        {{-- <a class="collapse-item {{ request()->is('*/assignments/*') ? 'active' : '' }}" href="{{ route('assignments.create') }}">Add New assignments</a> --}}
                        <a class="collapse-item {{ request()->is('*/assignments') || request()->is('*/assignments/*') ? 'active' : '' }}" href="{{ route('assignments.index') }}"> 🚕 Driver assignments</a>
                    @endif

                    @if (auth()->user()->hasRole(currentRole()) && $role->hasAnyPermission(['show_performance_records', 'create_performance_records', 'edit_performance_records', 'delete_performance_records']))
                        {{-- <a class="collapse-item {{ request()->is('*/performance_records/*') ? 'active' : '' }}" href="{{ route('performance-records.create') }}">Add Performance Records</a> --}}
                        <a class="collapse-item {{ request()->is('*/performance-records') || request()->is('*/performance-records/*') ? 'active' : '' }} " href="{{ route('performance-records.index') }}"> 📖 Performance Records</a>
                    @endif
                    
                </div>
            </div>
        </li>
    @endif


    <!-- Nav Item - Incident Reporting & Management Menu -->
    @if (auth()->user()->hasRole(currentRole()) && $role->hasAnyPermission(['show_incident_views', 'create_incident_views', 'edit_incident_views', 'delete_incident_views','show_follow_up_actions','create_follow_up_actions','edit_follow_up_actions','delete_follow_up_actions','show_closure_details','create_closure_details','edit_closure_details','delete_closure_details']))
        @php
            $isActive = request()->is('*/incidentViews/*') || request()->is('*/incidentViews') || request()->is('*/followUpActions/*') || request()->is('*/followUpActions') || request()->is('*/closureDetails/*') || request()->is('*/closureDetails');
        @endphp
        <li class="nav-item {{ $isActive ? 'active' : '' }}">
            <a class="nav-link collapsed {{ $isActive ? 'active' : '' }}" href="#. Incident Reporting & Management" data-toggle="collapse" data-target="#collapseManagement" aria-expanded="true" aria-controls="collapseManagement">
                {{-- <i class="fas fa-fw fa-wrench"></i> --}}
                <i class="fas fa-fw fa-chart-line"></i>
                <span>Management Reporting </span>
            </a>
        
            <div id="collapseManagement" class="collapse {{ $isActive ? 'show' : '' }}" aria-labelledby="headingManagement" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Reporting Management:</h6>
                    @if (auth()->user()->hasRole(currentRole()) && $role->hasAnyPermission(['show_incident_views', 'create_incident_views', 'edit_incident_views', 'delete_incident_views']))
                        {{-- <a class="collapse-item {{ request()->is('*/incident_views/*') ? 'active' : '' }} " href="{{ route('incidentViews.create') }}">Add New Incident Report</a> --}}
                        <a class="collapse-item {{ request()->is('*/incidentViews') || request()->is('*/incidentViews/*') ? 'active' : '' }} " href="{{ route('incidentViews.index') }}"> 👩🏾‍🤝‍👩🏼 Incident Management</a>
                    @endif

                    @if (auth()->user()->hasRole(currentRole()) && $role->hasAnyPermission(['show_follow_up_actions', 'create_follow_up_actions', 'edit_follow_up_actions', 'delete_follow_up_actions']))
                        {{-- <a class="collapse-item {{ request()->is('*/followUpActions/*') ? 'active' : '' }}" href="{{ route('followUpActions.create') }}">Add Follow up</a> --}}
                        <a class="collapse-item {{ request()->is('*/followUpActions') || request()->is('*/followUpActions/*') ? 'active' : '' }}" href="{{ route('followUpActions.index') }}"> 📊 Follow-up Actions</a>
                    @endif

                    @if (auth()->user()->hasRole(currentRole()) && $role->hasAnyPermission(['show_closure_details', 'create_closure_details', 'edit_closure_details', 'delete_closure_details']))
                        {{-- <a class="collapse-item {{ request()->is('*/closure_details/*') ? 'active' : '' }}" href="{{ route('closureDetails.create') }}">Add Closure Details</a> --}}
                        <a class="collapse-item {{ request()->is('*/closureDetails') || request()->is('*/closureDetails/*') ? 'active' : '' }}" href="{{ route('closureDetails.index') }}"> 📝 Closure Details</a>
                    @endif
                    
                </div>
            </div>
        </li>
    @endif


    <!-- Nav Item - Incident Reporting & Management Menu -->
    @if (auth()->user()->hasRole(currentRole()) && $role->hasAnyPermission(['show_inventories', 'create_inventories', 'edit_inventories', 'delete_inventories', 'show_user_assignments', 'create_user_assignments', 'edit_user_assignments','delete_user_assignments','show_compliances','create_compliances','edit_compliances','delete_compliances']))
        @php
            $isActive = request()->is('*/inventories/*') || request()->is('*/inventories') || request()->is('*/user_assignments/*') || request()->is('*/user_assignments') || request()->is('*/compliances/*') || request()->is('*/compliances');
        @endphp
        <li class="nav-item {{ $isActive ? 'active' : '' }}">
            <a class="nav-link collapsed {{ $isActive ? 'active' : '' }}" href="#Management & Onboarding" data-toggle="collapse" data-target="#collapseinventories" aria-expanded="true" aria-controls="collapseinventories">
                {{-- <i class="fas fa-fw fa-wrench"></i> --}}
                <i class="fas fa-fw fa-briefcase"></i>
                <span>Management boarding </span>
            </a>
        
            <div id="collapseinventories" class="collapse {{ $isActive ? 'show' : '' }}" aria-labelledby="headinginventories" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Equipment Management:</h6>
                    @if (auth()->user()->hasRole(currentRole()) && $role->hasAnyPermission(['show_inventories', 'create_inventories', 'edit_inventories', 'delete_inventories']))
                        {{-- <a class="collapse-item {{ request()->is('*/inventories/*') ? 'active' : '' }} " href="{{ route('inventories.create') }}">Add New inventories</a> --}}
                        <a class="collapse-item {{ request()->is('*/inventories') || request()->is('*/inventories/*') ? 'active' : '' }} " href="{{ route('inventories.index') }}"> 📇 inventories</a>
                    @endif

                    @if (auth()->user()->hasRole(currentRole()) && $role->hasAnyPermission(['show_user_assignments', 'create_user_assignments', 'edit_user_assignments', 'delete_user_assignments']))
                        {{-- <a class="collapse-item {{ request()->is('*/userAssignments/*') ? 'active' : '' }}" href="{{ route('user_assignments.create') }}">Add userAssignments</a> --}}
                        <a class="collapse-item {{ request()->is('*/user_assignments') || request()->is('*/user_assignments/*') ? 'active' : '' }}" href="{{ route('user_assignments.index') }}"> 📑 userAssignments</a>
                    @endif

                    @if (auth()->user()->hasRole(currentRole()) && $role->hasAnyPermission(['show_compliances', 'create_compliances', 'edit_compliances', 'delete_compliances']))
                        {{-- <a class="collapse-item {{ request()->is('*/compliances/*') ? 'active' : '' }}" href="{{ route('compliances.create') }}">Add compliances</a> --}}
                        <a class="collapse-item {{ request()->is('*/compliances') || request()->is('*/compliances/*') ? 'active' : '' }}" href="{{ route('compliances.index') }}"> 🛃 compliances</a>
                    @endif
                    
                </div>
            </div>
        </li>
    @endif
    <!-- Divider -->
    
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Addons
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
            <i class="fas fa-fw fa-folder"></i>
            <span>Audit & LOgs</span>
        </a>
        <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                {{-- <h6 class="collapse-header">Login Screens:</h6> --}}
                <a class="collapse-item" href="{{ route('audits.index') }}">Audits</a>
                <a class="collapse-item" href="{{ route('logs.index') }}">Logs</a>
                {{-- <a class="collapse-item" href="forgot-password.html">Forgot Password</a> --}}
                <div class="collapse-divider"></div>
                <h6 class="collapse-header">Other Pages:</h6>
                <a class="collapse-item" href="404.html">404Page</a>
                <a class="collapse-item" href="blank.html">BlankPage</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Charts -->
    <li class="nav-item">
        <a class="nav-link" href="charts.html">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Charts</span>
        </a>
    </li>

    <!-- Nav Item - Tables -->
    <li class="nav-item">
        <a class="nav-link" href="tables.html">
            <i class="fas fa-fw fa-table"></i>
            <span>Tables</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

    <!-- Sidebar Message -->
    <div class="sidebar-card d-none d-lg-flex">
        <img class="sidebar-card-illustration mb-2" src="{{ asset('img/undraw_rocket.svg')}}" alt="...">
        <p class="text-center mb-2"><strong>SB Admin Pro</strong> is
            packed with premium features, components, and more!
        </p>
        <a class="btn btn-success btn-sm"
            href="https://startbootstrap.com/theme/sb-admin-pro">Upgrade
            to Pro!
        </a>
    </div>

</ul>
<!-- End of Sidebar -->
