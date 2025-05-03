@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="mb-4">Admin Dashboard</h2>
        </div>
    </div>

    <div class="row">
        <!-- Total Users Card -->
        <div class="col-md-3 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Total Users</h6>
                            <h3 class="mb-0">{{ $stats['total_users'] }}</h3>
                        </div>
                        <div class="bg-primary bg-opacity-10 p-3 rounded">
                            <i class="fas fa-users fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Products Card -->
        <div class="col-md-3 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Total Products</h6>
                            <h3 class="mb-0">{{ $stats['total_products'] }}</h3>
                        </div>
                        <div class="bg-success bg-opacity-10 p-3 rounded">
                            <i class="fas fa-box fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Orders Card -->
        <div class="col-md-3 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Total Orders</h6>
                            <h3 class="mb-0">{{ $stats['total_orders'] }}</h3>
                        </div>
                        <div class="bg-warning bg-opacity-10 p-3 rounded">
                            <i class="fas fa-shopping-cart fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Revenue Card -->
        <div class="col-md-3 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Total Revenue</h6>
                            <h3 class="mb-0">${{ number_format($stats['total_revenue'], 2) }}</h3>
                        </div>
                        <div class="bg-info bg-opacity-10 p-3 rounded">
                            <i class="fas fa-dollar-sign fa-2x text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-4">Quick Actions</h5>
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-primary w-100">
                                <i class="fas fa-users me-2"></i>Manage Users
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.products.index') }}" class="btn btn-outline-success w-100">
                                <i class="fas fa-box me-2"></i>Manage Products
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-warning w-100">
                                <i class="fas fa-shopping-cart me-2"></i>Manage Orders
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.sales.index') }}" class="btn btn-outline-info w-100">
                                <i class="fas fa-chart-line me-2"></i>Sales Analysis
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 