<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ config('app.name', 'FamilyTree Pro') }} — @yield('title', 'Dashboard')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        /* Override tree variables to match Parking design if needed */
        :root {
            --text-color: var(--text);
            --card-bg: var(--card);
            --connector-color: var(--border);
            --card-hover: var(--primary-light);
            --border-color: var(--primary);
        }
    </style>
    
    @stack('styles')
</head>
<body class="font-sans antialiased">
    <div class="sidebar-overlay" onclick="toggleSidebar()"></div>
    
    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <h1><span><i class="fas fa-sitemap"></i></span> FamilyTree</h1>
            <p>Pro Edition</p>
        </div>
        
        <nav class="nav-section">
            <div class="nav-label">Main</div>
            <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="fas fa-chart-pie"></i> Dashboard
            </a>
            <a href="{{ route('family-members.index') }}" class="nav-item {{ request()->routeIs('family-members.*') ? 'active' : '' }}">
                <i class="fas fa-users"></i> Family Members
            </a>
        </nav>
        
        <nav class="nav-section">
            <div class="nav-label">Analysis</div>
            <a href="#" class="nav-item">
                <i class="fas fa-chart-line"></i> Reports
            </a>
            <a href="#" class="nav-item">
                <i class="fas fa-history"></i> History
            </a>
        </nav>
        
        <nav class="nav-section">
            <div class="nav-label">Personal</div>
            <a href="{{ route('profile.edit') }}" class="nav-item {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
                <i class="fas fa-user-cog"></i> My Profile
            </a>
        </nav>
        
        <div class="sidebar-footer">
            <form method="POST" action="{{ route('logout') }}" id="logout-form">
                @csrf
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="main">
        <div class="topbar">
            <div style="display:flex;align-items:center">
                <button class="sidebar-toggle" onclick="toggleSidebar()">
                    <i class="fas fa-bars"></i>
                </button>
                <h2>@yield('title', 'Dashboard')</h2>
            </div>
            
            <div class="topbar-actions">
                <div class="topbar-user">
                    <i class="fas fa-user-circle"></i>
                    <span>{{ Auth::user()->name }}</span>
                </div>
            </div>
        </div>
        
        <div class="content">
            @if(session('success'))
                <div class="bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center gap-2">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif
            
            @yield('content')
        </div>
    </div>

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('show');
            document.querySelector('.sidebar-overlay').classList.toggle('show');
        }
    </script>
    @stack('scripts')
</body>
</html>