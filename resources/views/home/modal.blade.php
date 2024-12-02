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
                                    <!-- List of checkboxes for service types -->
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
                            </div>
                        </div>
                    </div>

                    <!-- Date and Time Fields -->
                    <div class="row mb-3">
                        <!-- Date Field -->
                        <div class="col-sm-4">
                    <div class="form-group">
                        <div class="icon"><span class="ion-ios-calendar"></span></div>
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
                                <div class="icon"><span class="ion-ios-clock"></span></div>
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

    
document.getElementById('appointmentForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent the default form submission

    const formData = new FormData(this); // Collect all the form data

    console.log("Form Data Submitted:", Object.fromEntries(formData.entries())); // For debugging

    fetch("{{ route('appointments.store') }}", {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',  // CSRF token for protection
            'Accept': 'application/json', // Ensure the response is JSON
        },
        body: formData, // Send the form data
    })
    .then(response => {
        console.log('Response:', response); // Log raw response for debugging

        if (response.ok) {
            return response.text(); // Get raw text response (instead of JSON)
        } else {
            throw new Error('Network response was not ok');
        }
    })
    .then(text => {
        console.log('Raw Response Text:', text); // Log the raw response text

        try {
            const data = JSON.parse(text); // Try to parse it as JSON
            if (data.success) {
                alert('Appointment successfully booked!');
            } else {
                alert('Error occurred while booking the appointment');
            }
        } catch (error) {
            console.error('Error parsing JSON:', error); // Log the parsing error
            alert('An error occurred while submitting the form.');
        }
    })
    .catch(error => {
        console.error('Error:', error); // Log any error
        alert('An error occurred while submitting the form.');
    });
});

document.addEventListener('DOMContentLoaded', function () {
        // Initialize Flatpickr on the input field
        flatpickr("#appointment_date", {
            dateFormat: "Y-m-d", // Set the format of the date
            minDate: "today",    // Disable past dates by setting the minimum date to today
            onChange: function(selectedDates, dateStr, instance) {
                const errorElement = document.getElementById('dateError');
                if (new Date(dateStr) < new Date()) {
                    errorElement.style.display = 'block'; // Show error if somehow a past date is selected
                } else {
                    errorElement.style.display = 'none'; // Hide error for valid dates
                }
            }
        });
    });


</script>

<!-- CSS for Mobile-Friendly Styling -->
<style>
/* Style for checkboxes */
.checkbox-wrap {
    margin-top: 10px;
    padding: 5px;
    border-radius: 5px;
    background-color: #f9f9f9;
}

.checkbox-wrap label {
    display: block;
    margin-bottom: 5px;
    font-size: 14px;
}

@media screen and (max-width: 600px) {
    .form-group {
        font-size: 14px;
    }
}
</style>