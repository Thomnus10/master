<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #e8f5e9;
            color: #2E7D32;
            transition: margin-left 0.3s ease-in-out;
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
            font-size: 1.5rem;
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

        .sidebar.collapsed + .main-content {
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
<div class="sidebar">
    <h4>POS Groceries</h4>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a href="{{ route('admin.dashboard') }}" class="nav-link">
                <i class="bi bi-house-door"></i> Home
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.dashboard') }}" class="nav-link">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.inventory') }}" class="nav-link">
                <i class="bi bi-box-seam"></i> Inventory
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.suppliers') }}" class="nav-link">
                <i class="bi bi-person"></i> Suppliers
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.products') }}" class="nav-link">
                <i class="bi bi-box"></i> Products
            </a>
        </li>
        
        <!-- Purchase Section -->
        <li class="nav-item">
            <a href="{{ route('admin.purchase') }}" class="nav-link">
                <i class="bi bi-cart"></i> Purchase
            </a>
        </li>
        
                <li class="nav-item">
            <a href="{{ route('admin.expenses.list') }}" class="nav-link">
                <i class="bi bi-file-earmark-text"></i> Expenses
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('admin.transaction') }}" class="nav-link">
                <i class="bi bi-receipt"></i> Transactions
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.user') }}" class="nav-link">
                <i class="bi bi-people"></i> Users
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('logout') }}" class="nav-link">
                <i class="bi bi-box-arrow-right"></i> Logout
            </a>
        </li>
    </ul>
</div>

    <div class="main-content">
        @yield('content')
    </div>

    <script>
        function toggleSidebar() {
            let sidebar = document.getElementById("sidebar");
            sidebar.classList.toggle("collapsed");
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
