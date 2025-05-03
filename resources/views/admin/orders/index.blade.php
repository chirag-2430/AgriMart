@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="mb-4">Manage Orders</h2>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Total Amount</th>
                            <th>Status</th>
                            <th>Order Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                            <tr>
                                <td>#{{ $order->id }}</td>
                                <td>{{ $order->user->name }}</td>
                                <td>${{ number_format($order->total_amount, 2) }}</td>
                                <td>
                                    <span class="badge bg-{{ $order->status === 'completed' ? 'success' : ($order->status === 'pending' ? 'warning' : 'danger') }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td>{{ $order->created_at->format('M d, Y H:i') }}</td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#orderDetailsModal{{ $order->id }}">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#updateStatusModal{{ $order->id }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </td>
                            </tr>

                            <!-- Order Details Modal -->
                            <div class="modal fade" id="orderDetailsModal{{ $order->id }}" tabindex="-1" aria-labelledby="orderDetailsModalLabel{{ $order->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="orderDetailsModalLabel{{ $order->id }}">Order #{{ $order->id }} Details</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <h6>Customer Information</h6>
                                                    <p><strong>Name:</strong> {{ $order->user->name }}</p>
                                                    <p><strong>Email:</strong> {{ $order->user->email }}</p>
                                                </div>
                                                <div class="col-md-6">
                                                    <h6>Order Information</h6>
                                                    <p><strong>Order Date:</strong> {{ $order->created_at->format('M d, Y H:i') }}</p>
                                                    <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
                                                </div>
                                            </div>
                                            <h6>Order Items</h6>
                                            <table class="table table-sm">
                                                <thead>
                                                    <tr>
                                                        <th>Product</th>
                                                        <th>Quantity</th>
                                                        <th>Price</th>
                                                        <th>Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($order->items as $item)
                                                        <tr>
                                                            <td>{{ $item->product->name }}</td>
                                                            <td>{{ $item->quantity }}</td>
                                                            <td>${{ number_format($item->price, 2) }}</td>
                                                            <td>${{ number_format($item->price * $item->quantity, 2) }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="3" class="text-end"><strong>Total:</strong></td>
                                                        <td>${{ number_format($order->total_amount, 2) }}</td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Update Status Modal -->
                            <div class="modal fade" id="updateStatusModal{{ $order->id }}" tabindex="-1" aria-labelledby="updateStatusModalLabel{{ $order->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="updateStatusModalLabel{{ $order->id }}">Update Order Status</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="status" class="form-label">Status</label>
                                                    <select class="form-select" id="status" name="status" required>
                                                        <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                                        <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                                                        <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                                        <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Update Status</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No orders found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
</div>
@endsection 