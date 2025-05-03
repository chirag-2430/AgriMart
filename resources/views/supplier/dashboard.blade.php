@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="mb-4">Supplier Dashboard</h2>
        </div>
    </div>

    <div class="row">
        <!-- Total Products Card -->
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Total Products</h6>
                            <h3 class="mb-0">{{ $stats['total_products'] }}</h3>
                        </div>
                        <div class="bg-primary bg-opacity-10 p-3 rounded">
                            <i class="fas fa-box fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Orders Card -->
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Total Orders</h6>
                            <h3 class="mb-0">{{ $stats['total_orders'] }}</h3>
                        </div>
                        <div class="bg-success bg-opacity-10 p-3 rounded">
                            <i class="fas fa-shopping-cart fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Revenue Card -->
        <div class="col-md-4 mb-4">
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
                            <a href="{{ route('supplier.products') }}" class="btn btn-outline-primary w-100">
                                <i class="fas fa-box me-2"></i>My Products
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('supplier.products.create') }}" class="btn btn-outline-success w-100">
                                <i class="fas fa-plus me-2"></i>Add New Product
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('supplier.orders') }}" class="btn btn-outline-warning w-100">
                                <i class="fas fa-shopping-cart me-2"></i>View Orders
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('products.index') }}" class="btn btn-outline-info w-100">
                                <i class="fas fa-store me-2"></i>Browse Products
                            </a>
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
                    <h5 class="card-title mb-4">Recent Orders</h5>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Customer</th>
                                    <th>Total Amount</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentOrders as $order)
                                    <tr>
                                        <td>#{{ $order->id }}</td>
                                        <td>{{ $order->user->name }}</td>
                                        <td>${{ number_format($order->total_amount, 2) }}</td>
                                        <td>
                                            <span class="badge bg-{{ $order->status === 'completed' ? 'success' : ($order->status === 'pending' ? 'warning' : 'danger') }}">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $order->created_at->format('M d, Y') }}</td>
                                        <td>
                                            <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No recent orders found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 