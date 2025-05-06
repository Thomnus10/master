<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'POS System')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
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
            font-family: Arial, sans-serif;
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
            padding: 15px 20px;
        }
        .navbar-brand, .navbar-text {
            color: var(--secondary-palette-1) !important;
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
            opacity: 0.9;
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
    </style>
    @yield('styles')
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('cashier.index') }}">DOWENCE MARKET</a>
            <div class="ms-auto d-flex align-items-center">
                <span class="navbar-text me-2">Cashier: {{ Auth::user()->name ?? 'Jane Doe' }}</span>
                <div class="cashier-avatar">{{ Auth::user() ? substr(Auth::user()->name, 0, 2) : 'JD' }}</div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="dropdown-item">
                        <i class="bi bi-box-arrow-right me-2"></i>Logout
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
