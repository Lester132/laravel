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

                @if($pendingAppointments->isEmpty())
                    <p>No pending appointments.</p>
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
    @foreach($pendingAppointments as $appointment)
        @if(\Carbon\Carbon::parse($appointment->appointment_date)->isToday()) 
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
                    <form action="{{ route('completed', $appointment->id) }}" method="POST" style="display: inline;" onsubmit="return confirmAction('complete')">
                        @csrf
                        <button class="btn btn-success btn-sm">Complete</button>
                    </form>

                    <form action="{{ route('expired', $appointment->id) }}" method="POST" style="display: inline;" onsubmit="return confirmAction('cancel')">
                        @csrf
                        <button class="btn btn-danger btn-sm">Cancel</button>
                    </form>
                </td> 
            </tr>
        @endif
    @endforeach
</tbody>

                        </table>
                    </div>
                @endif
            </div>
        </main>
    </div>

    @include('adminpage.footer')
    @include('adminpage.scripts')

    <!-- JavaScript for confirmation dialog -->
    <script>
        function confirmAction(action) {
            let message = action === 'complete' ? 'Are you sure you want to mark this appointment as complete?' : 'Are you sure you want to cancel this appointment?';
            return confirm(message); // Show confirmation dialog
        }

        function updateTime() {
            var currentDate = new Date();
            var currentTime = currentDate.toLocaleTimeString();
            var currentDateStr = currentDate.toLocaleDateString();

            document.getElementById('current-time').innerText = currentTime;
            document.getElementById('current-date').innerText = currentDateStr;
        }

        setInterval(updateTime, 1000); 
        updateTime(); 

        document.getElementById('appointmentForm').onsubmit = function(event) {
        event.preventDefault(); // Prevent default submission to handle validations or show a loader

        this.submit();
    };

    </script>
</body>
</html>
