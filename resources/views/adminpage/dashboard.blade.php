<!DOCTYPE html>
<html lang="en">
    <head>
@include('adminpage.header')
    </head>
    <body class="sb-nav-fixed">
      
    @include('adminpage.navbar')
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="display-5 mt-4 fw-bold">Dashboard</h1>
                        <ol class="breadcrumb mb-4">
                     
                        </ol>
                        <div class="row">
                         <!-- Total Registered Patients -->
    <div class="col-xl-3 col-md-6">
        <div class="card bg-primary text-white mb-4">
            <div class="card-body">
                <h1 class="fw-bold">Total Registered Patients:</h1>
                <h2 class="fw-bold text-center display-3">{{ $userCount }}</h2>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="#">View Details</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>

    <!-- Pending Appointments -->
    <div class="col-xl-3 col-md-6">
        <div class="card bg-warning text-white mb-4">
            <div class="card-body">
                <h1 class="fw-bold">Pending Appointments:</h1>
                <h2 class="fw-bold text-center display-3">{{ $pendingCount }}</h2>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="{{ route('pending') }}">View Details</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>

    <!-- Completed Appointments -->
    <div class="col-xl-3 col-md-6">
        <div class="card bg-success text-white mb-4">
            <div class="card-body">
                <h1 class="fw-bold">Completed Appointments:</h1>
                <h2 class="fw-bold text-center display-3">{{ $completedCount }}</h2>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="{{ route('completed') }}">View Details</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
        </div>
           <!-- expired/cancelled Appointments -->

           <div class="col-xl-3 col-md-6">
    <div class="card bg-danger text-white mb-4">
        <div class="card-body">
            <h1 class="fw-bold">Expired/Cancelled Appointments:</h1>
            <h2 class="fw-bold text-center display-3">{{ $expiredAppointmentsCount }}</h2>
        </div>
        <div class="card-footer d-flex align-items-center justify-content-between">
            <a class="small text-white stretched-link" href="{{ route('expired') }}">View Details</a>
            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
        </div>
    </div>
</div>

           
                        
                </main>
              @include('adminpage.footer')
            </div>
       
     @include('adminpage.scripts')
    </body>
</html>
