@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="mb-4">Sales Analysis</h2>
        </div>
    </div>

    <div class="row">
        <!-- Total Revenue Card -->
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Total Revenue</h6>
                            <h3 class="mb-0">${{ number_format($salesData->sum('total_revenue'), 2) }}</h3>
                        </div>
                        <div class="bg-success bg-opacity-10 p-3 rounded">
                            <i class="fas fa-dollar-sign fa-2x text-success"></i>
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
                            <h3 class="mb-0">{{ $salesData->sum('total_orders') }}</h3>
                        </div>
                        <div class="bg-primary bg-opacity-10 p-3 rounded">
                            <i class="fas fa-shopping-cart fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Average Order Value Card -->
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Average Order Value</h6>
                            <h3 class="mb-0">${{ number_format($salesData->sum('total_revenue') / max($salesData->sum('total_orders'), 1), 2) }}</h3>
                        </div>
                        <div class="bg-info bg-opacity-10 p-3 rounded">
                            <i class="fas fa-chart-bar fa-2x text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-4">Sales Overview</h5>
                    <canvas id="salesChart" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-4">Recent Sales</h5>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Orders</th>
                                    <th>Revenue</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($salesData as $sale)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($sale->date)->format('M d, Y') }}</td>
                                        <td>{{ $sale->total_orders }}</td>
                                        <td>${{ number_format($sale->total_revenue, 2) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">No sales data available.</td>
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

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('salesChart').getContext('2d');
        const salesData = @json($salesData);
        
        const dates = salesData.map(item => new Date(item.date).toLocaleDateString());
        const revenues = salesData.map(item => item.total_revenue);
        const orders = salesData.map(item => item.total_orders);

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: dates,
                datasets: [
                    {
                        label: 'Revenue',
                        data: revenues,
                        borderColor: 'rgb(75, 192, 192)',
                        tension: 0.1,
                        yAxisID: 'y'
                    },
                    {
                        label: 'Orders',
                        data: orders,
                        borderColor: 'rgb(255, 99, 132)',
                        tension: 0.1,
                        yAxisID: 'y1'
                    }
                ]
            },
            options: {
                responsive: true,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                scales: {
                    y: {
                        type: 'linear',
                        display: true,
                        position: 'left',
                        title: {
                            display: true,
                            text: 'Revenue ($)'
                        }
                    },
                    y1: {
                        type: 'linear',
                        display: true,
                        position: 'right',
                        title: {
                            display: true,
                            text: 'Orders'
                        },
                        grid: {
                            drawOnChartArea: false
                        }
                    }
                }
            }
        });
    });
</script>
@endpush
@endsection 