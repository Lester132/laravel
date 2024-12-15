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
        .alert {
            margin-top: 20px;
        }
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
        .modal-content {
            border-radius: 10px;
        }
        .modal-header {
            background-color: #007bff;
            color: #fff;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }
        .modal-footer {
            background-color: #f1f1f1;
        }
        .btn-save {
            background-color: #007bff;
            color: white;
        }
        .btn-save:hover {
            background-color: #0056b3;
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

                <!-- Display Flash Message -->
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Search Filter -->
                <form method="GET" action="{{ route('users.index') }}" class="mb-4 d-flex justify-content-end">
                    <div class="input-group" style="width: 250px;">
                        <input type="text" name="search" class="form-control" placeholder="Search by name..." value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>
                </form>

                <!-- Card for Users Table -->
                @if($users->isEmpty())
                    <p class="text-center">No registered users found.</p>
                @else
                    <div class="card mt-4">
                        <div class="card-header">Users List</div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone Number</th>
                                    <th>Status</th> <!-- New Column -->
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                    <tr>
                                    <td>{{ $loop->iteration }}</td>
                                        <td>{{ $user->first_name }} {{ $user->middle_name }} {{ $user->last_name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->phone }}</td>
                                        <td>{{ ucfirst($user->status) }}</td> <!-- Display Status -->
                                        <td>

                                       
                                            <button class="btn btn-warning btn-sm editUserBtn"
                                                data-id="{{ $user->id }}"
                                                data-first_name="{{ $user->first_name }}"
                                                data-middle_name="{{ $user->middle_name }}"
                                                data-last_name="{{ $user->last_name }}"
                                                data-email="{{ $user->email }}"
                                                data-phone="{{ $user->phone }}"
                                                data-status="{{ $user->status }}">
                                                UPDATE
                                            </button>
                                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">DELETE</button>
                                            </form>

                                            <button class="btn btn-info btn-sm historyUserBtn"
                                        data-id="{{ $user->id }}"
                                        data-first_name="{{ $user->first_name }}"
                                        data-middle_name="{{ $user->middle_name }}" 
                                        data-last_name="{{ $user->last_name }}">
                                        HISTORY
                                    </button>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </main>
    </div>

    <!-- Edit User Modal -->
    <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editUserForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <input type="hidden" name="user_id" id="user_id">
                    <div class="mb-3">
                        <label for="first_name" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="first_name" name="first_name" required>
                    </div>

                    <div class="mb-3">
                        <label for="middle_name" class="form-label">Middle Name</label>
                        <input type="text" class="form-control" id="middle_name" name="middle_name" required>
                    </div>

                    <div class="mb-3">
                        <label for="last_name" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="last_name" name="last_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone Number</label>
                        <input type="text" class="form-control" id="phone" name="phone" required>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                            <option value="deceased">Deceased</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>




<!-- History Modal -->
<div class="modal fade" id="historyUserModal" tabindex="-1" aria-labelledby="historyUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="historyUserModalLabel">User Appointment History</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Name:</strong> <span id="historyUserName"></span></p>
                <p><strong>Account Created:</strong> <span id="historyAccountCreated"></span></p>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>Service Type</th>
                                <th>Date of Appointment</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody id="historyTableBody">
                            <!-- Rows will be dynamically added via JavaScript -->
                        </tbody>
                    </table>
                </div>
                <p id="historyPaginationInfo" class="text-center"></p>
            </div>
            <div class="modal-footer">
    <div id="historyPaginationLinks" class="pagination d-flex justify-content-center"></div>
</div>

        </div>
    </div>
</div>


@include('adminpage.footer')
@include('adminpage.scripts')

<!-- JavaScript for Current Date/Time and Modal Handling -->
<script>
document.addEventListener('DOMContentLoaded', () => {
    const editButtons = document.querySelectorAll('.editUserBtn');
    const modal = new bootstrap.Modal(document.getElementById('editUserModal'));

    editButtons.forEach(button => {
        button.addEventListener('click', () => {
            // Populate modal fields with user data
            document.getElementById('user_id').value = button.dataset.id;
            document.getElementById('first_name').value = button.dataset.first_name;
            document.getElementById('middle_name').value = button.dataset.middle_name;
            document.getElementById('last_name').value = button.dataset.last_name;
            document.getElementById('phone').value = button.dataset.phone;
            document.getElementById('status').value = button.dataset.status; // Set the status

            // Dynamically set form action
            document.getElementById('editUserForm').action = `/users/${button.dataset.id}`;

            // Show the modal
            modal.show();
        });
    });
});
document.addEventListener('DOMContentLoaded', () => {
    const historyButtons = document.querySelectorAll('.historyUserBtn');
    const historyModal = new bootstrap.Modal(document.getElementById('historyUserModal'));
    const paginationLinksContainer = document.getElementById('historyPaginationLinks');
    let currentPage = 1; // Track the current page

    historyButtons.forEach(button => {
        button.addEventListener('click', () => {
            const userId = button.dataset.id;
            const firstName = button.dataset.first_name;
            const middleName = button.dataset.middle_name;
            const lastName = button.dataset.last_name;

            // Set user information in the modal
            document.getElementById('historyUserName').innerText = `${firstName} ${middleName} ${lastName}`;
            currentPage = 1; // Reset to the first page when opening the modal
            fetchHistory(userId, currentPage);

            // Show the modal
            historyModal.show();
        });
    });

    // Fetch history data
    function fetchHistory(userId, page) {
    fetch(`/users/${userId}/history?page=${page}`)
        .then(response => response.json())
        .then(data => {
            // Set account created date
            document.getElementById('historyAccountCreated').innerText = data.account_created;

            // Filter history to show only canceled, expired, or completed appointments
            const filteredHistory = data.history.filter(appointment => {
                return ['canceled', 'expired', 'completed'].includes(appointment.status);
            });

            // Populate table with filtered history data
            const historyTableBody = document.getElementById('historyTableBody');
            historyTableBody.innerHTML = '';

            if (filteredHistory.length === 0) {
                historyTableBody.innerHTML = '<tr><td colspan="3" class="text-center">No appointment history found.</td></tr>';
            } else {
                filteredHistory.forEach(appointment => {
                    const row = `
                        <tr>
                            <td>${appointment.service_type}</td>
                            <td>${appointment.date}</td>
                            <td>${appointment.status}</td>
                        </tr>
                    `;
                    historyTableBody.innerHTML += row;
                });
            }

            // Update pagination links
            renderPaginationLinks(userId, data.current_page, data.total_pages);
        });
}


    // Render pagination links
    function renderPaginationLinks(userId, currentPage, totalPages) {
        let links = '';

        if (currentPage > 1) {
            links += `<a href="#" class="page-link" data-page="${currentPage - 1}">&laquo; Previous</a>`;
        }

        for (let i = 1; i <= totalPages; i++) {
            links += `<a href="#" class="page-link ${i === currentPage ? 'active' : ''}" data-page="${i}">${i}</a>`;
        }

        if (currentPage < totalPages) {
            links += `<a href="#" class="page-link" data-page="${currentPage + 1}">Next &raquo;</a>`;
        }

        paginationLinksContainer.innerHTML = links;

        // Add event listeners to pagination links
        const paginationLinks = paginationLinksContainer.querySelectorAll('.page-link');
        paginationLinks.forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                const page = parseInt(link.dataset.page);
                if (!isNaN(page)) {
                    fetchHistory(userId, page);
                }
            });
        });
    }
});

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


    <!-- Bootstrap CSS and JS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
