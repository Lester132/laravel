<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

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
        $filter = $request->get('filter', 'today'); 
        
        $query = Appointment::where('status', 'completed')->with('user');
    
        // Apply filtering based on the selected filter
        switch ($filter) {
            case 'week':
                $query->whereBetween('updated_at', [
                    \Carbon\Carbon::now()->startOfWeek(),
                    \Carbon\Carbon::now()->endOfWeek()
                ]);
                break;
    
            case 'month':
                $query->whereYear('updated_at', \Carbon\Carbon::now()->year)
                      ->whereMonth('updated_at', \Carbon\Carbon::now()->month);
                break;
    
            default: // 'today'
                $query->whereDate('updated_at', \Carbon\Carbon::today());
                break;
        }
    
        $completedAppointments = $query->paginate(10); // Paginate results for better UI
    
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

    // Mark appointment as completed
    public function complete($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->status = 'completed';
        $appointment->updated_at = now();
        $appointment->save();

        return redirect()->route('appointments.pending')->with('success', 'Appointment marked as completed!');
    }

    // Mark appointment as canceled

}