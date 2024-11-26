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
	          <li class="nav-item active"><a href="{{ url('/') }}" class="nav-link">Home</a></li>
	          <li class="nav-item"><a href="{{ url('/about') }}" class="nav-link">About</a></li>
	          <li class="nav-item"><a href="{{ url('/services') }}" class="nav-link">Services</a></li>
			  <li class="nav-item"><a href="{{ url('/contact') }}" class="nav-link">Contact</a></li>
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