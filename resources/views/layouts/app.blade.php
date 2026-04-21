<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Cinema Z | @yield('title', 'Book Now')</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        /* BRAND COLORS & UI RESET */
        :root {
            --cinema-red: #E21B22;
            --cinema-black: #0B0B0B;
        }

        body { 
            margin: 0; padding: 0; 
            background-color: var(--cinema-black) !important; 
            font-family: 'Figtree', sans-serif;
            color: #ffffff;
        }

        /* NAVBAR GLASSMORPHISM */
        .navbar { 
            background: rgba(0, 0, 0, 0.5) !important; 
            backdrop-filter: blur(10px);
            padding: 1.2rem 5%; 
            display: flex; 
            align-items: center;
            position: sticky; 
            top: 0;
            z-index: 1000;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        
        .nav-link { 
            color: #9ca3af !important; 
            text-decoration: none; 
            padding: 0.5rem 1.2rem; 
            font-weight: 600;
            transition: 0.3s;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .nav-link:hover, .nav-link.active {
            color: #ffffff !important;
        }

        /* LOGIN BUTTON */
        .login-btn {
            background: var(--cinema-red);
            color: white !important;
            border: none;
            padding: 10px 25px;
            border-radius: 50px;
            font-weight: bold;
            font-size: 0.8rem;
            transition: 0.3s;
        }

        .login-btn:hover { 
            background: #b9151b; 
            transform: scale(1.05);
        }
    </style>
</head>
<body>

    <nav class="navbar">
        <div style="display: flex; align-items: center; gap: 10px; margin-right: 40px;">
            <div style="background: var(--cinema-red); padding: 5px; border-radius: 5px;">🎬</div>
            <span style="font-weight: 800; font-size: 1.4rem; letter-spacing: -1px;">CINEMA <span style="color: var(--cinema-red);">Z</span></span>
        </div>

        {{-- 1. THE HOME LINK --}}
        {{-- Only highlights on the specific Dashboard or Admin Home --}}
        <a href="{{ route('dashboard') }}" 
        class="nav-link {{ Request::is('dashboard') || Request::is('admin/home') ? 'active' : '' }}">
        Home
        </a>

        @auth
            {{-- 2. ADMIN NAVIGATION --}}
            @if(Auth::user()->role_id == 1)
                {{-- Per your request: Home > Add Movies > Catalog > Tickets --}}
                <a href="{{ route('admin.add_movies') }}" 
                class="nav-link {{ Request::is('admin/movies/create') ? 'active' : '' }}">
                Add Movies
                </a>

                <a href="{{ route('admin.home') }}" 
                class="nav-link {{ Request::is('admin/home') ? 'active' : '' }}">
                Catalog
                </a>

                <a href="#" class="nav-link {{ Request::is('admin/tickets*') ? 'active' : '' }}">
                Tickets
                </a>
            
            {{-- 3. CUSTOMER NAVIGATION --}}
            @else
                {{-- Per your request: Home > Movies > Catalog > Tickets --}}
                <a href="{{ route('home') }}" 
                class="nav-link {{ Request::is('home') ? 'active' : '' }}">
                Movies
                </a>

                <a href="{{ route('home') }}" {{-- Update this route if you make a separate catalog page --}}
                class="nav-link {{ Request::is('catalog*') ? 'active' : '' }}">
                Catalog
                </a>

                <a href="#" class="nav-link {{ Request::is('my-tickets*') ? 'active' : '' }}">
                My Tickets
                </a>
            @endif
        @endauth

    {{-- 4. Auth Section --}}
    <div style="margin-left: auto;">
        @auth
            <div style="display: flex; align-items: center; gap: 20px;">
                {{-- Show user name/email if you want --}}
                <span style="font-size: 0.7rem; color: #666; text-transform: uppercase;">{{ Auth::user()->email }}</span>
                
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="nav-link" style="background:none; border:none; cursor:pointer; padding:0;">LOGOUT</button>
                </form>
            </div>
        @else
            @if(!Route::is('login') && !Route::is('register'))
                <a href="{{ route('login') }}" class="login-btn">LOG IN</a>
            @endif
        @endauth
    </div>
    </nav>

    @if(isset($currentStep))
        <div class="py-8">
            </div>
    @endif

    <main>
        {{-- Full width by default to match your Hero design --}}
        @yield('content')
    </main>

    <footer style="padding: 40px; text-align: center; color: #444; font-size: 0.8rem; border-top: 1px solid rgba(255,255,255,0.05);">
        &copy; 2026 Cinema Z. All rights reserved.
    </footer>

</body>
</html>