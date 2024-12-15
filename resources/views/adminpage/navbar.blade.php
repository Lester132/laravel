<nav class="sb-topnav navbar navbar-expand navbar-light bg-white" style="outline: 1px solid; background: linear-gradient(120deg, #56b3fa, #42a5f5, #64d8cb);">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="{{route('dashboard')}}"><img src="images/nav_icon.png" width="100" height="40" alt=""></a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
                <div class="input-group">
                   
                </div>
            </form>
            <!-- Navbar-->
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <x-app-layout></x-app-layout>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark bg-dark" id="sidenavAccordion" style="outline: 1px solid; background-color: #343a40;">
                <div class="sb-sidenav-menu">
    <div class="nav">
        <div class="sb-sidenav-menu-heading">Main</div>
        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
            Dashboard
        </a>
        <div class="sb-sidenav-menu-heading">Clients</div>
        <a class="nav-link collapsed {{ request()->routeIs('pending') || request()->routeIs('completed') || request()->routeIs('expired') ? 'active' : '' }}" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
            Appointments
            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
        </a>
        <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
            <nav class="sb-sidenav-menu-nested nav">
                <a class="nav-link {{ request()->routeIs('pending') ? 'active' : '' }}" href="{{ route('pending') }}">Pending </a>
                <a class="nav-link {{ request()->routeIs('completed') ? 'active' : '' }}" href="{{ route('completed') }}">Completed</a>
                <a class="nav-link {{ request()->routeIs('expired') ? 'active' : '' }}" href="{{ route('expired') }}">Cancelled/Expired</a>
            </nav>
        </div>
        <a class="nav-link {{ request()->routeIs('registered') ? 'active' : '' }}" href="{{ route('registered') }}">
        <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div> Total Registered Patients
</a>

        <div class="sb-sidenav-menu-heading">Addons</div>
        <a class="nav-link {{ request()->routeIs('adminpage.contentupdate') ? 'active' : '' }}" href="{{ route('adminpage.contentupdate') }}">
    <div class="sb-nav-link-icon"><i class="fa fa-wrench" aria-hidden="true"></i></div>
    Content Update Panel
</a>

    
    </div>
</div>

                    <div class="sb-sidenav-footer">
             
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Rosario Dental Clinic 2024</div>
                           
                        </div>
                    </div>
         
                    </div>
                </nav>
            </div>