@extends('layouts.app')

@section('title', 'Admin Dashboard - PageTurner')

@push('styles')
<style>
.admin-hero {
  background: linear-gradient(135deg, #ff6b6b 0%, #4ecdc4 50%, #45b7d1 100%);
  color: white;
  border-radius: 25px;
  padding: 3rem;
  margin-bottom: 2rem;
  position: relative;
  overflow: hidden;
}
.admin-hero::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
}
.stat-card-admin {
  position: relative;
  overflow: hidden;
  transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
  border: none;
  border-radius: 25px;
}
.stat-card-admin::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  height: 5px;
  background: linear-gradient(90deg, var(--bs-primary), var(--bs-info));
}
.stat-card-admin:hover {
  transform: translateY(-15px) scale(1.02);
  box-shadow: 0 30px 60px rgba(0,0,0,0.25);
}
.metric-icon {
  width: 80px;
  height: 80px;
  border-radius: 20px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 2rem;
  box-shadow: 0 10px 30px rgba(0,0,0,0.2);
}
.table-hover tbody tr:hover {
  background-color: rgba(0,123,255,0.05);
  transform: scale(1.01);
}
.chart-container {
  position: relative;
  height: 300px;
  border-radius: 20px;
  overflow: hidden;
  box-shadow: 0 20px 40px rgba(0,0,0,0.1);
}
@keyframes pulse-glow {
  0% { box-shadow: 0 0 0 0 rgba(76, 175, 80, 0.7); }
  70% { box-shadow: 0 0 0 20px rgba(76, 175, 80, 0); }
  100% { box-shadow: 0 0 0 0 rgba(76, 175, 80, 0); }
}
.pulse-glow {
  animation: pulse-glow 2s infinite;
}
</style>
@endpush

@section('content')
<div class="py-5" style="background: linear-gradient(to bottom, #f0f2f5, #e9ecef); min-height: 100vh;">
  <div class="container">
    <!-- Hero Section -->
    <div class="admin-hero position-relative">
      <div class="row align-items-center">
        <div class="col-lg-8">
          <h1 class="display-3 fw-bold mb-4 pulse-glow">Admin Control Center</h1>
          <p class="lead mb-0 opacity-90">Complete overview of your bookstore operations. Manage with confidence.</p>
        </div>
        <div class="col-lg-4 text-lg-end">
          <div class="d-flex flex-column align-items-end">
            <h3 class="mb-3">{{ Auth::user()->name }}</h3>
            <span class="badge bg-light text-dark px-3 py-2 fs-6">Administrator</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Stats Grid -->
    <div class="row g-4 mb-5">
      <div class="col-xl-3 col-lg-6">
        <div class="card stat-card-admin bg-gradient-primary text-white h-100">
          <div class="card-body text-center">
            <div class="metric-icon mb-3">
              <i class="bi bi-people-fill"></i>
            </div>
            <h2 class="display-4 fw-bold mb-1">{{ $stats['total_users'] }}</h2>
            <p class="mb-0 lead opacity-90">Registered Users</p>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-lg-6">
        <div class="card stat-card-admin bg-gradient-success text-white h-100">
          <div class="card-body text-center">
            <div class="metric-icon mb-3">
              <i class="bi bi-book-fill"></i>
            </div>
            <h2 class="display-4 fw-bold mb-1">{{ $stats['total_books'] }}</h2>
            <p class="mb-0 lead opacity-90">Books Available</p>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-lg-6">
        <div class="card stat-card-admin bg-gradient-info text-white h-100">
          <div class="card-body text-center">
            <div class="metric-icon mb-3">
              <i class="bi bi-tag-fill"></i>
            </div>
            <h2 class="display-4 fw-bold mb-1">{{ $stats['total_categories'] }}</h2>
            <p class="mb-0 lead opacity-90">Categories</p>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-lg-6">
        <div class="card stat-card-admin bg-gradient-warning text-white h-100">
          <div class="card-body text-center">
            <div class="metric-icon mb-3">
              <i class="bi bi-receipt-fill"></i>
            </div>
            <h2 class="display-4 fw-bold mb-1">{{ $stats['total_orders'] }}</h2>
            <p class="mb-0 lead opacity-90">Total Orders</p>
          </div>
        </div>
      </div>
    </div>

    <div class="row g-4">
      <!-- Chart & Orders -->
      <div class="col-lg-8">
        <div class="card shadow-xl border-0" style="border-radius: 25px; overflow: hidden;">
          <div class="card-header bg-transparent pb-0">
            <h5 class="mb-0">Sales Overview</h5>
          </div>
          <div class="card-body p-4">
            <canvas id="salesChart" height="100"></canvas>
          </div>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="card shadow-xl border-0" style="border-radius: 25px;">
          <div class="card-header bg-transparent pb-0">
            <h5 class="mb-0">Order Status</h5>
          </div>
          <div class="card-body">
            <div class="list-group list-group-flush">
              @foreach($orderStatusSummary as $status => $count)
              <div class="list-group-item px-0 border-0 d-flex justify-content-between align-items-center py-3">
                <span class="text-capitalize">{{ $status }}</span>
                <span class="badge bg-{{ $status == 'completed' ? 'success' : ($status == 'cancelled' ? 'danger' : ($status == 'processing' ? 'info' : 'warning')) }} fs-6 px-3">
                  {{ $count }}
                </span>
              </div>
              @endforeach
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Recent Activity Tables -->
    <div class="row g-4 mt-4">
      <div class="col-lg-6">
        <div class="card shadow-xl border-0" style="border-radius: 25px;">
          <div class="card-header bg-transparent pb-0">
            <div class="d-flex justify-content-between">
              <h5 class="mb-0">Recent Orders</h5>
              <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-primary">View All</a>
            </div>
          </div>
          <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table table-hover mb-0">
                <thead class="table-dark">
                  <tr>
                    <th>ID</th>
                    <th>Customer</th>
                    <th>Amount</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($recentOrders as $order)
                  <tr class="table-hover">
                    <td class="fw-bold">#{{ $order->id }}</td>
                    <td>{{ Str::limit($order->user->name, 15) }}</td>
                    <td>₱{{ number_format($order->total_amount, 2) }}</td>
                    <td><span class="badge bg-{{ $order->status == 'completed' ? 'success' : ($order->status == 'cancelled' ? 'danger' : ($order->status == 'processing' ? 'info' : 'warning')) }}">
                      {{ ucfirst($order->status) }}
                    </span></td>
                  </tr>
                  @empty
                  <tr>
                    <td colspan="4" class="text-center py-4 text-muted">No recent orders</td>
                  </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="card shadow-xl border-0" style="border-radius: 25px;">
          <div class="card-header bg-transparent pb-0">
            <div class="d-flex justify-content-between">
              <h5 class="mb-0">Recent Reviews</h5>
              <a href="{{ route('admin.books.index') }}" class="btn btn-sm btn-primary">Manage Books</a>
            </div>
          </div>
          <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table table-hover mb-0">
                <thead class="table-dark">
                  <tr>
                    <th>Book</th>
                    <th>Reviewer</th>
                    <th>Rating</th>
                    <th>Date</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($recentReviews as $review)
                  <tr class="table-hover">
                    <td>{{ Str::limit($review->book->title, 20) }}</td>
                    <td>{{ Str::limit($review->user->name, 12) }}</td>
                    <td>
                      @for($i = 1; $i <= 5; $i++)
                        @if($i <= $review->rating)
                          ★
                        @else
                          ☆
                        @endif
                      @endfor
                    </td>
                    <td>{{ $review->created_at->diffForHumans() }}</td>
                  </tr>
                  @empty
                  <tr>
                    <td colspan="4" class="text-center py-4 text-muted">No reviews</td>
                  </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Quick Links -->
    <div class="row mt-5">
      <div class="col-12">
        <h5>Quick Navigation</h5>
        <div class="d-flex flex-wrap gap-3">
          <a href="{{ route('admin.books.index') }}" class="btn btn-lg btn-primary px-4 shadow-lg">
            <i class="bi bi-book me-2"></i>Books
          </a>
          <a href="{{ route('admin.categories.index') }}" class="btn btn-lg btn-success px-4 shadow-lg">
            <i class="bi bi-tags me-2"></i>Categories
          </a>
          <a href="{{ route('admin.orders.index') }}" class="btn btn-lg btn-info px-4 shadow-lg">
            <i class="bi bi-receipt me-2"></i>Orders
          </a>
          <a href="{{ route('profile.edit') }}" class="btn btn-lg btn-outline-secondary px-4 shadow">
            <i class="bi bi-person-circle me-2"></i>Profile
          </a>
        </div>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
  const ctx = document.getElementById('salesChart');
  if (ctx) {
    new Chart(ctx, {
      type: 'doughnut',
      data: {
        labels: {{ json_encode(array_keys($orderStatusSummary)) }},
        datasets: [{
          data: {{ json_encode(array_values($orderStatusSummary)) }},
          backgroundColor: ['#28a745', '#007bff', '#ffc107', '#dc3545', '#6c757d'],
          borderWidth: 0,
          borderRadius: 10
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            position: 'bottom',
            labels: {
              padding: 20,
              usePointStyle: true
            }
          }
        }
      }
    });
  }
});
</script>
@endpush>
@endsection

