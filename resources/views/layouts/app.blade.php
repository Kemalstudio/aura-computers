<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Aura Computers')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="shortcut icon" href="/images/logo/logo.svg" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/css/flag-icon.min.css" />
    <link href="https://fonts.bunny.net/css?family=nunito:400,500,600,700&display=swap" rel="stylesheet" />

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
            background-color: var(--bs-body-bg);
            color: var(--bs-body-color);
        }

        .content-wrapper {
            flex: 1;
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

        .theme-icon-sun,
        .theme-icon-moon {
            transition: opacity 0.3s ease;
        }

        .compare-bar {
            position: fixed;
            bottom: -120px;
            left: 0;
            width: 100%;
            background-color: var(--bs-tertiary-bg);
            border-top: 1px solid var(--bs-border-color);
            z-index: 1050;
            transition: bottom 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            padding: 1rem 0;
            box-shadow: 0 -5px 20px rgba(0, 0, 0, 0.1);
        }

        .compare-bar.show {
            bottom: 0;
        }

        .compare-bar-item {
            position: relative;
            background-color: var(--bs-body-bg);
            border: 1px solid var(--bs-border-color);
            border-radius: .5rem;
            width: 80px;
            height: 80px;
            padding: .25rem;
            transition: transform .2s ease;
        }

        .compare-bar-item:hover {
            transform: scale(1.05);
            z-index: 10;
        }

        .compare-bar-item img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .compare-bar-item-remove {
            position: absolute;
            top: 0;
            right: 0;
            transform: translate(50%, -50%);
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background-color: var(--bs-danger);
            color: white;
            border: 2px solid var(--bs-tertiary-bg);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            line-height: 1;
            cursor: pointer;
            z-index: 5;
            transition: background-color .2s ease;
        }

        .compare-bar-placeholder {
            width: 80px;
            height: 80px;
            border: 2px dashed var(--bs-border-color);
            border-radius: .5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--bs-secondary-color);
        }

        .dropdown-item .flag-icon {
            font-size: 1rem;
            box-shadow: 0 0 2px rgba(0, 0, 0, 0.2);
        }

        .scroll-to-top {
            position: fixed;
            bottom: 1.5rem;
            right: 1.5rem;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: #0d6efd;
            color: #fff;
            border: 1px solid var(--bs-border-color);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            text-decoration: none;
            z-index: 1040;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease, visibility 0.3s ease, transform 0.3s ease, background-color 0.2s ease;
            transform: translateY(20px);
        }

        .scroll-to-top.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .scroll-to-top:hover {
            color: var(--bs-primary);
            background-color: var(--bs-secondary-bg);
            transform: scale(1.1) translateY(0);
        }
    </style>
    @stack('styles')
</head>

<body>
    <header class="sticky-top">
        <nav class="navbar navbar-expand-lg bg-body-tertiary border-bottom shadow-sm">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                    <svg viewBox="0 0 316 316" xmlns="http://www.w3.org/2000/svg" class="navbar-brand-logo me-2">
                        <path fill="currentColor" d="M305.8 81.125C305.77 80.995 305.69 80.885 305.65 80.755C305.56 80.525 305.49 80.285 305.37 80.075C305.29 79.935 305.17 79.815 305.07 79.685C304.94 79.515 304.83 79.325 304.68 79.175C304.55 79.045 304.39 78.955 304.25 78.845C304.09 78.715 303.95 78.575 303.77 78.475L251.32 48.275C249.97 47.495 248.31 47.495 246.96 48.275L194.51 78.475C194.33 78.575 194.19 78.725 194.03 78.845C193.89 78.955 193.73 79.045 193.6 79.175C193.45 79.325 193.34 79.515 193.21 79.685C193.11 79.815 192.99 79.935 192.91 80.075C192.79 80.285 192.71 80.525 192.63 80.755C192.58 80.875 192.51 80.995 192.48 81.125C192.38 81.495 192.33 81.875 192.33 82.265V139.625L148.62 164.795V52.575C148.62 52.185 148.57 51.805 148.47 51.435C148.44 51.305 148.36 51.195 148.32 51.065C148.23 50.835 148.16 50.595 148.04 50.385C147.96 50.245 147.84 50.125 147.74 49.995C147.61 49.825 147.5 49.635 147.35 49.485C147.22 49.355 147.06 49.265 146.92 49.155C146.76 49.025 146.62 48.885 146.44 48.785L93.99 18.585C92.64 17.805 90.98 17.805 89.63 18.585L37.18 48.785C37 48.885 36.86 49.035 36.7 49.155C36.56 49.265 36.4 49.355 36.27 49.485C36.12 49.635 36.01 49.825 35.88 49.995C35.78 50.125 35.66 50.245 35.58 50.385C35.46 50.595 35.38 50.835 35.3 51.065C35.25 51.185 35.18 51.305 35.15 51.435C35.05 51.805 35 52.185 35 52.575V232.235C35 233.795 35.84 235.245 37.19 236.025L142.1 296.425C142.33 296.555 142.58 296.635 142.82 296.725C142.93 296.765 143.04 296.835 143.16 296.865C143.53 296.965 143.9 297.015 144.28 297.015C144.66 297.015 145.03 296.965 145.4 296.865C145.5 296.835 145.59 296.775 145.69 296.745C145.95 296.655 146.21 296.565 146.45 296.435L251.36 236.035C252.72 235.255 253.55 233.815 253.55 232.245V174.885L303.81 145.945C305.17 145.165 306 143.725 306 142.155V82.265C305.95 81.875 305.89 81.495 305.8 81.125ZM144.2 227.205L100.57 202.515L146.39 176.135L196.66 147.195L240.33 172.335L208.29 190.625L144.2 227.205ZM244.75 114.995V164.795L226.39 154.225L201.03 139.625V89.825L219.39 100.395L244.75 114.995ZM249.12 57.105L292.81 82.265L249.12 107.425L205.43 82.265L249.12 57.105ZM114.49 184.425L96.13 194.995V85.305L121.49 70.705L139.85 60.135V169.815L114.49 184.425ZM91.76 27.425L135.45 52.585L91.76 77.745L48.07 52.585L91.76 27.425ZM43.67 60.135L62.03 70.705L87.39 85.305V202.545V202.555V202.565C87.39 202.735 87.44 202.895 87.46 203.055C87.49 203.265 87.49 203.485 87.55 203.695V203.705C87.6 203.875 87.69 204.035 87.76 204.195C87.84 204.375 87.89 204.575 87.99 204.745C87.99 204.745 87.99 204.755 88 204.755C88.09 204.905 88.22 205.035 88.33 205.175C88.45 205.335 88.55 205.495 88.69 205.635L88.7 205.645C88.82 205.765 88.98 205.855 89.12 205.965C89.28 206.085 89.42 206.225 89.59 206.325C89.6 206.325 89.6 206.325 89.61 206.335C89.62 206.335 89.62 206.345 89.63 206.345L139.87 234.775V285.065L43.67 229.705V60.135ZM244.75 229.705L148.58 285.075V234.775L219.8 194.115L244.75 179.875V229.705ZM297.2 139.625L253.49 164.795V114.995L278.85 100.395L297.21 89.825V139.625H297.2Z"></path>
                    </svg>
                    <span style="font-weight: 600;">Aura Computers</span>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbarNav"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="mainNavbarNav">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Главная</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('catalog.index') }}">Каталог</a></li>
                    </ul>

                    <form class="d-flex w-50 mx-auto" action="{{-- route('search') --}}" method="GET" role="search">
                        <input class="form-control me-2" type="search" name="query" placeholder="Поиск по сайту..." aria-label="Search">
                        <button class="btn btn-outline-primary" type="submit">Найти</button>
                    </form>

                    <ul class="navbar-nav ms-auto align-items-center">
                        <li class="nav-item">
                            <a href="{{ route('favorites.index') }}" class="btn btn-outline-secondary btn-action-icon position-relative" title="Избранное">
                                <i class="bi bi-heart"></i>
                                <span id="favoritesCountBadge" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger action-icon-badge">{{ auth()->user()?->favorites()->count() ?? 0 }}</span>
                            </a>
                        </li>
                        <li class="nav-item ms-2">
                            <a href="{{ route('compare.index') }}" class="btn btn-outline-secondary btn-action-icon position-relative" title="Сравнение">
                                <i class="bi bi-bar-chart-line"></i>
                                <span id="compareCountBadge" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-info text-dark action-icon-badge">{{ auth()->user()?->compares()->count() ?? 0 }}</span>
                            </a>
                        </li>
                        <li class="nav-item ms-2">
                            <button class="btn btn-primary btn-action-icon position-relative" type="button" title="Корзина"><i class="bi bi-cart3"></i></button>
                        </li>

                        <li class="nav-item dropdown ms-lg-3 ms-2">
                            <a class="btn btn-outline-secondary btn-action-icon" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" title="Выбрать язык">
                                <i class="bi bi-globe"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item d-flex align-items-center @if(app()->getLocale() == 'tk') active @endif" href="{{-- route('language.switch', 'tk') --}}">
                                        <span class="flag-icon flag-icon-tm me-2"></span>
                                        Türkmençe
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item d-flex align-items-center @if(app()->getLocale() == 'ru') active @endif" href="{{-- route('language.switch', 'ru') --}}">
                                        <span class="flag-icon flag-icon-ru me-2"></span>
                                        Русский
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item d-flex align-items-center @if(app()->getLocale() == 'en') active @endif" href="{{-- route('language.switch', 'en') --}}">
                                        <span class="flag-icon flag-icon-gb me-2"></span>
                                        English
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item ms-lg-3 ms-2">
                            <button id="themeToggleButton" class="btn btn-outline-secondary btn-action-icon" type="button" title="Сменить тему">
                                <i class="bi bi-sun-fill theme-icon-sun"></i>
                                <i class="bi bi-moon-stars-fill theme-icon-moon d-none"></i>
                            </button>
                        </li>
                        @guest
                        <li class="nav-item dropdown ms-lg-3 ms-2">
                            <a class="nav-link dropdown-toggle btn btn-outline-secondary" href="#" role="button" data-bs-toggle="dropdown"><i class="bi bi-person"></i></a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="{{ route('login') }}">Вход</a></li>
                                @if (Route::has('register'))<li><a class="dropdown-item" href="{{ route('register') }}">Регистрация</a></li>@endif
                            </ul>
                        </li>
                        @else
                        <li class="nav-item dropdown ms-lg-3 ms-2">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">{{ Auth::user()->name }}</a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="{{ route('profile.edit') }}">Профиль</a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">@csrf<a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();this.closest('form').submit();">Выход</a></form>
                                </li>
                            </ul>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main class="content-wrapper py-4">
        @yield('content')
    </main>

    <div class="compare-bar shadow-lg" id="compareBar">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-3">
                    <h5 class="mb-1">Сравнение товаров</h5>
                    <small class="text-body-secondary" id="compareBarText">Добавьте до 4 товаров</small>
                </div>
                <div class="col-lg-6">
                    <div id="compareItemsContainer" class="d-flex justify-content-center align-items-center gap-3"></div>
                </div>
                <div class="col-lg-3">
                    <div class="d-flex justify-content-end align-items-center gap-2">
                        <button class="btn btn-sm btn-outline-danger d-none" id="clearCompareBtn">Очистить все</button><a href="{{ route('compare.index') }}" class="btn btn-primary d-none" id="compareBarButton">Сравнить</a><button class="btn-close" id="closeCompareBar" aria-label="Закрыть"></button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="mt-auto bg-body-tertiary border-top py-5">
        <div class="container text-center">
            <p class="text-muted mb-0">© {{ date('Y') }} Aura Computers. Все права защищены.</p>
        </div>
    </footer>

    <a href="#" id="scrollTopBtn" class="scroll-to-top" title="Вернуться наверх">
    <i class="bi bi-arrow-up"></i>
    </a>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            document.body.addEventListener('click', handleActions);
            document.body.addEventListener('change', handleActions);

            function handleActions(event) {
                const favoriteButton = event.target.closest('.product-action-favorite');
                if (favoriteButton && event.type === 'click') {
                    event.preventDefault();
                    toggleFavorite(favoriteButton);
                    return;
                }
                const removeCompareButton = event.target.closest('.compare-bar-item-remove');
                if (removeCompareButton && event.type === 'click') {
                    event.preventDefault();
                    removeCompareItem(removeCompareButton);
                    return;
                }
                if (event.target.matches('.compare-checkbox') && event.type === 'change') {
                    toggleCompare(event.target);
                }
                const clearCompareBtn = event.target.closest('#clearCompareBtn');
                if (clearCompareBtn && event.type === 'click') {
                    clearCompareList();
                }
                const closeCompareBarBtn = event.target.closest('#closeCompareBar');
                if (closeCompareBarBtn && event.type === 'click') {
                    document.getElementById('compareBar').classList.remove('show');
                }
            }
            async function toggleFavorite(button) {
                @guest
                alert('Для добавления в избранное необходимо войти в систему.');
                return;
                @endguest
                const productId = button.dataset.productId;
                if (!productId) return;
                button.disabled = true;
                try {
                    const data = await apiRequest(`/favorites/toggle/${productId}`);
                    if (data.success) {
                        button.classList.toggle('is-favorite');
                        document.getElementById('favoritesCountBadge').textContent = data.count;
                    }
                } catch (error) {
                    console.error('Ошибка:', error);
                    alert('Произошла ошибка.');
                } finally {
                    button.disabled = false;
                }
            }
            async function toggleCompare(checkbox) {
                @guest
                checkbox.checked = !checkbox.checked;
                alert('Для сравнения товаров необходимо войти в систему.');
                return;
                @endguest
                try {
                    const data = await apiRequest(`/compare/toggle/${checkbox.value}`);
                    updateCompareUI(data);
                } catch (error) {
                    alert(error.message);
                    checkbox.checked = !checkbox.checked;
                }
            }
            async function removeCompareItem(button) {
                const productId = button.dataset.productId;
                if (!productId) return;
                button.disabled = true;
                try {
                    const data = await apiRequest(`/compare/toggle/${productId}`);
                    updateCompareUI(data);
                } catch (error) {
                    alert(error.message);
                    button.disabled = false;
                }
            }
            async function clearCompareList() {
                try {
                    const data = await apiRequest('/compare/clear');
                    updateCompareUI(data);
                } catch (error) {
                    alert(error.message);
                }
            }
            async function apiRequest(url, method = 'POST') {
                const response = await fetch(url, {
                    method: method,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                });
                const data = await response.json();
                if (!response.ok) throw new Error(data.message || 'Произошла ошибка');
                return data;
            }

            function updateCompareUI(data) {
                const count = data.count || 0;
                document.getElementById('compareCountBadge').textContent = count;
                updateCompareBar(data.items || [], count);
                const itemIds = (data.items || []).map(item => item.id.toString());
                document.querySelectorAll('.compare-checkbox').forEach(cb => {
                    cb.checked = itemIds.includes(cb.value);
                });
            }

            function updateCompareBar(items, count) {
                const compareBar = document.getElementById('compareBar');
                if (!compareBar) return;
                if (count === 0) {
                    compareBar.classList.remove('show');
                    return;
                }
                document.getElementById('compareBarButton').classList.toggle('d-none', count < 2);
                document.getElementById('clearCompareBtn').classList.toggle('d-none', count === 0);
                document.getElementById('compareBarText').textContent = `Выбрано ${count} из 4 товаров`;
                const container = document.getElementById('compareItemsContainer');
                container.innerHTML = '';
                items.forEach(item => {
                    const itemHtml = `<div class="compare-bar-item"><img src="${item.thumbnail_url || '#'}" alt="${item.name}" title="${item.name}"><button class="compare-bar-item-remove" data-product-id="${item.id}" title="Убрать">×</button></div>`;
                    container.insertAdjacentHTML('beforeend', itemHtml);
                });
                for (let i = 0; i < (4 - count); i++) {
                    container.insertAdjacentHTML('beforeend', `<div class="compare-bar-placeholder"><i class="bi bi-plus-lg"></i></div>`);
                }
                compareBar.classList.add('show');
            }
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

            const scrollTopBtn = document.getElementById('scrollTopBtn');
            if (scrollTopBtn) {
                window.addEventListener('scroll', function() {
                    if (window.scrollY > 400) {
                        scrollTopBtn.classList.add('show');
                    } else {
                        scrollTopBtn.classList.remove('show');
                    }
                });
                scrollTopBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                });
            }

            @auth
            const favoriteProductIds = @json(auth() -> user() -> favorites() -> pluck('product_id') -> toArray() ?? []);
            document.querySelectorAll('.product-action-favorite').forEach(button => {
                if (favoriteProductIds.includes(parseInt(button.dataset.productId, 10))) {
                    button.classList.add('is-favorite');
                }
            });
            @if(class_exists('App\\Http\\Controllers\\CompareController'))
            try {
                const initialCompareData = @json(app('App\\Http\\Controllers\\CompareController') -> getCompareDataForJS());
                if (initialCompareData && initialCompareData.success) {
                    updateCompareUI(initialCompareData);
                }
            } catch (e) {
                console.error("Could not initialize compare data:", e);
            }
            @endif
            @endauth
        });
    </script>
</body>

</html>