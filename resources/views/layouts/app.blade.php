<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light">

<head>
    <meta charset="utf-g">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Aura Computers')</title>

    {{-- Подключение стилей --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.bunny.net/css?family=nunito:400,500,600,700&display=swap" rel="stylesheet" />

    {{-- Основные стили и стили для панели сравнения --}}
    <style>
        :root {
            --bs-primary-rgb: 59, 130, 246;
            --bs-body-font-family: 'Nunito', sans-serif;
        }

        [data-bs-theme="dark"] {
            --bs-primary-rgb: 96, 165, 250;
            --bs-body-bg: #111827;
            --bs-body-color: #f3f4f6;
            --bs-tertiary-bg: #1f2937;
            --bs-border-color: #374151;
            --bs-border-color-translucent: rgba(255, 255, 255, 0.1);
        }

        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .content-wrapper {
            flex: 1;
        }

        .navbar {
            background-color: var(--bs-body-bg);
            border-bottom: 1px solid var(--bs-border-color-translucent);
        }

        .navbar-brand-logo {
            height: 32px;
        }

        .action-icon-badge {
            font-size: 0.6em;
            padding: 0.2em 0.4em;
        }

        .navbar .btn-action-icon {
            font-size: 1.2rem;
            padding: .375rem .6rem;
        }

        .lang-flag {
            width: 20px;
            height: 15px;
            border-radius: 2px;
        }

        /* СТИЛИ ДЛЯ ПАНЕЛИ СРАВНЕНИЯ */
        .compare-bar {
            position: fixed;
            bottom: -200px;
            /* Скрыта */
            left: 50%;
            transform: translateX(-50%);
            width: 95%;
            max-width: 800px;
            background-color: #212529;
            color: #fff;
            border-radius: 12px 12px 0 0;
            box-shadow: 0 -5px 25px rgba(0, 0, 0, 0.2);
            padding: 1rem 1.5rem;
            z-index: 1050;
            transition: bottom 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            display: flex;
            align-items: center;
        }

        .compare-bar.show {
            bottom: 0;
        }

        .compare-bar__icon {
            margin-right: 1.5rem;
            flex-shrink: 0;
        }

        .compare-bar__icon svg {
            width: 40px;
            height: 40px;
            color: var(--bs-primary);
        }

        .compare-bar__info {
            flex-grow: 1;
        }

        .compare-bar__text {
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }

        .compare-bar__items {
            display: flex;
            gap: 0.75rem;
        }

        .compare-bar__item {
            position: relative;
            flex-shrink: 0;
        }

        .compare-bar__item img {
            width: 50px;
            height: 50px;
            object-fit: contain;
            background-color: #fff;
            border-radius: 6px;
            padding: 4px;
        }

        .compare-bar__item-remove {
            position: absolute;
            top: -6px;
            right: -6px;
            width: 18px;
            height: 18px;
            background-color: #dc3545;
            color: white;
            border-radius: 50%;
            border: 1px solid white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            line-height: 1;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .compare-bar__item-remove:hover {
            transform: scale(1.1);
        }

        .compare-bar__actions {
            margin-left: 1.5rem;
            display: flex;
            gap: 0.5rem;
            align-items: center;
        }

        .compare-bar__close {
            background: none;
            border: none;
            color: #adb5bd;
            font-size: 24px;
            padding: 0 .5rem;
            line-height: 1;
        }

        .compare-bar__close:hover {
            color: #fff;
        }
    </style>
    @stack('styles')
</head>

<body class="font-sans antialiased">
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                {{-- Ваша иконка, как и была --}}
                <svg viewBox="0 0 316 316" xmlns="http://www.w3.org/2000/svg" class="navbar-brand-logo me-2">
                    <path fill="currentColor" d="M305.8 81.125C305.77 80.995 305.69 80.885 305.65 80.755C305.56 80.525 305.49 80.285 305.37 80.075C305.29 79.935 305.17 79.815 305.07 79.685C304.94 79.515 304.83 79.325 304.68 79.175C304.55 79.045 304.39 78.955 304.25 78.845C304.09 78.715 303.95 78.575 303.77 78.475L251.32 48.275C249.97 47.495 248.31 47.495 246.96 48.275L194.51 78.475C194.33 78.575 194.19 78.725 194.03 78.845C193.89 78.955 193.73 79.045 193.6 79.175C193.45 79.325 193.34 79.515 193.21 79.685C193.11 79.815 192.99 79.935 192.91 80.075C192.79 80.285 192.71 80.525 192.63 80.755C192.58 80.875 192.51 80.995 192.48 81.125C192.38 81.495 192.33 81.875 192.33 82.265V139.625L148.62 164.795V52.575C148.62 52.185 148.57 51.805 148.47 51.435C148.44 51.305 148.36 51.195 148.32 51.065C148.23 50.835 148.16 50.595 148.04 50.385C147.96 50.245 147.84 50.125 147.74 49.995C147.61 49.825 147.5 49.635 147.35 49.485C147.22 49.355 147.06 49.265 146.92 49.155C146.76 49.025 146.62 48.885 146.44 48.785L93.99 18.585C92.64 17.805 90.98 17.805 89.63 18.585L37.18 48.785C37 48.885 36.86 49.035 36.7 49.155C36.56 49.265 36.4 49.355 36.27 49.485C36.12 49.635 36.01 49.825 35.88 49.995C35.78 50.125 35.66 50.245 35.58 50.385C35.46 50.595 35.38 50.835 35.3 51.065C35.25 51.185 35.18 51.305 35.15 51.435C35.05 51.805 35 52.185 35 52.575V232.235C35 233.795 35.84 235.245 37.19 236.025L142.1 296.425C142.33 296.555 142.58 296.635 142.82 296.725C142.93 296.765 143.04 296.835 143.16 296.865C143.53 296.965 143.9 297.015 144.28 297.015C144.66 297.015 145.03 296.965 145.4 296.865C145.5 296.835 145.59 296.775 145.69 296.745C145.95 296.655 146.21 296.565 146.45 296.435L251.36 236.035C252.72 235.255 253.55 233.815 253.55 232.245V174.885L303.81 145.945C305.17 145.165 306 143.725 306 142.155V82.265C305.95 81.875 305.89 81.495 305.8 81.125ZM144.2 227.205L100.57 202.515L146.39 176.135L196.66 147.195L240.33 172.335L208.29 190.625L144.2 227.205ZM244.75 114.995V164.795L226.39 154.225L201.03 139.625V89.825L219.39 100.395L244.75 114.995ZM249.12 57.105L292.81 82.265L249.12 107.425L205.43 82.265L249.12 57.105ZM114.49 184.425L96.13 194.995V85.305L121.49 70.705L139.85 60.135V169.815L114.49 184.425ZM91.76 27.425L135.45 52.585L91.76 77.745L48.07 52.585L91.76 27.425ZM43.67 60.135L62.03 70.705L87.39 85.305V202.545V202.555V202.565C87.39 202.735 87.44 202.895 87.46 203.055C87.49 203.265 87.49 203.485 87.55 203.695V203.705C87.6 203.875 87.69 204.035 87.76 204.195C87.84 204.375 87.89 204.575 87.99 204.745C87.99 204.745 87.99 204.755 88 204.755C88.09 204.905 88.22 205.035 88.33 205.175C88.45 205.335 88.55 205.495 88.69 205.635L88.7 205.645C88.82 205.765 88.98 205.855 89.12 205.965C89.28 206.085 89.42 206.225 89.59 206.325C89.6 206.325 89.6 206.325 89.61 206.335C89.62 206.335 89.62 206.345 89.63 206.345L139.87 234.775V285.065L43.67 229.705V60.135ZM244.75 229.705L148.58 285.075V234.775L219.8 194.115L244.75 179.875V229.705ZM297.2 139.625L253.49 164.795V114.995L278.85 100.395L297.21 89.825V139.625H297.2Z"></path>
                </svg>
                <span style="font-weight: 600;">Aura Computers</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNavbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link {{ Request::is('/') ? 'active' : '' }}" href="{{ url('/') }}">Главная</a></li>
                    <li class="nav-item"><a class="nav-link {{ Request::routeIs('catalog.index') ? 'active' : '' }}" href="{{ route('catalog.index') }}">Каталог</a></li>
                </ul>

                <form class="d-flex mx-auto my-2 my-lg-0" role="search" style="width: 100%; max-width: 450px;">
                    <input class="form-control me-2" type="search" placeholder="Поиск товаров..." aria-label="Search">
                    <button class="btn btn-outline-primary flex-shrink-0" type="submit"><i class="bi bi-search"></i></button>
                </form>

                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item dropdown me-2">
                        <a class="nav-link dropdown-toggle btn-action-icon" href="#" role="button" data-bs-toggle="dropdown" title="Выбрать язык"><i class="bi bi-globe2"></i></a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            @php $currentLocale = session('locale', config('app.locale')); @endphp
                            <li><a class="dropdown-item d-flex align-items-center {{ $currentLocale == 'tm' ? 'active' : '' }}" href="{{ route('locale.switch', 'tm') }}"><img src="https://www.ynamdar.com/static/tm.png" alt="TM" class="lang-flag me-2">Türkmen</a></li>
                            <li><a class="dropdown-item d-flex align-items-center {{ $currentLocale == 'ru' ? 'active' : '' }}" href="{{ route('locale.switch', 'ru') }}"><img src="https://www.ynamdar.com/static/ru.png" alt="RU" class="lang-flag me-2">Русский</a></li>
                            <li><a class="dropdown-item d-flex align-items-center {{ $currentLocale == 'en' ? 'active' : '' }}" href="{{ route('locale.switch', 'en') }}"><img src="https://www.ynamdar.com/static/en.png" alt="EN" class="lang-flag me-2">English</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('favorites.index') }}" class="btn btn-outline-secondary btn-action-icon position-relative" title="Избранное">
                            <i class="bi bi-heart"></i>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning text-dark action-icon-badge" id="favoritesCountBadge">@auth{{ Auth::user()->favorites()->count() }}@else 0 @endauth</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('compare.index') }}" class="btn btn-outline-secondary btn-action-icon position-relative ms-2" title="Сравнение">
                            <i class="bi bi-arrow-left-right"></i>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-info text-dark action-icon-badge" id="compareCountBadge">{{ count(session('compare.products', [])) }}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <button class="btn btn-primary btn-action-icon position-relative ms-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#shoppingCartOffcanvas" title="Корзина">
                            <i class="bi bi-cart3"></i>
                        </button>
                    </li>
                    <li class="nav-item ms-lg-3 ms-2">
                        <button id="themeToggleButton" class="btn btn-outline-secondary btn-action-icon" type="button" title="Сменить тему"><i class="bi bi-sun-fill theme-icon-sun"></i><i class="bi bi-moon-stars-fill theme-icon-moon d-none"></i></button>
                    </li>
                    @guest
                    <li class="nav-item dropdown ms-lg-3 ms-2">
                        <a class="nav-link dropdown-toggle btn btn-outline-secondary" href="#" role="button" data-bs-toggle="dropdown"><i class="bi bi-person"></i></a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('login') }}">Вход</a></li>
                            @if (Route::has('register'))<li><a class="dropdown-item" href="{{ route('register') }}">Регистрация</a></li>@endif
                        </ul>
                    </li>
                    @else
                    <li class="nav-item dropdown ms-lg-3 ms-2">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">{{ Auth::user()->name }}</a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Профиль</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">@csrf<a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">Выход</a></form>
                            </li>
                        </ul>
                    </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main class="content-wrapper">
        @yield('content')
    </main>

    <footer class="py-4 mt-auto text-center text-muted small" style="border-top: 1px solid var(--bs-border-color-translucent);">
        © {{ date('Y') }} Aura Computers. Все права защищены.
    </footer>

    <!-- ПАНЕЛЬ СРАВНЕНИЯ -->
    <div class="compare-bar" id="compareBar">
        <div class="compare-bar__icon">
            <svg viewBox="0 0 316 316" xmlns="http://www.w3.org/2000/svg">
                <path fill="currentColor" d="M305.8 81.125C305.77 80.995 305.69 80.885 305.65 80.755C305.56 80.525 305.49 80.285 305.37 80.075C305.29 79.935 305.17 79.815 305.07 79.685C304.94 79.515 304.83 79.325 304.68 79.175C304.55 79.045 304.39 78.955 304.25 78.845C304.09 78.715 303.95 78.575 303.77 78.475L251.32 48.275C249.97 47.495 248.31 47.495 246.96 48.275L194.51 78.475C194.33 78.575 194.19 78.725 194.03 78.845C193.89 78.955 193.73 79.045 193.6 79.175C193.45 79.325 193.34 79.515 193.21 79.685C193.11 79.815 192.99 79.935 192.91 80.075C192.79 80.285 192.71 80.525 192.63 80.755C192.58 80.875 192.51 80.995 192.48 81.125C192.38 81.495 192.33 81.875 192.33 82.265V139.625L148.62 164.795V52.575C148.62 52.185 148.57 51.805 148.47 51.435C148.44 51.305 148.36 51.195 148.32 51.065C148.23 50.835 148.16 50.595 148.04 50.385C147.96 50.245 147.84 50.125 147.74 49.995C147.61 49.825 147.5 49.635 147.35 49.485C147.22 49.355 147.06 49.265 146.92 49.155C146.76 49.025 146.62 48.885 146.44 48.785L93.99 18.585C92.64 17.805 90.98 17.805 89.63 18.585L37.18 48.785C37 48.885 36.86 49.035 36.7 49.155C36.56 49.265 36.4 49.355 36.27 49.485C36.12 49.635 36.01 49.825 35.88 49.995C35.78 50.125 35.66 50.245 35.58 50.385C35.46 50.595 35.38 50.835 35.3 51.065C35.25 51.185 35.18 51.305 35.15 51.435C35.05 51.805 35 52.185 35 52.575V232.235C35 233.795 35.84 235.245 37.19 236.025L142.1 296.425C142.33 296.555 142.58 296.635 142.82 296.725C142.93 296.765 143.04 296.835 143.16 296.865C143.53 296.965 143.9 297.015 144.28 297.015C144.66 297.015 145.03 296.965 145.4 296.865C145.5 296.835 145.59 296.775 145.69 296.745C145.95 296.655 146.21 296.565 146.45 296.435L251.36 236.035C252.72 235.255 253.55 233.815 253.55 232.245V174.885L303.81 145.945C305.17 145.165 306 143.725 306 142.155V82.265C305.95 81.875 305.89 81.495 305.8 81.125ZM144.2 227.205L100.57 202.515L146.39 176.135L196.66 147.195L240.33 172.335L208.29 190.625L144.2 227.205ZM244.75 114.995V164.795L226.39 154.225L201.03 139.625V89.825L219.39 100.395L244.75 114.995ZM249.12 57.105L292.81 82.265L249.12 107.425L205.43 82.265L249.12 57.105ZM114.49 184.425L96.13 194.995V85.305L121.49 70.705L139.85 60.135V169.815L114.49 184.425ZM91.76 27.425L135.45 52.585L91.76 77.745L48.07 52.585L91.76 27.425ZM43.67 60.135L62.03 70.705L87.39 85.305V202.545V202.555V202.565C87.39 202.735 87.44 202.895 87.46 203.055C87.49 203.265 87.49 203.485 87.55 203.695V203.705C87.6 203.875 87.69 204.035 87.76 204.195C87.84 204.375 87.89 204.575 87.99 204.745C87.99 204.745 87.99 204.755 88 204.755C88.09 204.905 88.22 205.035 88.33 205.175C88.45 205.335 88.55 205.495 88.69 205.635L88.7 205.645C88.82 205.765 88.98 205.855 89.12 205.965C89.28 206.085 89.42 206.225 89.59 206.325C89.6 206.325 89.6 206.325 89.61 206.335C89.62 206.335 89.62 206.345 89.63 206.345L139.87 234.775V285.065L43.67 229.705V60.135ZM244.75 229.705L148.58 285.075V234.775L219.8 194.115L244.75 179.875V229.705ZM297.2 139.625L253.49 164.795V114.995L278.85 100.395L297.21 89.825V139.625H297.2Z"></path>
            </svg>
        </div>
        <div class="compare-bar__info">
            <p class="compare-bar__text">Добавьте товары для сравнения.</p>
            <div class="compare-bar__items" id="compareItemsContainer"></div>
        </div>
        <div class="compare-bar__actions">
            <a href="{{ route('compare.index') }}" class="btn btn-primary" id="compareBarButton">Сравнить</a>
            <button class="compare-bar__close" id="closeCompareBar" aria-label="Закрыть">×</button>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // СКРИПТ ПЕРЕКЛЮЧЕНИЯ ТЕМЫ
            const themeToggleButton = document.getElementById('themeToggleButton');
            if (themeToggleButton) {
                const htmlElement = document.documentElement;
                const sunIcon = themeToggleButton.querySelector('.theme-icon-sun');
                const moonIcon = themeToggleButton.querySelector('.theme-icon-moon');
                const getPreferredTheme = () => localStorage.getItem('theme') || (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
                const setTheme = (theme) => {
                    htmlElement.setAttribute('data-bs-theme', theme);
                    sunIcon.classList.toggle('d-none', theme === 'dark');
                    moonIcon.classList.toggle('d-none', theme !== 'dark');
                    localStorage.setItem('theme', theme);
                };
                setTheme(getPreferredTheme());
                themeToggleButton.addEventListener('click', () => setTheme(htmlElement.getAttribute('data-bs-theme') === 'light' ? 'dark' : 'light'));
            }

            // СКРИПТ ДЛЯ СРАВНЕНИЯ
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const compareBar = document.getElementById('compareBar');
            if (!compareBar) return;

            const compareItemsContainer = document.getElementById('compareItemsContainer');
            const compareCountBadge = document.getElementById('compareCountBadge');
            const compareBarButton = document.getElementById('compareBarButton');
            const compareBarText = document.querySelector('.compare-bar__text');

            async function fetchApi(url, method = 'POST') {
                try {
                    const response = await fetch(url, {
                        method: method,
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        }
                    });
                    const data = await response.json();
                    if (!response.ok) throw new Error(data.message || 'Ошибка сервера');
                    return data;
                } catch (error) {
                    console.error('Ошибка API:', error);
                    throw error;
                }
            }

            function updateCompareUI(data) {
                const count = data.count || 0;
                const items = data.items || [];

                if (compareCountBadge) compareCountBadge.textContent = count;
                updateCompareBar(items, count);
                const itemIds = items.map(item => item.id.toString());
                document.querySelectorAll('.compare-checkbox').forEach(cb => {
                    cb.checked = itemIds.includes(cb.value);
                });
            }

            function updateCompareBar(items, count) {
                if (count === 0) {
                    compareBar.classList.remove('show');
                    return;
                }
                compareBarButton.style.display = count > 1 ? 'inline-block' : 'none';
                compareBarText.textContent = `Выбрано ${count} из 4 товаров для сравнения.`;
                compareItemsContainer.innerHTML = '';
                items.forEach(item => {
                    const itemHtml = `<div class="compare-bar__item"><img src="${item.thumbnail_url || 'https://placehold.co/60x60?text=Aura'}" alt="${item.name}" title="${item.name}"><button class="compare-bar__item-remove" data-product-id="${item.id}" title="Убрать">×</button></div>`;
                    compareItemsContainer.insertAdjacentHTML('beforeend', itemHtml);
                });
                compareBar.classList.add('show');
            }

            document.body.addEventListener('change', async function(event) {
                if (!event.target.matches('.compare-checkbox')) return;
                const checkbox = event.target;
                const productId = checkbox.value;
                try {
                    const data = await fetchApi(`/compare/toggle/${productId}`);
                    updateCompareUI(data);
                } catch (error) {
                    checkbox.checked = !checkbox.checked;
                    alert(error.message);
                }
            });

            compareBar.addEventListener('click', async function(event) {
                const target = event.target;
                if (target.matches('.compare-bar__item-remove')) {
                    const data = await fetchApi(`/compare/toggle/${target.dataset.productId}`);
                    updateCompareUI(data);
                }
                if (target.matches('#closeCompareBar')) {
                    compareBar.classList.remove('show');
                }
            });

            const initialCompareData = {
                !!json_encode(app(\App\ Http\ Controllers\ CompareController::class) - > getCompareDataForJS()) !!
            };
            if (initialCompareData && initialCompareData.success) {
                updateCompareUI(initialCompareData);
            }
        });
    </script>
</body>

</html>