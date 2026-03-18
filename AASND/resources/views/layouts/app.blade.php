"<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'PageTurner Bookstore')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Styles -->
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Figtree', sans-serif;
            background-color: #1f2937;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            color: #e5e7eb;
        }
        
        .container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 1rem;
        }
        
        /* Navigation */
        .navbar {
            background-color: #312e81;
            color: white;
            padding: 1rem 0;
        }
        
        .navbar-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .navbar-brand {
            font-size: 1.5rem;
            font-weight: bold;
            color: white;
            text-decoration: none;
        }
        
        .navbar-links {
            display: flex;
            gap: 1.5rem;
            align-items: center;
        }
        
        .navbar-links a {
            color: white;
            text-decoration: none;
            padding: 0.5rem 0.75rem;
            border-radius: 0.375rem;
            transition: background-color 0.2s;
        }
        
        .navbar-links a:hover {
            background-color: #3730a3;
        }
        
        .navbar-right {
            display: flex;
            gap: 1rem;
            align-items: center;
        }
        
        /* Buttons */
        .btn {
            display: inline-block;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            text-decoration: none;
            font-weight: 500;
            cursor: pointer;
            border: none;
            transition: all 0.2s;
        }
        
        .btn-primary {
            background-color: #3730a3;
            color: white;
        }
        
        .btn-primary:hover {
            background-color: #312e81;
        }
        
        .btn-secondary {
            background-color: #6b7280;
            color: white;
        }
        
        .btn-secondary:hover {
            background-color: #4b5563;
        }
        
        .btn-danger {
            background-color: #ef4444;
            color: white;
        }
        
        .btn-danger:hover {
            background-color: #dc2626;
        }
        
        .btn-warning {
            background-color: #f59e0b;
            color: white;
        }
        
        .btn-warning:hover {
            background-color: #d97706;
        }
        
        .btn-white {
            background-color: #e5e7eb;
            color: #312e81;
        }
        
        .btn-white:hover {
            background-color: #d1d5db;
        }
        
        /* Forms */
        .form-group {
            margin-bottom: 1rem;
        }
        
        .form-label {
            display: block;
            font-weight: 500;
            margin-bottom: 0.5rem;
            color: #d1d5db;
        }
        
        .form-input,
        .form-select,
        .form-textarea {
            width: 100%;
            padding: 0.625rem;
            border: 1px solid #4b5563;
            border-radius: 0.375rem;
            font-size: 1rem;
            background-color: #374151;
            color: #f3f4f6;
        }
        
        .form-input:focus,
        .form-select:focus,
        .form-textarea:focus {
            outline: none;
            border-color: #4f46e5;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }
        
        /* Cards */
        .card {
            background: #374151;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            color: #e5e7eb;
        }
        
        /* Grid */
        .grid {
            display: grid;
            gap: 1.5rem;
        }
        
        .grid-cols-1 { grid-template-columns: repeat(1, 1fr); }
        .grid-cols-2 { grid-template-columns: repeat(2, 1fr); }
        .grid-cols-3 { grid-template-columns: repeat(3, 1fr); }
        .grid-cols-4 { grid-template-columns: repeat(4, 1fr); }
        
        @media (min-width: 640px) {
            .sm\:grid-cols-2 { grid-template-columns: repeat(2, 1fr); }
        }
        
        @media (min-width: 768px) {
            .md\:grid-cols-3 { grid-template-columns: repeat(3, 1fr); }
            .md\:grid-cols-4 { grid-template-columns: repeat(4, 1fr); }
        }
        
        /* Alerts */
        .alert {
            padding: 1rem;
            border-radius: 0.375rem;
            margin-bottom: 1rem;
        }
        
        .alert-success {
            background-color: #d1fae5;
            border: 1px solid #34d399;
            color: #065f46;
        }
        
        .alert-error {
            background-color: #fee2e2;
            border: 1px solid #f87171;
            color: #991b1b;
        }
        
        .alert-info {
            background-color: #dbeafe;
            border: 1px solid #60a5fa;
            color: #1e40af;
        }
        
        /* Tables */
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .table th,
        .table td {
            padding: 0.75rem;
            text-align: left;
            border-bottom: 1px solid #4b5563;
            color: #e5e7eb;
        }
        
        .table th {
            font-weight: 600;
            background-color: #374151;
        }
        
        /* Footer */
        footer {
            margin-top: auto;
            background-color: #1f2937;
            color: white;
            padding: 2rem 0;
        }
        
        /* Main content */
        main {
            flex: 1;
            padding: 2rem 0;
        }
        
        /* Header */
        header {
            background: #374151;
            padding: 1.5rem 0;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
            margin-bottom: 2rem;
        }
        
        /* Utilities */
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .font-bold { font-weight: 700; }
        .font-semibold { font-weight: 600; }
        
        .text-xl { font-size: 1.25rem; }
        .text-2xl { font-size: 1.5rem; }
        .text-3xl { font-size: 1.875rem; }
        .text-4xl { font-size: 2.25rem; }
        
        .mb-2 { margin-bottom: 0.5rem; }
        .mb-4 { margin-bottom: 1rem; }
        .mb-6 { margin-bottom: 1.5rem; }
        .mb-8 { margin-bottom: 2rem; }
        
        .mt-2 { margin-top: 0.5rem; }
        .mt-4 { margin-top: 1rem; }
        .mt-6 { margin-top: 1.5rem; }
        .mt-8 { margin-top: 2rem; }
        
        .py-2 { padding-top: 0.5rem; padding-bottom: 0.5rem; }
        .py-4 { padding-top: 1rem; padding-bottom: 1rem; }
        .py-6 { padding-top: 1.5rem; padding-bottom: 1.5rem; }
        .py-8 { padding-top: 2rem; padding-bottom: 2rem; }
        .py-12 { padding-top: 3rem; padding-bottom: 3rem; }
        
        .px-4 { padding-left: 1rem; padding-right: 1rem; }
        .px-6 { padding-left: 1.5rem; padding-right: 1.5rem; }
        
        .flex { display: flex; }
        .flex-wrap { flex-wrap: wrap; }
        .items-center { align-items: center; }
        .justify-between { justify-content: space-between; }
        .justify-center { justify-content: center; }
        .gap-4 { gap: 1rem; }
        
        .w-full { width: 100%; }
        .max-w-2xl { max-width: 42rem; }
        
        .rounded { border-radius: 0.25rem; }
        .rounded-lg { border-radius: 0.5rem; }
        
        .shadow { box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1); }
        .shadow-md { box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); }
        .shadow-lg { box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1); }
        
        .bg-white { background-color: white; }
        .bg-gray-100 { background-color: #f3f4f6; }
        .bg-gray-800 { background-color: #1f2937; }
        .bg-indigo-600 { background-color: #4f46e5; }
        .bg-indigo-700 { background-color: #4338ca; }
        .bg-green-100 { background-color: #d1fae5; }
        .bg-red-100 { background-color: #fee2e2; }
        .bg-blue-100 { background-color: #dbeafe; }
        
        .text-white { color: white; }
        .text-gray-600 { color: #4b5563; }
        .text-gray-700 { color: #374151; }
        .text-gray-800 { color: #1f2937; }
        .text-gray-900 { color: #111827; }
        .text-indigo-600 { color: #4f46e5; }
        .text-green-600 { color: #16a34a; }
        .text-red-600 { color: #dc2626; }
        .text-yellow-400 { color: #fbbf24; }
        
        .border { border: 1px solid #e5e7eb; }
        .border-b { border-bottom: 1px solid #e5e7eb; }
        
        .truncate {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        
        /* Book card specific */
        .book-card {
            background: white;
            border-radius: 0.5rem;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.2s;
        }
        
        .book-card:hover {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .book-cover {
            height: 12rem;
            background-color: #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .book-cover img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .book-info {
            padding: 1rem;
        }
        
        /* Rating stars */
        .rating {
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }
        
        .star {
            width: 1rem;
            height: 1rem;
        }
        
        .star-filled {
            color: #fbbf24;
        }
        
        .star-empty {
            color: #d1d5db;
        }
        
        /* Hero section */
        .hero {
            background: linear-gradient(135deg, #312e81 0%, #4338ca 100%);
            color: white;
            padding: 3rem;
            border-radius: 0.75rem;
            margin-bottom: 2rem;
        }
        
        /* Pagination */
        .pagination {
            display: flex;
            gap: 0.5rem;
            margin-top: 2rem;
        }
        
        .pagination a,
        .pagination span {
            padding: 0.5rem 0.75rem;
            border: 1px solid #e5e7eb;
            border-radius: 0.25rem;
            text-decoration: none;
            color: #374151;
        }
        
        .pagination a:hover {
            background-color: #f3f4f6;
        }
        
        .pagination .active {
            background-color: #4f46e5;
            color: white;
            border-color: #4f46e5;
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="container navbar-content">
            <a href="{{ route('home') }}" class="navbar-brand">PageTurner</a>
            
            <div class="navbar-links">
                <a href="{{ route('home') }}">Home</a>
                <a href="{{ route('books.index') }}">Books</a>
                <a href="{{ route('categories.index') }}">Categories</a>
                @auth
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.books.create') }}">Add Book</a>
                        <a href="{{ route('admin.categories.create') }}">Add Category</a>
                    @endif
                @endauth
            </div>
            
            <div class="navbar-right">
                @guest
                    <a href="{{ route('login') }}" class="btn btn-white btn-sm">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-white btn-sm">Register</a>
                @endguest
                
                @auth
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-white btn-sm">Orders</a>
                    @else
                        <a href="{{ route('user.orders.index') }}" class="btn btn-white btn-sm">My Orders</a>
                    @endif
                    <a href="{{ route('profile.edit') }}" class="btn btn-white btn-sm" style="font-weight: bold;">
                        <i class="fas fa-user"></i> Profile
                    </a>
                    <span>{{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-white btn-sm">Logout</button>
                    </form>
                @endauth
            </div>
        </div>
    </nav>
    
    <!-- Flash Messages -->
    @if(session('success'))
        <div class="container" style="margin-top: 1rem;">
            <div class="alert alert-success">{{ session('success') }}</div>
        </div>
    @endif
    
    @if(session('error'))
        <div class="container" style="margin-top: 1rem;">
            <div class="alert alert-error">{{ session('error') }}</div>
        </div>
    @endif
    
    @if($errors->any())
        <div class="container" style="margin-top: 1rem;">
            <div class="alert alert-error">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif
    
    <!-- Page Heading -->
    @hasSection('header')
        <header>
            <div class="container">
                @yield('header')
            </div>
        </header>
    @endif
    
    <!-- Main Content -->
    <main>
        <div class="container">
            @yield('content')
        </div>
    </main>
    
    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="grid grid-cols-3">
                <div>
                    <h3 style="font-size: 1.125rem; margin-bottom: 1rem;">PageTurner Bookstore</h3>
                    <p style="color: #9ca3af;">Your destination for quality books at great prices.</p>
                </div>
                <div>
                    <h3 style="font-size: 1.125rem; margin-bottom: 1rem;">Quick Links</h3>
                    <ul style="color: #9ca3af; list-style: none;">
                        <li><a href="{{ route('home') }}" style="color: #9ca3af;">Home</a></li>
                        <li><a href="{{ route('books.index') }}" style="color: #9ca3af;">Browse Books</a></li>
                        <li><a href="{{ route('categories.index') }}" style="color: #9ca3af;">Categories</a></li>
                    </ul>
                </div>
                <div>
                    <h3 style="font-size: 1.125rem; margin-bottom: 1rem;">Contact</h3>
                    <p style="color: #9ca3af;">Email: support@pageturner.com</p>
Phone: 0967-223-5652
                </div>
            </div>
            <div style="border-top: 1px solid #374151; margin-top: 2rem; padding-top: 2rem; text-align: center; color: #9ca3af;">
                <p>&copy; {{ date('Y') }} PageTurner Bookstore. All rights reserved.</p>
            </div>
        </div>
    </footer>
    
    @stack('scripts')
</body>
</html>

