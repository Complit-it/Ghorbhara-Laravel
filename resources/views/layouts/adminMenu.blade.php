<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/dashboard" class="brand-link">
        <img src="/adminAsset/dist/img/roadpartner_logo.png" alt="Dashboard Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">Dashboard</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="/adminAsset/dist/img/avatar5.png" class="img-circle elevation-2" alt="User Image">
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


                <li class="nav-item {{ request()->is('dashboard') ? 'menu-open' : '' }}">
                    <a href="/dashboard" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Home
                        </p>
                    </a>

                </li>


                <li class="nav-item">
                    <a href="add-notification" class="nav-link {{ request()->is('add-notification') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-bullhorn"></i>
                        <p>
                            Send Notification
                        </p>
                    </a>

                </li>



                <!-- <li class="nav-item @if (request()->is('addProduct') || request()->is('editProduct') || request()->is('addProductPost') || request()->is('editProductPost')) menu-open @endif">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa fa-shopping-basket"></i>
                        <p>
                            Products
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item ">
                            <a href="addProduct" class="nav-link  @if (request()->is('addProduct') || request()->is('addProductPost')) active @endif">
                                <i class="nav-icon far fa-circle"></i>

                                <p>
                                    Add
                                </p>
                            </a>

                        </li>
                        <li class="nav-item ">
                            <a href="editProduct" class="nav-link @if (request()->is('editProduct') || request()->is('editProductPost')) active @endif">
                                <i class="nav-icon far fa-circle"></i>

                                <p>
                                    View/Edit
                                </p>
                            </a>

                        </li>



                    </ul>
                </li> -->

                <!-- <li class="nav-item @if (request()->is('addVendor') || request()->is('viewVendors') || request()->is('addVendorPost') || request()->is('editVendorPost')) menu-open @endif">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa fa-cart-plus"></i>
                        <p>
                            Service Provider
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">

                        <li class="nav-item ">
                            <a href="viewVendors" class="nav-link @if (request()->is('viewVendors') || request()->is('editVendor')) active @endif">
                                <i class="nav-icon far fa-circle"></i>

                                <p>
                                    View
                                </p>
                            </a>

                        </li>



                    </ul>
                </li> -->

                <!-- <li class="nav-item @if (request()->is('viewStockRequest')) menu-open @endif">
                    <a href="viewStockRequest" class="nav-link">
                        <i class="nav-icon fa fa-archive"></i>
                        <p>
                            Stocks
                        </p>
                    </a>
                </li> -->




                <li class="nav-item">
                    <a href="changePassword" class="nav-link">
                        <i class="nav-icon fas fa-user-shield"></i>
                        <p>
                            Change Password
                        </p>
                    </a>

                </li>



                <li class="nav-item @if (request()->is('app-banner') ) menu-open @endif">
                    <a href="#" class="nav-link">
                        <i class="nav-icon far fa-plus-square"></i>
                        <p>
                            App Data
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item ">
                            <a href="/app-banner" class="nav-link  @if (request()->is('app-banner')) active @endif">
                                <i class="nav-icon far fa-circle"></i>

                                <p>
                                    Bannners
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
