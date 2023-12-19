<aside class="main-sidebar sidebar-dark-primary elevation-4">

    <a href="index3.html" class="brand-link">
        <img src="{{ asset('dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">Multi-Purpose</span>
    </a>

    <div class="sidebar">

        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">Mostafa Rhazlani</a>
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <li class="nav-item">
                    <router-link to="/admin/dashboard" active-class="active" class="nav-link">
                        <i class="nav-icon fas fa-chart-line"></i>
                        <p>
                            Dashboard
                        </p>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/admin/appointments" active-class="active" class="nav-link">
                        <i class="nav-icon fas fa-calendar-alt"></i>
                        <p>
                            Appointments
                        </p>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/admin/users" active-class="active" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Users
                        </p>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/admin/settings" active-class="active" class="nav-link">
                        <i class="nav-icon fas fa-cog"></i>
                        <p>
                            Settings
                        </p>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/admin/profile" active-class="active" class="nav-link">
                        <i class="nav-icon fas fa-user"></i>
                        <p>
                            Profile
                        </p>
                    </router-link>
                </li>
                <li class="nav-item">
                    <a href="#" active-class="active" class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>
                            Log out
                        </p>
                    </a>
                </li>
            </ul>
        </nav>

    </div>

</aside>
