<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <title>@yield('title', 'Campus Club')</title>

    <!-- Scripts -->
     @stack('styles')
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Customize Navbar */
        .navbar {
            background-color: #ffffff;
            padding: 0.5rem 1rem;
        }
        .navbar-nav .nav-link {
            color: rgb(28, 2, 46) !important;
        }
        .navbar-nav .nav-link:hover {
            color: #8c8f91 !important;
        }

        /* Form containers */
        .login-container, .registration-container, .admin-container {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        /* Button styles */
        .btn-primary {
            background-color: #ffffff;
            border-color: #3b0759;
        }
        /* Dropdown styles */
        .dropdown-toggle {
            cursor: pointer;
            outline: none;
        }
        .dropdown-menu {
            border: none;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            margin-top: 0.5rem;
        }
        .dropdown-item {
            padding: 0.5rem 1.5rem;
            transition: all 0.2s;
        }
        .dropdown-item:hover {
            background-color: #f8f9fa;
        }
        .dropdown-divider {
            margin: 0.25rem 0;
        }

        /* Notification styles */
        .notification-bell {
            position: relative;
            margin-right: 1.5rem;
        }
        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            font-size: 0.65rem;
            padding: 0.25em 0.4em;
        }

        /* Profile image */
        .profile-img {
            width: 32px;
            height: 32px;
            object-fit: cover;
        }
    </style>
</head>
<body>
    <!-- REQUIRED SCRIPTS -->
    <!-- jQuery first, then Bootstrap Bundle with Popper -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')
    <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <title>@yield('title', 'Campus Club')</title>

    <style>
        /* Customize Navbar */
        .navbar {
            background-color: #ffffff;
            padding: 0.5rem 1rem;
        }
        .navbar-nav .nav-link {
            color: rgb(28, 2, 46) !important;
        }
        .navbar-nav .nav-link:hover {
            color: #8c8f91 !important;
        }
        .secondary-navbar {
            background-color: #523159; /* Same as footer */
            height: 10px; /* Thin bar */
            width: 100%;
            display: block; /* Ensure it's displayed */
        }

        /* Form containers */
        .login-container, .registration-container, .admin-container {
            background-color: rgba(206, 201, 201, 0.8);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 3 10px 10px rgba(0, 0, 0, 0.1);
        }


        /* Set html and body to full height */
        html, body {
            height: 100%;
            margin: 0;
        }

        /* Main wrapper to push footer down */
        #app {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Main content area */
        .main-content {
            flex: 1;
        }

        /* Dropdown styles */
        .dropdown-toggle {
            cursor: pointer;
            outline: none;
            background: none;
            border: none;
        }
        .dropdown-toggle::after {
            display: inline-block;
            vertical-align: 0.255em;
            content: "";
            border-top: 0.3em solid;
            border-right: 0.3em solid transparent;
            border-bottom: 0;
            border-left: 0.3em solid transparent;
        }
        .dropdown-menu {
            border: none;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            margin-top: 0.5rem;
        }
        .dropdown-item {
            padding: 0.5rem 1.5rem;
            transition: all 0.2s;
        }
        .dropdown-item:hover {
            background-color: #f8f9fa;
        }
        .dropdown-divider {
            margin: 0.25rem 0;
        }
        .footer {
        background: rgb(25, 25, 88);
        color: #fff;
        padding: 3rem 0;
        margin-top: auto;
        text-align: left;
        margin-top: 2rem; /* Push the footer down a little bit */
        position: relative;
        z-index: 1;
        position: relative;  /* Default position for the footer */
    }

    .footer h5 {
        font-weight: bold;
        font-size: 1.25rem;
        margin-bottom: 1rem;
    }

    .footer a {
        color: #f8f9fa;
        text-decoration: none;
        transition: color 0.3s ease, transform 0.3s ease;
    }

    .footer a:hover {
        text-decoration: underline;
        color: #ffd700; /* Gold color for hover effect */
        transform: scale(1.1); /* Slightly enlarge link on hover */
    }

    .footer .row {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 40px;
    }

    .footer .col-md-4 ul {
        padding-left: 0;
    }

    .footer .col-md-4 ul li {
        list-style-type: none;
        margin: 8px 0;
    }

    .footer .col-md-4 ul li a {
        font-size: 0.9rem;
    }

    .footer .social-icons {
        display: flex;
        gap: 15px;
        justify-content: flex-end;
    }

    .footer .social-icons i {
        font-size: 1.5rem;
        color: #fff;
        transition: color 0.3s ease;
    }

    .footer .social-icons i:hover {
        color: #ffd700; /* Gold color for hover effect */
    }

    .footer .copyright {
        background-color: rgb(48, 48, 128);
        text-align: center;
        padding: 1rem 0;
        margin-top: 1rem;
        font-size: 0.9rem;
        color: #f0e0f8;
    }

    /* Back to top button */
    .footer .back-to-top {
        position: fixed;
        bottom: 20px;
        right: 20px;
        background-color: #000000;
        border-radius: 50%;
        padding: 10px;
        color: #fff;
        font-size: 1.25rem;
        transition: background-color 0.3s ease;
        cursor: pointer;
    }

    .footer .back-to-top:hover {
        background-color: #000000;
    }

        /* Ensure white background */
        body {
            background-color: white;
            margin: 0;
            padding: 0;
        }

        /* Remove any existing background styles */
        .auth-card {
            background-color: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            border: 1px solid #eee;
        }

        /* User icon style */
        .user-icon {
            font-size: 1.25rem;
            color: #6c757d;
            margin-right: 0.5rem;
        }

        /* Fix for dropdown alignment */
        .dropdown-menu-end {
            right: 0;
            left: auto;
        }

    </style>
    <!-- Scripts -->
    @stack('styles')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset('images/logo.uitm.png') }}" alt="UiTM Logo" height="40">
            </a>

            <div class="d-flex align-items-center">
                @auth
                <!-- User Dropdown (only shown when logged in) -->
                <div class="dropdown ms-3">
                    <button class="btn dropdown-toggle d-flex align-items-center p-0 border-0 bg-transparent"
                            type="button"
                            id="userDropdown"
                            data-bs-toggle="dropdown"
                            aria-expanded="false">
                        <i class="fas fa-user-circle user-icon"></i> <!-- Changed to user icon -->
                        <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        @if(auth()->guard('admin')->check())
                            
                        @elseif(auth()->guard('president')->check())
                            <li><a class="dropdown-item" href="{{ route('president.profile') }}">
                                <i class="fas fa-user me-2"></i> Profile
                            </a></li>
                        @else
                            <li><a class="dropdown-item" href="{{ route('student.profile') }}">
                                <i class="fas fa-user me-2"></i> Profile
                            </a></li>
                            <li><a class="dropdown-item" href="{{ route('student.clubs') }}">
                                <i class="fas fa-users me-2"></i> Clubs
                            </a></li>
                        @endif
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item bg-transparent border-0 w-100 text-start">
                                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
                @else
                <!-- Guest Navigation Links (only show if not on admin login page) -->
                @if(!Request::is('admin/login'))
                    <div class="d-flex">
                        <a class="nav-link ms-3" href="{{ route('president.login') }}"><i class="fas fa-user-circle me-1"></i> President Login</a>
                        <a class="nav-link" href="{{ route('register') }}"><i class="fas fa-user-plus me-1"></i> Registration</a>
                    </div>
                @endif
                @endauth
            </div>
        </div>
    </nav>

    <main class="py-4">
        @yield('content')
    </main>

    @if(Request::is('president') || Request::is('president/president-login'))
            {{-- Full footer for president login page --}}
            <footer class="footer">
            <div class="copyright">
                © COPYRIGHT LIYANA SYAMIMI
            </div>

            <!-- Back to top button -->
            <div class="back-to-top" onclick="window.scrollTo({ top: 0, behavior: 'smooth' });">
                <i class="fas fa-arrow-up"></i>
            </div>
        @else
            {{-- Full footer for all other pages --}}
            <footer class="footer">
            <div class="container py-4">
                <div class="row">
                    <div class="col-md-4">
                        <h5>QUICK LINKS</h5>
                        <ul>
                            <li><a href="https://www.mohe.gov.my/" target="_blank">Ministry of Higher Education</a></li>
                            <li><a href="https://hea.uitm.edu.my/v4/index.php/calendars/academic-calendar">Academic Calendar</a></li>
                            <li><a href="https://simsweb.uitm.edu.my/sportal_app/graduat_search/index.htm">Graduate Quick Search</a></li>
                            <li><a href="https://library.uitm.edu.my/">Library</a></li>
                            <li><a href="https://news.uitm.edu.my/">News</a></li>
                            <li><a href="https://uitmholdings.com/">UiTM Holdings</a></li>
                            <li><a href="https://uitmholdings.com/">WiFi UiTM</a></li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <h5>CONTACT US</h5>
                        <ul>
                            <li>Universiti Teknologi MARA (UiTM)</li>
                            <li>02600 Arau, [Perlis Indera Kayangan]</li>
                            <li>Malaysia</li>
                            <li>Tel: +603-988 2411</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Social Media Icons -->
            <div class="social-icons">
                <a href="https://www.facebook.com/uitmrasmi/" target="_blank"><i class="fab fa-facebook-f"></i></a>
                <a href="https://x.com/uitmofficial" target="_blank"><i class="fab fa-twitter"></i></a>
                <a href="https://www.youtube.com/channel/UCjIWjQSyTuVDD-GHPYcg7Pw" target="_blank"><i class="fab fa-youtube"></i></a>
                <a href="https://www.instagram.com/uitm.official/" target="_blank"><i class="fab fa-instagram"></i></a>
            </div>

            <div class="copyright">
                © COPYRIGHT LIYANA SYAMIMI
            </div>

            <!-- Back to top button -->
            <div class="back-to-top" onclick="window.scrollTo({ top: 0, behavior: 'smooth' });">
                <i class="fas fa-arrow-up"></i>
            </div>
        @endif
</div>

    <!-- REQUIRED SCRIPTS -->
    <!-- jQuery first, then Bootstrap Bundle with Popper -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')
</body>
</html>
