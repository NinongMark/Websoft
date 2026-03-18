@extends('layouts.app')

@section('title', 'Dashboard - PageTurner')

@push('styles')
<style>
.dashboard-hero {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
  border-radius: 20px;
  padding: 2rem;
  margin-bottom: 2rem;
  position: relative;
  overflow: hidden;
}
.dashboard-hero::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
}
.stat-card {
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  border: none;
  border-radius: 20px;
  backdrop-filter: blur(10px);
}
.stat-card:hover {
  transform: translateY(-10px);
  box-shadow: 0 20px 40px rgba(0,0,0,0.2);
}
.icon-box {
  width: 60px;
  height: 60px;
  border-radius: 15px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.5rem;
}
.book-card-small {
  border-radius: 15px;
  overflow: hidden;
  transition: transform 0.3s ease;
}
.book-card-small:hover {
  transform: scale(1.05);
}
@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translateY(30px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}
.fade-in-up {
  animation: fadeInUp 0.6s ease forwards;
}
</style>
@endpush

@section('content')
<div class="py-5" style="background: linear-gradient(to bottom, #f8fafc, #e2e8f0); min-height: 100vh;">
  <div class="container">
    <!-- Hero Welcome Section -->
    <div class="dashboard-hero position-relative fade-in-up">
      <div class="row align-items-center">
        <div class="col-md-8">
          <h1 class="display-4 fw-bold mb-3">Welcome back, {{ $user->name }}!</h1>
          <p class="lead mb-0">Your personalized dashboard with everything you need at a glance.</p>
        </div>
        <div class="col-md-4 text-end">
          <div class="avatar-lg mx-auto" style="width: 120px; height: 120px; border-radius: 50%; background: rgba(255,255,255,0.2); display: flex; align-items: center; justify-content: center; font-size: 3rem; margin: 0 auto 1rem;">
            {{ strtoupper(substr($user->name, 0, 1)) }}
          </div>
        </div>
      </div>
    </div>

    <!-- Status Alerts -->
    @if(!$accountStatus['email_verified'])
    <div class="alert alert-warning border-start border-5 border-warning shadow-sm fade-in-up" role="alert">
      <div class="d-flex">
        <div class="flex-shrink-0">
          <i class="bi bi-exclamation-triangle-fill fs-3 text-warning"></i>
        </div>
        <div class="flex-grow-1 ms-3">
          <strong>Email Verification Required</strong>
          <p class="mb-0">Verify your email to place orders and write reviews.</p>
          <a href="{{ route('verification.notice') }}" class="btn btn-warning btn-sm mt-2">Verify Now</a>
        </div>
      </div>
    </div>
    @endif

    <!-- Stats Grid -->
    <div class="row g-4 mb-5">
      <div class="col-lg-3 col-md-6">
        <div class="card stat-card bg-gradient-primary text-white shadow-lg">
          <div class="card-body text-center">
            <div class="icon-box bg-white bg-opacity-20 mb-3">
              <i class="bi bi-cart-fill"></i>
            </div>
            <h3 class="fw-bold">{{ $totalOrders }}</h3>
            <p class="mb-0">Total Orders</p>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6">
        <div class="card stat-card bg-gradient-success text-white shadow-lg">
          <div class="card-body text-center">
            <div class="icon-box bg-white bg-opacity-20 mb-3">
              <i class="bi bi-book-fill"></i>
            </div>
            <h3 class="fw-bold">{{ count($purchasedBooks) }}</h3>
            <p class="mb-0">Purchased Books</p>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6">
        <div class="card stat-card bg-gradient-info text-white shadow-lg">
          <div class="card-body text-center">
            <div class="icon-box bg-white bg-opacity-20 mb-3">
              <i class="bi bi-star-fill"></i>
            </div>
            <h3 class="fw-bold">{{ $userReviews->count() }}</h3>
            <p class="mb-0">Reviews Written</p>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6">
        <div class="card stat-card bg-gradient-warning text-white shadow-lg">
          <div class="card-body text-center">
            <div class="icon-box bg-white bg-opacity-20 mb-3">
              <i class="bi bi-shield-fill"></i>
            </div>
            <span class="badge bg-light text-dark fs-6">{{ $accountStatus['email_verified'] ? 'Verified' : 'Pending' }}</span>
            <br><br>
            <span class="badge bg-light text-dark fs-6">{{ $accountStatus['two_factor_enabled'] ? '2FA On' : '2FA Off' }}</span>
            <p class="mb-0 mt-2 small">Account Status</p>
          </div>
        </div>
      </div>
    </div>

    <div class="row g-4">
      <!-- Quick Actions -->
      <div class="col-lg-4">
        <div class="card stat-card shadow-lg border-0 fade-in-up">
          <div class="card-header bg-transparent border-0 pb-0">
            <h5 class="card-title mb-0">Quick Actions</h5>
          </div>
          <div class="card-body pt-0">
            <div class="list-group list-group-flush">
              <a href="{{ route('books.index') }}" class="list-group-item list-group-item-action px-0 border-0">
                <div class="d-flex align-items-center">
                  <div class="bg-primary bg-opacity-10 text-primary rounded-circle p-2 me-3">
                    <i class="bi bi-book-half fs-5"></i>
                  </div>
                  <div>
                    <h6 class="mb-1">Browse Books</h6>
                    <small class="text-muted">Discover new reads</small>
                  </div>
                </div>
              </a>
              <a href="{{ route('user.orders.index') }}" class="list-group-item list-group-item-action px-0 border-0">
                <div class="d-flex align-items-center">
                  <div class="bg-success bg-opacity-10 text-success rounded-circle p-2 me-3">
                    <i class="bi bi-receipt fs-5"></i>
                  </div>
                  <div>
                    <h6 class="mb-1">Order History</h6>
                    <small class="text-muted">Track your purchases</small>
                  </div>
                </div>
              </a>
              <a href="{{ route('profile.edit') }}" class="list-group-item list-group-item-action px-0 border-0">
                <div class="d-flex align-items-center">
                  <div class="bg-info bg-opacity-10 text-info rounded-circle p-2 me-3">
                    <i class="bi bi-person fs-5"></i>
                  </div>
                  <div>
                    <h6 class="mb-1">Edit Profile</h6>
                    <small class="text-muted">Update your info</small>
                  </div>
                </div>
              </a>
            </div>
          </div>
        </div>
      </div>

      <!-- Recent Orders -->
      <div class="col-lg-8">
        <div class="card stat-card shadow-lg border-0 fade-in-up">
          <div class="card-header bg-transparent border-0 pb-2">
            <div class="d-flex justify-content-between align-items-center">
              <h5 class="mb-0">Recent Orders</h5>
              <a href="{{ route('user.orders.index') }}" class="btn btn-outline-primary btn-sm">View All</a>
            </div>
          </div>
          <div class="card-body p-0">
            @forelse($recentOrders as $index => $order)
            <div class="border-bottom p-3 {{ $index < $recentOrders->count() - 1 ? 'border-end-0' : '' }}">
              <div class="row align-items-center">
                <div class="col-md-2">
                  <span class="fw-bold text-primary">#{{ $order->id }}</span>
                </div>
                <div class="col-md-5">
                  <h6 class="mb-1">{{ $order->created_at->format('M d, Y H:i') }}</h6>
                  <small class="text-muted">{{ $order->total_items }} item{{ $order->total_items != 1 ? 's' : '' }}</small>
                </div>
                <div class="col-md-3 text-end">
                  <h5 class="mb-1 text-primary">₱{{ number_format($order->total_amount, 2) }}</h5>
                </div>
                <div class="col-md-2">
                  <span class="badge bg-{{ $order->status == 'completed' ? 'success' : ($order->status == 'cancelled' ? 'danger' : ($order->status == 'processing' ? 'info' : 'warning')) }} px-3 py-2">
                    {{ ucfirst($order->status) }}
                  </span>
                  <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-link p-0 ms-2">View</a>
                </div>
              </div>
            </div>
            @empty
            <div class="text-center py-5">
              <i class="bi bi-receipt-cutoff fs-1 text-muted mb-3"></i>
              <h5 class="text-muted">No Orders Yet</h5>
              <p class="text-muted">Your order history will appear here.</p>
              <a href="{{ route('books.index') }}" class="btn btn-primary">Start Shopping</a>
            </div>
            @endforelse
          </div>
        </div>
      </div>
    </div>

    <!-- Recently Purchased Books -->
    <div class="row g-4 mt-4">
      @forelse($purchasedBooks as $book)
      <div class="col-lg-3 col-md-6">
        <div class="card book-card-small shadow h-100">
          <div class="card-img-top p-3 bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
            @if($book->cover_image)
            <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}" class="img-fluid rounded shadow" style="max-height: 180px; object-fit: cover;">
            @else
            <div class="bg-gradient-primary text-white rounded p-4">
              <i class="bi bi-book fs-1"></i>
            </div>
            @endif
          </div>
          <div class="card-body">
            <h6 class="card-title mb-2">{{ Str::limit($book->title, 40) }}</h6>
            <p class="small text-muted mb-2">{{ $book->author }}</p>
            <div class="d-flex justify-content-between align-items-center mb-2">
              <span class="fw-bold text-primary small">₱{{ number_format($book->price, 2) }}</span>
              <span class="badge bg-success">Owned</span>
            </div>
            <a href="{{ route('books.show', $book) }}" class="btn btn-outline-primary btn-sm w-100">Read More</a>
          </div>
        </div>
      </div>
      @empty
      <div class="col-12 text-center py-5">
        <i class="bi bi-book fs-1 text-muted mb-3"></i>
        <h5 class="text-muted">No Purchased Books</h5>
        <p class="text-muted">Your purchased books will appear here.</p>
        <a href="{{ route('books.index') }}" class="btn btn-primary">Browse Library</a>
      </div>
      @endforelse
    </div>
  </div>
</div>
@endsection

