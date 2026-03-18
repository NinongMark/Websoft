<?php

// Namespace declaration - this file belongs to the App\Http\Middleware namespace
// Middleware provides a way to filter HTTP requests entering the application
namespace App\Http\Middleware;

// Import Closure type hint for the $next parameter (represents the next middleware/controller)
use Closure;
// Import Request for handling HTTP request data
use Illuminate\Http\Request;
// Import Session for checking if user is logged in
use Illuminate\Support\Facades\Session;
// Import Response type hint for the return type
use Symfony\Component\HttpFoundation\Response;

/**
 * AuthCheck Middleware - Protects routes that require authentication.
 * 
 * This middleware runs before a request reaches the controller.
 * If the user is not logged in (no user_id in session), they are redirected to the login page.
 * This ensures only authenticated users can access protected routes like tasks and profile.
 */
class AuthCheck
{
    /**
     * Handle an incoming request.
     * This is the main method that gets executed for each HTTP request to protected routes.
     *
     * @param Request $request - The incoming HTTP request
     * @param Closure $next - A closure that passes the request to the next middleware or controller
     * @return Response - Either redirects to login or continues to the requested page
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user is logged in by looking for user_id in the session
        // Session::has('user_id') returns true if 'user_id' exists in the session
        if (!Session::has('user_id')) {
            // User is not logged in - redirect to the login page
            return redirect('/login');
        }
        
        // User is logged in - allow the request to continue to the controller
        // $next($request) passes the request to the next middleware or the requested controller
        return $next($request);
    }
}
