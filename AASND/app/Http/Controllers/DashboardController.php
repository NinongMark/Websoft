<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Models\Order;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Show the appropriate dashboard based on user role.
     */
    public function index()
    {
        if (Auth::user()->isAdmin()) {
            return $this->adminDashboard();
        }
        
        return $this->userDashboard();
    }

    /**
     * Show the admin dashboard.
     */
    public function adminDashboard()
    {
        // Get statistics
        $stats = [
            'total_users' => User::count(),
            'total_books' => Book::count(),
            'total_categories' => Category::count(),
            'total_orders' => Order::count(),
        ];

        // Get recent orders
        $recentOrders = Order::with('user')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // Get order status summary
        $orderStatusSummary = Order::select('status')
            ->selectRaw('COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        // Get recent reviews
        $recentReviews = Review::with(['user', 'book'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return view('dashboard.admin', compact(
            'stats',
            'recentOrders',
            'orderStatusSummary',
            'recentReviews'
        ));
    }

    /**
     * Show the user (customer) dashboard.
     */
    public function userDashboard()
    {
        $user = Auth::user();

        // Get order statistics
        $totalOrders = $user->orders()->count();
        
        // Get recent orders
        $recentOrders = $user->orders()
            ->with('orderItems.book')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Get order status counts
        $orderStatusCounts = $user->orders()
            ->select('status')
            ->selectRaw('COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        // Get recently purchased books
        $purchasedBooks = $user->orders()
            ->whereIn('status', ['processing', 'completed'])
            ->with('orderItems.book')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get()
            ->pluck('orderItems.*.book')
            ->flatten()
            ->unique('id')
            ->take(5);

        // Get user's reviews
        $userReviews = $user->reviews()
            ->with('book')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Account status
        $accountStatus = [
            'email_verified' => $user->hasVerifiedEmail(),
            'two_factor_enabled' => $user->isTwoFactorEnabled(),
        ];

        return view('dashboard.user', compact(
            'user',
            'totalOrders',
            'recentOrders',
            'orderStatusCounts',
            'purchasedBooks',
            'userReviews',
            'accountStatus'
        ));
    }
}

