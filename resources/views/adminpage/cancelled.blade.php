<!DOCTYPE html>
<html lang="en">
<head>
    @include('adminpage.header')
    <style>
        .table th {
            background-color: #f8f9fa;
            color: #343a40;
            font-weight: bold;
            text-transform: uppercase;
        }
        .table td {
            vertical-align: middle;
        }
        .status-label {
            font-size: 14px;
            font-weight: bold;
            padding: 5px 10px;
            border-radius: 15px;
        }
        .status-canceled {
            background-color: #ffc107;
            color: #212529;
        }
        .status-expired {
            background-color: #dc3545;
            color: #fff;
        }
        .status-other {
            background-color: #6c757d;
            color: #fff;
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
    @include('adminpage.navbar')

    <div id="layoutSidenav_content">
        <main>
            <div class="container mt-4">

            <div class="header-info">
                    <div>Current Time: <span id="current-time" class="current-time"></span></div>
                    <div>Today’s Date: <span id="current-date"></span></div>
                </div>

                  <h1 style="font-size: 48px; font-weight: bold; color: #343a40; margin-bottom: 40px;">
                  Cancelled/Expired Appointments
                </h1>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="text-center">
                            <tr>
                                 <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Number</th>
                                <th>Service Type</th>
                                <th>Appointment Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($expiredAppointments as $index => $appointment)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $appointment->user->first_name }} {{ $appointment->user->middle_name }} {{ $appointment->user->last_name ?? 'N/A'}}</td>

                                    <td>{{ optional($appointment->user)->email ?? 'N/A' }}</td>
                                    <td>{{ optional($appointment->user)->phone ?? 'N/A' }}</td>
                                    <td>{{ $appointment->service_type }}</td>
                                    <td>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('F d, Y') }}</td>
                                    <td class="text-center">
                                        @if($appointment->status == 'canceled')
                                            <span class="status-label status-canceled">Cancelled</span>
                                        @elseif(\Carbon\Carbon::parse($appointment->appointment_date)->isPast())
                                            <span class="status-label status-expired">Expired</span>
                                        @else
                                            <span class="status-label status-other">{{ ucfirst($appointment->status) }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">No cancelled or expired appointments found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    @include('adminpage.footer')
    @include('adminpage.scripts')

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
