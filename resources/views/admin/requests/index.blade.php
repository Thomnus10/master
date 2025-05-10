@extends('layouts.app')

@section('title', 'Product Requests')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h2 class="mb-0">Product Requests</h2>
                <a href="{{ route('requests.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> New Request
                </a>
            </div>

            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <div class="row mb-3">
                    <div class="col-md-4">
                        <form method="GET" action="{{ route('requests.index') }}">
                            <div class="input-group">
                                <select name="status" class="form-select">
                                    <option value="">All Statuses</option>
                                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending
                                    </option>
                                    <option value="received" {{ request('status') === 'received' ? 'selected' : '' }}>Received
                                    </option>
                                </select>
                                <button type="submit" class="btn btn-outline-secondary">Filter</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Product</th>
                                <th>Supplier</th>
                                <th class="text-end">Quantity</th>
                                <th class="text-end">Unit Price</th>
                                <th class="text-end">Total</th>
                                <th>Status</th>
                                <th>Requested At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($requests as $request)
                                <tr>
                                    <td>
                                        <strong>{{ $request->product->name }}</strong><br>
                                        <small
                                            class="text-muted">{{ $request->product->category->name ?? 'No Category' }}</small>
                                    </td>
                                    <td>{{ $request->supplier->name }}</td>
                                    <td class="text-end">{{ number_format($request->quantity) }}</td>
                                    <td class="text-end">₱{{ number_format($request->price, 2) }}</td>
                                    <td class="text-end">₱{{ number_format($request->price * $request->quantity, 2) }}</td>
                                    <td>
                                        <span class="badge bg-{{ $request->status === 'received' ? 'success' : 'warning' }}">
                                            {{ ucfirst($request->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $request->created_at->format('M d, Y h:i A') }}</td>
                                    <td>
                                        @if($request->status !== 'received')
                                            <button class="btn btn-sm btn-success" onclick="openReceiveModal({{ $request->id }})">
                                                <i class="fas fa-check"></i> Receive
                                            </button>
                                        @else
                                            <span class="text-success">
                                                <i class="fas fa-check-circle"></i> Received
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="12" class="text-center py-4">No product requests found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Receive Modal -->
    <div class="modal fade" id="receiveModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" id="receiveForm">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Mark Request as Received</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="expiration_date" class="form-label">Expiration Date *</label>
                            <input type="date" name="expiration_date" class="form-control" required
                                min="{{ now()->format('Y-m-d') }}">
                        </div>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> This will add the requested quantity to inventory.
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-check"></i> Confirm Receipt
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openReceiveModal(id) {
            const form = document.getElementById('receiveForm');
            form.action = `/admin/requests/${id}/receive`;

            // Reset form and set min date to today
            form.reset();
            const dateInput = form.querySelector('input[type="date"]');
            dateInput.min = new Date().toISOString().split('T')[0];

            // Show modal
            const modal = new bootstrap.Modal(document.getElementById('receiveModal'));
            modal.show();
        }
    </script>
@endsection