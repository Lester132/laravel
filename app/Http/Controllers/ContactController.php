<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactInfo; // Ensure the model is imported

class ContactController extends Controller
{
    // Method to display the contact information page (for frontend)
    public function showContactPage()
    {
        // Retrieve the contact info
        $contactInfo = ContactInfo::first();

        // Pass the data to the contact page view
        return view('contact.contactpage', compact('contactInfo'));
    }

    // Method for displaying the contact update form (admin view)
    public function showUpdateForm()
    {
        // Retrieve the contact info
        $contactInfo = ContactInfo::first();

        // Pass the data to the update form view
        return view('adminpage.contentupdate', compact('contactInfo'));
    }

    // Method for updating the contact information (admin post)
    public function updateContactInfo(Request $request)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'email' => 'required|email',
            'facebook' => 'nullable|url',
        ]);
    
        // Retrieve the first contact info record
        $contactInfo = ContactInfo::first();
    
        // Update the contact information in the database
        $contactInfo->update([
            'address' => $validated['address'],
            'phone' => $validated['phone'],
            'email' => $validated['email'],
            'facebook' => $validated['facebook'],
        ]);
    
        // Redirect back to the admin contact page with a success message
        return redirect()->route('adminpage.contentupdate')->with('success', 'Contact information updated successfully!');
    }
    
}
