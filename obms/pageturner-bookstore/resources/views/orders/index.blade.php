@extends('layouts.app')

@section('title', 'My Orders - PageTurner')

@section('header')
<h1 class="text-3xl font-bold text-white">My Orders</h1>
@endsection

@section('content')
@if($orders->count() > 0)
<div class="space-y-4">
    @foreach($orders as $order)
    <div class="bg-gray-800 rounded-lg shadow p-6 border border-gray-700">
        <div class="flex justify-between items-start mb-4">
            <div>
                <h3 class="text-lg font-semibold text-white">Order #{{ $order->id }}</h3>
                <p class="text-gray-500 text-sm">{{ $order->created_at->format('F j, Y g:i A') }}</p>
            </div>
            <div class="text-right">
                <p class="text-xl font-bold text-indigo-400">${{ number_format($order->total_amount, 2) }}</p>
                <span class="inline-block px-3 py-1 text-sm font-semibold rounded-full 
                    @if($order->status === 'completed') bg-green-900 text-green-300
                    @elseif($order->status === 'processing') bg-blue-900 text-blue-300
                    @elseif($order->status === 'cancelled') bg-red-900 text-red-300
                    @else bg-yellow-900 text-yellow-300 @endif">
                    {{ ucfirst($order->status) }}
                </span>
            </div>
        </div>
        
        <div class="border-t border-gray-700 pt-4">
            <h4 class="font-medium mb-2 text-white">Order Items:</h4>
            @foreach($order->orderItems as $item)
            <div class="flex justify-between items-center py-2">
                <div class="flex items-center">
                    <span class="text-gray-400">{{ $item->quantity }}x</span>
                    <a href="{{ route('books.show', $item->book) }}" class="ml-2 text-indigo-400 hover:underline">
                        {{ $item->book->title }}
                    </a>
                </div>
                <span class="text-gray-400">${{ number_format($item->unit_price * $item->quantity, 2) }}</span>
            </div>
            @endforeach
        </div>
        
        <div class="mt-4">
            <a href="{{ route('orders.show', $order) }}" class="text-indigo-400 hover:underline">
                View Details →
            </a>
        </div>
    </div>
    @endforeach
</div>

{{-- Pagination --}}
<div class="mt-8">
    {{ $orders->links() }}
</div>
@else
<div class="bg-gray-800 border border-gray-700 text-gray-300 px-4 py-3 rounded relative">
    You haven't placed any orders yet. <a href="{{ route('books.index') }}" class="underline text-indigo-400">Browse books</a> to start shopping!
</div>
@endif
@endsection

