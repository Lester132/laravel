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
    .btn {
        border-radius: 8px;
        font-size: 14px;
        padding: 8px 12px;
        transition: background-color 0.3s, transform 0.2s;
        box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
    }

    .btn-success {
        background-color: #28a745;
        color: #fff;
        border: none;
    }

    .btn-success:hover {
        background-color: #218838;
        transform: translateY(-2px);
    }

    .btn-danger {
        background-color: #dc3545;
        color: #fff;
        border: none;
    }

    .btn-danger:hover {
        background-color: #c82333;
        transform: translateY(-2px);
    }

    .btn-actions {
        display: flex;
        justify-content: center;
        gap: 10px;
    }

    .btn-actions .btn {
        box-shadow: 0 3px 8px rgba(0, 0, 0, 0.2);
    }

    .btn-actions .btn:hover {
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.3);
    }

    /* Card Layout Styles */
    .card {
        border: 1px solid #ddd;
        border-radius: 8px;
        margin-bottom: 30px;
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
    @include('adminpage.navbar')

    <div id="layoutSidenav_content">
        <main>
            <div class="container mt-4">
                <div class="header-info">
                    <div>Current Time: <span id="current-time" class="current-time"></span></div>
                    <div>Today’s Date: <span id="current-date"></span></div>
                </div>

                <h1 style="font-size: 48px; font-weight: bold; color: #343a40; margin-bottom: 20px; padding-bottom: 10px;">
                    Pending Appointments
                </h1>

                <!-- Card for Today's Appointments -->
                <div class="card">
                    <div class="card-header">
                        Today's Appointments
                    </div>
                    <div class="card-body">
                        @if($pendingAppointmentsToday->isEmpty())
                            <p>No pending appointments for today.</p>
                        @else
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Number</th>
                                            <th>Service Type</th>
                                            <th>Appointment Date</th>
                                            <th>Appointment Time</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($pendingAppointmentsToday as $appointment)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $appointment->user->first_name }} {{ $appointment->user->middle_name }} {{ $appointment->user->last_name }}</td>
                                                <td>{{ $appointment->user->email }}</td>
                                                <td>{{ $appointment->user->phone }}</td>
                                                <td>{{ $appointment->service_type }}</td>
                                                <td>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('F j, Y') }}</td>
                                                <td>
                                                @php
                                                    $appointmentTime = \Carbon\Carbon::parse($appointment->appointment_time);
                                                    $hour = $appointmentTime->hour;
                                                    $period = ($hour >= 9 && $hour <= 11) ? 'AM' : 'PM';
                                                @endphp
                                                {{ $appointmentTime->format('h:i') }} {{ $period }}
                                            </td>
                                                <td>
                                                    <form action="{{ route('appointments.complete', $appointment->id) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        <button class="btn btn-success btn-sm" type="submit">Complete</button>
                                                    </form>
                                                    <form action="{{ route('appointments.cancel', $appointment->id) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        <button class="btn btn-danger btn-sm" type="submit">Cancel</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Card for Tomorrow's Appointments -->
                <div class="card">
                    <div class="card-header">
                        Tomorrow's Appointments
                    </div>
                    <div class="card-body">
                        @if($pendingAppointmentsTomorrow->isEmpty())
                            <p>No pending appointments for tomorrow.</p>
                        @else
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Number</th>
                                            <th>Service Type</th>
                                            <th>Appointment Date</th>
                                            <th>Appointment Time</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($pendingAppointmentsTomorrow as $appointment)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $appointment->user->first_name }} {{ $appointment->user->middle_name }} {{ $appointment->user->last_name }}</td>
                                                <td>{{ $appointment->user->email }}</td>
                                                <td>{{ $appointment->user->phone }}</td>
                                                <td>{{ $appointment->service_type }}</td>
                                                <td>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('F j, Y') }}</td>
                                                <td>
                                                @php
                                                    $appointmentTime = \Carbon\Carbon::parse($appointment->appointment_time);
                                                    $hour = $appointmentTime->hour;
                                                    $period = ($hour >= 9 && $hour <= 11) ? 'AM' : 'PM';
                                                @endphp
                                                {{ $appointmentTime->format('h:i') }} {{ $period }}
                                            </td>
                                                <td>
                                                    <form action="{{ route('appointments.complete', $appointment->id) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        <button class="btn btn-success btn-sm" type="submit">Complete</button>
                                                    </form>
                                                    <form action="{{ route('appointments.cancel', $appointment->id) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        <button class="btn btn-danger btn-sm" type="submit">Cancel</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </main>
    </div>

    @include('adminpage.footer')
    @include('adminpage.scripts')

    <script>
    document.addEventListener('DOMContentLoaded', () => {
        // Time and date update logic
        setInterval(() => {
            var currentDate = new Date();
            var currentTime = currentDate.toLocaleTimeString();
            var currentDateStr = currentDate.toLocaleDateString();

            document.getElementById('current-time').innerText = currentTime;
            document.getElementById('current-date').innerText = currentDateStr;
        }, 1000); // Update every second
    });
    </script>
</body>
</html>
