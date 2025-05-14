@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h1 class="card-title h3 mb-4 text-primary">Sales Report Dashboard</h1>

            <!-- Filter Form -->
            <form method="GET" action="{{ route('sales.report') }}" class="bg-light p-4 rounded mb-4">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label for="start_date" class="form-label fw-bold">Start Date</label>
                        <input type="date" id="start_date" name="start_date" class="form-control" value="{{ $startDate }}">
                    </div>
                    <div class="col-md-3">
                        <label for="end_date" class="form-label fw-bold">End Date</label>
                        <input type="date" id="end_date" name="end_date" class="form-control" value="{{ $endDate }}">
                    </div>
                    <div class="col-md-3">
                        <label for="period" class="form-label fw-bold">Period</label>
                        <select name="period" id="period" class="form-select">
                            <option value="daily" {{ $period === 'daily' ? 'selected' : '' }}>Daily</option>
                            <option value="weekly" {{ $period === 'weekly' ? 'selected' : '' }}>Weekly</option>
                            <option value="monthly" {{ $period === 'monthly' ? 'selected' : '' }}>Monthly</option>
                        </select>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-filter"></i> Apply Filters
                        </button>
                    </div>
                </div>
            </form>

            <!-- Summary Cards -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card text-center bg-primary bg-opacity-10 border-0">
                        <div class="card-body">
                            <h5 class="card-title text-primary">Total Sales</h5>
                            <h2 class="mb-0">${{ number_format($sales->sum(function($group) { 
                                return $group->sum('total_sales');
                            }), 2) }}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-center bg-success bg-opacity-10 border-0">
                        <div class="card-body">
                            <h5 class="card-title text-success">Total Orders</h5>
                            <h2 class="mb-0">{{ $sales->sum(function($group) { 
                                return $group->sum('total_orders');
                            }) }}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-center bg-info bg-opacity-10 border-0">
                        <div class="card-body">
                            <h5 class="card-title text-info">Average Order Value</h5>
                            <h2 class="mb-0">
                                ${{ number_format(
                                    $sales->sum(function($group) { return $group->sum('total_sales'); }) / 
                                    max(1, $sales->sum(function($group) { return $group->sum('total_orders'); })), 
                                2) }}
                            </h2>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Chart -->
                <div class="col-lg-7 mb-4">
                    <div class="card h-100">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Sales Trend</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="salesChart" height="250"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Sales Report Table -->
                <div class="col-lg-5 mb-4">
                    <div class="card h-100">
                        <div class="card-header bg-white d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Sales Breakdown</h5>
                            <button class="btn btn-sm btn-outline-secondary" id="downloadReport">
                                <i class="bi bi-download"></i> Export
                            </button>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>{{ ucfirst($period) }}</th>
                                            <th>Payment Type</th>
                                            <th class="text-end">Sales</th>
                                            <th class="text-end">Orders</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($sales as $periodGroup => $group)
                                            @foreach($group as $sale)
                                                <tr>
                                                    <td>{{ $periodGroup }}</td>
                                                    <td>
                                                        <span class="badge {{ $sale->payment_method === 'credit' ? 'bg-primary' : ($sale->payment_method === 'cash' ? 'bg-success' : 'bg-info') }} rounded-pill">
                                                            {{ ucfirst($sale->payment_method) }}
                                                        </span>
                                                    </td>
                                                    <td class="text-end fw-bold">${{ number_format($sale->total_sales, 2) }}</td>
                                                    <td class="text-end">{{ $sale->total_orders }}</td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css"></script>
<script>
    // Initialize Chart
    const ctx = document.getElementById('salesChart').getContext('2d');
    const salesChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($labels) !!},
            datasets: {!! json_encode($datasets) !!}
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        usePointStyle: true,
                        boxWidth: 10
                    }
                },
                title: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (context.parsed.y !== null) {
                                label += new Intl.NumberFormat('en-US', {
                                    style: 'currency',
                                    currency: 'USD'
                                }).format(context.parsed.y);
                            }
                            return label;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return '$' + value.toLocaleString();
                        }
                    },
                    title: {
                        display: true,
                        text: 'Total Sales'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: '{{ ucfirst($period) }}'
                    }
                }
            }
        }
    });

    // Export functionality
    document.getElementById('downloadReport').addEventListener('click', function() {
        // Implement export functionality here
        alert('Report download started');
    });

    // Form validation
    document.querySelector('form').addEventListener('submit', function(e) {
        const startDate = document.getElementById('start_date').value;
        const endDate = document.getElementById('end_date').value;
        
        if(startDate > endDate) {
            e.preventDefault();
            alert('Start date cannot be after end date');
        }
    });
</script>
@endpush