@extends('layouts.app')

@section('title', 'Login')

@section('content')
<style>
    .login-page {
        width: 100vw;
        min-height: calc(100vh - 3rem);
        margin-left: calc(50% - 50vw);
        margin-top: -1.5rem;
        margin-bottom: -1.5rem;
        background: #eef8ff;
        display: grid;
        place-items: center;
        padding: 42px 18px;
        font-family: "Segoe UI", system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
    }

    .login-card {
        width: min(1320px, 100%);
        min-height: 720px;
        display: grid;
        grid-template-columns: 1fr 1fr;
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0 28px 60px rgba(11, 61, 115, .17);
        overflow: hidden;
        border: 1px solid rgba(117, 181, 226, .35);
    }

    .login-visual {
        position: relative;
        background: linear-gradient(135deg, #f7fcff 0%, #e9f6ff 100%);
        display: grid;
        place-items: center;
        padding: 48px;
        overflow: hidden;
    }

    .login-visual::before,
    .login-visual::after {
        content: "";
        position: absolute;
        border-radius: 999px;
        background: rgba(159, 213, 247, .32);
    }

    .login-visual::before {
        width: 230px;
        height: 230px;
        top: -86px;
        right: 120px;
    }

    .login-visual::after {
        width: 420px;
        height: 420px;
        left: 60px;
        bottom: 48px;
    }

    .dot-pattern {
        position: absolute;
        top: 112px;
        left: 70px;
        width: 120px;
        height: 120px;
        z-index: 1;
        background-image: radial-gradient(#8bbef1 3px, transparent 3px);
        background-size: 22px 22px;
        opacity: .85;
    }

    .circle-small,
    .circle-bottom {
        position: absolute;
        border-radius: 999px;
        background: rgba(117, 181, 226, .36);
        z-index: 1;
    }

    .circle-small {
        width: 58px;
        height: 58px;
        right: 86px;
        top: 250px;
    }

    .circle-bottom {
        width: 210px;
        height: 210px;
        right: -36px;
        bottom: -84px;
    }

    .education-image {
        position: relative;
        z-index: 2;
        width: 80%;
        max-width: 540px;
        max-height: 80%;
        object-fit: contain;
        border-radius: 18px;
        filter: drop-shadow(0 24px 26px rgba(11, 61, 115, .12));
    }

    .login-form-panel {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 48px;
        background: #ffffff;
    }

    .login-form-inner {
        width: min(100%, 520px);
        text-align: center;
    }

    .login-brand-icon {
        width: 112px;
        height: 112px;
        margin: 0 auto 26px;
        border-radius: 28px;
        display: grid;
        place-items: center;
        color: #006bc7;
        background: linear-gradient(135deg, #f5fbff 0%, #e9f5ff 100%);
        box-shadow: 0 18px 34px rgba(0, 107, 199, .12);
    }

    .login-brand-icon i {
        font-size: 4.6rem;
        line-height: 1;
    }

    .login-title {
        color: #0c1d35;
        font-size: clamp(1.7rem, 2.4vw, 2.35rem);
        line-height: 1.18;
        font-weight: 800;
        letter-spacing: 0;
        margin-bottom: 16px;
    }

    .login-subtitle {
        color: #006bc7;
        font-size: 1.22rem;
        font-weight: 800;
        letter-spacing: 0;
        margin-bottom: 42px;
    }

    .login-field {
        position: relative;
        margin-bottom: 22px;
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
        left: 22px;
        color: #006bc7;
        font-size: 1.28rem;
    }

    .password-toggle {
        right: 18px;
        border: 0;
        background: transparent;
        color: #7a8796;
        font-size: 1.35rem;
        padding: 6px;
    }

    .login-input {
        height: 66px;
        border-radius: 10px;
        border: 1.6px solid #c8d6e6;
        padding: 0 58px;
        color: #182336;
        font-size: 1rem;
        font-weight: 600;
        box-shadow: 0 8px 20px rgba(8, 118, 201, .04);
        transition: border-color .2s ease, box-shadow .2s ease, transform .2s ease;
    }

    .login-input::placeholder {
        color: #9aa6b5;
        font-weight: 500;
    }

    .login-input:focus {
        border-color: #0077d9;
        box-shadow: 0 0 0 .25rem rgba(0, 119, 217, .14), 0 12px 24px rgba(8, 118, 201, .10);
        transform: translateY(-1px);
    }

    .login-options {
        display: flex;
        align-items: center;
        justify-content: flex-start;
        margin: 8px 0 30px;
        color: #182336;
        font-weight: 600;
    }

    .login-check {
        width: 22px;
        height: 22px;
        border-radius: 6px;
        margin-right: 12px;
        border-color: #7cbcf0;
        cursor: pointer;
    }

    .login-check:checked {
        background-color: #0876c9;
        border-color: #0876c9;
    }

    .login-button {
        width: 100%;
        min-height: 68px;
        border: 0;
        border-radius: 10px;
        background: linear-gradient(135deg, #087ce0 0%, #0066cb 100%);
        color: #ffffff;
        font-size: 1.3rem;
        font-weight: 800;
        box-shadow: 0 16px 26px rgba(0, 107, 199, .22);
        transition: transform .2s ease, box-shadow .2s ease, filter .2s ease;
    }

    .login-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 20px 34px rgba(0, 107, 199, .30);
        filter: brightness(1.03);
        color: #ffffff;
    }

    .authorized-text {
        display: flex;
        align-items: center;
        gap: 18px;
        color: #667085;
        font-weight: 600;
        margin-top: 34px;
        white-space: nowrap;
    }

    .authorized-text::before,
    .authorized-text::after {
        content: "";
        height: 1px;
        flex: 1;
        background: #cbd5e1;
    }

    @media (max-width: 991.98px) {
        .login-card {
            min-height: auto;
            grid-template-columns: 1fr;
        }

        .login-visual {
            min-height: 320px;
            padding: 30px;
        }

        .education-image {
            width: min(62%, 310px);
            max-height: 260px;
        }

        .login-form-panel {
            padding: 36px 26px 44px;
        }
    }

    @media (max-width: 575.98px) {
        .login-page {
            padding: 14px;
        }

        .login-card {
            border-radius: 16px;
        }

        .login-visual {
            min-height: 220px;
            padding: 18px;
        }

        .education-image {
            width: min(68%, 220px);
            max-height: 180px;
            border-radius: 14px;
        }

        .login-form-panel {
            padding: 28px 18px 32px;
        }

        .login-brand-icon {
            width: 82px;
            height: 82px;
            border-radius: 20px;
            margin-bottom: 22px;
        }

        .login-brand-icon i {
            font-size: 3.35rem;
        }

        .login-title {
            font-size: 1.38rem;
        }

        .login-subtitle {
            font-size: 1rem;
            margin-bottom: 30px;
        }

        .login-input {
            height: 58px;
            padding-left: 52px;
            padding-right: 52px;
        }

        .login-button {
            min-height: 58px;
            font-size: 1.1rem;
        }

        .authorized-text {
            gap: 12px;
            font-size: .9rem;
        }
    }
</style>

<div class="login-page">
    <section class="login-card" aria-label="Inicio de sesion institucional">
        <div class="login-visual">
            <span class="dot-pattern"></span>
            <span class="circle-small"></span>
            <span class="circle-bottom"></span>
            <img class="education-image" src="{{ asset('images/login/left-illustration.png') }}" alt="Ilustracion institucional de seguridad academica">
        </div>

        <div class="login-form-panel">
            <div class="login-form-inner">
                <div class="login-brand-icon" aria-hidden="true">
                    <i class="bi bi-shield-fill-check"></i>
                </div>

                <h1 class="login-title">Sistema de Monitoreo de Riesgo Estudiantil</h1>
                <div class="login-subtitle">Panel Institucional</div>

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
