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

        /* Hide text when sidebar is collapsed */
        .sidebar.collapsed .nav-link span {
            opacity: 0;
            width: 0;
            transition: opacity 0.2s ease-in-out, width 0.2s ease-in-out;
        }

        /* Center icons properly in collapsed mode */
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

        /* Adjust content margin when sidebar is collapsed */
        .sidebar.collapsed + .main-content {
            margin-left: 70px;
        }

        /* Mobile Responsive */
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
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <button class="toggle-btn" onclick="toggleSidebar()"><i class="bi bi-chevron-left"></i></button>
            <span>@yield('title', 'Admin Panel')</span>
        </div>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="{{ route('admin.home') }}" class="nav-link {{ request()->routeIs('admin.home') ? 'active' : '' }}">
                    <i class="bi bi-house-door"></i> <span>Home</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i> <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.inventory') }}" class="nav-link {{ request()->routeIs('admin.inventory') ? 'active' : '' }}">
                    <i class="bi bi-box-seam"></i> <span>Inventory</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.transaction') }}" class="nav-link {{ request()->routeIs('admin.transaction') ? 'active' : '' }}">
                    <i class="bi bi-receipt"></i> <span>Transaction</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.user') }}" class="nav-link {{ request()->routeIs('admin.user') ? 'active' : '' }}">
                    <i class="bi bi-people"></i> <span>User</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.employee') }}" class="nav-link {{ request()->routeIs('admin.employee') ? 'active' : '' }}">
                    <i class="bi bi-person-badge"></i> <span>Employee</span>
                </a>
            </li>
            <!-- Add the Logout Form -->
            <li class="nav-item">
                <form action="{{ route('logout') }}" method="POST" class="nav-link d-flex align-items-center">
                    @csrf
                    <button type="submit" class="btn btn-link text-white" style="border: none; background: none;">
                        <i class="bi bi-box-arrow-right"></i> <span>Logout</span>
                    </button>
                </form>
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
