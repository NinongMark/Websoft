<?php

namespace App\Http\Controllers;

// Import the User model to interact with the users table in the database
use App\Models\User;
// Import Request for handling HTTP request data
use Illuminate\Http\Request;
// Import Hash for secure password hashing (bcrypt)
use Illuminate\Support\Facades\Hash;
// Import Session for managing user sessions (login state)
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    /**
     * Display the login form.
     * This function renders the login blade view for user authentication.
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Handle user login authentication.
     * Validates credentials and creates a session if successful.
     * 
     * @param Request $request - Contains email and password from the login form
     * @return \Illuminate\Http\RedirectResponse - Redirects to tasks page on success, back with errors on failure
     */
    public function login(Request $request)
    {
        // Validate that email and password are provided and email is in correct format
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Query the database to find a user with the provided email
        $user = User::where('email', $request->email)->first();

        // Check if user exists AND password matches (Hash::check compares plain text against hashed password)
        if ($user && Hash::check($request->password, $user->password)) {
            // Store user's ID in session to track their login state
            // This allows us to identify the user across different requests
            Session::put('user_id', $user->id);
            return redirect('/tasks')->with('success', 'Logged in successfully');
        }

        // Return back with error message if credentials don't match
        return back()->withErrors(['email' => 'Invalid credentials']);
    }

    /**
     * Display the registration form for new users.
     * This function renders the registration blade view.
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Handle new user registration.
     * Validates input, creates user record, and automatically logs them in.
     * 
     * @param Request $request - Contains name, email, password, and password_confirmation
     * @return \Illuminate\Http\RedirectResponse - Redirects to tasks page after successful registration
     */
    public function register(Request $request)
    {
        // Validate registration data:
        // - name: required, must be string, max 255 characters
        // - email: required, must be valid email format, must be unique in users table
        // - password: required, minimum 6 characters, must match password_confirmation field
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed'
        ]);

        // Create new user in the database with hashed password
        // Hash::make() creates a bcrypt hash of the password for secure storage
        // We NEVER store plain-text passwords for security reasons
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        // Automatically log in the new user by storing their ID in session
        Session::put('user_id', $user->id);

        return redirect('/tasks')->with('success', 'Registered successfully');
    }

    /**
     * Handle user logout.
     * Clears the user session and redirects to login page.
     * 
     * @return \Illuminate\Http\RedirectResponse - Redirects to login page
     */
    public function logout()
    {
        // Remove user_id from session to log the user out
        Session::forget('user_id');
        return redirect('/login')->with('success', 'Logged out successfully');
    }
}
