<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Health & Wellness Tracker')</title>
    
    <!-- Favicon -->
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='0.9em' font-size='90'>❤️</text></svg>">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Custom CSS -->
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
        }

        /* Topbar */
        .topbar {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: white;
            height: 60px;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
            padding: 0 20px;
        }

        .topbar-brand {
            font-size: 1.5rem;
            font-weight: 700;
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .topbar-brand:hover {
            color: white;
        }

        .topbar-menu {
            margin-left: auto;
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .topbar-user {
            display: flex;
            align-items: center;
            gap: 10px;
            color: white;
            cursor: pointer;
            padding: 8px 15px;
            border-radius: 8px;
            transition: background 0.3s;
        }

        .topbar-user:hover {
            background: rgba(255,255,255,0.1);
        }

        .topbar-toggle {
            background: none;
            border: none;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
            margin-right: 15px;
            display: none;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 60px;
            left: 0;
            width: 260px;
            height: calc(100vh - 60px);
            background: white;
            box-shadow: 2px 0 10px rgba(0,0,0,0.05);
            overflow-y: auto;
            transition: transform 0.3s ease;
            z-index: 999;
        }

        .sidebar-menu {
            list-style: none;
            padding: 20px 0;
        }

        .sidebar-item {
            margin-bottom: 5px;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 20px;
            color: #666;
            text-decoration: none;
            transition: all 0.3s;
            font-weight: 500;
        }

        .sidebar-link i {
            font-size: 1.2rem;
            width: 24px;
            text-align: center;
            color: #1e3c72;
        }

        .sidebar-link:hover,
        .sidebar-link.active {
            background: linear-gradient(90deg, rgba(30,60,114,0.1) 0%, rgba(42,82,152,0.05) 100%);
            color: #1e3c72;
            border-left: 3px solid #1e3c72;
        }

        .sidebar-divider {
            height: 1px;
            background: #e9ecef;
            margin: 15px 20px;
        }

        .sidebar-title {
            padding: 10px 20px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            color: #999;
            letter-spacing: 1px;
        }

        /* Main Content */
        .main-content {
            margin-left: 260px;
            margin-top: 60px;
            padding: 30px;
            min-height: calc(100vh - 60px);
            transition: margin-left 0.3s ease;
        }

        /* Cards */
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            margin-bottom: 20px;
            background: white;
        }

        .card-header {
            background: white;
            border-bottom: 1px solid #e9ecef;
            padding: 15px 20px;
            font-weight: 600;
            color: #1e3c72;
            border-radius: 12px 12px 0 0 !important;
        }

        .card-body {
            padding: 20px;
        }

        /* Stat Cards */
        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            transition: transform 0.3s, box-shadow 0.3s;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.15);
        }

        .stat-card-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .stat-card-icon.primary {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: white;
        }

        .stat-card-icon.success {
            background: linear-gradient(135deg, #56ab2f 0%, #a8e063 100%);
            color: white;
        }

        .stat-card-icon.warning {
            background: linear-gradient(135deg, #f2994a 0%, #f2c94c 100%);
            color: white;
        }

        .stat-card-icon.info {
            background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
            color: white;
        }

        .stat-card-content {
            flex: 1;
        }

        .stat-card-value {
            font-size: 1.8rem;
            font-weight: 700;
            color: #1e3c72;
            margin-bottom: 5px;
        }

        .stat-card-label {
            font-size: 0.9rem;
            color: #666;
        }

        /* Buttons */
        .btn-primary {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            font-weight: 600;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(30,60,114,0.3);
            background: linear-gradient(135deg, #2a5298 0%, #1e3c72 100%);
        }

        .btn-outline-primary {
            border: 2px solid #1e3c72;
            color: #1e3c72;
            border-radius: 8px;
            padding: 10px 20px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-outline-primary:hover {
            background: #1e3c72;
            color: white;
            transform: translateY(-2px);
        }

        /* Tables */
        .table {
            margin-bottom: 0;
        }

        .table thead th {
            background: #f8f9fa;
            color: #1e3c72;
            font-weight: 600;
            border-bottom: 2px solid #e9ecef;
            padding: 12px;
        }

        .table tbody td {
            padding: 12px;
            vertical-align: middle;
        }

        /* Badges */
        .badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.75rem;
        }

        .badge-primary {
            background: #1e3c72;
        }

        .badge-success {
            background: #56ab2f;
        }

        .badge-warning {
            background: #f2994a;
        }

        .badge-info {
            background: #3498db;
        }

        /* Alerts */
        .alert {
            border-radius: 8px;
            border: none;
        }

        /* Dropdown */
        .dropdown-menu {
            border-radius: 8px;
            border: none;
            box-shadow: 0 5px 20px rgba(0,0,0,0.15);
        }

        .dropdown-item {
            padding: 10px 20px;
            transition: background 0.3s;
        }

        .dropdown-item:hover {
            background: #f8f9fa;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-260px);
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .topbar-toggle {
                display: block;
            }
        }

        /* Animations */
        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Loader */
        .global-loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            backdrop-filter: blur(5px);
        }

        .global-loader.active {
            display: flex;
        }

        .loader-content {
            text-align: center;
        }

        .loader-heart {
            font-size: 5rem;
            color: #1e3c72;
            animation: heartbeat 1.2s ease-in-out infinite;
            filter: drop-shadow(0 0 20px rgba(30, 60, 114, 0.6));
        }

        @keyframes heartbeat {
            0% {
                transform: scale(1);
                opacity: 1;
            }
            25% {
                transform: scale(1.3);
                opacity: 0.8;
            }
            50% {
                transform: scale(1);
                opacity: 1;
            }
            75% {
                transform: scale(1.3);
                opacity: 0.8;
            }
            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        .loader-text {
            color: #262b35ff;
            font-size: 1.2rem;
            margin-top: 1.5rem;
            font-weight: 600;
            letter-spacing: 1px;
        }

        .loader-dots {
            display: inline-block;
            width: 40px;
            text-align: left;
        }

        .loader-dots::after {
            content: '...';
            animation: dots 1.5s steps(4, end) infinite;
        }

        @keyframes dots {
            0%, 20% {
                content: '.';
            }
            40% {
                content: '..';
            }
            60%, 100% {
                content: '...';
            }
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- Global Loader -->
    <div class="global-loader" id="globalLoader">
        <div class="loader-content">
            <div class="loader-heart">
                <i class="fas fa-heartbeat"></i>
            </div>
            <div class="loader-text">
                Loading<span class="loader-dots"></span>
            </div>
        </div>
    </div>

    @auth
    <!-- Topbar -->
    <div class="topbar">
        <button class="topbar-toggle" onclick="toggleSidebar()">
            <i class="fas fa-bars"></i>
        </button>
        <a href="{{ route('home') }}" class="topbar-brand">
            <i class="fas fa-heartbeat"></i>
            Health & Wellness
        </a>
        <div class="topbar-menu">
            <div class="topbar-user">
                <i class="fas fa-user-circle fa-lg"></i>
                <span>{{ auth()->user()->name }}</span>
            </div>
            <form action="{{ route('logout') }}" method="POST" style="margin-left: 1rem;">
                @csrf
                <button type="submit" class="btn btn-sm" style="background: rgba(255,255,255,0.1); color: white; border: 1px solid rgba(255,255,255,0.2); padding: 0.5rem 1rem; border-radius: 6px; transition: all 0.3s;">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </form>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <ul class="sidebar-menu">
            @if(auth()->user()->isParticipant())
                <li class="sidebar-item">
                    <a class="sidebar-link {{ request()->routeIs('participant.dashboard') ? 'active' : '' }}" href="{{ route('participant.dashboard') }}">
                        <i class="fas fa-home"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link {{ request()->routeIs('participant.programs') ? 'active' : '' }}" href="{{ route('participant.programs') }}">
                        <i class="fas fa-list"></i>
                        <span>Browse Programs</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link {{ request()->routeIs('participant.my-programs') ? 'active' : '' }}" href="{{ route('participant.my-programs') }}">
                        <i class="fas fa-bookmark"></i>
                        <span>My Programs</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link {{ request()->routeIs('participant.attendance') ? 'active' : '' }}" href="{{ route('participant.attendance') }}">
                        <i class="fas fa-calendar-check"></i>
                        <span>My Attendance</span>
                    </a>
                </li>
                <div class="sidebar-divider"></div>
                <div class="sidebar-title">Account</div>
                <li class="sidebar-item">
                    <a class="sidebar-link {{ request()->routeIs('participant.profile') ? 'active' : '' }}" href="{{ route('participant.profile') }}">
                        <i class="fas fa-user-circle"></i>
                        <span>Profile</span>
                    </a>
                </li>
            @elseif(auth()->user()->isCoordinator())
                <li class="sidebar-item">
                    <a class="sidebar-link {{ request()->routeIs('coordinator.dashboard') ? 'active' : '' }}" href="{{ route('coordinator.dashboard') }}">
                        <i class="fas fa-home"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link {{ request()->routeIs('coordinator.programs*') ? 'active' : '' }}" href="{{ route('coordinator.programs') }}">
                        <i class="fas fa-clipboard-list"></i>
                        <span>Programs</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link {{ request()->routeIs('coordinator.all-sessions') ? 'active' : '' }}" href="{{ route('coordinator.all-sessions') }}">
                        <i class="fas fa-calendar-alt"></i>
                        <span>All Sessions</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link {{ request()->routeIs('coordinator.all-participants') ? 'active' : '' }}" href="{{ route('coordinator.all-participants') }}">
                        <i class="fas fa-users"></i>
                        <span>All Participants</span>
                    </a>
                </li>
                <div class="sidebar-divider"></div>
                <div class="sidebar-title">Account</div>
                <li class="sidebar-item">
                    <a class="sidebar-link {{ request()->routeIs('coordinator.profile') ? 'active' : '' }}" href="{{ route('coordinator.profile') }}">
                        <i class="fas fa-user-circle"></i>
                        <span>Profile</span>
                    </a>
                </li>
            @elseif(auth()->user()->isAdmin())
                <li class="sidebar-item">
                    <a class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-home"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <div class="sidebar-divider"></div>
                <div class="sidebar-title">Management</div>
                <li class="sidebar-item">
                    <a class="sidebar-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}" href="{{ route('admin.users') }}">
                        <i class="fas fa-users"></i>
                        <span>Users</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link {{ request()->routeIs('admin.programs*') ? 'active' : '' }}" href="{{ route('admin.programs') }}">
                        <i class="fas fa-clipboard-list"></i>
                        <span>Programs</span>
                    </a>
                </li>
                <div class="sidebar-divider"></div>
                <div class="sidebar-title">System</div>
                <li class="sidebar-item">
                    <a class="sidebar-link {{ request()->routeIs('admin.settings') ? 'active' : '' }}" href="{{ route('admin.settings') }}">
                        <i class="fas fa-cog"></i>
                        <span>Settings</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link {{ request()->routeIs('admin.audit-logs') ? 'active' : '' }}" href="{{ route('admin.audit-logs') }}">
                        <i class="fas fa-history"></i>
                        <span>Audit Logs</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link {{ request()->routeIs('admin.reports') ? 'active' : '' }}" href="{{ route('admin.reports') }}">
                        <i class="fas fa-chart-bar"></i>
                        <span>Reports</span>
                    </a>
                </li>
                <div class="sidebar-divider"></div>
                <div class="sidebar-title">Account</div>
                <li class="sidebar-item">
                    <a class="sidebar-link {{ request()->routeIs('admin.profile') ? 'active' : '' }}" href="{{ route('admin.profile') }}">
                        <i class="fas fa-user-circle"></i>
                        <span>Profile</span>
                    </a>
                </li>
            @endif
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container-fluid">
            <!-- Alerts -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle"></i>
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>
    @else
    <!-- Guest Navigation -->
    @if(!request()->routeIs('login') && !request()->routeIs('register'))
        <nav class="navbar navbar-expand-lg" style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%); box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
            <div class="container">
                <a class="navbar-brand text-white" href="{{ route('home') }}">
                    <i class="fas fa-heartbeat"></i>
                    Health & Wellness
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" style="border-color: white;">
                    <span class="navbar-toggler-icon" style="filter: invert(1);"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('login') }}">
                                <i class="fas fa-sign-in-alt"></i> Login
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('register') }}">
                                <i class="fas fa-user-plus"></i> Register
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    @endif

    <!-- Guest Content -->
    <div style="padding: {{ request()->routeIs('login') || request()->routeIs('register') ? '60px 0 30px' : '30px 0' }};">
        <div class="container">
            @yield('content')
        </div>
    </div>
    @endauth

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        const loader = document.getElementById('globalLoader');
        
        function showLoader() {
            if (loader) {
                loader.classList.add('active');
            }
        }
        
        function hideLoader() {
            if (loader) {
                loader.classList.remove('active');
            }
        }

        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('active');
        }

        // Close sidebar on mobile when clicking outside
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const toggle = document.querySelector('.topbar-toggle');
            
            if (sidebar && window.innerWidth <= 768) {
                if (!sidebar.contains(event.target) && !toggle.contains(event.target)) {
                    sidebar.classList.remove('active');
                }
            }
        });

        // Show loader on all forms with 3 second delay
        document.addEventListener('DOMContentLoaded', function() {
            // Handle all form submissions
            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    // Skip if form has data-no-loader attribute
                    if (this.hasAttribute('data-no-loader')) {
                        return;
                    }
                    
                    e.preventDefault();
                    showLoader();
                    
                    // Submit after 3 seconds
                    setTimeout(() => {
                        this.submit();
                    }, 3000);
                });
            });

            // Handle sidebar links
            const sidebarLinks = document.querySelectorAll('.sidebar-link');
            sidebarLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    // Skip if it's a dropdown toggle or has data-no-loader
                    if (this.hasAttribute('data-bs-toggle') || this.hasAttribute('data-no-loader')) {
                        return;
                    }
                    
                    e.preventDefault();
                    const href = this.getAttribute('href');
                    
                    if (href && href !== '#') {
                        showLoader();
                        setTimeout(() => {
                            window.location.href = href;
                        }, 1000);
                    }
                });
            });

            // Handle regular buttons that navigate (not submit buttons)
            const navButtons = document.querySelectorAll('a.btn, button[onclick*="location"], button[data-href]');
            navButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    // Skip if it's a submit button or has data-no-loader
                    if (this.type === 'submit' || this.hasAttribute('data-no-loader')) {
                        return;
                    }
                    
                    const href = this.getAttribute('href') || this.getAttribute('data-href');
                    
                    if (href && href !== '#' && !href.startsWith('javascript:')) {
                        e.preventDefault();
                        showLoader();
                        setTimeout(() => {
                            window.location.href = href;
                        }, 1000);
                    }
                });
            });

            // Handle logout button specifically
            const logoutForm = document.getElementById('logout-form');
            if (logoutForm) {
                const logoutButton = document.querySelector('[onclick*="logout-form"]');
                if (logoutButton) {
                    logoutButton.addEventListener('click', function(e) {
                        e.preventDefault();
                        showLoader();
                        setTimeout(() => {
                            logoutForm.submit();
                        }, 1000);
                    });
                }
            }
        });

        // Hide loader on page load
        window.addEventListener('load', function() {
            hideLoader();
        });
    </script>
    
    @stack('scripts')
</body>
</html>
