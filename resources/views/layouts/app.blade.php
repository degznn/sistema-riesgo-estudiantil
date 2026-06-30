<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Sistema de Monitoreo de Riesgo Estudiantil')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #0b3d73;
            --primary-dark: #082f59;
            --accent: #0f9f6e;
            --warning: #f3b21a;
            --danger: #d64242;
            --surface: #ffffff;
            --muted: #667085;
            --line: #d9e2ec;
            --page: #f4f7fb;
            --sidebar-width: 278px;
            --sidebar-mini: 86px;
        }

        body {
            background: var(--page);
            color: #1f2937;
            font-size: 0.95rem;
        }

        .card {
            border-radius: 8px;
            border: 1px solid var(--line);
            box-shadow: 0 10px 28px rgba(8, 47, 89, 0.05);
        }

        .table thead th {
            background: #eef4fa;
            color: #344054;
            font-size: 0.78rem;
            font-weight: 700;
            text-transform: uppercase;
            white-space: nowrap;
        }

        .badge-risk-Rojo,
        .badge-risk-Alto { background: var(--danger); }
        .badge-risk-Ambar,
        .badge-risk-Medio { background: var(--warning); color: #2b2b2b; }
        .badge-risk-Verde,
        .badge-risk-Bajo { background: var(--accent); }
        .badge-risk-Sin { background: #6c757d; }

        .app-shell {
            min-height: 100vh;
            display: flex;
        }

        .app-sidebar {
            width: var(--sidebar-width);
            background: linear-gradient(180deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: #fff;
            position: fixed;
            inset: 0 auto 0 0;
            z-index: 1040;
            transition: width .2s ease, transform .2s ease;
            display: flex;
            flex-direction: column;
        }

        .brand-panel {
            height: 76px;
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0 22px;
            border-bottom: 1px solid rgba(255, 255, 255, .13);
        }

        .brand-mark {
            width: 42px;
            height: 42px;
            border-radius: 8px;
            display: grid;
            place-items: center;
            background: #fff;
            color: var(--primary);
            flex: 0 0 auto;
        }

        .brand-title {
            font-weight: 800;
            line-height: 1.1;
        }

        .brand-subtitle {
            color: rgba(255, 255, 255, .7);
            font-size: .76rem;
        }

        .sidebar-menu {
            padding: 16px 12px;
            overflow-y: auto;
        }

        .sidebar-link {
            color: rgba(255, 255, 255, .82);
            display: flex;
            align-items: center;
            gap: 12px;
            min-height: 44px;
            padding: 10px 12px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .sidebar-link:hover,
        .sidebar-link.active {
            color: #fff;
            background: rgba(255, 255, 255, .14);
        }

        .sidebar-link i {
            font-size: 1.12rem;
            width: 24px;
            text-align: center;
            flex: 0 0 auto;
        }

        .sidebar-footer {
            margin-top: auto;
            padding: 16px;
            border-top: 1px solid rgba(255, 255, 255, .13);
        }

        .sidebar-user-card {
            background: rgba(255, 255, 255, .1);
            border-radius: 8px;
            padding: 12px;
        }

        .app-main {
            flex: 1;
            min-width: 0;
            margin-left: var(--sidebar-width);
            transition: margin-left .2s ease;
        }

        .topbar {
            min-height: 76px;
            background: rgba(255, 255, 255, .94);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--line);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            padding: 0 24px;
            position: sticky;
            top: 0;
            z-index: 1020;
        }

        .icon-button {
            border: 1px solid var(--line);
            background: #fff;
            color: var(--primary);
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: inline-grid;
            place-items: center;
        }

        .content-wrap {
            padding: 24px;
        }

        .role-pill {
            background: #e7f6f0;
            color: #08714d;
            border: 1px solid #bde8d8;
            border-radius: 999px;
            padding: 5px 10px;
            font-size: .78rem;
            font-weight: 700;
        }

        .sidebar-collapsed .app-sidebar {
            width: var(--sidebar-mini);
        }

        .sidebar-collapsed .app-main {
            margin-left: var(--sidebar-mini);
        }

        .sidebar-collapsed .brand-copy,
        .sidebar-collapsed .sidebar-text,
        .sidebar-collapsed .sidebar-footer {
            display: none;
        }

        .sidebar-collapsed .brand-panel {
            justify-content: center;
            padding-inline: 12px;
        }

        .sidebar-collapsed .sidebar-link {
            justify-content: center;
        }

        .sidebar-backdrop {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, .45);
            z-index: 1030;
        }

        @media (max-width: 991.98px) {
            .app-sidebar {
                transform: translateX(-100%);
                width: var(--sidebar-width);
            }

            .sidebar-open .app-sidebar {
                transform: translateX(0);
            }

            .sidebar-open .sidebar-backdrop {
                display: block;
            }

            .app-main,
            .sidebar-collapsed .app-main {
                margin-left: 0;
            }

            .sidebar-collapsed .app-sidebar {
                width: var(--sidebar-width);
            }

            .sidebar-collapsed .brand-copy,
            .sidebar-collapsed .sidebar-text,
            .sidebar-collapsed .sidebar-footer {
                display: block;
            }

            .sidebar-collapsed .brand-panel {
                justify-content: flex-start;
                padding: 0 22px;
            }

            .sidebar-collapsed .sidebar-link {
                justify-content: flex-start;
            }

            .topbar {
                padding: 0 16px;
            }

            .content-wrap {
                padding: 18px 14px;
            }
        }
    </style>
</head>
<body>
    @auth
        <div class="app-shell" id="appShell">
            <aside class="app-sidebar">
                <div class="brand-panel">
                    <span class="brand-mark"><i class="bi bi-mortarboard-fill"></i></span>
                    <div class="brand-copy">
                        <div class="brand-title">Riesgo Estudiantil</div>
                        <div class="brand-subtitle">Panel institucional</div>
                    </div>
                </div>

                <nav class="sidebar-menu">
                    <a class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}" title="Dashboard">
                        <i class="bi bi-grid-1x2-fill"></i>
                        <span class="sidebar-text">Dashboard</span>
                    </a>
                    <a class="sidebar-link {{ request()->routeIs('estudiantes.*') ? 'active' : '' }}" href="{{ route('estudiantes.index') }}" title="Estudiantes">
                        <i class="bi bi-people-fill"></i>
                        <span class="sidebar-text">{{ auth()->user()->hasRole('tutor') ? 'Mis estudiantes' : 'Estudiantes' }}</span>
                    </a>
                    <a class="sidebar-link {{ request()->routeIs('entrevistas.*') ? 'active' : '' }}" href="{{ route('entrevistas.index') }}" title="Entrevistas">
                        <i class="bi bi-clipboard2-pulse-fill"></i>
                        <span class="sidebar-text">Entrevistas</span>
                    </a>
                    @if (auth()->user()->hasRole('administrador', 'bienestar'))
                        <a class="sidebar-link {{ request()->routeIs('periodos.*') ? 'active' : '' }}" href="{{ route('periodos.index') }}" title="Periodos">
                            <i class="bi bi-calendar3"></i>
                            <span class="sidebar-text">Periodos</span>
                        </a>
                        <a class="sidebar-link {{ request()->routeIs('tutores.*') ? 'active' : '' }}" href="{{ route('tutores.index') }}" title="Tutores">
                            <i class="bi bi-person-workspace"></i>
                            <span class="sidebar-text">Tutores</span>
                        </a>
                        <a class="sidebar-link {{ request()->routeIs('asignaciones.*') ? 'active' : '' }}" href="{{ route('asignaciones.index') }}" title="Asignaciones">
                            <i class="bi bi-diagram-3-fill"></i>
                            <span class="sidebar-text">Asignaciones</span>
                        </a>
                    @endif
                </nav>

                <div class="sidebar-footer">
                    <div class="sidebar-user-card">
                        <div class="fw-bold text-truncate">{{ auth()->user()->name }}</div>
                        <div class="small opacity-75 text-truncate">{{ auth()->user()->email }}</div>
                    </div>
                </div>
            </aside>

            <div class="sidebar-backdrop" id="sidebarBackdrop"></div>

            <div class="app-main">
                <header class="topbar">
                    <div class="d-flex align-items-center gap-2">
                        <button class="icon-button" type="button" id="sidebarToggle" aria-label="Mostrar u ocultar menu">
                            <i class="bi bi-list"></i>
                        </button>
                        <div>
                            <div class="fw-bold">Sistema de Monitoreo de Riesgo Estudiantil</div>
                            <div class="small text-muted d-none d-sm-block">{{ now()->timezone('America/Lima')->format('d/m/Y') }}</div>
                        </div>
                    </div>

                    <div class="d-flex align-items-center gap-2 gap-sm-3">
                        <span class="role-pill d-none d-md-inline-flex">{{ ucfirst(auth()->user()->role) }}</span>
                        <div class="text-end d-none d-lg-block">
                            <div class="fw-semibold">{{ auth()->user()->name }}</div>
                            <div class="small text-muted">{{ auth()->user()->email }}</div>
                        </div>
                        <form action="{{ route('logout') }}" method="POST" class="m-0">
                            @csrf
                            <button class="btn btn-outline-danger btn-sm" title="Cerrar sesion">
                                <i class="bi bi-box-arrow-right"></i>
                                <span class="d-none d-sm-inline">Salir</span>
                            </button>
                        </form>
                    </div>
                </header>

                <main class="content-wrap">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>Revise los datos ingresados.</strong>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @yield('content')
                </main>
            </div>
        </div>
    @else
        <main class="container py-4">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Revise los datos ingresados.</strong>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>
    @endauth

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @auth
        <script>
            const shell = document.getElementById('appShell');
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebarBackdrop = document.getElementById('sidebarBackdrop');

            if (localStorage.getItem('sidebar-collapsed') === 'true') {
                shell.classList.add('sidebar-collapsed');
            }

            sidebarToggle.addEventListener('click', () => {
                if (window.innerWidth < 992) {
                    shell.classList.toggle('sidebar-open');
                    return;
                }

                shell.classList.toggle('sidebar-collapsed');
                localStorage.setItem('sidebar-collapsed', shell.classList.contains('sidebar-collapsed'));
            });

            sidebarBackdrop.addEventListener('click', () => shell.classList.remove('sidebar-open'));
        </script>
    @endauth
    @stack('scripts')
</body>
</html>
