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
        return view('contact.contactpage');
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
    


    public function completedAppointments(Request $request)
    {
        // Get the selected filter, defaulting to 'today' if none is selected
        $filter = $request->get('filter', 'today'); 
    
        // Initialize the query for completed appointments
        $query = Appointment::where('status', 'completed')->with('user');
        
        // Apply filtering based on the selected filter
        switch ($filter) {
            case 'week':
                // Get the start and end of the current week (from Monday to Sunday)
                $startOfWeek = Carbon::now()->startOfWeek(); // Start of the current week (Monday)
                $endOfWeek = Carbon::now()->endOfWeek(); // End of the current week (Sunday)
                $query->whereBetween('updated_at', [$startOfWeek, $endOfWeek]);
                break;
    
            case 'month':
                // Get the start and end of the current month (from 1st to the last day of the month)
                $startOfMonth = Carbon::now()->startOfMonth(); // Start of the current month
                $endOfMonth = Carbon::now()->endOfMonth(); // End of the current month
                $query->whereBetween('updated_at', [$startOfMonth, $endOfMonth]);
                break;
    
            default: // 'today'
                // Filter by today (only appointments that were completed today)
                $today = Carbon::today(); // Get today's date
                $query->whereDate('updated_at', $today);
                break;
        }
    
        // Paginate results for better UI (10 per page)
        $completedAppointments = $query->paginate(10);
        
        // Return the view with the filtered appointments and selected filter
        return view('adminpage.completed', compact('completedAppointments', 'filter'));
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
    // Use paginate instead of get for pagination
    $expiredAppointments = Appointment::whereNotIn('status', ['accepted', 'completed'])
                                       ->where('appointment_date', '<', $today->endOfDay())  // Make sure to compare with the full day
                                       ->with('user') // Eager load associated user data
                                       ->paginate(10);  // Paginate results (10 items per page)

    // Return the view with the expired appointments data
    return view('adminpage.cancelled', compact('expiredAppointments'));
}




public function completed()
{
    return view('adminpage.completed'); // Ensure the contact.contactpage view exists
}
    
}
 