<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Rosario Dental Clinic</title>
    
    <!-- css -->

    @include('home.homecss')

  </head>
  <body>
    
  <nav class="navbar navbar-expand-lg ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
	    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
          <img src="images/nav_icon.png " alt="Rosario Clinic logo" width="100" height="auto">
      </a>
      

	      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
	        <span class="oi oi-menu"></span> Menu
	      </button>

	      <div class="collapse navbar-collapse" id="ftco-nav">
	        <ul class="navbar-nav ml-auto">
	          <li class="nav-item "><a href="{{ url('/') }}" class="nav-link">Home</a></li>
	          <li class="nav-item"><a href="{{ url('/about') }}" class="nav-link">About</a></li>
	          <li class="nav-item"><a href="{{ url('/services') }}" class="nav-link">Services</a></li>
			  <li class="nav-item active" ><a href="{{ url('/contact') }}" class="nav-link">Contact</a></li>
			  <li class="nav-item cta"><a href="contact.html" class="nav-link" data-toggle="modal" data-target="#modalRequest"><span>Make an Appointment</span></a></li>

			  @if (Route::has('login'))
			  @auth


			  <li class="nav-item" style="padding-top: 7px;">
    <x-app-layout></x-app-layout>
</li>
			  
			@else
	          <li class="nav-item"><a href="{{route('login')}}" class="nav-link">Login</a></li>
	    
	          <li class="nav-item"><a href="{{route('register')}}" class="nav-link">Register</a></li>
	         
			  @endauth
			  @endif

	        </ul>
	      </div>
	    </div>
	  </nav>
    <!-- END nav -->

    <section class="home-slider owl-carousel">
      <div class="slider-item bread-item" style="background-image: url('images/bg1.jpg');" data-stellar-background-ratio="0.5">
        <div class="overlay"></div>
        <div class="container" data-scrollax-parent="true">
          <div class="row slider-text align-items-end">
            <div class="col-md-7 col-sm-12 ftco-animate mb-5">
              <p class="breadcrumbs" data-scrollax=" properties: { translateY: '70%', opacity: 1.6}"><span class="mr-2"><a href="{{ url('/home') }}">Home</a></span> <span>Contact</span></p>
              <h1 class="mb-3" data-scrollax=" properties: { translateY: '70%', opacity: .9}">Contact Us</h1>
            </div>
          </div>
        </div>
      </div>
    </section>
		
		<section class="ftco-section contact-section ftco-degree-bg">
      <div class="container">
        <div class="row d-flex mb-5 contact-info">
          <div class="col-md-12 mb-4">
            <h2 class="h4">Contact Information</h2>
          </div>
          <div class="w-100"></div>
          <div class="col-md-3">
            <p><span>Address:</span> <a href="https://maps.app.goo.gl/2zNJs6eqdvCgNqVT7">
            Rosario Dental Clinic Cristina Bldg., Mc Arthur Highway, San Vicente, Urdaneta, Philippines
          </a>
          </p>
          </div>
          <div class="col-md-3">
            <p><span>Phone:</span> <a href="tel://0905 456 0625">
            0905 456 0625 </a></p>
          </div>
          <div class="col-md-3">
            <p><span>Email:</span> <a href="mailto:info@yoursite.com">Xample@gmail.com</a></p>
          </div>
          <div class="col-md-3">
            <p><span>Website</span> <a href="https://www.facebook.com/profile.php?id=61560554867743">Rosario Dental Clinic</a></p>
          </div>
        </div>
       
      </div>
    </section>

    
  

  <!-- loader -->
  <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg></div>

  <!-- Modal -->
  @include('home.modal')


  <script src="js/jquery.min.js"></script>
  <script src="js/jquery-migrate-3.0.1.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/jquery.easing.1.3.js"></script>
  <script src="js/jquery.waypoints.min.js"></script>
  <script src="js/jquery.stellar.min.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/jquery.magnific-popup.min.js"></script>
  <script src="js/aos.js"></script>
  <script src="js/jquery.animateNumber.min.js"></script>
  <script src="js/bootstrap-datepicker.js"></script>
  <script src="js/jquery.timepicker.min.js"></script>
  <script src="js/scrollax.min.js"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false"></script>
  <script src="js/google-map.js"></script>
  <script src="js/main.js"></script>
    
  </body>
</html>