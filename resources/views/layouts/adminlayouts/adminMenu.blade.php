<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/dashboard" class="brand-link">
        <img src="userAsset/images/logo.png" alt="Dashboard Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">Dashboard</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="adminAsset/dist/img/avatar5.png" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ auth()->user()->name }}</a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                    aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->


                <li class="nav-item {{ request()->is('admin-home') ? 'menu-open' : '' }}">
                    <a href="/admin-home" class="nav-link {{ request()->is('admin-home') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Home
                        </p>
                    </a>

                </li>



                {{-- <li class="nav-item">
                    <a href="changePassword" class="nav-link">
                        <i class="nav-icon fas fa-user-shield"></i>
                        <p>
                            Change Password
                        </p>
                    </a>

                </li> --}}

                <li class="nav-item {{ request()->is('add-vehicle') ? 'menu-open' : '' }}">
                    <a href="add-vehicle" class="nav-link {{ request()->is('add-vehicle') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-map"></i>
                        <p>
                            Add Vehicles
                        </p>
                    </a>

                </li>

                <li
                    class="nav-item {{ request()->is('add-featured-destination') || request()->is('delete-featured-destination') ? 'menu-open' : '' }}">
                    <a href="featured-destination"
                        class="nav-link {{ request()->is('add-featured-destination') || request()->is('delete-featured-destination') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-map"></i>
                        <p>
                            Featured Destinations
                        </p>
                    </a>

                </li>

                <li class="nav-item @if (request()->is('pickup-point') ||
                    request()->is('add-pickup-point') ||
                    request()->is('delete-pickup-point') ||
                    request()->is('edit-pickup-point') ||
                    request()->is('edit-pickup-point-post') ||
                    request()->is('service-city') ||
                    request()->is('add-city') ||
                    request()->is('edit-city') ||
                    request()->is('delete-city') ||
                    request()->is('edit-city-post')) menu-open @endif">
                    <a href="#" class="nav-link">
                        <i class="nav-icon far fa-plus-square"></i>
                        <p>
                            Add Master Data
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">

                        <li class="nav-item ">
                            <a href="/service-city" class="nav-link @if (request()->is('service-city') ||
                                request()->is('add-city') ||
                                request()->is('edit-city') ||
                                request()->is('delete-city') ||
                                request()->is('edit-city-post')) active @endif">
                                <i class="nav-icon far fa-circle"></i>

                                <p>
                                    Add Service City
                                </p>
                            </a>

                        </li>


                        <li class="nav-item ">
                            <a href="pickup-point" class="nav-link  @if (request()->is('pickup-point') ||
                                request()->is('add-pickup-point') ||
                                request()->is('delete-pickup-point') ||
                                request()->is('edit-pickup-point') ||
                                request()->is('edit-pickup-point-post')) active @endif">
                                <i class="nav-icon far fa-circle"></i>

                                <p>
                                    Add Pickup Points
                                </p>
                            </a>

                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="auditTrail" class="nav-link {{ request()->is('auditTrail') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-shield-alt"></i>
                        <p>
                            Audit Trail
                        </p>
                    </a>

                </li>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
