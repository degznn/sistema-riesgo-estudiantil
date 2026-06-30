@extends('layouts.app')

@section('title', 'Login')

@section('content')
<style>
    :root {
        --login-blue: #0f4c81;
        --login-blue-dark: #0b3a63;
        --login-blue-soft: #eaf4fb;
        --login-border: #d8e2ec;
        --login-text: #142033;
        --login-muted: #64748b;
    }

    .login-page {
        width: 100vw;
        min-height: calc(100vh - 3rem);
        margin-left: calc(50% - 50vw);
        margin-top: -1.5rem;
        margin-bottom: -1.5rem;
        background: #f8fafc;
        display: grid;
        place-items: center;
        padding: 48px 20px;
        font-family: Inter, Nunito, "Segoe UI", system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
        position: relative;
        overflow: hidden;
    }

    .login-page::before,
    .login-page::after {
        content: "";
        position: absolute;
        border-radius: 999px;
        background: #e8f3fb;
        opacity: .7;
        pointer-events: none;
    }

    .login-page::before {
        width: 220px;
        height: 220px;
        top: -90px;
        left: -80px;
    }

    .login-page::after {
        width: 160px;
        height: 160px;
        right: -64px;
        bottom: 70px;
    }

    .login-card {
        position: relative;
        z-index: 1;
        width: min(1160px, 100%);
        min-height: 650px;
        display: grid;
        grid-template-columns: 1fr 1fr;
        background: #ffffff;
        border: 1px solid #edf2f7;
        border-radius: 18px;
        box-shadow: 0 22px 54px rgba(15, 76, 129, .10);
        overflow: hidden;
    }

    .login-visual {
        position: relative;
        display: grid;
        place-items: center;
        padding: 54px;
        background: #f4f9fd;
        border-right: 1px solid #edf2f7;
    }

    .login-visual::before {
        content: "";
        position: absolute;
        width: 76%;
        max-width: 440px;
        aspect-ratio: 1;
        border-radius: 999px;
        background: #e5f1fa;
        opacity: .62;
    }

    .academic-illustration {
        position: relative;
        z-index: 1;
        width: min(82%, 430px);
        color: var(--login-blue);
    }

    .illustration-screen {
        position: relative;
        background: #ffffff;
        border: 1px solid #dce8f2;
        border-radius: 20px;
        padding: 26px;
        box-shadow: 0 18px 40px rgba(15, 76, 129, .12);
    }

    .illustration-screen::after {
        content: "";
        position: absolute;
        left: 50%;
        bottom: -52px;
        width: 42%;
        height: 52px;
        transform: translateX(-50%);
        background: linear-gradient(180deg, #d9e6f0 0%, #c7d8e5 100%);
        clip-path: polygon(18% 0, 82% 0, 100% 100%, 0 100%);
    }

    .illustration-base {
        width: 62%;
        height: 12px;
        margin: 66px auto 0;
        border-radius: 999px;
        background: #c7d8e5;
    }

    .screen-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 18px;
        margin-bottom: 22px;
    }

    .screen-title-lines {
        flex: 1;
    }

    .screen-line {
        display: block;
        height: 9px;
        border-radius: 999px;
        background: #d8e7f3;
        margin-bottom: 9px;
    }

    .screen-line:first-child {
        width: 72%;
        background: #b9d5ea;
    }

    .screen-line:last-child {
        width: 46%;
        margin-bottom: 0;
    }

    .screen-badge {
        width: 58px;
        height: 58px;
        border-radius: 16px;
        display: grid;
        place-items: center;
        color: #ffffff;
        background: var(--login-blue);
        box-shadow: 0 12px 22px rgba(15, 76, 129, .20);
    }

    .screen-badge i {
        font-size: 1.9rem;
    }

    .screen-grid {
        display: grid;
        grid-template-columns: .95fr 1.05fr;
        gap: 18px;
    }

    .metric-panel,
    .chart-panel {
        min-height: 150px;
        border: 1px solid #e6eef5;
        border-radius: 16px;
        background: #fbfdff;
        padding: 18px;
    }

    .metric-panel {
        display: grid;
        align-content: center;
        gap: 12px;
    }

    .metric-row {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .metric-dot {
        width: 12px;
        height: 12px;
        border-radius: 999px;
        background: #2aa7c9;
    }

    .metric-dot.warning {
        background: #d9a441;
    }

    .metric-dot.danger {
        background: #d95c5c;
    }

    .metric-bar {
        height: 8px;
        flex: 1;
        border-radius: 999px;
        background: #d8e7f3;
    }

    .chart-panel {
        display: flex;
        align-items: end;
        justify-content: space-between;
        gap: 10px;
    }

    .chart-bar {
        width: 22%;
        border-radius: 999px 999px 8px 8px;
        background: #cfe2f1;
    }

    .chart-bar:nth-child(1) { height: 46%; }
    .chart-bar:nth-child(2) { height: 68%; background: #7db4d6; }
    .chart-bar:nth-child(3) { height: 82%; background: var(--login-blue); }
    .chart-bar:nth-child(4) { height: 56%; background: #2aa7c9; }

    .login-form-panel {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 56px 58px;
        background: #ffffff;
    }

    .login-form-inner {
        width: min(100%, 450px);
    }

    .login-heading {
        text-align: center;
        margin-bottom: 42px;
    }

    .login-brand-icon {
        width: 72px;
        height: 72px;
        margin: 0 auto 22px;
        border-radius: 18px;
        display: grid;
        place-items: center;
        color: var(--login-blue);
        background: var(--login-blue-soft);
        border: 1px solid #d5e7f4;
    }

    .login-brand-icon i {
        font-size: 2.45rem;
        line-height: 1;
    }

    .login-title {
        color: var(--login-text);
        font-size: clamp(1.55rem, 2.1vw, 2rem);
        line-height: 1.2;
        font-weight: 800;
        letter-spacing: 0;
        margin: 0 0 12px;
    }

    .login-subtitle {
        color: var(--login-blue);
        font-size: 1.08rem;
        font-weight: 700;
        letter-spacing: 0;
        margin: 0;
    }

    .login-field {
        position: relative;
        margin-bottom: 20px;
    }

    .login-field-icon,
    .password-toggle {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        display: grid;
        place-items: center;
        z-index: 2;
    }

    .login-field-icon {
        left: 20px;
        color: var(--login-blue);
        font-size: 1.1rem;
    }

    .password-toggle {
        right: 16px;
        border: 0;
        background: transparent;
        color: #7b8794;
        font-size: 1.2rem;
        padding: 7px;
        border-radius: 10px;
        transition: color .18s ease, background-color .18s ease;
    }

    .password-toggle:hover {
        color: var(--login-blue);
        background: #f1f6fb;
    }

    .login-input {
        height: 58px;
        border-radius: 14px;
        border: 1px solid var(--login-border);
        background: #ffffff;
        padding: 0 56px;
        color: var(--login-text);
        font-size: 1rem;
        font-weight: 600;
        box-shadow: 0 8px 18px rgba(15, 76, 129, .04);
        transition: border-color .18s ease, box-shadow .18s ease, background-color .18s ease;
    }

    .login-input:hover {
        border-color: #b9d0e3;
        box-shadow: 0 10px 22px rgba(15, 76, 129, .07);
    }

    .login-input::placeholder {
        color: #98a2b3;
        font-weight: 500;
    }

    .login-input:focus {
        border-color: var(--login-blue);
        box-shadow: 0 0 0 .22rem rgba(15, 76, 129, .13), 0 10px 22px rgba(15, 76, 129, .08);
    }

    .login-options {
        display: flex;
        align-items: center;
        justify-content: flex-start;
        margin: 6px 0 28px;
        color: var(--login-text);
        font-weight: 600;
    }

    .login-check {
        width: 20px;
        height: 20px;
        border-radius: 6px;
        margin-right: 11px;
        border-color: #b8c8d8;
        cursor: pointer;
    }

    .login-check:checked {
        background-color: var(--login-blue);
        border-color: var(--login-blue);
    }

    .login-button {
        width: 100%;
        min-height: 58px;
        border: 0;
        border-radius: 14px;
        background: var(--login-blue);
        color: #ffffff;
        font-size: 1.08rem;
        font-weight: 800;
        box-shadow: 0 12px 24px rgba(15, 76, 129, .22);
        transition: transform .18s ease, box-shadow .18s ease, background-color .18s ease;
    }

    .login-button:hover {
        transform: translateY(-1px);
        background: var(--login-blue-dark);
        box-shadow: 0 16px 30px rgba(15, 76, 129, .28);
        color: #ffffff;
    }

    .authorized-text {
        display: flex;
        align-items: center;
        gap: 16px;
        color: var(--login-muted);
        font-size: .95rem;
        font-weight: 600;
        margin-top: 32px;
        white-space: nowrap;
    }

    .authorized-text::before,
    .authorized-text::after {
        content: "";
        height: 1px;
        flex: 1;
        background: #e2e8f0;
    }

    @media (max-width: 991.98px) {
        .login-card {
            min-height: auto;
            grid-template-columns: 1fr;
        }

        .login-visual {
            min-height: 330px;
            padding: 34px;
            border-right: 0;
            border-bottom: 1px solid #edf2f7;
        }

        .academic-illustration {
            width: min(64%, 330px);
        }

        .login-form-panel {
            padding: 42px 28px 46px;
        }
    }

    @media (max-width: 575.98px) {
        .login-page {
            padding: 16px;
        }

        .login-card {
            border-radius: 16px;
        }

        .login-visual {
            min-height: 240px;
            padding: 24px 18px;
        }

        .academic-illustration {
            width: min(82%, 250px);
        }

        .illustration-screen {
            border-radius: 16px;
            padding: 18px;
        }

        .screen-grid {
            gap: 12px;
        }

        .metric-panel,
        .chart-panel {
            min-height: 105px;
            padding: 12px;
            border-radius: 12px;
        }

        .screen-badge {
            width: 48px;
            height: 48px;
            border-radius: 14px;
        }

        .login-form-panel {
            padding: 34px 20px 36px;
        }

        .login-heading {
            margin-bottom: 32px;
        }

        .login-brand-icon {
            width: 62px;
            height: 62px;
            border-radius: 16px;
            margin-bottom: 18px;
        }

        .login-brand-icon i {
            font-size: 2.05rem;
        }

        .login-title {
            font-size: 1.35rem;
        }

        .login-subtitle {
            font-size: .98rem;
        }

        .login-input {
            height: 56px;
            padding-left: 52px;
            padding-right: 52px;
        }

        .login-button {
            min-height: 56px;
            font-size: 1rem;
        }

        .authorized-text {
            gap: 12px;
            font-size: .88rem;
        }
    }
</style>

<div class="login-page">
    <section class="login-card" aria-label="Inicio de sesion institucional">
        <div class="login-visual">
            <div class="academic-illustration" aria-hidden="true">
                <div class="illustration-screen">
                    <div class="screen-header">
                        <div class="screen-title-lines">
                            <span class="screen-line"></span>
                            <span class="screen-line"></span>
                        </div>
                        <div class="screen-badge">
                            <i class="bi bi-mortarboard-fill"></i>
                        </div>
                    </div>

                    <div class="screen-grid">
                        <div class="metric-panel">
                            <div class="metric-row">
                                <span class="metric-dot"></span>
                                <span class="metric-bar"></span>
                            </div>
                            <div class="metric-row">
                                <span class="metric-dot warning"></span>
                                <span class="metric-bar"></span>
                            </div>
                            <div class="metric-row">
                                <span class="metric-dot danger"></span>
                                <span class="metric-bar"></span>
                            </div>
                        </div>
                        <div class="chart-panel">
                            <span class="chart-bar"></span>
                            <span class="chart-bar"></span>
                            <span class="chart-bar"></span>
                            <span class="chart-bar"></span>
                        </div>
                    </div>
                </div>
                <div class="illustration-base"></div>
            </div>
        </div>

        <div class="login-form-panel">
            <div class="login-form-inner">
                <div class="login-heading">
                    <div class="login-brand-icon" aria-hidden="true">
                        <i class="bi bi-shield-check"></i>
                    </div>

                    <h1 class="login-title">Sistema de Monitoreo de Riesgo Estudiantil</h1>
                    <p class="login-subtitle">Panel Institucional</p>
                </div>

                <form action="{{ route('login.store') }}" method="POST">
                    @csrf

                    <div class="login-field">
                        <i class="bi bi-person-fill login-field-icon"></i>
                        <input
                            type="email"
                            name="email"
                            class="form-control login-input @error('email') is-invalid @enderror"
                            value="{{ old('email') }}"
                            placeholder="Correo institucional"
                            autocomplete="email"
                            required
                        >
                    </div>

                    <div class="login-field">
                        <i class="bi bi-lock-fill login-field-icon"></i>
                        <input
                            type="password"
                            name="password"
                            id="passwordInput"
                            class="form-control login-input @error('password') is-invalid @enderror"
                            placeholder="Contrase&ntilde;a"
                            autocomplete="current-password"
                            required
                        >
                        <button class="password-toggle" type="button" id="togglePassword" aria-label="Mostrar u ocultar contrasena">
                            <i class="bi bi-eye-fill"></i>
                        </button>
                    </div>

                    <label class="login-options">
                        <input class="form-check-input login-check" type="checkbox" name="remember" value="1">
                        Recordarme
                    </label>

                    <button class="login-button" type="submit">Ingresar</button>
                </form>

                <div class="authorized-text">Solo personal autorizado</div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script>
    const passwordInput = document.getElementById('passwordInput');
    const togglePassword = document.getElementById('togglePassword');

    togglePassword.addEventListener('click', () => {
        const isPassword = passwordInput.type === 'password';
        passwordInput.type = isPassword ? 'text' : 'password';
        togglePassword.innerHTML = isPassword
            ? '<i class="bi bi-eye-slash-fill"></i>'
            : '<i class="bi bi-eye-fill"></i>';
    });
</script>
@endpush