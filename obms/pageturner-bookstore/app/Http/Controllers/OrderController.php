<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->with('orderItems.book')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array',
            'items.*.book_id' => 'required|exists:books,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        $totalAmount = 0;
        $orderItems = [];

        foreach ($validated['items'] as $item) {
            $book = Book::findOrFail($item['book_id']);
            $quantity = $item['quantity'];

            if ($book->stock_quantity < $quantity) {
                return redirect()->back()
                    ->with('error', 'Not enough stock for book: ' . $book->title);
            }

            $totalAmount += $book->price * $quantity;
            $orderItems[] = [
                'book_id' => $book->id,
                'quantity' => $quantity,
                'unit_price' => $book->price,
            ];

            // Decrease stock
            $book->decrement('stock_quantity', $quantity);
        }

        $order = Order::create([
            'user_id' => Auth::id(),
            'total_amount' => $totalAmount,
            'status' => 'pending',
        ]);

        foreach ($orderItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'book_id' => $item['book_id'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
            ]);
        }

        return redirect()->route('orders.show', $order)
            ->with('success', 'Order placed successfully!');
    }

    public function show(Order $order)
    {
        // Ensure user can only view their own orders (or admin)
        if ($order->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403);
        }

        $order->load('orderItems.book', 'user');
        return view('orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }

        $validated = $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled',
        ]);

        $order->update($validated);

        return redirect()->back()
            ->with('success', 'Order status updated successfully!');
    }

    // Admin: View all orders
    public function adminIndex()
    {
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }

        $orders = Order::with('user', 'orderItems.book')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('orders.admin-index', compact('orders'));
    }
}
