<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;


class AppointmentController extends Controller
{
    // Store a new appointment
    public function store(Request $request)
    {
        // Validate input data
        $validated = $request->validate([
            'service_type' => 'required|array', // Expecting an array for service types
            'appointment_date' => 'required|date',
            'appointment_time' => 'required|string',
        ]);
    
        // Process and store the appointment
        $appointment = Appointment::create([
            'user_id' => auth()->id(),
            'service_type' => implode(', ', $validated['service_type']), // Convert array to string
            'appointment_date' => Carbon::parse($validated['appointment_date'])->format('Y-m-d'),
            'appointment_time' => $validated['appointment_time'],
            'status' => 'pending',  // Default status
        ]);
    
        // Return a JSON response indicating success
        return response()->json([
            'success' => true,
            'message' => 'Appointment successfully booked!',
            'appointment' => $appointment,
        ]);
    }
    

    // Display completed appointments
    public function indexCompleted(Request $request)
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
                Log::info("Filtering appointments for the week: Start - $startOfWeek, End - $endOfWeek"); // Debug log
                $query->whereBetween('updated_at', [$startOfWeek, $endOfWeek]);
                break;

            case 'month':
                // Get the start and end of the current month (from 1st to the last day of the month)
                $startOfMonth = Carbon::now()->startOfMonth(); // Start of the current month
                $endOfMonth = Carbon::now()->endOfMonth(); // End of the current month
                Log::info("Filtering appointments for the month: Start - $startOfMonth, End - $endOfMonth"); // Debug log
                $query->whereBetween('updated_at', [$startOfMonth, $endOfMonth]);
                break;

            default: // 'today'
                // Filter by today (only appointments that were completed today)
                $today = Carbon::today(); // Get today's date
                Log::info("Filtering appointments for today: $today"); // Debug log
                $query->whereDate('updated_at', $today);
                break;
        }
        
        // Paginate results for better UI (10 per page)
        $completedAppointments = $query->paginate(10);
        
        // Return the view with the filtered appointments and selected filter
        return view('adminpage.completed', compact('completedAppointments', 'filter'));
    }
    

    // Display pending appointments
    public function indexPending()
    {
        $pendingAppointments = Appointment::where('status', 'pending')
                                          ->with('user')
                                          ->paginate(10);
        return view('adminpage.pending', compact('pendingAppointments'));
    }

    // Mark appointment as completed// AppointmentController.php

// AppointmentController.php

public function complete($id)
{
    $appointment = Appointment::findOrFail($id);
    $appointment->status = 'completed';
    $appointment->updated_at = now();
    $appointment->save();

    return redirect()->route('pending')->with('success', 'Appointment marked as completed!');
}

public function cancel($id)
{
    $appointment = Appointment::findOrFail($id);
    $appointment->status = 'canceled';
    $appointment->updated_at = now();
    $appointment->save();

    return redirect()->route('pending')->with('success', 'Appointment canceled successfully!');
}



}