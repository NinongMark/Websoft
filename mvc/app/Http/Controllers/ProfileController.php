<?php

// Namespace declaration - this file belongs to the App\Http\Controllers namespace
// Controllers handle HTTP requests and coordinate between Models and Views
namespace App\Http\Controllers;

// Import the User model to interact with the users table in the database
use App\Models\User;
// Import Request for handling HTTP request data (form inputs)
use Illuminate\Http\Request;
// Import Session for accessing user session data (to get current logged-in user's ID)
use Illuminate\Support\Facades\Session;
// Import Hash for secure password hashing (bcrypt)
use Illuminate\Support\Facades\Hash;

/**
 * ProfileController handles user profile operations.
 * Allows users to view and update their profile information.
 */
class ProfileController extends Controller
{
    /**
     * Display the current user's profile page.
     * Shows the user's name and email in a read-only format.
     * 
     * @return \Illuminate\View\View - Returns the profile show blade view with user data
     */
    public function show()
    {
        // Find the currently logged-in user by their ID stored in the session
        // This ensures users can only view their own profile
        $user = User::find(Session::get('user_id'));
        
        // Pass the user data to the profile view
        return view('profile.show', compact('user'));
    }

    /**
     * Update the current user's profile information.
     * Handles the form submission from the profile edit page.
     * 
     * @param Request $request - Contains name, email, and optionally password from the form
     * @return \Illuminate\Http\RedirectResponse - Redirects back to profile page with success message
     */
    public function update(Request $request)
    {
        // Find the currently logged-in user
        $user = User::find(Session::get('user_id'));
        
        // Validate the input:
        // - name: required (must be provided)
        // - email: required and must be a valid email format
        $request->validate([
            'name' => 'required',
            'email' => 'required|email'
        ]);

        // Update the user's name and email with the new values from the form
        $user->name = $request->name;
        $user->email = $request->email;
        
        // Only update password if a new password was provided in the form
        // This allows users to change their password without being required to
        // $request->filled('password') checks if the password field is not empty
        if ($request->filled('password')) {
            // Hash the new password using bcrypt before storing
            // We NEVER store plain-text passwords for security reasons
            $user->password = Hash::make($request->password);
        }
        
        // Save all the changes to the database
        $user->save();

        // Redirect back to the profile page with a success message
        return back()->with('success', 'Profile updated successfully');
    }
}
