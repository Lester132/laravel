<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Appointment; 
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Handle the index route.
     * Redirect users based on their authentication and usertype.
     */
    public function pendingpage()
    {
        // Ensure only admin can access this page
        if (Auth::check() && Auth::user()->usertype === 'admin') {
            // Fetch all appointments that are 'pending'
            $pendingAppointments = Appointment::where('status', 'pending')
                                                ->with('user')  // Eager load the associated user
                                                ->get();

            // Pass the appointments to the view
            return view('adminpage.pending', compact('pendingAppointments'));
        }

        // Redirect unauthorized users to the home page
        return redirect()->route('home');
    }

    /**
     * Render the homepage for regular users.
     */
    public function homepage()
    {
        return view('home.homepage'); // Ensure the home.homepage view exists
    }

    /**
     * Render the about page.
     */
    public function aboutpage()
    {
        return view('about.aboutpage'); // Ensure the about.aboutpage view exists
    }

    /**
     * Render the services page.
     */
    public function servicespage()
    {
        return view('services.servicespage'); // Ensure the services.servicespage view exists
    }

    /**
     * Render the contact page.
     */
    public function contactpage()
    {
        return view('contact.contactpage'); // Ensure the contact.contactpage view exists
    }

    /**
     * Render the admin dashboard.
     */
    public function dashboard()
    {
        if (Auth::check() && Auth::user()->usertype === 'admin') {
            $userCount = User::where('usertype', 'user')->count();
            $pendingCount = Appointment::where('status', 'pending')
                                       ->whereDate('appointment_date', Carbon::today('Asia/Manila'))
                                       ->count();
            $completedCount = Appointment::where('status', 'completed')
                                          ->whereDate('updated_at', Carbon::today('Asia/Manila'))
                                          ->count();

            $expiredAppointmentsCount = Appointment::whereNotIn('status', ['accepted', 'completed'])
                                          ->where('appointment_date', '<', \Carbon\Carbon::today('Asia/Manila')->endOfDay())
                                          ->count(); // Count of expired appointments                           
    
            return view('adminpage.dashboard', compact('userCount', 'pendingCount', 'completedCount', 'expiredAppointmentsCount'));
        }
    
        return redirect()->route('home');
    }
    

    /**
     * Fetch completed appointments for today.
     */
/**
 * Fetch completed appointments for today.
 */
public function completedAppointments()
{
    $today = Carbon::today('Asia/Manila'); // Ensure correct timezone
    $completedAppointments = Appointment::where('status', 'completed')
                                    ->whereDate('updated_at', $today)
                                    ->with('user')
                                    ->paginate(10);
return view('adminpage.completed', compact('completedAppointments'));

}

public function completedCount()
{
    $today = \Carbon\Carbon::today('Asia/Manila'); // Set timezone explicitly
    $completedCount = Appointment::where('status', 'completed')
                                 ->whereDate('updated_at', $today)
                                 ->count();

    return response()->json(['completedCount' => $completedCount]);
}
public function expiredAppointments()
{
    // Get the current date with timezone consideration
    $today = \Carbon\Carbon::today('Asia/Manila');

    // Fetch appointments that are not accepted or completed and whose date has passed
    $expiredAppointments = Appointment::whereNotIn('status', ['accepted', 'completed'])
                                       ->where('appointment_date', '<', $today->endOfDay())  // Make sure to compare with the full day
                                       ->with('user') // Eager load associated user data
                                       ->get();

    // Return the view with the expired appointments data
    return view('adminpage.cancelled', compact('expiredAppointments'));
}



public function completed()
{
    return view('adminpage.completed'); // Ensure the contact.contactpage view exists
}
    
}
 