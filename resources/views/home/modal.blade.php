<!-- Include CSS and JS for modal and form -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<!-- Modal for Appointment Form -->
<div class="modal fade" id="modalRequest" tabindex="-1" role="dialog" aria-labelledby="modalRequestLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalRequestLabel">Make an Appointment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Appointment Form -->
                <form id="appointmentForm" action="{{ route('appointments.store') }}" method="POST">
                    @csrf <!-- CSRF token -->

                    <!-- Service Type Checkboxes -->
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Service Types (Select all that apply):</label>
                                <div class="checkbox-wrap" style="max-height: 200px; overflow-y: auto; border: 1px solid #ddd; padding: 10px; border-radius: 5px; background-color: #f9f9f9;">
                                    <label><input type="checkbox" name="service_type[]" value="Dental Consultation"> Dental Consultation</label><br>
                                    <label><input type="checkbox" name="service_type[]" value="Tooth Extraction"> Tooth Extraction</label><br>
                                    <label><input type="checkbox" name="service_type[]" value="Dental Filling"> Dental Filling</label><br>
                                    <label><input type="checkbox" name="service_type[]" value="Dental Crown"> Dental Crown</label><br>
                                    <label><input type="checkbox" name="service_type[]" value="Dental Bridge"> Dental Bridge</label><br>
                                    <label><input type="checkbox" name="service_type[]" value="Dental Implant"> Dental Implant</label><br>
                                    <label><input type="checkbox" name="service_type[]" value="Root Canal Treatment"> Root Canal Treatment</label><br>
                                    <label><input type="checkbox" name="service_type[]" value="Dental Cleaning"> Dental Cleaning</label><br>
                                    <label><input type="checkbox" name="service_type[]" value="Teeth Whitening"> Teeth Whitening</label><br>
                                    <label><input type="checkbox" name="service_type[]" value="Quality Brackets"> Quality Brackets</label><br>
                                    <label><input type="checkbox" name="service_type[]" value="Modern Anesthetic"> Modern Anesthetic</label><br>
                                    <label><input type="checkbox" name="service_type[]" value="Dental Calculus"> Dental Calculus</label><br>
                                    <label><input type="checkbox" name="service_type[]" value="Paradontosis"> Paradontosis</label><br>
                                    <label><input type="checkbox" name="service_type[]" value="Tooth Braces"> Tooth Braces</label><br>
                                    <label><input type="checkbox" name="service_type[]" value="Other"> Other</label>
                                </div>
                                <small id="serviceTypeError" class="text-danger" style="display: none;">You can select a maximum of 3 service types.</small>
                            </div>
                        </div>
                    </div>

                    <!-- Date and Time Fields -->
                    <div class="row mb-3">
                        <!-- Date Field -->
                        <div class="col-sm-4">
                            <div class="form-group">
                               DATE:
                                <input 
                                    type="text" 
                                    id="appointment_date" 
                                    name="appointment_date" 
                                    class="form-control" 
                                    placeholder="Select Date" 
                                    required>
                                <small id="dateError" class="text-danger" style="display: none;">Please select today or a future date.</small>
                            </div>
                        </div>

                        <!-- Time Field -->
                        <div class="col-sm-6">
                            <div class="form-group">
                                TIME:
                                <select name="appointment_time" class="form-control" required>
                                    <option value="">Select Time</option>
                                    <option value="08:00">8:00 AM</option>
                                    <option value="09:00">9:00 AM</option>
                                    <option value="10:00">10:00 AM</option>
                                    <option value="11:00">11:00 AM</option>
                                    <option value="12:00">12:00 PM</option>
                                    <option value="01:00">1:00 PM</option>
                                    <option value="02:00">2:00 PM</option>
                                    <option value="03:00">3:00 PM</option>
                                    <option value="04:00">4:00 PM</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Display Success or Error Messages -->
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Submit Button -->
                    <div class="form-group">
                        <input type="submit" value="Make an Appointment" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for Notification and Form Submission -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const availableTimes = ["08:00", "09:00", "10:00", "11:00", "12:00", "13:00", "14:00", "15:00", "16:00"];
    const serviceCheckboxes = document.querySelectorAll('input[name="service_type[]"]');
    const serviceTypeError = document.getElementById('serviceTypeError');
    const dateError = document.getElementById('dateError');
    const timeField = document.querySelector("select[name='appointment_time']");

    // Initialize Flatpickr on the input field
    flatpickr("#appointment_date", {
        dateFormat: "Y-m-d", // Set the format of the date
        minDate: "today",    // Disable past dates by setting the minimum date to today
        disable: [
            function (date) {
                const currentDate = new Date();
                // If the date is today, check the available time slots
                if (date.toDateString() === currentDate.toDateString()) {
                    const currentHour = currentDate.getHours();
                    // Check if any available time slot is valid
                    const hasValidTime = availableTimes.some(time => {
                        const [hour] = time.split(":").map(Number);
                        return hour > currentHour;
                    });
                    return !hasValidTime; // Disable today if no valid time slots
                }
                return false; // Do not disable other dates
            }
        ],
        onChange: function (selectedDates, dateStr, instance) {
            const currentDate = new Date();
            const selectedDate = new Date(dateStr);

            if (selectedDate.toDateString() === currentDate.toDateString()) {
                // If the selected date is today, limit the time options
                limitTimeOptions(currentDate, timeField);
            } else {
                // Enable all time options if the date is in the future
                enableAllTimeOptions(timeField);
            }

            // Display error if a past date is selected (additional safeguard)
            if (selectedDate < currentDate) {
                dateError.style.display = 'block';
            } else {
                dateError.style.display = 'none';
            }
        }
    });

    // Limit the number of selections to 3
    serviceCheckboxes.forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            const selectedCount = document.querySelectorAll('input[name="service_type[]"]:checked').length;

            if (selectedCount > 3) {
                // If more than 3 checkboxes are selected, disable the remaining checkboxes
                this.checked = false;
                serviceTypeError.style.display = 'block'; // Show error message
            } else {
                // Hide error message if less than or equal to 3 checkboxes are selected
                serviceTypeError.style.display = selectedCount > 3 ? 'block' : 'none';
            }
        });
    });

    // Limit time options based on the current time
    function limitTimeOptions(currentDate, timeField) {
        const currentHour = currentDate.getHours();
        const options = timeField.options;

        // Loop through time options
        for (let i = 0; i < options.length; i++) {
            const optionTime = parseInt(options[i].value.split(":")[0], 10); // Extract hour (24-hour format)
            if (optionTime < currentHour) {
                options[i].disabled = true; // Disable past options
            } else {
                options[i].disabled = false; // Enable future options
            }
        }
    }

    // Enable all time options
    function enableAllTimeOptions(timeField) {
        const options = timeField.options;
        for (let i = 0; i < options.length; i++) {
            options[i].disabled = false;
        }
    }

    // Add event listener for form submission
    document.getElementById('appointmentForm').addEventListener('submit', function (event) {
        // Validate the service type checkboxes (max 3 selected)
        const selectedServices = document.querySelectorAll('input[name="service_type[]"]:checked');
        if (selectedServices.length > 3) {
            event.preventDefault(); // Prevent form submission
            serviceTypeError.style.display = 'block'; // Show error message
        } else {
            serviceTypeError.style.display = 'none'; // Hide error message
        }

        // Prevent default form submission
        event.preventDefault();

        // Proceed with form submission using AJAX (fetch)
        const formData = new FormData(this);
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content'); // Get CSRF token

        fetch("{{ route('appointments.store') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken, // Include CSRF token in headers
            },
            body: formData
        })
        .then(response => response.json()) // Parse the response as JSON
        .then(data => {
            if (data.success) {
                // Show a confirmation dialog (instead of alert)
                if (window.confirm("Appointment successfully booked! Do you want to proceed with another appointment?")) {
                    // If user clicks "OK", you can reset the form or perform other actions
                    document.getElementById('appointmentForm').reset();
                } else {
                    // If user clicks "Cancel", just hide the modal and reset form
                    $('#modalRequest').modal('hide'); // Hide the modal
                }
            } else {
                alert('There was an error with your submission.'); // Show error message if needed
            }
        })
        .catch(error => {
            console.error('Error:', error); // Log any error that occurs
        });
    });
});
</script>
