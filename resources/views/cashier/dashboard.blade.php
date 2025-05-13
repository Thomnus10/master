@extends('layout.pos')
@section('title', 'Dashboard')

@section('content')
    <h2>Daily Summary</h2>
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Sales</h5>
                    <p class="card-text display-6">₱{{ number_format($totalSales, 2) }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Orders Today</h5>
                    <p class="card-text display-6">{{ $ordersCount }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Top Product</h5>
                    <p class="card-text display-6">{{ $topProduct }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection