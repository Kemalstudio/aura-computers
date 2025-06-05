@extends('layouts.app')

@section('title', 'Регистрация - Aura Computers')

@push('styles')
<style>
    .register-container {
        min-height: 85vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding-top: 2rem;
        padding-bottom: 2rem;
    }

    .register-card {
        width: 100%;
        max-width: 450px;
        border-radius: 0.75rem;
        border: 1px solid var(--bs-border-color-translucent);
        overflow: hidden;
    }

    [data-bs-theme="light"] .register-card {
        background-color: var(--bs-body-bg);
        box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.1);
    }

    [data-bs-theme="dark"] .register-card {
        background-color: var(--bs-tertiary-bg);
        box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.25);
    }

    .register-card-header {
        padding: 1.5rem 1.75rem;
        border-bottom: 1px solid var(--bs-border-color-translucent);
    }

    [data-bs-theme="light"] .register-card-header {
        background-color: var(--bs-light-bg-subtle);
    }

    [data-bs-theme="dark"] .register-card-header {
        background-color: var(--bs-dark-bg-subtle);
    }

    .register-card-header .logo-container {
        margin-bottom: 1rem;
        text-align: center;
    }

    .register-card-header .logo-container img,
    .register-card-header .logo-container svg {
        height: 48px;
        width: auto;
    }

    .register-card-header h2 {
        font-weight: 600;
        color: var(--bs-emphasis-color);
        margin-bottom: 0.25rem;
    }

    .register-card-header .text-muted {
        color: var(--bs-secondary-color) !important;
    }

    .register-card-body {
        padding: 1.75rem;
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
</style>
@endpush

@section('content')
<div class="register-container" data-has-errors="{{ isset($errors) && $errors instanceof \Illuminate\Support\MessageBag && $errors->any() ? 'true' : 'false' }}">
    <div class="register-card">
        <div class="register-card-header text-center">
            <div class="logo-container">
                <a href="{{ route('home') }}">
                    <x-application-logo />
                </a>
            </div>
            <h2>Регистрация в Aura Computers</h2>
            <p class="text-muted">Создайте новый аккаунт</p>
        </div>

        <div class="register-card-body">
            @if (session('status'))
            <div class="alert alert-success mb-4" role="alert">
                {{ session('status') }}
            </div>
            @endif

            <form method="POST" action="{{ route('register') }}" id="registerForm">
                @csrf

                <!-- Name -->
                <div class="form-floating mb-3">
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Ваше имя" value="{{ old('name') }}" required autofocus autocomplete="name">
                    <label for="name">Имя</label>
                    @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <!-- Username -->
                <div class="form-floating mb-3">
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Ваше имя" value="{{ old('name') }}" required autofocus autocomplete="name">
                    <label for="name">Фамилия</label>
                    @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <!-- Email Address -->
                <div class="form-floating mb-3">
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="name@example.com" value="{{ old('email') }}" required autocomplete="username">
                    <label for="email">Электронная почта</label>
                    @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="form-floating mb-3">
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Пароль" required autocomplete="new-password">
                    <label for="password">Пароль</label>
                    @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="form-floating mb-3">
                    <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation" placeholder="Подтвердите пароль" required autocomplete="new-password">
                    <label for="password_confirmation">Подтвердите пароль</label>
                    @error('password_confirmation')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>


                <div class="d-flex justify-content-end align-items-center mt-4 mb-3">
                    <a class="link-primary small" href="{{ route('login') }}">
                        Уже зарегистрированы?
                    </a>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-lg" id="registerButton">
                        <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true" style="display: none;" id="registerSpinner"></span>
                        <span id="registerButtonText">Зарегистрироваться</span>
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const registerForm = document.getElementById('registerForm');
        const registerButton = document.getElementById('registerButton');
        const registerButtonText = document.getElementById('registerButtonText');
        const registerSpinner = document.getElementById('registerSpinner');
        const hasErrors = document.querySelector('.register-container').dataset.hasErrors === 'true';

        if (registerForm && registerButton && registerSpinner && registerButtonText) {
            registerForm.addEventListener('submit', function(event) {
                if (!registerForm.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                    registerForm.classList.add('was-validated');
                    return;
                }

                registerSpinner.style.display = 'inline-block';
                registerButtonText.textContent = 'Регистрация...';
                registerButton.disabled = true;
            });
        }

        if (hasErrors) {
            if (registerButton && registerSpinner && registerButtonText) {
                registerSpinner.style.display = 'none';
                registerButtonText.textContent = 'Зарегистрироваться';
                registerButton.disabled = false;
            }
            if (registerForm && !registerForm.classList.contains('was-validated')) {
                registerForm.classList.add('was-validated');
            }
        }
    });
</script>
@endpush