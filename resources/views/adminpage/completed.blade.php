<!DOCTYPE html>
<html lang="en">
<head>
    @include('adminpage.header') 
    <style>
        .table th, .table td {
            vertical-align: middle;
        }
        .header-info {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .current-time {
            font-size: 20px;
            font-weight: bold;
            margin-top: 10px;
        }
        .header-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .filter-form {
            display: flex;
            align-items: center;
        }

        /* Card Layout for Table */
        .card {
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            background-color: #f8f9fa;
            padding: 15px;
            font-size: 18px;
            font-weight: bold;
            color: #343a40;
        }
        .card-body {
            padding: 20px;
        }
    </style>
</head>
<body class="sb-nav-fixed">
    @include('adminpage.navbar') <!-- Includes the navigation bar -->

    <div id="layoutSidenav_content">
        <main>
            <div class="container mt-4">
                <!-- Header Section -->
                <div class="header-info">
                    <div>Current Time: <span id="current-time" class="current-time"></span></div>
                    <div>Today’s Date: <span id="current-date"></span></div>
                </div>

                <div class="header-section mb-4">
                    <h1 style="font-size: 40px; font-weight: bold; color: #343a40;">Completed Appointments</h1>
                    <!-- Filter Form -->
                    <form method="GET" action="{{ url()->current() }}" class="filter-form">
                        <label for="start_date" class="me-2" style="font-size: 18px; font-weight: 500; color: #555;">From:</label>
                        <input 
                            type="date" 
                            name="start_date" 
                            id="start_date" 
                            class="form-control me-2" 
                            style="width: 180px; border-radius: 10px; box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1); font-size: 16px;"
                            value="{{ request('start_date') }}"
                        >

                        <label for="end_date" class="me-2" style="font-size: 18px; font-weight: 500; color: #555;">To:</label>
                        <input 
                            type="date" 
                            name="end_date" 
                            id="end_date" 
                            class="form-control me-2" 
                            style="width: 180px; border-radius: 10px; box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1); font-size: 16px;"
                            value="{{ request('end_date') }}"
                        >

                        <button type="submit" class="btn btn-primary" style="border-radius: 10px; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1); font-size: 16px;">Apply</button>
                    </form>
                </div>

                <!-- Card for Completed Appointments Table -->
                @if($completedAppointments->isEmpty())
                    <p>No completed appointments for the selected period.</p>
                @else
                    <div class="card mt-4">
                        <div class="card-header">
                        Users List 
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Service Type</th>
                                            <th>Completion Date</th>
                                            <th>Completion Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($completedAppointments as $index => $appointment)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $appointment->user->first_name }} {{ $appointment->user->middle_name }} {{ $appointment->user->last_name ?? 'N/A' }}</td> 
                                                <td>{{ optional($appointment->user)->email ?? 'N/A' }}</td>
                                                <td>{{ optional($appointment->user)->phone ?? 'N/A' }}</td>
                                                <td>{{ $appointment->service_type }}</td>
                                                <td>{{ \Carbon\Carbon::parse($appointment->updated_at)->format('F d, Y') }}</td>
                                                <td>{{ \Carbon\Carbon::parse($appointment->updated_at)->format('h:i A') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div style="padding-bottom: 10px;" class="pagination d-flex justify-content-center">
                                    {{ $completedAppointments->appends(['start_date' => request('start_date'), 'end_date' => request('end_date')])->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </main>
    </div>

    @include('adminpage.footer') <!-- Includes the footer part -->
    @include('adminpage.scripts') <!-- Includes necessary scripts -->
    
    <script>
        function updateTime() {
            var currentDate = new Date();
            var currentTime = currentDate.toLocaleTimeString();
            var currentDateStr = currentDate.toLocaleDateString();

            document.getElementById('current-time').innerText = currentTime;
            document.getElementById('current-date').innerText = currentDateStr;
        }

        setInterval(updateTime, 1000); 
        updateTime(); 
    </script>
</body>
</html>
