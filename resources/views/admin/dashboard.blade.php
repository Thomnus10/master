@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <!-- Header Section with Welcome Message & Date -->
        <div class="col-12 mb-4">
            <div class="card shadow-sm">
                <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                    <div>
                        <h1 class="h3 fw-bold text-dark">Welcome back, Admin</h1>
                        <p class="text-muted mt-1">Here's what's happening with your store today</p>
                    </div>
                    <div class="mt-3 mt-md-0">
                        <div class="badge bg-primary bg-opacity-10 text-primary p-2 rounded-pill">
                            <i class="bi bi-calendar3 me-2"></i>{{ date('l, F j, Y') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Key Financial Metrics -->
        <div class="col-md-3 col-sm-6 mb-4">
            <!-- Today's Sales -->
            <div class="card shadow-sm h-100 border-0 position-relative">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted small fw-semibold">Today's Sales</p>
                            <p class="h3 fw-bold mt-2">{{ $todaySales }}</p>
                        </div>
                        <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                            <i class="bi bi-currency-dollar text-primary fs-4"></i>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mt-3">
                        @if($salesChange > 0)
                            <span class="text-success d-flex align-items-center small">
                                <i class="bi bi-arrow-up-short me-1"></i>{{ $salesChange }}%
                            </span>
                        @else
                            <span class="text-danger d-flex align-items-center small">
                                <i class="bi bi-arrow-down-short me-1"></i>{{ abs($salesChange) }}%
                            </span>
                        @endif
                        <span class="text-muted small ms-2">from yesterday</span>
                    </div>
                </div>
                <div class="progress" style="height: 4px;">
                    <div class="progress-bar bg-primary" role="progressbar" style="width: 100%"></div>
                </div>
            </div>
        </div>
        
        <!-- Weekly Revenue -->
        <div class="col-md-3 col-sm-6 mb-4">
            <div class="card shadow-sm h-100 border-0 position-relative">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted small fw-semibold">Weekly Revenue</p>
                            <p class="h3 fw-bold mt-2">{{ $weeklyRevenue }}</p>
                        </div>
                        <div class="rounded-circle bg-success bg-opacity-10 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                            <i class="bi bi-graph-up-arrow text-success fs-4"></i>
                        </div>
                    </div>
                    <p class="text-muted small mt-3">Last 7 days</p>
                </div>
                <div class="progress" style="height: 4px;">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 100%"></div>
                </div>
            </div>
        </div>
        
        <!-- Monthly Revenue -->
        <div class="col-md-3 col-sm-6 mb-4">
            <div class="card shadow-sm h-100 border-0 position-relative">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted small fw-semibold">Monthly Revenue</p>
                            <p class="h3 fw-bold mt-2">{{ $monthlyRevenue }}</p>
                        </div>
                        <div class="rounded-circle bg-purple bg-opacity-10 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                            <i class="bi bi-calendar-check text-purple fs-4" style="color: #6f42c1;"></i>
                        </div>
                    </div>
                    <p class="text-muted small mt-3">{{ $currentMonth }}</p>
                </div>
                <div class="progress" style="height: 4px;">
                    <div class="progress-bar" role="progressbar" style="width: 100%; background-color: #6f42c1;"></div>
                </div>
            </div>
        </div>
        
        <!-- Total Orders Today -->
        <div class="col-md-3 col-sm-6 mb-4">
            <div class="card shadow-sm h-100 border-0 position-relative">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted small fw-semibold">Total Orders</p>
                            <p class="h3 fw-bold mt-2">{{ $todayOrders }}</p>
                        </div>
                        <div class="rounded-circle bg-warning bg-opacity-10 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                            <i class="bi bi-bag text-warning fs-4"></i>
                        </div>
                    </div>
                    <p class="text-muted small mt-3">Avg. {{ $avgOrderValue }} per order</p>
                </div>
                <div class="progress" style="height: 4px;">
                    <div class="progress-bar bg-warning" role="progressbar" style="width: 100%"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Dashboard Content -->
    <div class="row mb-4">
        <!-- Sales Chart (Span 2 columns) -->
        <div class="col-lg-8 mb-4 mb-lg-0">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                <i class="bi bi-graph-up text-primary"></i>
                            </div>
                            <h5 class="fw-bold mb-0">Sales Overview</h5>
                        </div>
                        <select id="salesPeriod" class="form-select form-select-sm" style="width: auto;">
                            <option value="week">This Week</option>
                            <option value="month">This Month</option>
                            <option value="quarter">This Quarter</option>
                        </select>
                    </div>
                    <div style="height: 350px;" id="salesChart"></div>
                </div>
            </div>
        </div>

        <!-- Top Selling Products -->
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-4">
                        <div class="rounded-circle bg-success bg-opacity-10 d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                            <i class="bi bi-trophy text-success"></i>
                        </div>
                        <h5 class="fw-bold mb-0">Top Selling Products</h5>
                    </div>
                    <div class="d-flex flex-column gap-3">
                        @foreach($topSellingProducts as $product)
                            <div class="d-flex align-items-center justify-content-between p-3 bg-light rounded">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3" style="width: 32px; height: 32px;">
                                        <span class="small fw-bold">{{ $loop->iteration }}</span>
                                    </div>
                                    <div>
                                        <p class="mb-0 fw-medium">{{ $product['name'] }}</p>
                                        <p class="text-muted small mb-0">{{ $product['category'] }}</p>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <p class="mb-0 fw-medium">{{ $product['quantity'] }} sold</p>
                                    <p class="text-success small mb-0">{{ $product['revenue'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Inventory Overview Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-4">
                        <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                            <i class="bi bi-box-seam text-primary"></i>
                        </div>
                        <h5 class="fw-bold mb-0">Inventory Overview</h5>
                    </div>
                    
                    <div class="row">
                        <!-- Total Products -->
                        <div class="col-md-3 col-sm-6 mb-4">
                            <div class="card bg-light border-0 text-center">
                                <div class="card-body">
                                    <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 48px; height: 48px;">
                                        <i class="bi bi-box text-primary"></i>
                                    </div>
                                    <p class="h3 fw-bold mb-0">{{ $totalProducts }}</p>
                                    <p class="text-muted small mt-1">Total Products</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Low Stock Items -->
                        <div class="col-md-3 col-sm-6 mb-4">
                            <div class="card bg-light border-0 text-center">
                                <div class="card-body">
                                    <div class="rounded-circle bg-warning bg-opacity-10 d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 48px; height: 48px;">
                                        <i class="bi bi-exclamation-triangle text-warning"></i>
                                    </div>
                                    <p class="h3 fw-bold text-warning mb-0">{{ $lowStockProducts }}</p>
                                    <p class="text-muted small mt-1">Low Stock Items</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Out of Stock -->
                        <div class="col-md-3 col-sm-6 mb-4">
                            <div class="card bg-light border-0 text-center">
                                <div class="card-body">
                                    <div class="rounded-circle bg-danger bg-opacity-10 d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 48px; height: 48px;">
                                        <i class="bi bi-x-circle text-danger"></i>
                                    </div>
                                    <p class="h3 fw-bold text-danger mb-0">{{ $outOfStockProducts }}</p>
                                    <p class="text-muted small mt-1">Out of Stock</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Expiring Soon -->
                        <div class="col-md-3 col-sm-6 mb-4">
                            <div class="card bg-light border-0 text-center">
                                <div class="card-body">
                                    <div class="rounded-circle bg-orange bg-opacity-10 d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 48px; height: 48px;">
                                        <i class="bi bi-clock-history" style="color: #fd7e14;"></i>
                                    </div>
                                    <p class="h3 fw-bold mb-0" style="color: #fd7e14;">{{ $expiringSoonProducts }}</p>
                                    <p class="text-muted small mt-1">Expiring Within 7 Days</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Second Row -->
    <div class="row">
        <!-- Category Sales Breakdown -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-4">
                        <div class="rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px; background-color: rgba(111, 66, 193, 0.1);">
                            <i class="bi bi-pie-chart" style="color: #6f42c1;"></i>
                        </div>
                        <h5 class="fw-bold mb-0">Category Breakdown</h5>
                    </div>
                    <div style="height: 350px;" id="categoryChart"></div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-4">
                        <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                            <i class="bi bi-activity text-primary"></i>
                        </div>
                        <h5 class="fw-bold mb-0">Recent Activity</h5>
                    </div>
                    <div class="d-flex flex-column gap-3">
                        @foreach($recentActivities as $activity)
                            <div class="d-flex align-items-start p-3 bg-light rounded">
                                <div class="rounded-circle d-flex align-items-center justify-content-center me-3 mt-1
                                    @if($activity->icon == 'plus') bg-success bg-opacity-10 @endif
                                    @if($activity->icon == 'user') bg-primary bg-opacity-10 @endif
                                    @if($activity->icon == 'truck') bg-purple bg-opacity-10 @endif
                                    @if($activity->icon == 'exclamation-triangle') bg-warning bg-opacity-10 @endif
                                    @if($activity->icon == 'dollar-sign') bg-info bg-opacity-10 @endif
                                " style="width: 32px; height: 32px;">
                                    <i class="bi bi-{{ $activity->icon == 'plus' ? 'plus' : 
                                                       ($activity->icon == 'user' ? 'person' : 
                                                       ($activity->icon == 'truck' ? 'truck' : 
                                                       ($activity->icon == 'exclamation-triangle' ? 'exclamation-triangle' : 
                                                       ($activity->icon == 'dollar-sign' ? 'currency-dollar' : '')))) }} 
                                    @if($activity->icon == 'plus') text-success @endif
                                    @if($activity->icon == 'user') text-primary @endif
                                    @if($activity->icon == 'truck') text-purple @endif
                                    @if($activity->icon == 'exclamation-triangle') text-warning @endif
                                    @if($activity->icon == 'dollar-sign') text-info @endif
                                    "></i>
                                </div>
                                <div>
                                    <p class="mb-1 small fw-medium">{{ $activity->description }}</p>
                                    <p class="text-muted small mb-0">{{ $activity->time }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Staff & Quick Links -->
        <div class="col-lg-4">
            <!-- Staff Overview -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-4">
                        <div class="rounded-circle bg-indigo bg-opacity-10 d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px; background-color: rgba(102, 16, 242, 0.1);">
                            <i class="bi bi-people" style="color: #6610f2;"></i>
                        </div>
                        <h5 class="fw-bold mb-0">Staff Overview</h5>
                    </div>
                    <div class="row text-center">
                        <div class="col-4">
                            <div class="card bg-indigo bg-opacity-10 border-0 p-3">
                                <p class="h3 fw-bold mb-0" style="color: #6610f2;">{{ $totalEmployees }}</p>
                                <p class="text-muted small mb-0">Total Staff</p>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="card bg-primary bg-opacity-10 border-0 p-3">
                                <p class="h3 fw-bold mb-0 text-primary">{{ $totalCashiers }}</p>
                                <p class="text-muted small mb-0">Cashiers</p>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="card bg-success bg-opacity-10 border-0 p-3">
                                <p class="h3 fw-bold mb-0 text-success">{{ $totalManagers }}</p>
                                <p class="text-muted small mb-0">Managers</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-4">
                        <div class="rounded-circle bg-warning bg-opacity-10 d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                            <i class="bi bi-grid text-warning"></i>
                        </div>
                        <h5 class="fw-bold mb-0">Quick Actions</h5>
                    </div>
                    <div class="row">
                        <div class="col-6 mb-3">
                            <a href="{{ route('admin.inventory') }}" class="card bg-light border-0 text-center text-decoration-none h-100">
                                <div class="card-body">
                                    <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 48px; height: 48px;">
                                        <i class="bi bi-box-seam text-primary"></i>
                                    </div>
                                    <p class="small fw-medium text-dark mb-0">Inventory</p>
                                </div>
                            </a>
                        </div>
                        <div class="col-6 mb-3">
                            <a href="{{ route('requests.index') }}" class="card bg-light border-0 text-center text-decoration-none h-100">
                                <div class="card-body">
                                    <div class="rounded-circle bg-success bg-opacity-10 d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 48px; height: 48px;">
                                        <i class="bi bi-cart text-success"></i>
                                    </div>
                                    <p class="small fw-medium text-dark mb-0">Orders</p>
                                </div>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('sales.report') }}" class="card bg-light border-0 text-center text-decoration-none h-100">
                                <div class="card-body">
                                    <div class="rounded-circle bg-warning bg-opacity-10 d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 48px; height: 48px;">
                                        <i class="bi bi-bar-chart text-warning"></i>
                                    </div>
                                    <p class="small fw-medium text-dark mb-0">Reports</p>
                                </div>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('suppliers.index') }}" class="card bg-light border-0 text-center text-decoration-none h-100">
                                <div class="card-body">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 48px; height: 48px; background-color: rgba(111, 66, 193, 0.1);">
                                        <i class="bi bi-truck" style="color: #6f42c1;"></i>
                                    </div>
                                    <p class="small fw-medium text-dark mb-0">Suppliers</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Initialize Charts
    document.addEventListener('DOMContentLoaded', function() {
        // Sales Chart
        const salesCtx = document.getElementById('salesChart').getContext('2d');
        const salesChart = new Chart(salesCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($salesChartLabels) !!},
                datasets: [{
                    label: 'Sales',
                    data: {!! json_encode($salesChartData) !!},
                    borderColor: '#0d6efd',
                    backgroundColor: 'rgba(13, 110, 253, 0.1)',
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#0d6efd',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: {
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(255, 255, 255, 0.9)',
                        titleColor: '#212529',
                        bodyColor: '#212529',
                        bodyFont: {
                            size: 13
                        },
                        titleFont: {
                            size: 15,
                            weight: 'bold'
                        },
                        padding: 12,
                        borderColor: '#dee2e6',
                        borderWidth: 1,
                        displayColors: false,
                        caretSize: 6,
                        cornerRadius: 8
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            display: true,
                            drawBorder: false,
                            color: 'rgba(0, 0, 0, 0.05)'
                        },
                        ticks: {
                            padding: 10,
                            font: {
                                size: 11
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            padding: 10,
                            font: {
                                size: 11
                            }
                        }
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index'
                }
            }
        });

        // Category Chart
        const categoryCtx = document.getElementById('categoryChart').getContext('2d');
        const categoryChart = new Chart(categoryCtx, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($categoryLabels) !!},
                datasets: [{
                    data: {!! json_encode($categoryData) !!},
                    backgroundColor: [
                        '#0d6efd', '#198754', '#ffc107', '#dc3545', '#6f42c1', '#d63384'
                    ],
                    borderWidth: 0,
                    hoverOffset: 5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            boxWidth: 12,
                            padding: 15,
                            font: {
                                size: 11
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(255, 255, 255, 0.9)',
                        titleColor: '#212529',
                        bodyColor: '#212529',
                        bodyFont: {
                            size: 13
                        },
                        titleFont: {
                            size: 15,
                            weight: 'bold'
                        },
                        padding: 12,
                        borderColor: '#dee2e6',
                        borderWidth: 1,
                        displayColors: true,
                        boxWidth: 10,
                        boxHeight: 10,
                        boxPadding: 3,
                        caretSize: 6,
                        cornerRadius: 8
                    }
                },
                cutout: '70%',
                animation: {
                    animateScale: true
                }
            }
        });
        
        // Sales Period Selector
        document.getElementById('salesPeriod').addEventListener('change', function () {
            const period = this.value;
            fetch(`/admin/dashboard/sales-data?period=${period}`)
                .then(response => response.json())
                .then(data => {
                    salesChart.data.labels = data.labels;
                    salesChart.data.datasets[0].data = data.data;
                    salesChart.update();
                });
        });
    });
</script>
@endpush
@endsection
