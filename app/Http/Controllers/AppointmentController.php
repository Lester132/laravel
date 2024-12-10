<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class AppointmentController extends Controller
{
    // Store a new appointment
    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_type' => 'required|array',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required|string',
        ]);
    
        // Create the appointment
        $appointment = Appointment::create([
            'user_id' => auth()->id(),
            'service_type' => implode(', ', $validated['service_type']),
            'appointment_date' => Carbon::parse($validated['appointment_date'])->format('Y-m-d'),
            'appointment_time' => $validated['appointment_time'],
            'status' => 'pending',
        ]);
    
        // Return a success response without the appointment details
        return response()->json([
            'success' => true,
            'message' => 'Appointment successfully booked!',
        ]);
    }
    
    
    
    

    // Display completed appointments
    public function indexCompleted(Request $request)
    {
        $filter = $request->get('filter', 'today');
        $query = Appointment::where('status', 'completed')->with('user');

        switch ($filter) {
            case 'week':
                $startOfWeek = Carbon::now()->startOfWeek();
                $endOfWeek = Carbon::now()->endOfWeek();
                $query->whereBetween('updated_at', [$startOfWeek, $endOfWeek]);
                break;
            case 'month':
                $startOfMonth = Carbon::now()->startOfMonth();
                $endOfMonth = Carbon::now()->endOfMonth();
                $query->whereBetween('updated_at', [$startOfMonth, $endOfMonth]);
                break;
            default: // 'today'
                $query->whereDate('updated_at', Carbon::today());
                break;
        }

        $completedAppointments = $query->paginate(10);

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

        return redirect()->route('pending')->with('success', 'Appointment marked as completed!');
    }

    // Cancel an appointment
    public function cancel($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->status = 'canceled';
        $appointment->updated_at = now();
        $appointment->save();

        return redirect()->route('pending')->with('success', 'Appointment canceled successfully!');
    }

     // Edit user information
  // In UserController


 
     // Update user information
     public function edit($id)
     {
         // Fetch user by id
         $user = User::findOrFail($id);
         
         // Pass user data to the view
         return view('adminpage.edit', compact('user'));
     }
     
     public function update(Request $request, $id)
     {
         $user = User::findOrFail($id);
     
         $validated = $request->validate([
             'first_name' => 'required|string|max:255',
             'last_name' => 'required|string|max:255',
        
             'phone' => 'required|string|max:15',
             'status' => 'required|in:active,inactive,deceased', 
         ]);
     
         $user->update($validated);
     
         return redirect()->route('users.index')->with('success', 'User updated successfully.');
     }
     
 
     // View user history (appointments)
     public function userHistory($id)
     {
         $user = User::findOrFail($id);
         $perPage = 10; // Number of records per page
         $appointments = $user->appointments()
             ->select('service_type', 'appointment_date as date', 'status')
             ->orderBy('appointment_date', 'desc')
             ->paginate($perPage);
     
         return response()->json([
             'account_created' => $user->created_at->format('F d, Y'),
             'history' => $appointments->items(),
             'total_pages' => $appointments->lastPage(),
             'current_page' => $appointments->currentPage(),
         ]);
     }
     
     
     


    // Delete a user
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);

        if ($user->appointments()->count() > 0) {
            return redirect()->route('users.index')->with('error', 'Cannot delete user with appointment records.');
        }

        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
