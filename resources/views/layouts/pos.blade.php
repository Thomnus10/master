<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'POS System')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Add this line to the head section of layouts.pos -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-accent: #13213C;
            --primary-base: #030303;
            --complementary-accent: #FCA311;
            --secondary-palette-1: #FDFDFD;
            --secondary-palette-2: #E5E5E5;
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Arial, sans-serif;
        }
        body {
            background-color: var(--secondary-palette-2);
            color: var(--primary-base);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .navbar {
            background-color: var(--primary-accent);
            color: var(--secondary-palette-1);
            padding: .75rem 1.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .navbar-brand, .navbar-text {
            color: var(--secondary-palette-1) !important;
        }
        .navbar-brand {
            font-size: 1.5rem;
            font-weight: 700;
            letter-spacing: 0.5px;
        }
        .cashier-avatar {
            width: 35px;
            height: 35px;
            background-color: var(--complementary-accent);
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            color: var(--primary-accent);
            font-weight: bold;
            margin-left: 10px;
        }
        .main-container {
            display: flex;
            flex: 1;
        }
        .content-area {
            flex: 7;
            padding: 20px;
            background-color: var(--secondary-palette-1);
        }
        .cart-area {
            flex: 3;
            background-color: var(--primary-accent);
            color: var(--secondary-palette-1);
            padding: 20px;
            display: flex;
            flex-direction: column;
        }
        .btn-primary {
            background-color: var(--complementary-accent);
            border-color: var(--complementary-accent);
            color: var(--primary-accent);
            font-weight: bold;
        }
        .btn-primary:hover {
            background-color: var(--complementary-accent);
            opacity: 0.9;
        }
        .btn-outline-light {
            color: var(--secondary-palette-1);
            border-color: var(--secondary-palette-1);
            transition: all 0.2s ease;
        }
        .btn-outline-light:hover {
            background-color: var(--complementary-accent);
            border-color: var(--complementary-accent);
            color: var(--primary-accent);
        }
        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
            transition: all 0.2s ease;
        }
        .btn-danger:hover {
            background-color: #bb2d3b;
            border-color: #bb2d3b;
        }
        .rounded-pill {
            border-radius: 50rem!important;
        }
        .table th {
            background-color: var(--primary-accent);
            color: var(--secondary-palette-1);
        }
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: var(--secondary-palette-2);
        }
        .form-control:focus {
            border-color: var(--complementary-accent);
            box-shadow: 0 0 0 0.25rem rgba(252, 163, 17, 0.25);
        }
        .cart-header, .customer-info, .cashier-details {
            margin-bottom: 15px;
        }
        .cart-item {
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px solid var(--complementary-accent);
        }
        .cart-summary {
            margin-top: auto;
        }
        .total-price {
            background-color: var(--secondary-palette-1);
            color: var(--primary-accent);
            padding: 10px;
            text-align: right;
            font-size: 18px;
            font-weight: bold;
            margin: 10px 0;
        }
        .action-buttons {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-top: 15px;
        }
        .action-button {
            background-color: var(--complementary-accent);
            color: var(--primary-accent);
            border: none;
            padding: 12px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            border-radius: 4px;
        }
        .action-button:hover {
            opacity: 0.9;
        }
        .action-button.payment {
            grid-column: span 2;
        }
        .alert {
            border-radius: 0;
            margin-bottom: 0;
        }
        .receipt-box {
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 10px;
        background: #fff;
    }
    .receipt-box table {
        width: 100%;
        font-size: 14px;
    }
    .receipt-box th, .receipt-box td {
        padding: 5px;
    }
    </style>
    @yield('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('cashier.pos.index') }}">
                <i class="bi bi-cart4 me-2"></i>
                DOWENCE MARKET
            </a>
            <div class="ms-auto d-flex align-items-center">
                <!-- Home Button -->
                <a href="{{ route('cashier.home') }}" class="btn btn-sm btn-outline-light me-3">
                    <i class="bi bi-house-door me-1"></i>Home
                </a>
                
                <div class="d-flex align-items-center bg-light bg-opacity-10 px-3 py-2 rounded-pill me-3">
                    <i class="bi bi-person-badge me-2"></i>
                    <span class="navbar-text">{{ $employee->Fname ?? 'Jane' }} {{ $employee->Lname ?? 'Doe' }}</span>
                </div>
                
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-danger rounded-pill px-3">
                        <i class="bi bi-box-arrow-right me-1"></i>Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    @if(session('success'))
    <div class="alert alert-success text-center">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger text-center">
        {{ session('error') }}
    </div>
    @endif

    <!-- Main Container -->
    <div class="main-container">
        <!-- Content Area -->
        <div class="content-area">
            @yield('content')
        </div>

        <!-- Cart Area -->
        <div class="cart-area">
            @yield('cart')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>