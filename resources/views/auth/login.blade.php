@extends('layouts.app')

@section('title', 'Вход - Aura Computers')

@push('styles')
<style>
    .login-container {
        min-height: 80vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding-top: 2rem;
        padding-bottom: 2rem;
    }

    .login-card {
        width: 100%;
        max-width: 420px;
        border-radius: 0.75rem;
        border: 1px solid var(--bs-border-color-translucent);
        overflow: hidden;
    }

    [data-bs-theme="light"] .login-card {
        background-color: var(--bs-body-bg);
        box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.1);
    }

    [data-bs-theme="dark"] .login-card {
        background-color: var(--bs-tertiary-bg);
        box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.25);
    }

    .login-card-header {
        padding: 1.5rem 1.75rem;
        border-bottom: 1px solid var(--bs-border-color-translucent);
    }

    [data-bs-theme="light"] .login-card-header {
        background-color: var(--bs-light-bg-subtle);
    }

    [data-bs-theme="dark"] .login-card-header {
        background-color: var(--bs-dark-bg-subtle);
    }


    .login-card-header .logo-container {
        margin-bottom: 1rem;
        text-align: center;
    }

    .login-card-header .logo-container img,
    .login-card-header .logo-container svg {
        height: 48px;
        width: auto;
    }

    .login-card-header h2 {
        font-weight: 600;
        color: var(--bs-emphasis-color);
        margin-bottom: 0.25rem;
    }

    .login-card-header .text-muted {
        color: var(--bs-secondary-color) !important;
    }

    .login-card-body {
        padding: 1.75rem;
    }

    .form-check-input:checked {
        background-color: var(--bs-primary);
        border-color: var(--bs-primary);
    }

    .btn-primary {
        font-weight: 500;
        padding: 0.75rem 1.5rem;
        letter-spacing: 0.025em;
        position: relative;
        transition: background-color 0.2s ease-in-out, border-color 0.2s ease-in-out;
    }

    .btn-primary:disabled {
        opacity: 0.75;
    }

    .link-primary {
        color: var(--bs-primary);
        text-decoration: none;
        font-weight: 500;
    }

    .link-primary:hover {
        text-decoration: underline;
        color: var(--bs-primary-darker, #0a58ca);
    }

    [data-bs-theme="dark"] .link-primary {
        color: var(--bs-primary-lighter, #4dabf7);
    }

    [data-bs-theme="dark"] .link-primary:hover {
        color: var(--bs-primary);
    }

    .input-group-text {
        background-color: var(--bs-tertiary-bg);
        border-right: none;
    }

    .form-control-with-icon {
        border-left: none;
    }

    .password-toggle-btn {
        background-color: var(--bs-tertiary-bg);
        border-left: none;
        cursor: pointer;
    }

    .password-toggle-btn:hover {
        color: var(--bs-primary);
    }
</style>
@endpush

@section('content')
<div class="login-container" data-has-errors="{{ isset($errors) && $errors instanceof \Illuminate\Support\MessageBag && $errors->any() ? 'true' : 'false' }}">
    <div class="login-card">
        <div class="login-card-header text-center">
            <div class="logo-container">
                <a href="{{ route('home') }}">
                    <x-application-logo />
                </a>
            </div>
            <h2>Вход в Aura Computers</h2>
            <p class="text-muted">Пожалуйста, войдите в свой аккаунт</p>
        </div>

        <div class="login-card-body">
            @if (session('status'))
            <div class="alert alert-success mb-4" role="alert">
                {{ session('status') }}
            </div>
            @endif

            @php
            $loginErrorMessage = ($errors instanceof \Illuminate\Support\MessageBag && $errors->has('email')) ? $errors->first('email') : null;
            @endphp

            @if ($loginErrorMessage === 'These credentials do not match our records.')
            <div class="alert alert-danger mb-4" role="alert">
                Неверный email или пароль. Пожалуйста, попробуйте снова.
            </div>
            @endif


            <form method="POST" action="{{ route('login') }}" id="loginForm">
                @csrf

                <div class="form-floating mb-3">
                    <input type="email" class="form-control @if ($loginErrorMessage && $loginErrorMessage !== 'These credentials do not match our records.' && $errors->has('email')) is-invalid @endif" id="email" name="email" placeholder="name@example.com" value="{{ old('email') }}" required autofocus autocomplete="username">
                    <label for="email">Электронная почта</label>
                    @if ($loginErrorMessage && $loginErrorMessage !== 'These credentials do not match our records.' && $errors->has('email'))
                    <div class="invalid-feedback">
                        {{ $loginErrorMessage }}
                    </div>
                    @endif
                </div>

                <div class="form-floating mb-3">
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Пароль" required autocomplete="current-password">
                    <label for="password">Пароль</label>
                    @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>


                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember_me" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember_me">
                            Запомнить меня
                        </label>
                    </div>
                    @if (Route::has('password.request'))
                    <a class="link-primary small" href="{{ route('password.request') }}">
                        Забыли пароль?
                    </a>
                    @endif
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-lg" id="loginButton">
                        <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true" style="display: none;" id="loginSpinner"></span>
                        <span id="loginButtonText">Войти</span>
                    </button>
                </div>

                @if (Route::has('register'))
                <p class="text-center mt-4 mb-0 small text-muted">
                    Нет аккаунта? <a href="{{ route('register') }}" class="link-primary fw-medium">Зарегистрироваться</a>
                </p>
                @endif
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const loginForm = document.getElementById('loginForm');
        const loginButton = document.getElementById('loginButton');
        const loginButtonText = document.getElementById('loginButtonText');
        const loginSpinner = document.getElementById('loginSpinner');
        const hasErrors = document.querySelector('.login-container').dataset.hasErrors === 'true';

        if (loginForm && loginButton && loginSpinner && loginButtonText) {
            loginForm.addEventListener('submit', function(event) {
                if (!loginForm.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                    loginForm.classList.add('was-validated');
                    return;
                }

                loginSpinner.style.display = 'inline-block';
                loginButtonText.textContent = 'Вход...';
                loginButton.disabled = true;
            });
        }

        if (hasErrors) {
            if (loginButton && loginSpinner && loginButtonText) {
                loginSpinner.style.display = 'none';
                loginButtonText.textContent = 'Войти';
                loginButton.disabled = false;
            }
            if (loginForm && !loginForm.classList.contains('was-validated')) {
                loginForm.classList.add('was-validated');
            }
        }
    });
</script>
@endpush