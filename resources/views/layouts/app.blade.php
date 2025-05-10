<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #E5E5E5;
            color: #13213C;
            transition: margin-left 0.3s ease-in-out;
        }

        .sidebar {
            width: 250px;
            height: 100vh;
            background: linear-gradient(180deg, #030303, #13213C);
            position: fixed;
            top: 0;
            left: 0;
            padding: 20px;
            color: #FDFDFD;
            transition: width 0.3s ease-in-out;
            box-shadow: 4px 0 10px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            z-index: 1030;
        }

        .sidebar.collapsed {
            width: 70px;
        }

        .sidebar-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px;
            border-bottom: 1px solid rgba(253, 253, 253, 0.2);
            transition: padding 0.3s;
        }

        .toggle-btn {
            background: none;
            border: none;
            color: #FDFDFD;
            font-size: 1.5rem;
            cursor: pointer;
            transition: transform 0.3s;
            z-index: 1040;
        }

        .sidebar.collapsed .toggle-btn {
            transform: rotate(180deg);
        }

        /* Hide text completely in collapsed sidebar */
        .sidebar.collapsed .sidebar-header span,
        .sidebar.collapsed .nav-link span,
        .sidebar.collapsed .logout-btn span {
            display: none;
        }

        .sidebar-header span {
            transition: opacity 0.3s ease-in-out, margin-left 0.3s ease-in-out;
            font-weight: 600;
            letter-spacing: -0.5px;
        }

        .sidebar.collapsed .sidebar-header span {
            opacity: 0;
            margin-left: -20px;
        }

        /* Sidebar nav links */
        .sidebar .nav-link {
            color: #FDFDFD;
            font-weight: 500;
            padding: 12px 15px;
            transition: 0.3s;
            border-radius: 5px;
            display: flex;
            align-items: center;
            gap: 15px;
            white-space: nowrap;
        }

        .sidebar .nav-link i {
            font-size: 1.4rem;
            min-width: 30px;
            text-align: center;
            transition: margin-left 0.3s ease-in-out;
        }

        .sidebar .nav-link:hover {
            background-color: rgba(252, 163, 17, 0.1);
            transform: none;
            color: #FCA311 !important;
        }

        .sidebar .nav-link.active {
            background-color: #13213C;
            border-left: 3px solid #FCA311;
        }

        /* Hide text when sidebar is collapsed */
        .sidebar.collapsed .nav-link span {
            display: none;
            opacity: 0;
            width: 0;
            transition: opacity 0.2s ease-in-out, width 0.2s ease-in-out;
        }

        /* Center icons properly in collapsed mode */
        .sidebar.collapsed .nav-link,
        .sidebar.collapsed .logout-btn {
            justify-content: center;
            padding: 12px 0;
            text-align: center;
        }

        .sidebar.collapsed .nav-link i,
        .sidebar.collapsed .logout-btn i {
            margin-left: 0;
            margin-right: 0;
        }

        .main-content {
            margin-left: 250px;
            padding: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: margin-left 0.3s ease-in-out;
            background-color: #FDFDFD;
        }

        .content-wrapper {
            padding: 20px;
            flex-grow: 1;
        }

        .brand-title {
            font-size: 3rem;
            font-weight: bold;
            color: #13213C;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
        }

        /* Adjust content margin when sidebar is collapsed */
        .sidebar.collapsed+.main-content {
            margin-left: 70px;
        }

        /* Company name styling */
        .company-name {
            font-weight: 700;
            font-size: 1.4rem;
            color: #13213C;
            letter-spacing: -0.5px;
            margin-right: 15px;
        }

        /* Toggle button in navbar */
        .navbar-toggle-btn {
            background: none;
            border: none;
            color: #13213C;
            font-size: 1.5rem;
            cursor: pointer;
            transition: transform 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            width: 40px;
            height: 40px;
            border-radius: 50%;
        }

        .navbar-toggle-btn:hover {
            background-color: rgba(19, 33, 60, 0.1);
        }

        /* Typography */
        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-weight: 600;
            color: #13213C;
        }

        .text-accent {
            color: #FCA311;
        }

        .font-light {
            font-weight: 300;
        }

        .font-medium {
            font-weight: 500;
        }

        .font-semibold {
            font-weight: 600;
        }

        .font-bold {
            font-weight: 700;
        }

        /* Navbar styling */
        .navbar {
            border-bottom: 1px solid #E5E5E5;
        }

        .navbar-brand {
            color: #13213C;
            font-weight: 600;
            letter-spacing: -0.5px;
        }

        /* Navbar links */
        .navbar .nav-link {
            color: #13213C !important;
            padding: 8px 16px;
            font-weight: 500;
        }

        .navbar .nav-link:hover {
            color: #FCA311 !important;
            background: none;
        }

        .dropdown-item:active,
        .dropdown-item:focus {
            background-color: #13213C;
            color: #FDFDFD;
        }

        .dropdown-item:hover {
            background-color: rgba(19, 33, 60, 0.1);
            color: #13213C;
        }

        /* Styling for buttons */
        .btn-primary {
            background-color: #13213C;
            border-color: #13213C;
            color: white;
            border-radius: 4px;
            padding: 8px 16px;
            font-size: 14px;
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0a1220;
            border-color: #0a1220;
        }

        .btn-accent {
            background-color: #FCA311;
            border-color: #FCA311;
            color: #030303;
            border-radius: 4px;
            padding: 8px 16px;
            font-size: 14px;
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }

        .btn-accent:hover {
            background-color: #e59310;
            border-color: #e59310;
            color: #030303;
        }

        /* Secondary Button */
        .btn-secondary {
            background-color: #6C757D;
            /* Grayish color */
            border-color: #6C757D;
            color: white;
            border-radius: 4px;
            padding: 8px 16px;
            font-size: 14px;
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }

        .btn-secondary:hover {
            background-color: #5a636b;
            /* Darker gray for hover effect */
            border-color: #5a636b;
        }

        /* Tertiary Button */
        .btn-tertiary {
            background-color: transparent;
            border-color: #13213C;
            /* Same as primary for consistency */
            color: #13213C;
            /* Same color as primary */
            border-radius: 4px;
            padding: 8px 16px;
            font-size: 14px;
            transition: background-color 0.3s ease, border-color 0.3s ease, color 0.3s ease;
        }

        .btn-tertiary:hover {
            background-color: #13213C;
            /* Dark background when hovered */
            color: white;
            /* Change text to white on hover */
            border-color: #13213C;
        }


        /* Logout button styling */
        .logout-btn {
            color: #FDFDFD;
            border: none;
            background: none;
            display: flex;
            align-items: center;
            gap: 15px;
            width: 100%;
            text-align: left;
            padding: 12px 15px;
            font-weight: 500;
            border-radius: 5px;
            transition: 0.3s;
        }

        .logout-btn:hover {
            background-color: rgba(252, 163, 17, 0.1);
            color: #FCA311;
        }

        .logout-btn i {
            font-size: 1.4rem;
            min-width: 30px;
            text-align: center;
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

            .sidebar .nav-link {
                justify-content: center;
                padding: 10px;
            }

            .sidebar .nav-link span {
                display: none;
            }

            .company-name {
                font-size: 1.1rem;
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
                <a href="{{ route('admin.dashboard') }}"
                    class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i> <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.inventory') }}"
                    class="nav-link {{ request()->routeIs('admin.inventory') ? 'active' : '' }}">
                    <i class="bi bi-box-seam"></i> <span>Inventory</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.transaction') }}"
                    class="nav-link {{ request()->routeIs('admin.transaction') ? 'active' : '' }}">
                    <i class="bi bi-receipt"></i> <span>Transaction</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.user') }}"
                    class="nav-link {{ request()->routeIs('admin.user') ? 'active' : '' }}">
                    <i class="bi bi-people"></i> <span>User</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.employee') }}"
                    class="nav-link {{ request()->routeIs('admin.employee') ? 'active' : '' }}">
                    <i class="bi bi-person-badge"></i> <span>Employee</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('suppliers.index') }}"
                    class="nav-link {{ request()->routeIs('admin.supplier') ? 'active' : '' }}">
                    <i class="bi bi-person-badge"></i> <span>Supplier</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('requests.index') }}"
                    class="nav-link {{ request()->routeIs('admin.request') ? 'active' : '' }}">
                    <i class="bi bi-person-badge"></i> <span>Request Product</span>
                </a>
            </li>
            {{-- <li class="nav-item">
                <a href="{{ route('discounts.index') }}"
                    class="nav-link {{ request()->routeIs('admin.discount') ? 'active' : '' }}">
                    <i class="bi bi-person-badge"></i> <span>Discounts</span>
                </a>
            </li> --}}
            <!-- Add the Logout Form -->
            {{-- <li class="nav-item mt-auto">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <i class="bi bi-box-arrow-right"></i> <span>Logout</span>
                    </button>
                </form>
            </li> --}}
        </ul>
    </div>

    <div class="main-content">
        <!-- Top Navbar -->
        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm mb-4">
            <div class="container-fluid">
                <div class="d-flex align-items-center">
                    <!-- Toggle button in navbar for collapsed sidebar -->
                    <button class="navbar-toggle-btn d-none" id="navbarToggleBtn" onclick="toggleSidebar()">
                        <i class="bi bi-list"></i>
                    </button>

                    <!-- Company Name -->
                    <span class="company-name">DOWENCE MARKET</span>
                </div>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" href="#"><i class="bi bi-plus-circle"></i> New Item</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#"><i class="bi bi-file-earmark-text"></i> Reports</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown">
                                <i class="bi bi-gear"></i> Settings
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="#">System Settings</a></li>
                                <li><a class="dropdown-item" href="#">Backup Database</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="#">Advanced Options</a></li>
                            </ul>
                        </li>
                    </ul>

                    <div class="d-flex align-items-center">
                        <div class="position-relative me-3">
                            <a href="#" class="text-secondary fs-5"><i class="bi bi-bell"></i></a>
                            <span
                                class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                3
                            </span>
                        </div>

                        <div class="dropdown">
                            <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle"
                                id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center text-white"
                                    style="width: 40px; height: 40px; background-color: #13213C !important;">
                                    <i class="bi bi-person-fill"></i>
                                </div>
                                <span class="ms-2 d-none d-lg-inline text-dark">Admin User</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>Profile</a></li>
                                <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i>Account
                                        Settings</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="bi bi-box-arrow-right me-2"></i>Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <div class="content-wrapper">
            @yield('content')
        </div>
    </div>

    <script>
        function toggleSidebar() {
            let sidebar = document.getElementById("sidebar");
            let navbarToggleBtn = document.getElementById("navbarToggleBtn");
            sidebar.classList.toggle("collapsed");

            // Show/hide the navbar toggle button based on sidebar state
            if (sidebar.classList.contains("collapsed")) {
                navbarToggleBtn.classList.remove("d-none");
            } else {
                navbarToggleBtn.classList.add("d-none");
            }
        }

        // Initialize the navbar toggle button visibility on page load
        document.addEventListener("DOMContentLoaded", function () {
            let sidebar = document.getElementById("sidebar");
            let navbarToggleBtn = document.getElementById("navbarToggleBtn");

            if (sidebar.classList.contains("collapsed")) {
                navbarToggleBtn.classList.remove("d-none");
            } else {
                navbarToggleBtn.classList.add("d-none");
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>