<!DOCTYPE html>
<html lang="en">
<head>
    @include('adminpage.header')

    <style>
        .table th, .table td {
            vertical-align: middle;
            text-align: center;
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
        .page-title {
            font-size: 48px;
            font-weight: bold;
            color: #343a40;
            margin-bottom: 20px;
            padding-bottom: 10px;
        }
    </style>
</head>
<body class="sb-nav-fixed">
    @include('adminpage.navbar')

    <div id="layoutSidenav_content">
        <main>
            <div class="container mt-4">
                <!-- Display Current Date and Time -->
                <div class="header-info">
                    <div>Current Time: <span id="current-time" class="current-time"></span></div>
                    <div>Today’s Date: <span id="current-date"></span></div>
                </div>

                <!-- Page Title -->
                <h1 class="page-title">All Registered Users</h1>

                <!-- Search Filter -->
                <form method="GET" action="{{ route('users.index') }}" class="mb-4 d-flex justify-content-end">
    <div class="input-group" style="width: 250px;">
        <input type="text" name="search" class="form-control" placeholder="Search by name..." value="{{ request('search') }}">
        <button type="submit" class="btn btn-primary">Search</button>
    </div>
</form>


                <!-- Users Table -->
                @if($users->isEmpty())
                    <p class="text-center">No registered users found.</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone Number</th>
                                    <th>Booked Appointments</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->phone }}</td>
                                        <td>{{ $user->appointments_count }}</td>
                                    </tr>
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

    <!-- JavaScript to display current date and time -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            function updateTime() {
                const currentDate = new Date();
                document.getElementById('current-time').innerText = currentDate.toLocaleTimeString();
                document.getElementById('current-date').innerText = currentDate.toLocaleDateString();
            }

            setInterval(updateTime, 1000); // Update every second
            updateTime(); // Initialize immediately
        });
    </script>
</body>
</html>
