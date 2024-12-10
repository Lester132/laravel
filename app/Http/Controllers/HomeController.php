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
        if (Auth::check() && Auth::user()->usertype === 'admin') {
            // Fetch today's and tomorrow's pending appointments
            $pendingAppointmentsToday = Appointment::where('status', 'pending')
                ->whereDate('appointment_date', \Carbon\Carbon::today()) // Filter by today's date
                ->with('user')
                ->paginate(10);
    
            $pendingAppointmentsTomorrow = Appointment::where('status', 'pending')
                ->whereDate('appointment_date', \Carbon\Carbon::tomorrow()) // Filter by tomorrow's date
                ->with('user')
                ->paginate(10);
    
            return view('adminpage.pending', compact('pendingAppointmentsToday', 'pendingAppointmentsTomorrow'));
        }
    
        return redirect()->route('home'); // Redirect if not authorized
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
        // Get the selected filter (start and end dates)
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');
    
        // Initialize the query for completed appointments
        $query = Appointment::where('status', 'completed')->with('user');
    
        // Apply filtering based on provided date range
        if ($startDate && $endDate) {
            $query->whereBetween('updated_at', [Carbon::parse($startDate)->startOfDay(), Carbon::parse($endDate)->endOfDay()]);
        } elseif ($startDate) {
            $query->whereDate('updated_at', Carbon::parse($startDate)->format('Y-m-d'));
        } elseif ($endDate) {
            $query->whereDate('updated_at', Carbon::parse($endDate)->format('Y-m-d'));
        } else {
            // Default to today's appointments if no date is selected
            $today = Carbon::today();
            $query->whereDate('updated_at', $today);
        }
    
        // Paginate results for better UI (10 per page)
        $completedAppointments = $query->paginate(10);
    
        // Return the view with the filtered appointments and selected dates
        return view('adminpage.completed', compact('completedAppointments', 'startDate', 'endDate'));
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

public function showUsers(Request $request)
{
    // Ensure only authenticated admins can access this method
    if (!Auth::check() || Auth::user()->usertype !== 'admin') {
        return redirect()->route('home'); // Redirect unauthorized users
    }

    // Trim and sanitize search input
    $search = trim($request->input('search'));

    // Initialize query to fetch users with usertype 'user'
    $query = User::where('usertype', 'user');

    // If a search term is provided, filter by name
    if ($search) {
        $searchTerms = explode(' ', $search); // Split search input into terms

        // Handle cases based on the number of terms
        $query->where(function ($query) use ($searchTerms) {
            if (count($searchTerms) === 2) {
                // Search by both first and last name
                $query->whereRaw('LOWER(first_name) LIKE ?', ['%' . strtolower($searchTerms[0]) . '%'])
                      ->whereRaw('LOWER(last_name) LIKE ?', ['%' . strtolower($searchTerms[1]) . '%']);
            } else {
                // Search by either first name or last name
                $query->whereRaw('LOWER(first_name) LIKE ?', ['%' . strtolower($searchTerms[0]) . '%'])
                      ->orWhereRaw('LOWER(last_name) LIKE ?', ['%' . strtolower($searchTerms[0]) . '%']);
            }
        });
    }

    // Retrieve the users with the count of their completed appointments
    $users = $query->withCount(['appointments as completed_appointments' => function ($query) {
        $query->where('status', 'completed');
    }])->get();

    // Return the view with the user data
    return view('adminpage.registered', compact('users'));
}





    
}
 