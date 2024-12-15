<!DOCTYPE html>
<html lang="en">
<head>
  @include('adminpage.header')
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
  <style>
    main {
      font-family: 'Poppins', sans-serif;
      background-color: #f9f9f9;
      color: #333;
      margin: 0;
      padding: 0;
    }
    .container {
      max-width: 800px;
      margin-top: 50px;
      padding: 20px;
    }
    .card {
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      background-color: #fff;
      margin-bottom: 20px;
      border: none;
    }
    .card-header {
      background-color:rgb(59, 59, 59);
      color: #fff;
      padding: 15px;
      font-weight: 600;
      border-radius: 10px 10px 0 0;
    }
    .card-body {
      padding: 15px;
    }
    .btn-primary {
      background-color: #007bff;
      border: none;
      color: white;
      font-weight: 500;
      padding: 10px 20px;
      border-radius: 5px;
      text-transform: uppercase;
      letter-spacing: 1px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }
    .btn-primary:hover {
      background-color: #0056b3;
    }
    .modal-header {
      background-color: #f1f1f1;
      border-bottom: 1px solid #ddd;
      padding: 15px;
    }
    .form-control {
      border-radius: 5px;
      padding: 10px;
      border: 1px solid #ddd;
      margin-bottom: 15px;
    }
    .form-group label {
      font-weight: 600;
    }
    h1 {
      font-size: 36px;
      text-align: center;
      color: #333;
      margin-bottom: 40px;
    }
  </style>
</head>
<body class="sb-nav-fixed">
  @include('adminpage.navbar')
  <div id="layoutSidenav_content">
    <main>
      <div class="container">
      <h1 class="text-start" style="font-size: 40px; font-weight: bold; color: #343a40; margin-bottom: 10px;">Content Update Panel</h1>

        <!-- Address Card -->
        <div class="card">
          <div class="card-header">
            <h5>Address</h5>
          </div>
          <div class="card-body">
            <p id="address">{{ $contactInfo->address }}</p>
          </div>
        </div>

        <!-- Phone Card -->
        <div class="card">
          <div class="card-header">
            <h5>Phone</h5>
          </div>
          <div class="card-body">
            <p id="phone">{{ $contactInfo->phone }}</p>
          </div>
        </div>

        <!-- Email Card -->
        <div class="card">
          <div class="card-header">
            <h5>Email</h5>
          </div>
          <div class="card-body">
            <p id="email">{{ $contactInfo->email }}</p>
          </div>
        </div>

        <!-- Facebook Card -->
        <div class="card">
          <div class="card-header">
            <h5>Facebook</h5>
          </div>
          <div class="card-body">
            <p id="facebook">{{ $contactInfo->facebook }}</p>
          </div>
        </div>

        <!-- Edit Button to Trigger Modal -->
        <div class="d-flex justify-content-center">
          <button class="btn btn-primary" data-toggle="modal" data-target="#editModal">Edit Information</button>
        </div>

        <!-- Modal for Editing Information -->
        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Contact Information</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <form action="{{ route('adminpage.updateContactInfo') }}" method="POST">
                @csrf
                <div class="modal-body">
                  <!-- Editable Form -->
                  <div class="form-group">
                    <label for="modal-address">Address</label>
                    <input type="text" name="address" id="modal-address" class="form-control" value="{{ $contactInfo->address }}">
                  </div>

                  <div class="form-group">
                    <label for="modal-phone">Phone</label>
                    <input type="text" name="phone" id="modal-phone" class="form-control" value="{{ $contactInfo->phone }}">
                  </div>

                  <div class="form-group">
                    <label for="modal-email">Email</label>
                    <input type="email" name="email" id="modal-email" class="form-control" value="{{ $contactInfo->email }}">
                  </div>

                  <div class="form-group">
                    <label for="modal-facebook">Facebook</label>
                    <input type="text" name="facebook" id="modal-facebook" class="form-control" value="{{ $contactInfo->facebook }}">
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>

  @include('adminpage.scripts')

  <!-- Bootstrap JS (make sure to include these if you don't have them yet) -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
