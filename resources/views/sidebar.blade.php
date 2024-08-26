<div class="sidebar" data-color="orange">
    <!--
        Tip 1: You can change the color of the sidebar using: data-color="blue | green | orange | red | yellow"
    -->
    <div class="logo">
        <a href="http://www.creative-tim.com" class="simple-text logo-mini">
            MB
        </a>
        <a href="http://www.creative-tim.com" class="simple-text logo-normal">
            Marca Band
        </a>
    </div>
    <div class="sidebar-wrapper" id="sidebar-wrapper">
        <ul class="nav">
            <li class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <a href="{{route('dashboard')}}">
                    <i class="now-ui-icons design_app"></i>
                    <p>Dashboard</p>
                </a>
            </li>
            @if(Auth::user()->role != 'User')

            <li class="{{ request()->routeIs('department.create') ? 'active' : '' }}">
                <a href="{{route('department.create')}}">
                    <i class="now-ui-icons location_map-big"></i>
                    <p>Department</p>
                </a>
            </li>
            <li class="{{ request()->routeIs('task.index') ? 'active' : '' }}">
                <a href="{{route('task.index')}}">
                    <i class="now-ui-icons education_atom"></i>
                    <p>Task</p>
                </a>
            </li>

            <!-- <li>
            <a href="./notifications.html">
              <i class="now-ui-icons ui-1_bell-53"></i>
              <p>User</p>
            </a>
          </li> -->
            @endif
            <li class="{{ request()->routeIs('project.index') ? 'active' : '' }}">
                <a href="{{route('project.index')}}">
                    <i class="now-ui-icons location_map-big"></i>
                    <p>Projects</p>
                </a>
            </li>
            <li class="{{ request()->routeIs('user.index') ? 'active' : '' }}">
                <a href="{{route('user.index')}}">
                    <i class="now-ui-icons users_single-02"></i>
                    <p>User </p>
                </a>
            </li>
            <li class="{{ request()->routeIs('report') ? 'active' : '' }}">
                <a href="{{route('report')}}">
                    <i class="now-ui-icons design_bullet-list-67"></i>
                    <p>Reports</p>
                </a>
            </li>

        </ul>
    </div>
</div>
