<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('img/Finzly.png') }}" type="image/png">
    <title>Finzly</title>


    {{-- FontAwesome --}}

    <script src="https://kit.fontawesome.com/e848d349d3.js" crossorigin="anonymous"></script>

    {{-- Google Fonts --}}
    {{-- <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet"> --}}

    {{-- <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap"
        rel="stylesheet"> --}}

    

    {{-- CSS Globales --}}
    <link rel="stylesheet" href="{{ asset('css/variable_global.css') }}">
    <link rel="stylesheet" href="{{ asset('css/plantillabase.css') }}">
    <link rel="stylesheet" href="{{ asset('css/aside.css') }}">
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}">

    {{-- Stack para CSS específicos por vista --}}
    @stack('styles')

    {{-- jQuery (global) --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    {{-- Hamburger menu button --}}
    <button class="menu-toggle" id="menuToggle">
        <i class="fas fa-bars"></i>
    </button>

    {{-- Overlay for mobile menu --}}
    <div class="overlay" id="overlay"></div>

    {{-- aside --}}
    <aside class="aside" id="sidebar">

        <div class="logo">
            <img src="{{ asset('img/Finzly.png') }}" alt="logo">
        </div>
        <div class="menu">
            <a href="{{ url('/') }}"><i class="fas fa-home"></i> Inicio</a>
            <a href="{{ url('/calendario') }}"><i class="fas fa-calendar"></i> Calendario</a>
            <a href="{{ url('/saldo_inicial') }}"><i class="fas fa-hand-holding-usd"></i> Saldo Inicial</a>
            <a href="{{ url('/categorias') }}"><i class="fas fa-tags"></i> Categorías</a>
            <a href="{{ url('/pagos') }}"><i class="fas fa-credit-card"></i> Pagos</a>
            <a href="{{ url('/reportes') }}"><i class="fas fa-chart-bar"></i> Reportes</a>
            <a href="{{ url('/perfil') }}" class="profile"><i class="fas fa-user"></i> Perfil</a>

        </div>
        <div class="user">
            <a href="{{ url('/logout') }}" class="logout"><i class="fas fa-sign-out-alt"></i> Cerrar sesión</a>
        </div>
        <div class="theme">
            <div class="theme-btn" id="dark-mode">
                <i class="fas fa-moon"></i>
            </div>
            <div class="theme-btn" id="light-mode">
                <i class="fas fa-sun"></i>
            </div>
        </div>
    </aside>

    {{-- navbar --}}
    <nav class="navbar">
        <div class="navbar-container">
            <div class="navbar-menu">
                <div class="bienvenido">
                    <p>Bienvenido</p>
                </div>
                <div class="usuario">
                    <p>Usuario: Johan</p>
                    <img src="{{ asset('img/FinZly.png') }}" alt="avatar">
                </div>
            </div>
        </div>
    </nav>

    {{-- main content --}}
    <main class="main-content">
        @yield('content')
    </main>

    {{-- JavaScript for mobile menu --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuToggle = document.getElementById('menuToggle');
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');

            function toggleMenu() {
                sidebar.classList.toggle('show');
                overlay.classList.toggle('show');
            }

            function closeMenu() {
                sidebar.classList.remove('show');
                overlay.classList.remove('show');
            }

            // Toggle menu when hamburger button is clicked
            menuToggle.addEventListener('click', toggleMenu);

            // Close menu when overlay is clicked
            overlay.addEventListener('click', closeMenu);

            // Close menu when window is resized to desktop size
            window.addEventListener('resize', function() {
                if (window.innerWidth > 768) {
                    closeMenu();
                }
            });

            // Close menu when clicking on menu links (mobile)
            const menuLinks = sidebar.querySelectorAll('.menu a, .logout');
            menuLinks.forEach(link => {
                link.addEventListener('click', function() {
                    if (window.innerWidth <= 768) {
                        closeMenu();
                    }
                });
            });
        });
    </script>

    {{-- Stack para scripts específicos por vista --}}
    @stack('scripts')
</body>

</html>
