@extends('layouts.app')

@section('title', 'My Profile - PageTurner')

<style>
    :root {
        --primary: #4f46e5;
        --primary-dark: #4338ca;
        --success: #10b981;
        --warning: #f59e0b;
        --danger: #ef4444;
        --info: #06b6d4;
        --dark: #1f2937;
        --gray: #6b7280;
        --light: #f3f4f6;
    }
    
    /* Override text colors for dark mode visibility */
    .stat-card, .settings-section, .settings-body, .settings-header {
        background: white !important;
    }
    
    .stat-card h4, .stat-card p, .section-title, .section-subtitle,
    .settings-section h5, .settings-section p, .settings-section label,
    .form-label, .text-muted {
        color: #1f2937 !important;
    }
    
    .settings-section .form-control-custom {
        background: #f3f4f6 !important;
        border-color: #d1d5db !important;
        color: #1f2937 !important;
    }
    
    .stat-card {
        color: #1f2937;
    }
    
    .stat-card h4 {
        color: #1f2937 !important;
    }
    
    .stat-card p {
        color: #4b5563 !important;
    }
    
    .profile-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 24px;
        padding: 40px;
        position: relative;
        overflow: hidden;
    }
    
    .profile-header::before {
        content: '';
        position: absolute;
        top: -100px;
        right: -100px;
        width: 300px;
        height: 300px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
    }
    
    .profile-header::after {
        content: '';
        position: absolute;
        bottom: -50px;
        left: -50px;
        width: 200px;
        height: 200px;
        background: rgba(255,255,255,0.05);
        border-radius: 50%;
    }
    
    .avatar-container {
        position: relative;
        display: inline-block;
    }
    
    .avatar-image {
        width: 140px;
        height: 140px;
        border-radius: 50%;
        object-fit: cover;
        border: 5px solid white;
        box-shadow: 0 10px 40px rgba(0,0,0,0.2);
    }
    
    .avatar-placeholder {
        width: 140px;
        height: 140px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 56px;
        color: white;
        border: 5px solid white;
        box-shadow: 0 10px 40px rgba(0,0,0,0.2);
    }
    
    .avatar-upload-btn {
        position: absolute;
        bottom: 5px;
        right: 5px;
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background: var(--primary);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        border: 3px solid white;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.4);
    }
    
    .avatar-upload-btn:hover {
        background: var(--primary-dark);
        transform: scale(1.1);
    }
    
    .avatar-upload-btn input {
        display: none;
    }
    
    .stat-card {
        background: white;
        border-radius: 16px;
        padding: 20px;
        text-align: center;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 30px rgba(0,0,0,0.12);
    }
    
    .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 12px;
        font-size: 20px;
    }
    
    .settings-section {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        margin-bottom: 24px;
        transition: all 0.3s ease;
    }
    
    .settings-section:hover {
        box-shadow: 0 8px 30px rgba(0,0,0,0.12);
    }
    
    .settings-header {
        padding: 24px 28px;
        border-bottom: 1px solid #e5e7eb;
        display: flex;
        align-items: center;
        gap: 16px;
    }
    
    .settings-icon {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }
    
    .settings-body {
        padding: 28px;
    }
    
    .form-control-custom {
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        padding: 14px 18px;
        font-size: 15px;
        transition: all 0.3s ease;
        background: #f9fafb;
    }
    
    .form-control-custom:focus {
        border-color: var(--primary);
        background: white;
        box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
        outline: none;
    }
    
    .btn-custom {
        padding: 14px 28px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 15px;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    
    .btn-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }
    
    .badge-custom {
        padding: 8px 16px;
        border-radius: 20px;
        font-weight: 500;
        font-size: 13px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    
    .two-factor-enabled {
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        border: 2px solid #34d399;
    }
    
    .two-factor-disabled {
        background: #f3f4f6;
        border: 2px solid #e5e7eb;
    }
    
    .danger-zone {
        border: 2px solid #fee2e2;
        background: linear-gradient(to bottom, #fef2f2, white);
    }
    
    .danger-zone .settings-header {
        background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
    }
    
    .section-title {
        font-size: 22px;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 8px;
    }
    
    .section-subtitle {
        font-size: 14px;
        color: var(--gray);
        margin: 0;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .animate-fade-in {
        animation: fadeIn 0.5s ease forwards;
    }
    
    .animate-delay-1 { animation-delay: 0.1s; }
    .animate-delay-2 { animation-delay: 0.2s; }
    .animate-delay-3 { animation-delay: 0.3s; }
    .animate-delay-4 { animation-delay: 0.4s; }
</style>

@section('content')
<div class="container py-5">
    <!-- Profile Header -->
    <div class="profile-header text-white mb-4 animate-fade-in">
        <div class="row align-items-center">
            <div class="col-lg-4 text-center">
                <div class="avatar-container">
                    @if($user->profile_picture)
                        <img src="{{ asset('storage/' . $user->profile_picture) }}?t={{ time() }}" 
                            alt="Profile Picture" class="avatar-image">
                    @else
                        <div class="avatar-placeholder">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                    @endif
                    
                    <form method="post" action="{{ route('profile.picture.update') }}" enctype="multipart/form-data" id="picForm">
                        @csrf
                        @method('patch')
                        <label for="profile_picture" class="avatar-upload-btn" title="Change Photo">
                            <i class="fas fa-camera"></i>
                        </label>
                        <input type="file" name="profile_picture" id="profile_picture" 
                            accept="image/*" onchange="document.getElementById('picForm').submit()">
                    </form>
                </div>
            </div>
            <div class="col-lg-8 mt-4 mt-lg-0">
                <h2 class="fw-bold mb-2" style="font-size: 32px;">{{ $user->name }}</h2>
                <p class="mb-3" style="opacity: 0.9; font-size: 16px;">{{ $user->email }}</p>
                <div class="d-flex flex-wrap gap-2">
                    @if($user->hasVerifiedEmail())
                        <span class="badge-custom bg-white text-success">
                            <i class="fas fa-check-circle"></i> Verified
                        </span>
                    @else
                        <span class="badge-custom bg-warning text-dark">
                            <i class="fas fa-clock"></i> Unverified
                        </span>
                    @endif
                    @if($user->isTwoFactorEnabled())
                        <span class="badge-custom bg-white text-info">
                            <i class="fas fa-shield-alt"></i> 2FA Protected
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Row -->
    <div class="row g-3 mb-4">
        <div class="col-md-4 animate-fade-in animate-delay-1">
            <div class="stat-card">
                <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                    <i class="fas fa-shopping-bag"></i>
                </div>
                <h4 class="fw-bold mb-1">{{ $user->orders->count() }}</h4>
                <p class="text-muted mb-0">Total Orders</p>
            </div>
        </div>
        <div class="col-md-4 animate-fade-in animate-delay-2">
            <div class="stat-card">
                <div class="stat-icon bg-warning bg-opacity-10 text-warning">
                    <i class="fas fa-star"></i>
                </div>
                <h4 class="fw-bold mb-1">{{ $user->reviews->count() }}</h4>
                <p class="text-muted mb-0">Reviews Written</p>
            </div>
        </div>
        <div class="col-md-4 animate-fade-in animate-delay-3">
            <div class="stat-card">
                <div class="stat-icon bg-info bg-opacity-10 text-info">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <h4 class="fw-bold mb-1">{{ $user->created_at->format('M Y') }}</h4>
                <p class="text-muted mb-0">Member Since</p>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Personal Information -->
            <div class="settings-section animate-fade-in animate-delay-2">
                <div class="settings-header">
                    <div class="settings-icon bg-primary bg-opacity-10 text-primary">
                        <i class="fas fa-user"></i>
                    </div>
                    <div>
                        <h5 class="section-title mb-0">Personal Information</h5>
                        <p class="section-subtitle mb-0">Update your personal details</p>
                    </div>
                </div>
                <div class="settings-body">
                    <form method="post" action="{{ route('profile.update') }}">
                        @csrf
                        @method('patch')
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-medium">Full Name</label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}" required 
                                    class="form-control form-control-custom">
                                @error('name')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-medium">Email Address</label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}" required 
                                    class="form-control form-control-custom">
                                @error('email')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <h6 class="mt-4 mb-3 fw-semibold text-muted">Shipping Address</h6>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-medium">Address Line 1</label>
                                <input type="text" name="address_line1" value="{{ old('address_line1', $user->address_line1) }}" 
                                    class="form-control form-control-custom" placeholder="Street address, P.O. box, etc">
                                @error('address_line1')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-medium">Address Line 2</label>
                                <input type="text" name="address_line2" value="{{ old('address_line2', $user->address_line2) }}" 
                                    class="form-control form-control-custom" placeholder="Apartment, suite, unit, etc (optional)">
                                @error('address_line2')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-medium">City</label>
                                <input type="text" name="city" value="{{ old('city', $user->city) }}" 
                                    class="form-control form-control-custom">
                                @error('city')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-medium">State</label>
                                <input type="text" name="state" value="{{ old('state', $user->state) }}" 
                                    class="form-control form-control-custom">
                                @error('state')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label fw-medium">ZIP Code</label>
                                <input type="text" name="postal_code" value="{{ old('postal_code', $user->postal_code) }}" 
                                    class="form-control form-control-custom">
                                @error('postal_code')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label fw-medium">Country</label>
                                <input type="text" name="country" value="{{ old('country', $user->country) }}" 
                                    class="form-control form-control-custom" placeholder="USA">
                                @error('country')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="d-flex align-items-center">
                            <button type="submit" class="btn btn-custom btn-primary">
                                <i class="fas fa-save"></i> Save Changes
                            </button>
                            @if (session('status') === 'profile-updated')
                                <span class="text-success ms-3">
                                    <i class="fas fa-check-circle"></i> Saved successfully!
                                </span>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <!-- Change Password -->
            <div class="settings-section animate-fade-in animate-delay-3">
                <div class="settings-header">
                    <div class="settings-icon bg-warning bg-opacity-10 text-warning">
                        <i class="fas fa-lock"></i>
                    </div>
                    <div>
                        <h5 class="section-title mb-0">Change Password</h5>
                        <p class="section-subtitle mb-0">Ensure your account stays secure</p>
                    </div>
                </div>
                <div class="settings-body">
                    <form method="post" action="{{ route('password.update') }}">
                        @csrf
                        @method('put')
                        
                        <div class="mb-3">
                            <label class="form-label fw-medium">Current Password</label>
                            <input type="password" name="current_password" required class="form-control form-control-custom">
                            @error('current_password', 'updatePassword')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-medium">New Password</label>
                                <input type="password" name="password" required class="form-control form-control-custom">
                                @error('password', 'updatePassword')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-medium">Confirm Password</label>
                                <input type="password" name="password_confirmation" required class="form-control form-control-custom">
                            </div>
                        </div>
                        
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="logout_other_devices" id="logout_other_devices" value="1">
                            <label class="form-check-label text-muted" for="logout_other_devices">
                                Logout from all other devices
                            </label>
                        </div>
                        
                        <div class="d-flex align-items-center">
                            <button type="submit" class="btn btn-custom btn-warning text-white">
                                <i class="fas fa-key"></i> Update Password
                            </button>
                            @if (session('status') === 'password-updated')
                                <span class="text-success ms-3">
                                    <i class="fas fa-check-circle"></i> Password updated!
                                </span>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <!-- Two-Factor Authentication -->
            <div class="settings-section animate-fade-in animate-delay-4">
                <div class="settings-header">
                    <div class="settings-icon bg-info bg-opacity-10 text-info">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <div>
                        <h5 class="section-title mb-0">Two-Factor Authentication</h5>
                        <p class="section-subtitle mb-0">Add extra security to your account</p>
                    </div>
                </div>
                <div class="settings-body">
                    @if($user->isTwoFactorEnabled())
                        <div class="d-flex align-items-center justify-content-between p-4 rounded-4 two-factor-enabled">
                            <div class="d-flex align-items-center">
                                <div class="settings-icon bg-success text-white me-3" style="width: 40px; height: 40px;">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 text-success fw-bold">2FA is Enabled</h6>
                                    <p class="mb-0 text-muted small">Login codes sent to email</p>
                                </div>
                            </div>
                            <form method="POST" action="{{ route('two-factor.disable') }}">
                                @csrf
                                
                                @error('password')
                                    <div class="text-danger small mb-2">{{ $message }}</div>
                                @enderror
                                
                                <div class="mb-3">
                                    <label class="form-label fw-medium small">Enter password to disable</label>
                                    <input type="password" name="password" required 
                                        class="form-control form-control-custom form-control-sm" 
                                        placeholder="Current password" autocomplete="current-password">
                                </div>
                                
                                <button type="submit" class="btn btn-custom btn-outline-danger" onclick="return confirm('Disable 2FA? This adds extra security.')">
                                    <i class="fas fa-times"></i> Disable 2FA
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="d-flex align-items-center justify-content-between p-4 rounded-4 two-factor-disabled">
                            <div class="d-flex align-items-center">
                                <div class="settings-icon bg-secondary text-white me-3" style="width: 40px; height: 40px;">
                                    <i class="fas fa-shield-alt"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-bold" style="color: #6b7280;">2FA is Disabled</h6>
                                    <p class="mb-0 text-muted small">Enable for extra protection</p>
                                </div>
                            </div>
                            <form method="POST" action="{{ route('two-factor.enable') }}">
                                @csrf
                                <button type="submit" class="btn btn-custom btn-outline-dark">
                                    <i class="fas fa-shield-alt"></i> Enable 2FA
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Delete Account -->
            <div class="settings-section danger-zone animate-fade-in animate-delay-4">
                <div class="settings-header">
                    <div class="settings-icon bg-danger text-white">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div>
                        <h5 class="section-title mb-0 text-danger">Delete Account</h5>
                        <p class="section-subtitle mb-0">Permanently remove your account</p>
                    </div>
                </div>
                <div class="settings-body">
                    <p class="text-muted mb-3">Once you delete your account, there is no going back. Please be certain.</p>
                    <form method="post" action="{{ route('profile.destroy') }}">
                        @csrf
                        @method('delete')
                        <div class="mb-3">
                            <label class="form-label fw-medium">Confirm with your password</label>
                            <input type="password" name="password" required class="form-control form-control-custom" placeholder="Enter password">
                            @error('password', 'userDeletion')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-custom btn-danger w-100" onclick="return confirm('Are you absolutely sure? This cannot be undone!')">
                            <i class="fas fa-trash-alt"></i> Delete Account
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

Contact
Email: support@pageturner.com

Phone: 0967-223-5652
