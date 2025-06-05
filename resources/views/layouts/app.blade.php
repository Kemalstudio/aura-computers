<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Aura Computers')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=nunito:400,500,600,700&display=swap" rel="stylesheet" />

    <style>
        :root {
            --bs-primary-rgb: 59, 130, 246;
            --bs-primary-darker: #2563eb;
            --bs-primary-lighter: #93c5fd;
            --bs-body-font-family: 'Nunito', sans-serif;
        }

        [data-bs-theme="dark"] {
            --bs-primary-rgb: 96, 165, 250;
            --bs-primary-darker: #3b82f6;
            --bs-primary-lighter: #bfdbfe;
            --bs-body-bg: #111827;
            --bs-body-color: #f3f4f6;
            --bs-emphasis-color-rgb: 243, 244, 246;
            --bs-secondary-color-rgb: 156, 163, 175;
            --bs-tertiary-bg-rgb: 31, 41, 55;
            --bs-border-color-translucent: rgba(255, 255, 255, 0.15);
            --bs-light-bg-subtle: #1f2937;
            --bs-dark-bg-subtle: #374151;
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
            width: auto;
            margin-right: 0.5rem;
            color: var(--bs-primary);
        }

        .navbar {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            background-color: var(--bs-tertiary-bg);
            padding-top: 0.75rem;
            padding-bottom: 0.75rem;
        }

        [data-bs-theme="light"] .navbar {
            background-color: var(--bs-white);
        }

        .action-icon-badge {
            font-size: 0.6em;
            padding: 0.2em 0.4em;
            line-height: 1;
        }

        .cart-icon-badge {
            font-size: 0.6em;
            padding: 0.2em 0.4em;
        }

        .navbar .btn-action-icon {
            font-size: 1.1rem;
            padding: 0.375rem 0.6rem;
        }

        .navbar .btn-action-icon .bi {
            vertical-align: -0.1em;
        }

        .lang-flag {
            width: 20px;
            /* Adjust as needed */
            height: 15px;
            /* Adjust as needed */
            object-fit: cover;
            border-radius: 2px;
            /* Optional: slight rounding for flags */
        }

        .dropdown-item.active,
        .dropdown-item:active {
            color: var(--bs-dropdown-link-active-color);
            background-color: var(--bs-dropdown-link-active-bg);
        }

        .navbar-nav .nav-link.active {
            font-weight: 600;
        }


        .offcanvas-header {
            border-bottom: 1px solid var(--bs-border-color-translucent);
            padding: 1rem 1.5rem;
        }

        .offcanvas-title {
            font-weight: 600;
        }

        .cart-item {
            display: flex;
            padding: 1rem 1.5rem;
            border-bottom: 1px solid var(--bs-border-color-translucent);
            gap: 1rem;
            align-items: flex-start;
        }

        .cart-item:last-child {
            border-bottom: none;
        }

        .cart-item-img img {
            width: 70px;
            height: 70px;
            object-fit: cover;
            border-radius: 0.5rem;
            background-color: var(--bs-secondary-bg);
        }

        .cart-item-details {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .cart-item-title {
            font-weight: 600;
            margin-bottom: 0.15rem;
            color: var(--bs-emphasis-color);
            font-size: 0.95rem;
            line-height: 1.3;
        }

        .cart-item-meta {
            font-size: 0.8rem;
            color: var(--bs-secondary-color);
            margin-bottom: 0.5rem;
        }

        .cart-item-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: auto;
        }

        .cart-item-quantity {
            display: flex;
            align-items: center;
        }

        .cart-item-quantity .form-control {
            width: 50px;
            text-align: center;
            font-size: 0.9rem;
            padding-left: 0.25rem;
            padding-right: 0.25rem;
            height: calc(1.5em + .5rem + 2px);
            border-radius: 0.375rem;
        }

        .cart-item-quantity .btn {
            padding: 0.25rem 0.5rem;
            line-height: 1;
        }

        .cart-item-price {
            font-weight: 600;
            font-size: 0.95rem;
            color: var(--bs-emphasis-color);
            white-space: nowrap;
        }

        .remove-item-btn {
            color: var(--bs-danger);
            background: none;
            border: none;
            padding: 0;
            font-size: 1.1rem;
            line-height: 1;
            margin-left: 0.5rem;
        }

        .remove-item-btn:hover {
            color: var(--bs-danger-text-emphasis);
        }

        .cart-footer {
            padding: 1.5rem;
            border-top: 1px solid var(--bs-border-color-translucent);
            background-color: var(--bs-tertiary-bg);
        }

        [data-bs-theme="light"] .cart-footer {
            background-color: var(--bs-light-bg-subtle);
        }

        .cart-summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }

        .cart-summary-row.total {
            font-weight: 600;
            font-size: 1.1rem;
            margin-top: 0.75rem;
            color: var(--bs-emphasis-color);
        }

        .empty-cart-message {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
            padding: 2rem;
            text-align: center;
            color: var(--bs-secondary-color);
        }

        .empty-cart-message i {
            font-size: 4rem;
            margin-bottom: 1rem;
            color: var(--bs-primary);
            opacity: 0.7;
        }

        .empty-cart-message p {
            font-size: 1.1rem;
            margin-bottom: 1.5rem;
        }

        .offcanvas {
            background-color: var(--bs-body-bg);
        }
    </style>
    @stack('styles')
</head>

<body class="font-sans antialiased">
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                <x-application-logo class="navbar-brand-logo" />
                <span style="font-weight: 600;">Aura Computers</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbarNav" aria-controls="mainNavbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNavbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('/') ? 'active' : '' }}" href="{{ url('/') }}">Главная</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::routeIs('catalog.index') ? 'active' : '' }}" href="{{ route('catalog.index') }}">Каталог</a>
                    </li>
                </ul>

                <form class="d-flex mx-auto my-2 my-lg-0" role="search" style="width: 100%; max-width: 450px;">
                    <input class="form-control me-2" type="search" placeholder="Поиск товаров..." aria-label="Search">
                    <button class="btn btn-outline-primary flex-shrink-0" type="submit" aria-label="Найти">
                        <i class="bi bi-search"></i></button>
                </form>

                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item dropdown me-2">
                        <a class="nav-link dropdown-toggle btn-action-icon" href="#" role="button" id="languageDropdown" data-bs-toggle="dropdown" aria-expanded="false" title="Выбрать язык">
                            <i class="bi bi-globe2"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="languageDropdown">

                        <!-- TM -->
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <img src="https://www.ynamdar.com/static/tm.png" alt="TM Flag" class="lang-flag me-2"> Türkmen dili
                                </a>
                            </li>

                            <!-- RU -->
                            <li>
                                <a class="dropdown-item d-flex align-items-center active" href="#">
                                    <img src="https://www.ynamdar.com/static/ru.png" alt="RU Flag" class="lang-flag me-2"> Русский
                                </a>
                            </li>

                            <!-- EN -->
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <img src="https://www.ynamdar.com/static/en.png" alt="US Flag" class="lang-flag me-2"> English
                                </a>
                            </li>

                        </ul>
                    </li>

                    @guest
                    <li class="nav-item">
                        <a class="nav-link {{ Request::routeIs('login') ? 'active' : '' }}" href="{{ route('login') }}">Вход</a>
                    </li>
                    @if (Route::has('register'))
                    <li class="nav-item">
                        <a class="nav-link {{ Request::routeIs('register') ? 'active' : '' }}" href="{{ route('register') }}">Регистрация</a>
                    </li>
                    @endif
                    @else
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownUserMenu" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownUserMenu">
                            <li><a class="dropdown-item" href="#">Профиль</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); this.closest('form').submit();">
                                        Выход
                                    </a>
                                </form>
                            </li>
                        </ul>
                    </li>
                    @endguest

                    <li class="nav-item">
                        <button class="btn btn-outline-secondary btn-action-icon position-relative ms-lg-2 ms-2 mt-2 mt-lg-0" type="button" title="Избранное" aria-label="Избранные товары">
                            <i class="bi bi-heart"></i>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning text-dark action-icon-badge" id="favoritesCountBadge">
                                0
                                <span class="visually-hidden">товаров в избранном</span>
                            </span>
                        </button>
                    </li>

                    <li class="nav-item">
                        <button class="btn btn-outline-secondary btn-action-icon position-relative ms-2 mt-2 mt-lg-0" type="button" title="Сравнение" aria-label="Сравнить товары">
                            <i class="bi bi-arrow-left-right"></i>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-info text-dark action-icon-badge" id="compareCountBadge">
                                0
                                <span class="visually-hidden">товаров в сравнении</span>
                            </span>
                        </button>
                    </li>

                    <li class="nav-item">
                        <button class="btn btn-primary btn-action-icon position-relative ms-2 mt-2 mt-lg-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#shoppingCartOffcanvas" aria-controls="shoppingCartOffcanvas" title="Корзина" aria-label="Открыть корзину">
                            <i class="bi bi-cart3"></i>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger action-icon-badge" id="cartItemCount">
                                3
                                <span class="visually-hidden">товаров в корзине</span>
                            </span>
                        </button>
                    </li>

                    <li class="nav-item ms-lg-3 ms-2 mt-2 mt-lg-0">
                        <button id="themeToggleButton" class="btn btn-outline-secondary btn-action-icon" type="button" aria-label="Toggle theme" title="Сменить тему">
                            <i class="bi bi-sun-fill theme-icon-sun"></i>
                            <i class="bi bi-moon-stars-fill theme-icon-moon d-none"></i>
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="content-wrapper">
        @yield('content')
    </main>

    <footer class="py-4 mt-auto text-center text-muted small" style="background-color: var(--bs-tertiary-bg);">
        © {{ date('Y') }} Aura Computers. Все права защищены.
    </footer>

    <div class="offcanvas offcanvas-end" tabindex="-1" id="shoppingCartOffcanvas" aria-labelledby="shoppingCartOffcanvasLabel" style="width: 100%; max-width: 490px;">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="shoppingCartOffcanvasLabel">Корзина</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body p-0 d-flex flex-column">
            <div id="cartItemsContainer" class="flex-grow-1 overflow-auto">
                <div class="cart-item">
                    <div class="cart-item-img">
                        <img src="https://via.placeholder.com/140/777/FFF?text=PC" alt="Игровой ПК 'Феникс'">
                    </div>
                    <div class="cart-item-details">
                        <h6 class="cart-item-title">Игровой ПК "Феникс"</h6>
                        <small class="cart-item-meta">Артикул: PC-FNX-001</small>
                        <div class="cart-item-actions">
                            <div class="cart-item-quantity">
                                <button class="btn btn-sm btn-outline-secondary" type="button"><i class="bi bi-dash"></i></button>
                                <input type="number" class="form-control form-control-sm mx-2" value="1" min="1" readonly>
                                <button class="btn btn-sm btn-outline-secondary" type="button"><i class="bi bi-plus"></i></button>
                            </div>
                            <span class="cart-item-price">95000 TMT</span>
                        </div>
                    </div>
                    <button class="remove-item-btn" title="Удалить товар"><i class="bi bi-x-lg"></i></button>
                </div>
                <div class="cart-item">
                    <div class="cart-item-img">
                        <img src="https://via.placeholder.com/140/888/FFF?text=Monitor" alt="Монитор 'Кристалл' 27">
                    </div>
                    <div class="cart-item-details">
                        <h6 class="cart-item-title">Монитор "Кристалл" 27"</h6>
                        <small class="cart-item-meta">Артикул: MON-CRY-27</small>
                        <div class="cart-item-actions">
                            <div class="cart-item-quantity">
                                <button class="btn btn-sm btn-outline-secondary" type="button"><i class="bi bi-dash"></i></button>
                                <input type="number" class="form-control form-control-sm mx-2" value="1" min="1" readonly>
                                <button class="btn btn-sm btn-outline-secondary" type="button"><i class="bi bi-plus"></i></button>
                            </div>
                            <span class="cart-item-price">23000 TMT</span>
                        </div>
                    </div>
                    <button class="remove-item-btn" title="Удалить товар"><i class="bi bi-x-lg"></i></button>
                </div>
                <div class="cart-item">
                    <div class="cart-item-img">
                        <img src="https://via.placeholder.com/140/999/FFF?text=Keyboard" alt="Клавиатура 'Гром'">
                    </div>
                    <div class="cart-item-details">
                        <h6 class="cart-item-title">Механическая клавиатура "Гром"</h6>
                        <small class="cart-item-meta">Артикул: KEY-GRM-RGB</small>
                        <div class="cart-item-actions">
                            <div class="cart-item-quantity">
                                <button class="btn btn-sm btn-outline-secondary" type="button"><i class="bi bi-dash"></i></button>
                                <input type="number" class="form-control form-control-sm mx-2" value="2" min="1" readonly>
                                <button class="btn btn-sm btn-outline-secondary" type="button"><i class="bi bi-plus"></i></button>
                            </div>
                            <span class="cart-item-price">7500 TMT</span>
                        </div>
                    </div>
                    <button class="remove-item-btn" title="Удалить товар"><i class="bi bi-x-lg"></i></button>
                </div>
                <div id="emptyCartPlaceholder" class="empty-cart-message d-none">
                    <i class="bi bi-cart-x"></i>
                    <p>Ваша корзина пуста.</p>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="offcanvas">Начать покупки</button>
                </div>
            </div>

            <div class="cart-footer">
                <div class="cart-summary-row">
                    <span>Сумма:</span>
                    <span id="cartSubtotal">133000 TMT</span>
                </div>
                <div class="cart-summary-row">
                    <span>Скидка:</span>
                    <span id="cartDiscount" class="text-success">-0 TMT</span>
                </div>
                <div class="cart-summary-row">
                    <span>Доставка:</span>
                    <span>5 TMT</span>
                </div>
                <hr class="my-2">
                <div class="cart-summary-row total">
                    <span>Итого:</span>
                    <span id="cartTotal">133000 TMT</span>
                </div>
                <div class="d-grid gap-2 mt-3">
                    <a href="#" class="btn btn-primary btn-lg">Оформить заказ</a>
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">Продолжить покупки</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const themeToggleButton = document.getElementById('themeToggleButton');
            const htmlElement = document.documentElement;
            const sunIcon = themeToggleButton.querySelector('.theme-icon-sun');
            const moonIcon = themeToggleButton.querySelector('.theme-icon-moon');

            const getPreferredTheme = () => {
                const storedTheme = localStorage.getItem('theme');
                if (storedTheme) {
                    return storedTheme;
                }
                return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
            };

            const setTheme = (theme) => {
                if (theme === 'dark') {
                    htmlElement.setAttribute('data-bs-theme', 'dark');
                    sunIcon.classList.add('d-none');
                    moonIcon.classList.remove('d-none');
                } else {
                    htmlElement.setAttribute('data-bs-theme', 'light');
                    sunIcon.classList.remove('d-none');
                    moonIcon.classList.add('d-none');
                }
                localStorage.setItem('theme', theme);
            };

            setTheme(getPreferredTheme());

            themeToggleButton.addEventListener('click', () => {
                const currentTheme = htmlElement.getAttribute('data-bs-theme');
                setTheme(currentTheme === 'light' ? 'dark' : 'light');
            });

            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
                if (!localStorage.getItem('theme')) {
                    setTheme(getPreferredTheme());
                }
            });
        });
    </script>
    @stack('scripts')

</body>

</html>