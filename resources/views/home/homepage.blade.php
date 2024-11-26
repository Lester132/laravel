<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Rosario Dental Clinic</title>
 
    @include('home.homecss')
  </head>
  <body>
    
	  @include('home.header')
    <!-- END nav -->

  <!-- carousel -->
@include('home.carousel')

    <!-- end carousel -->

        <!-- appointment -->
@include('home.appointment')

        <!-- end appointment -->
  

         <!-- SERVICES -->
    
        @include('home.services')
           <!-- endSERVICES -->
   

       <!-- Achievements -->
    @include('home.achievements')

       <!-- end Achievements -->

         <!-- testimony -->
		@include('home.testimony')

    <!-- end testimony -->  
	
  <!-- gallery -->

  @include('home.gallery')

  <!-- end gallery -->
 

  <!-- loader -->
  <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg></div>

  <!-- Modal -->
@include('home.modal')
  <!-- END modal -->



  @include('home.scripts')
    
  </body>
</html>