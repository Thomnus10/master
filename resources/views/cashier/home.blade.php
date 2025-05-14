@extends('layouts.pos')

@section('title', 'Cashier Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="mb-0" style="color: var(--primary-accent); font-weight: 600;">Cashier Dashboard</h2>
                <div>
                    <span class="badge bg-primary fs-6">{{ $today }}</span>
                </div>
            </div>
            
            <!-- Summary Cards -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card shadow-sm border-primary">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted mb-2">Total Sales</h6>
                                    <h3 class="mb-0">₱{{ number_format($totalSales, 2) }}</h3>
                                </div>
                                <div class="bg-primary bg-opacity-10 p-3 rounded">
                                    <i class="bi bi-currency-dollar fs-4 text-primary"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card shadow-sm border-success">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted mb-2">Transactions</h6>
                                    <h3 class="mb-0">{{ $totalTransactions }}</h3>
                                </div>
                                <div class="bg-success bg-opacity-10 p-3 rounded">
                                    <i class="bi bi-receipt fs-4 text-success"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card shadow-sm border-info">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted mb-2">Items Sold</h6>
                                    <h3 class="mb-0">{{ $totalItemsSold }}</h3>
                                </div>
                                <div class="bg-info bg-opacity-10 p-3 rounded">
                                    <i class="bi bi-box-seam fs-4 text-info"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- POS Quick Access -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0" style="color: var(--primary-accent);">
                            <i class="bi bi-cash-stack me-2"></i>Point of Sale
                        </h5>
                        <a href="{{ route('cashier.pos.index') }}" class="btn btn-primary">
                            <i class="bi bi-arrow-right me-1"></i> Open POS
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Today's Transactions -->
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0" style="color: var(--primary-accent);">
                        <i class="bi bi-clock-history me-2"></i>Today's Transactions
                    </h5>
                    <button class="btn btn-sm btn-outline-primary" id="printDailyReport">
                        <i class="bi bi-printer me-1"></i> Print Report
                    </button>
                </div>
                <div class="card-body">
                    @if($orders->isEmpty())
                        <div class="text-center py-5">
                            <i class="bi bi-cart-x fs-1 text-muted"></i>
                            <p class="mt-3 text-muted">No transactions yet today</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover" id="dailyTransactionsTable">
                                <thead>
                                    <tr>
                                        <th>Order #</th>
                                        <th>Time</th>
                                        <th>Cashier</th>
                                        <th>Items</th>
                                        <th>Payment Method</th>
                                        <th>Total</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                    <tr>
                                        <td>{{ $order->id }}</td>
                                        <td>{{ $order->created_at->format('h:i A') }}</td>
                                        <td>
                                            @if($order->employee)
                                                {{ $order->employee->Fname }} 
                                                {{ $order->employee->Mname ? $order->employee->Mname . ' ' : '' }}
                                                {{ $order->employee->Lname }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td>{{ $order->products->sum('pivot.quantity') }}</td>
                                        <td>
                                            @switch($order->payment_method)
                                                @case('cash') 💵 Cash @break
                                                @case('card') 💳 Card @break
                                                @case('digital') 📱 Mobile @break
                                                @default {{ $order->payment_method }}
                                            @endswitch
                                        </td>
                                        <td>₱{{ number_format($order->total_amount, 2) }}</td>
                                        <td>
                                            <a href="{{ route('orders.print_receipt', $order) }}" 
                                               class="btn btn-sm btn-outline-secondary" 
                                               title="Print Receipt">
                                                <i class="bi bi-receipt"></i>
                                            </a>
                                            <a href="{{ route('cashier.show', $order) }}" 
                                               class="btn btn-sm btn-outline-primary" 
                                               title="View Details">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Print Modal -->
<div class="modal fade" id="printModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Print Daily Sales Report</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Report Title</label>
                    <input type="text" class="form-control" id="reportTitle" value="Daily Sales Report - {{ $today }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Include</label>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="includeSummary" checked>
                        <label class="form-check-label" for="includeSummary">Summary Statistics</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="includeTransactions" checked>
                        <label class="form-check-label" for="includeTransactions">Transaction List</label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="confirmPrint">Print</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Print Daily Report
    document.getElementById('printDailyReport').addEventListener('click', function() {
        var printModal = new bootstrap.Modal(document.getElementById('printModal'));
        printModal.show();
    });
    
    document.getElementById('confirmPrint').addEventListener('click', function() {
        // Get print options
        const title = document.getElementById('reportTitle').value;
        const includeSummary = document.getElementById('includeSummary').checked;
        const includeTransactions = document.getElementById('includeTransactions').checked;
        
        // Open print view in new tab
        const printUrl = "{{ route('cashier.print.daily') }}" + 
            `?title=${encodeURIComponent(title)}` +
            `&includeSummary=${includeSummary}` +
            `&includeTransactions=${includeTransactions}`;
        
        window.open(printUrl, '_blank');
        
        // Close modal
        var printModal = bootstrap.Modal.getInstance(document.getElementById('printModal'));
        printModal.hide();
    });
});
</script>
@endsection