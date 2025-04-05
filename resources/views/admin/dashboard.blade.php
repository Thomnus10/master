<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #e8f5e9;
            color: #2E7D32;
            transition: margin-left 0.3s ease-in-out;
        }

        .card {
            color: white;
            text-align: center;
        }

        .card:hover {
            opacity: 0.9;
            transform: scale(1.02);
            transition: all 0.3s ease-in-out;
            cursor: pointer;
        }

        .bg-blue {
            background-color: #3b5998;
        }

        .bg-purple {
            background-color: #6f42c1;
        }

        .bg-orange {
            background-color: #fd7e14;
        }

        .bg-green {
            background-color: #28a745;
        }

        .bg-red {
            background-color: #dc3545;
        }

        .sidebar {
            width: 250px;
            height: 100vh;
            background: linear-gradient(180deg, #1B5E20, #388E3C);
            position: fixed;
            top: 0;
            left: 0;
            padding: 20px;
            color: white;
            transition: width 0.3s ease-in-out;
            box-shadow: 4px 0 10px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }

        .sidebar.collapsed {
            width: 70px;
        }

        .sidebar-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            transition: padding 0.3s;
        }

        .toggle-btn {
            background: none;
            border: none;
            color: white;
            font-size: 1.4rem;
            cursor: pointer;
            transition: transform 0.3s;
        }

        .sidebar.collapsed .toggle-btn {
            transform: rotate(180deg);
        }

        .sidebar-header span {
            transition: opacity 0.3s ease-in-out, margin-left 0.3s ease-in-out;
        }

        .sidebar.collapsed .sidebar-header span {
            opacity: 0;
            margin-left: -20px;
        }

        .nav-link {
            color: white;
            font-weight: 500;
            padding: 12px 15px;
            transition: 0.3s;
            border-radius: 5px;
            display: flex;
            align-items: center;
            gap: 15px;
            white-space: nowrap;
        }

        .nav-link i {
            font-size: 1.4rem;
            min-width: 30px;
            text-align: center;
            transition: margin-left 0.3s ease-in-out;
        }

        .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.2);
            transform: none;
            color: #FFD700 !important;
        }

        .nav-link.active {
            background-color: #1E8E3E;
        }

        .sidebar.collapsed .nav-link span {
            opacity: 0;
            width: 0;
            transition: opacity 0.2s ease-in-out, width 0.2s ease-in-out;
        }

        .sidebar.collapsed .nav-link {
            justify-content: center;
            padding: 12px 0;
        }

        .sidebar.collapsed .nav-link i {
            margin-left: 0;
        }

        .main-content {
            margin-left: 250px;
            padding: 20px;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            transition: margin-left 0.3s ease-in-out;
        }

        .brand-title {
            font-size: 3rem;
            font-weight: bold;
            color: #1B5E20;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
        }

        .sidebar.collapsed+.main-content {
            margin-left: 70px;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 70px;
                padding: 10px;
            }

            .sidebar-header span {
                display: none;
            }

            .main-content {
                margin-left: 70px;
            }

            .nav-link {
                justify-content: center;
                padding: 10px;
            }

            .nav-link span {
                display: none;
            }
        }
    </style>
</head>

<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h4>POS Groceries</h4>
        <ul class="nav flex-column">
            <li class="nav-item"><a href="{{ route('admin.dashboard') }}" class="nav-link"><i class="bi bi-house-door"></i> Home</a></li>
            <li class="nav-item"><a href="{{ route('admin.dashboard') }}" class="nav-link"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
            <li class="nav-item"><a href="{{ route('admin.inventory') }}" class="nav-link"><i class="bi bi-box-seam"></i> Inventory</a></li>
            <li class="nav-item"><a href="{{ route('admin.suppliers') }}" class="nav-link"><i class="bi bi-person"></i> Suppliers</a></li>
            <li class="nav-item"><a href="{{ route('admin.products') }}" class="nav-link"><i class="bi bi-box"></i> Products</a></li>
            <li class="nav-item"><a href="{{ route('admin.transaction') }}" class="nav-link"><i class="bi bi-receipt"></i> Transactions</a></li>
            <li class="nav-item"><a href="{{ route('admin.user') }}" class="nav-link"><i class="bi bi-people"></i> Users</a></li>
            <li class="nav-item"><a href="{{ route('admin.purchase') }}" class="nav-link"><i class="bi bi-cart"></i> Purchase</a></li>
            <li class="nav-item"><a href="{{ route('admin.expenses') }}" class="nav-link"><i class="bi bi-wallet2"></i> Expenses</a></li>
            <li class="nav-item"><a href="{{ route('logout') }}" class="nav-link"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container mt-4">
            <div class="row">
                <div class="col-md-3 mb-3">
                    <a href="{{ route('admin.transaction') }}" style="text-decoration: none;">
                        <div class="card bg-blue p-3">
                            <h3>5</h3>
                            <p>Total Categories</p>
                        </div>
                    </a>
                </div>
                <div class="col-md-3 mb-3">
                    <a href="{{ route('admin.inventory') }}" style="text-decoration: none;">
                        <div class="card bg-purple p-3">
                            <h3>7</h3>
                            <p>Total Product</p>
                        </div>
                    </a>
                </div>
                <div class="col-md-3 mb-3">
                    <a href="{{ route('admin.user') }}" style="text-decoration: none;">
                        <div class="card bg-orange p-3">
                            <h3>7</h3>
                            <p>Total Member</p>
                        </div>
                    </a>
                </div>
                <div class="col-md-3 mb-3">
                    <a href="{{ route('admin.suppliers') }}" style="text-decoration: none;">
                        <div class="card bg-green p-3">
                            <h3>3</h3>
                            <p>Total Supplier</p>
                        </div>
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <a href="{{ route('admin.transaction') }}" style="text-decoration: none;">
                        <div class="card bg-green p-3">
                            <h3>1645</h3>
                            <p>Sales</p>
                        </div>
                    </a>
                </div>
                <div class="col-md-4 mb-3">
                    <a href="{{ route('admin.suppliers') }}" style="text-decoration: none;">
                        <div class="card bg-red p-3">
                            <h3>198</h3>
                            <p>Total Expenses</p>
                        </div>
                    </a>
                </div>
                <div class="col-md-4 mb-3">
                    <a href="{{ route('admin.suppliers') }}" style="text-decoration: none;">
                        <div class="card bg-green p-3">
                            <h3>1144</h3>
                            <p>Total Purchase</p>
                        </div>
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card p-3">
                        <h4>Income Chart 01 October 2023 - 05 October 2023</h4>
                        <canvas id="incomeChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <script>
            var ctx = document.getElementById('incomeChart').getContext('2d');
            var incomeChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['1', '2', '3', '4', '5'],
                    datasets: [{
                        label: 'Income',
                        data: [-150, 250, -50, 100, 350],
                        backgroundColor: 'rgba(54, 162, 235, 0.5)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 2,
                        fill: true,
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: false
                        }
                    }
                }
            });
        </script>
    </div>

    <script>
        function toggleSidebar() {
            let sidebar = document.getElementById("sidebar");
            sidebar.classList.toggle("collapsed");
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
