@extends('layouts.app')

@section('title', 'Order #' . $order->id . ' - PageTurner')

@section('header')
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <h1 style="font-size: 1.875rem; font-weight: bold; color: #111827;">Order #{{ $order->id }}</h1>
<a href="{{ route('user.orders.index') }}" style="color: #4f46e5;">&larr; Back to Orders</a>
    </div>
@endsection

@section('content')
<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
    {{-- Order Items --}}
    <div>
        <div class="card">
            <h2 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 1rem;">Order Items</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Book</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->orderItems as $item)
                        <tr>
                            <td>
                                <div style="display: flex; align-items: center; gap: 1rem;">
                                    @if($item->book->cover_image)
                                        <img src="{{ asset('storage/' . $item->book->cover_image) }}" alt="{{ $item->book->title }}" style="width: 50px; height: 70px; object-fit: cover;">
                                    @else
                                        <div style="width: 50px; height: 70px; background: #e5e7eb; display: flex; align-items: center; justify-content: center;">
                                            <svg style="width: 24px; height: 24px; color: #9ca3af;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                            </svg>
                                        </div>
                                    @endif
                                    <div>
                                        <a href="{{ route('books.show', $item->book) }}" style="color: #4f46e5; font-weight: 500;">{{ $item->book->title }}</a>
                                        <p style="font-size: 0.875rem; color: #6b7280;">by {{ $item->book->author }}</p>
                                    </div>
                                </div>
                            </td>
                            ₱{{ number_format($item->unit_price, 2) }}
                            <td>{{ $item->quantity }}</td>
                            <td>₱{{ number_format($item->quantity * $item->unit_price, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
    {{-- Order Summary --}}
    <div>
        <div class="card">
            <h2 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 1rem;">Order Summary</h2>
            
            <div style="margin-bottom: 1rem;">
                <p style="color: #6b7280; font-size: 0.875rem;">Order ID</p>
                <p style="font-weight: 500;">#{{ $order->id }}</p>
            </div>
            
            <div style="margin-bottom: 1rem;">
                <p style="color: #6b7280; font-size: 0.875rem;">Date</p>
                <p style="font-weight: 500;">{{ $order->created_at->format('M d, Y h:i A') }}</p>
            </div>
            
            <div style="margin-bottom: 1rem;">
                <p style="color: #6b7280; font-size: 0.875rem;">Customer</p>
                <p style="font-weight: 500;">{{ $order->user->name }}</p>
                <p style="font-size: 0.875rem; color: #6b7280;">{{ $order->user->email }}</p>
            </div>
            
            <div style="margin-bottom: 1rem;">
                <p style="color: #6b7280; font-size: 0.875rem;">Status</p>
                <span style="padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.875rem; font-weight: 500;
                    @if($order->status == 'completed') background: #d1fae5; color: #065f46;
                    @elseif($order->status == 'processing') background: #dbeafe; color: #1e40af;
                    @elseif($order->status == 'cancelled') background: #fee2e2; color: #991b1b;
                    @else background: #fef3c7; color: #92400e;
                    @endif">
                    {{ ucfirst($order->status) }}
                </span>
            </div>
            
            @auth
                @if(auth()->user()->isAdmin())
                    <div style="margin-bottom: 1rem;">
                        <p style="color: #6b7280; font-size: 0.875rem; margin-bottom: 0.5rem;">Update Status</p>
                        <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <select name="status" style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem; margin-bottom: 0.5rem;">
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                            <button type="submit" class="btn btn-primary" style="width: 100%; padding: 0.5rem;">
                                Update Status
                            </button>
                        </form>
                    </div>
                @endif
            @endauth
            
            <div style="border-top: 1px solid #e5e7eb; padding-top: 1rem; margin-top: 1rem;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <p style="font-size: 1.125rem; font-weight: 600;">Total</p>
                    <p style="font-size: 1.25rem; font-weight: 700; color: #4f46e5;">₱{{ number_format($order->total_amount, 2) }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
