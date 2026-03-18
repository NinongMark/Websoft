@extends('layouts.app')

@section('title', 'My Orders - PageTurner')

@section('header')
    <h1 style="font-size: 1.875rem; font-weight: bold; color: #111827;">
        @if(auth()->user()->isAdmin())
            All Orders
        @else
            My Orders
        @endif
    </h1>
@endsection

@section('content')
@if($orders->count() > 0)
    <div class="card" style="overflow-x: auto;">
        <table class="table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    @if(auth()->user()->isAdmin())
                        <th>Customer</th>
                    @endif
                    <th>Date</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td>#{{ $order->id }}</td>
                        @if(auth()->user()->isAdmin())
                            <td>{{ $order->user->name }}</td>
                        @endif
                        <td>{{ $order->created_at->format('M d, Y') }}</td>
₱{{ number_format($order->total_amount, 2) }}
                        <td>
                            <span style="padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.875rem; font-weight: 500;
                                @if($order->status == 'completed') background: #d1fae5; color: #065f46;
                                @elseif($order->status == 'processing') background: #dbeafe; color: #1e40af;
                                @elseif($order->status == 'cancelled') background: #fee2e2; color: #991b1b;
                                @else background: #fef3c7; color: #92400e;
                                @endif">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('orders.show', $order) }}" style="color: #4f46e5;">View Details</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <div style="margin-top: 2rem;">
        {{ $orders->links() }}
    </div>
@else
    <div class="alert alert-info">
        No orders found.
    </div>
@endif
@endsection

