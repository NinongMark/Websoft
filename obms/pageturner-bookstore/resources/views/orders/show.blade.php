@extends('layouts.app')

@section('title', 'Order Details - PageTurner')

@section('header')
<div class="flex justify-between items-center">
    <h1 class="text-3xl font-bold text-white">Order #{{ $order->id }}</h1>
    @auth
    @if(auth()->user()->isAdmin())
    <form action="{{ route('orders.updateStatus', $order) }}" method="POST" class="flex items-center gap-2">
        @csrf
        @method('PATCH')
        <select name="status" class="bg-gray-700 border-gray-600 text-white rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
            <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed</option>
            <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
        </select>
        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition">
            Update Status
        </button>
    </form>
    @endif
    @endauth
</div>
@endsection

@section('content')
<div class="bg-gray-800 rounded-lg shadow p-6 mb-6 border border-gray-700">
    <div class="grid grid-cols-2 gap-4 mb-6">
        <div>
            <h3 class="text-lg font-semibold mb-2 text-white">Order Information</h3>
            <p class="text-gray"><strong>Order-300 ID:</strong> #{{ $order->id }}</p>
            <p class="text-gray-300"><strong>Date:</strong> {{ $order->created_at->format('F j, Y g:i A') }}</p>
            <p class="text-gray-300"><strong>Status:</strong> 
                <span class="inline-block px-3 py-1 text-sm font-semibold rounded-full 
                    @if($order->status === 'completed') bg-green-900 text-green-300
                    @elseif($order->status === 'processing') bg-blue-900 text-blue-300
                    @elseif($order->status === 'cancelled') bg-red-900 text-red-300
                    @else bg-yellow-900 text-yellow-300 @endif">
                    {{ ucfirst($order->status) }}
                </span>
            </p>
        </div>
        <div>
            <h3 class="text-lg font-semibold mb-2 text-white">Customer Information</h3>
            <p class="text-gray-300"><strong>Name:</strong> {{ $order->user->name }}</p>
            <p class="text-gray-300"><strong>Email:</strong> {{ $order->user->email }}</p>
        </div>
    </div>
    
    <div class="border-t border-gray-700 pt-6">
        <h3 class="text-lg font-semibold mb-4 text-white">Order Items</h3>
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-700">
                    <th class="text-left py-2 text-gray-300">Book</th>
                    <th class="text-center py-2 text-gray-300">Quantity</th>
                    <th class="text-right py-2 text-gray-300">Unit Price</th>
                    <th class="text-right py-2 text-gray-300">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->orderItems as $item)
                <tr class="border-b border-gray-700">
                    <td class="py-3">
                        <a href="{{ route('books.show', $item->book) }}" class="text-indigo-400 hover:underline">
                            {{ $item->book->title }}
                        </a>
                        <p class="text-sm text-gray-500">by {{ $item->book->author }}</p>
                    </td>
                    <td class="text-center py-3 text-gray-300">{{ $item->quantity }}</td>
                    <td class="text-right py-3 text-gray-300">${{ number_format($item->unit_price, 2) }}</td>
                    <td class="text-right py-3 text-gray-300">${{ number_format($item->unit_price * $item->quantity, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="text-right py-3 font-semibold text-white">Total:</td>
                    <td class="text-right py-3 font-bold text-xl text-indigo-400">${{ number_format($order->total_amount, 2) }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
    
    <div class="mt-6">
        <a href="{{ route('orders.index') }}" class="text-indigo-400 hover:underline">
            ← Back to My Orders
        </a>
    </div>
</div>
@endsection

