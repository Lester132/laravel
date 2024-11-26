<!DOCTYPE html>
<html lang="en">
<head>
    @include('adminpage.header') <!-- Includes the header part -->
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

                <div class="d-flex justify-content-between align-items-center mb-4">
    <h1 style="font-size: 48px; font-weight: bold; color: #343a40;">
        Completed Appointments
    </h1>
    <!-- Filter Dropdown -->
    <form method="GET" action="{{ url()->current() }}" class="d-flex align-items-center">
        <label for="filter" class="me-2" style="font-size: 18px; font-weight: 500; color: #555;">Filter By:</label>
        <select 
            name="filter" 
            id="filter" 
            class="form-select" 
            style="width: 200px; border-radius: 10px; box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1); font-size: 16px;" 
            onchange="this.form.submit()"
        >
            <option value="today" {{ request('filter') === 'today' ? 'selected' : '' }}>Today</option>
            <option value="week" {{ request('filter') === 'week' ? 'selected' : '' }}>This Week</option>
            <option value="month" {{ request('filter') === 'month' ? 'selected' : '' }}>This Month</option>
        </select>
    </form>
</div>


                <!-- Table Section -->
                @if($completedAppointments->isEmpty())
                    <p>No completed appointments for the selected period.</p>
                @else
                    <div class="table-responsive mt-4">
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
                                        <td>{{ optional($appointment->user)->name ?? 'N/A' }}</td>
                                        <td>{{ optional($appointment->user)->email ?? 'N/A' }}</td>
                                        <td>{{ optional($appointment->user)->phone ?? 'N/A' }}</td>
                                        <td>{{ $appointment->service_type }}</td>
                                        <td>{{ \Carbon\Carbon::parse($appointment->updated_at)->format('F d, Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($appointment->updated_at)->format('h:i A') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $completedAppointments->links() }} <!-- Add pagination links -->
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
