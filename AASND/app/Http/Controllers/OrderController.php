<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Notifications\NewOrderNotification;
use App\Notifications\OrderPlacedNotification;
use App\Notifications\OrderStatusChangedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the user's orders.
     */
    public function index()
    {
        if (Auth::user()->isAdmin()) {
            $orders = Order::with('user', 'orderItems.book')->orderBy('created_at', 'desc')->paginate(10);
        } else {
            $orders = Auth::user()->orders()->with('orderItems.book')->orderBy('created_at', 'desc')->paginate(10);
        }
        
        return view('orders.index', compact('orders'));
    }

    /**
     * Store a newly created order in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'book_id' => 'required|exists:books,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $book = Book::findOrFail($validated['book_id']);

        if ($book->stock_quantity < $validated['quantity']) {
            return back()->with('error', 'Not enough stock available.');
        }

        // Create order
        $order = Order::create([
            'user_id' => Auth::id(),
            'total_amount' => $book->price * $validated['quantity'],
            'status' => 'pending',
        ]);

        // Create order item
        OrderItem::create([
            'order_id' => $order->id,
            'book_id' => $book->id,
            'quantity' => $validated['quantity'],
            'unit_price' => $book->price,
        ]);

        // Decrease stock
        $book->decrement('stock_quantity', $validated['quantity']);

        // Send notification to customer
        $order->user->notify(new OrderPlacedNotification($order));

        // Send notification to admin
        $admin = User::where('role', 'admin')->first();
        if ($admin) {
            $admin->notify(new NewOrderNotification($order));
        }

        return redirect()->route('orders.show', $order)
            ->with('success', 'Order placed successfully!');
    }

    /**
     * Display the specified order.
     */
    public function show(Order $order)
    {
        // Check authorization
        if (!Auth::user()->isAdmin() && $order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->load('orderItems.book', 'user');

        return view('orders.show', compact('order'));
    }

    /**
     * Update the order status.
     */
    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled',
        ]);

        $oldStatus = $order->status;
        $order->update(['status' => $validated['status']]);

        // Send notification to customer about status change
        $order->user->notify(new OrderStatusChangedNotification($order, $oldStatus, $validated['status']));

        return back()->with('success', 'Order status updated successfully!');
    }
}

