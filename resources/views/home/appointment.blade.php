<section class="ftco-intro">
    	<div class="container">
    		<div class="row no-gutters">
    			<div class="col-md-3 color-1 p-4">
    				<h3 class="mb-4">Contact Us</h3>
    				<p>Have a concern? Our team is here to help. Reach out at:</p>
    				<span class="phone-number">+(63) 9054560625 /           +(63) 9760947795</span>
    			</div>
    			<div class="col-md-3 color-2 p-4">
    				<h3 class="mb-4">Opening Hours</h3>
    				<p class="openinghours d-flex">
    					<span>Monday </span>
    					<span>8:00 AM - 5:00 PM</span>
    				</p>
    				<p class="openinghours d-flex">
    					<span>Saturday</span>
    					<span>8:00 AM - 5:00 PM</span>
    				</p>
    				
    			</div>
    			<div class="col-md-6 color-3 p-4">
    <h3 class="mb-2">Make an Appointment</h3>
    <form action="{{ route('appointments.store') }}" method="POST" class="appointment-form">
        @csrf <!-- CSRF token for security -->

        <div class="row">
            <!-- Service Type Dropdown -->
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="select-wrap">
                        <div class="icon"><span class="ion-ios-arrow-down"></span></div>
                        <select name="service_type" class="form-control" required>
                            <option value="">Service type</option>
                            <option value="Dental Consultation">Dental Consultation</option>
                            <option value="Tooth Extraction">Tooth Extraction</option>
                            <option value="Dental Filling">Dental Filling</option>
                            <option value="Dental Crown">Dental Crown</option>
                            <option value="Dental Bridge">Dental Bridge</option>
                            <option value="Dental Implant">Dental Implant</option>
                            <option value="Root Canal Treatment">Root Canal Treatment</option>
                            <option value="Dental Cleaning">Dental Cleaning</option>
                            <option value="Teeth Whitening">Teeth Whitening</option>
                            <option value="Teeth Cleaning">Teeth Cleaning</option>
                            <option value="Quality Brackets">Quality Brackets</option>
                            <option value="Modern Anesthetic">Modern Anesthetic</option>
                            <option value="Dental Calculus">Dental Calculus</option>
                            <option value="Paradontosis">Paradontosis</option>
                            <option value="Dental Implants">Dental Implants</option>
                            <option value="Tooth Braces">Tooth Braces</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Date Field -->
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="icon"><span class="ion-ios-calendar"></span></div>
                    <input type="text" name="appointment_date" class="form-control appointment_date" placeholder="Select Date" required>
                </div>    
            </div>

            <!-- Time Field -->
            <div class="col-sm-4">
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

        <!-- Success and Error Messages -->
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
    </section>