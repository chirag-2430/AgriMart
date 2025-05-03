<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@700&display=swap" rel="stylesheet">
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f8f9fa;
            padding-top: 60px; /* Add padding for fixed navbar */
        }
        .navbar-brand {
            font-weight: bold;
            color: #28a745 !important;
        }
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
        }
        .dropdown-menu {
            border: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            padding: 0.5rem;
        }
        .dropdown-item {
            padding: 0.5rem 1rem;
            border-radius: 4px;
            transition: all 0.2s;
        }
        .dropdown-item:hover {
            background-color: #e9ecef;
            color: #28a745;
        }
        .dropdown-item i {
            width: 20px;
            margin-right: 8px;
            color: #28a745;
        }
        .nav-link {
            color: #495057 !important;
            transition: color 0.2s;
        }
        .nav-link:hover {
            color: #28a745 !important;
        }
        .dropdown-toggle::after {
            margin-left: 0.5rem;
        }
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm fixed-top">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    AgriMart
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('home') }}">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#about">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#contact">Contact</a>
                        </li>
                        @auth
                            @if(auth()->user()->isAdmin())
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-cog"></i> Admin Panel
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                                        <li><a class="dropdown-item" href="{{ route('admin.users.index') }}"><i class="fas fa-users"></i> Manage Users</a></li>
                                        <li><a class="dropdown-item" href="{{ route('admin.products.index') }}"><i class="fas fa-box"></i> Manage Products</a></li>
                                        <li><a class="dropdown-item" href="{{ route('admin.orders.index') }}"><i class="fas fa-shopping-cart"></i> Manage Orders</a></li>
                                        <li><a class="dropdown-item" href="{{ route('admin.sales.index') }}"><i class="fas fa-chart-line"></i> Sales Analysis</a></li>
                                    </ul>
                                </li>
                            @elseif(auth()->user()->isSupplier())
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-store"></i> Seller Panel
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="{{ route('supplier.dashboard') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                                        <li><a class="dropdown-item" href="{{ route('supplier.products') }}"><i class="fas fa-box"></i> My Products</a></li>
                                        <li><a class="dropdown-item" href="{{ route('supplier.orders') }}"><i class="fas fa-shopping-cart"></i> Orders</a></li>
                                        <li><a class="dropdown-item" href="{{ route('supplier.products.create') }}"><i class="fas fa-plus-circle"></i> Add New Product</a></li>
                                    </ul>
                                </li>
                            @elseif(auth()->user()->isFarmer())
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-user"></i> Farmer Panel
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="{{ route('farmer.dashboard') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                                        <li><a class="dropdown-item" href="{{ route('farmer.browse') }}"><i class="fas fa-search"></i> Browse Products</a></li>
                                        <li><a class="dropdown-item" href="{{ route('orders.index') }}"><i class="fas fa-shopping-cart"></i> My Orders</a></li>
                                        <li><a class="dropdown-item" href="{{ route('cart.index') }}"><i class="fas fa-shopping-basket"></i> Cart</a></li>
                                    </ul>
                                </li>
                            @endif
                        @endauth
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            <div class="container">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Initialize all tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });

        // Smooth scrolling
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>
</body>
</html>
