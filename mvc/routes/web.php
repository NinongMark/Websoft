<?php

// Import the Route facade - Laravel's way of defining routes
use Illuminate\Support\Facades\Route;
// Import the AuthController for handling authentication (login, register, logout)
use App\Http\Controllers\AuthController;
// Import the ProfileController for handling user profile operations
use App\Http\Controllers\ProfileController;
// Import the TaskController for handling task CRUD operations
use App\Http\Controllers\TaskController;


// ============================================================
// AUTHENTICATION ROUTES (Public - accessible to everyone)
// ============================================================

// Show the login form - GET request to /login
// ->name('login') gives this route a named identifier for use in code
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');

// Handle login form submission - POST request to /login
// This validates credentials and creates a session
Route::post('/login', [AuthController::class, 'login']);

// Show the registration form - GET request to /register
Route::get('/register', [AuthController::class, 'showRegister']);

// Handle registration form submission - POST request to /register
// This creates a new user account and logs them in
Route::post('/register', [AuthController::class, 'register']);

// Handle logout - POST request to /logout
// This clears the user session and logs them out
Route::post('/logout', [AuthController::class, 'logout']);

// ============================================================
// PROTECTED ROUTES (Require authentication)
// ============================================================

// Route::middleware() applies authentication middleware to all routes in this group
// The AuthCheck middleware checks if user_id exists in session
// If not logged in, user is redirected to /login
Route::middleware('auth.check')->group(function () {
    
    // -----------------
    // TASK ROUTES
    // -----------------
    
    // Display all tasks for the logged-in user
    Route::get('/tasks', [TaskController::class, 'index']);
    
    // Show the form for creating a new task
    Route::get('/tasks/create', [TaskController::class, 'create']);
    
    // Handle the form submission for creating a new task
    Route::post('/tasks', [TaskController::class, 'store']);
    
    // Show the form for editing an existing task (/{id} is a URL parameter)
    Route::get('/tasks/{id}/edit', [TaskController::class, 'edit']);
    
    // Handle the form submission for updating a task
    // PUT method is used for updating existing resources
    Route::put('/tasks/{id}', [TaskController::class, 'update']);
    
    // Handle deleting a task
    // DELETE method is used for deleting resources
    Route::delete('/tasks/{id}', [TaskController::class, 'destroy']);
    
    // -----------------
    // PROFILE ROUTES
    // -----------------
    
    // Display the user's profile page
    Route::get('/profile', [ProfileController::class, 'show']);
    
    // Handle profile update form submission
    // PUT method is used for updating existing resources
    Route::put('/profile', [ProfileController::class, 'update']);
});

// ============================================================
// ROOT ROUTE
// ============================================================

// Redirect the root URL (/) to the login page
// This is the entry point when users visit the application
Route::get('/', function () {
    return redirect('/login');
});
