<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ config('app.name', 'CrestCareers') }} - Premium Recruitment</title>

    {{-- Bootstrap 5 & Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    {{-- CORRECTED: Global Fonts (Plus Jakarta Sans for the premium SaaS look) --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        /* ==========================================
           PREMIUM GLOBAL SAAS STYLING
           ========================================== */
        :root {
            --primary-indigo: #4f46e5;
            --primary-violet: #7c3aed;
            --dark-slate: #0f172a;
            --light-slate: #64748b;
            --bg-soft: #f8fafc;
            --transition-smooth: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-soft);
            padding-top: 85px; 
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            letter-spacing: -0.2px;
            -webkit-font-smoothing: antialiased;
            text-rendering: optimizeLegibility;
        }

        /* ------------------------------------------
           NAVBAR & GLASSMORPHISM
           ------------------------------------------ */
        .navbar-glass {
            background: rgba(15, 23, 42, 0.75); 
            backdrop-filter: blur(16px); 
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            transition: var(--transition-smooth);
        }

        /* Brand Logo Hover Animation */
        .navbar-brand {
            transition: var(--transition-smooth);
        }
        .navbar-brand:hover {
            transform: translateY(-1px);
        }
        .navbar-brand .logo-icon {
            background: linear-gradient(135deg, #60a5fa 0%, #a78bfa 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));
            transition: var(--transition-smooth);
        }
        .navbar-brand:hover .logo-icon {
            transform: scale(1.1) rotate(5deg);
        }

        /* Nav Link Animations */
        .navbar-dark .navbar-nav .nav-link {
            color: rgba(255, 255, 255, 0.65);
            font-weight: 500;
            padding: 0.5rem 1rem;
            transition: var(--transition-smooth);
            position: relative;
        }
        .navbar-dark .navbar-nav .nav-link:hover {
            color: #ffffff;
            transform: translateY(-2px);
        }
        
        /* Animated active state underline */
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 50%;
            transform: translateX(-50%) scaleX(0);
            width: 24px;
            height: 3px;
            background: linear-gradient(90deg, #60a5fa, #a78bfa);
            border-radius: 50px;
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            transform-origin: center;
        }
        .nav-link:hover::after {
            transform: translateX(-50%) scaleX(0.5);
        }
        .nav-link.active {
            color: #ffffff !important;
            text-shadow: 0 0 10px rgba(255, 255, 255, 0.2);
        }
        .nav-link.active::after {
            transform: translateX(-50%) scaleX(1);
        }

        /* ------------------------------------------
           BUTTON UPGRADES (Global Overrides)
           ------------------------------------------ */
        .btn {
            transition: var(--transition-smooth);
        }
        
        /* Transform default primary buttons into gradient SaaS buttons */
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-indigo), var(--primary-violet));
            border: none;
            box-shadow: 0 4px 10px -2px rgba(79, 70, 229, 0.4);
            color: white !important;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, var(--primary-violet), var(--primary-indigo));
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 10px 20px -3px rgba(79, 70, 229, 0.5);
        }
        .btn-primary:active {
            transform: translateY(1px);
        }

        /* Light button hover states (Dropdown toggle) */
        .btn-light {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(5px);
        }
        .btn-light:hover {
            background: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 8px 15px -3px rgba(0, 0, 0, 0.1);
        }

        /* Mobile Toggle Button */
        .navbar-toggler {
            border: none;
            padding: 0.5rem;
            transition: var(--transition-smooth);
        }
        .navbar-toggler:focus {
            box-shadow: none;
            outline: 2px solid rgba(124, 58, 237, 0.5);
            border-radius: 8px;
        }

        /* ------------------------------------------
           DROPDOWN ANIMATIONS
           ------------------------------------------ */
        .dropdown-menu {
            animation: dropdownFade 0.25s cubic-bezier(0.4, 0, 0.2, 1) forwards;
            transform-origin: top right;
            border: 1px solid var(--border-soft);
            box-shadow: 0 15px 35px rgba(0,0,0,0.05);
            border-radius: 1rem;
            padding: 0.5rem;
        }
        @keyframes dropdownFade {
            0% { opacity: 0; transform: translateY(10px) scale(0.95); }
            100% { opacity: 1; transform: translateY(0) scale(1); }
        }
        .dropdown-item {
            border-radius: 0.5rem;
            transition: var(--transition-smooth);
        }
        .dropdown-item:hover {
            background-color: #fee2e2;
            color: #dc2626 !important;
            transform: translateX(4px);
        }

        main {
            flex-grow: 1;
        }
    </style>
</head>
<body>

    {{-- Dark & Transparent Navigation Bar --}}
    <nav class="navbar navbar-expand-lg navbar-dark navbar-glass fixed-top py-3">
        <div class="container">
            
            {{-- Brand Logo & Tagline --}}
            <a class="navbar-brand d-flex align-items-center text-decoration-none" href="{{ route('home') }}">
                <i class="bi bi-layers-fill fs-2 me-2 logo-icon"></i>
                <div class="d-flex flex-column justify-content-center">
                    <span class="fw-bold fs-4 tracking-tight lh-1 text-white">CrestCareers</span>
                    <span style="font-size: 0.65rem; font-weight: 500; letter-spacing: 0.5px; color: rgba(255,255,255,0.6);" class="text-uppercase mt-1">
                        Your career, at its peak.
                    </span>
                </div>
            </a>

            {{-- Mobile Menu Toggle Button --}}
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            {{-- Navigation Links --}}
            <div class="collapse navbar-collapse" id="mainNavbar">

                <ul class="navbar-nav ms-auto align-items-lg-center gap-2 gap-lg-4 mt-3 mt-lg-0">
                    
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') || request()->routeIs('jobs.show') ? 'active' : '' }}" href="{{ route('home') }}">
                            <i class="bi bi-search d-lg-none me-2"></i>Find Jobs
                        </a>
                    </li>

                    @guest
                        {{-- Show to visitors --}}
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('login') ? 'active' : '' }}" href="{{ route('login') }}">Log In</a>
                        </li>
                        <li class="nav-item ms-lg-2 mt-2 mt-lg-0">
                            <a href="{{ route('register') }}" class="btn btn-primary rounded-pill fw-bold px-4 py-2 shadow-sm w-100 w-lg-auto text-center">
                                Sign Up
                            </a>
                        </li>
                    @else
                        {{-- Show to ALL logged-in users (Admins & Candidates) --}}
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                                <i class="bi bi-grid-1x2-fill d-lg-none me-2"></i>Dashboard
                            </a>
                        </li>
                        
                        <li class="nav-item ms-lg-2 mt-2 mt-lg-0 d-flex align-items-center gap-2">
                            
                            {{-- ONLY Admins get the Post Job button --}}
                            @if(auth()->user()->isAdmin())
                                <a href="{{ route('jobs.create') }}" class="btn btn-primary rounded-pill fw-bold px-3 py-2 shadow-sm flex-grow-1 text-center">
                                    <i class="bi bi-plus-lg me-1"></i> Post Job
                                </a>
                            @endif
                            
                            {{-- User Greeting & Logout Form --}}
                            <div class="dropdown">
                                <button class="btn btn-light rounded-pill border fw-bold px-3 py-2 text-dark dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-person-circle text-primary me-1"></i> {{ auth()->user()->name }}
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2 rounded-3">
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}" class="m-0">
                                            @csrf
                                            <button type="submit" class="dropdown-item text-danger fw-medium d-flex align-items-center">
                                                <i class="bi bi-box-arrow-right me-2"></i> Sign Out
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    {{-- Main Page Content --}}
    <main>
        @yield('content')
    </main>

    {{-- Simple, Clean Footer --}}
    <footer class="bg-white border-top py-4 mt-auto">
        <div class="container text-center text-muted small fw-medium">
            &copy; {{ date('Y') }} CrestCareers. All rights reserved.
        </div>
    </footer>

    {{-- Bootstrap JS Bundle (Required for Modals and Navbar Toggle) --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>