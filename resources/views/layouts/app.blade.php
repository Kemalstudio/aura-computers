<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Aura Computers')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="shortcut icon" href="/public/images/logo/logo.svg" type="image/x-icon">
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

        .offcanvas {
            background-color: var(--bs-body-bg);
            border-left: 1px solid var(--bs-border-color);
            box-shadow: -10px 0 30px rgba(0, 0, 0, 0.2);
        }

        .offcanvas-header {
            background-color: var(--bs-tertiary-bg);
            border-bottom: 1px solid var(--bs-border-color-translucent);
            padding: 1rem 1.5rem;
        }

        .offcanvas-title {
            font-weight: 600;
        }

        .offcanvas-body {
            padding: 0;
            display: flex;
            flex-direction: column;
        }

        .cart-list {
            flex-grow: 1;
            overflow-y: auto;
            padding: 0.5rem;
        }

        .cart-item {
            display: flex;
            gap: 1rem;
            padding: 1rem;
            background-color: var(--bs-tertiary-bg);
            border: 1px solid var(--bs-border-color-translucent);
            border-radius: 0.75rem;
            margin-bottom: 0.75rem;
            transition: all 0.3s ease-in-out;
            opacity: 1;
            transform: translateX(0);
        }

        .cart-item.removing {
            opacity: 0;
            transform: translateX(100%);
            padding-top: 0;
            padding-bottom: 0;
            margin-bottom: 0;
            height: 0;
            border-width: 0;
        }

        .cart-item-img {
            width: 60px;
            height: 60px;
            object-fit: contain;
            background-color: var(--bs-body-bg);
            border-radius: .5rem;
            flex-shrink: 0;
            padding: 0.25rem;
        }

        .cart-item-details {
            flex-grow: 1;
        }

        .cart-item-title {
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 0.25rem;
            line-height: 1.3;
        }

        .cart-item-price {
            font-weight: 700;
            color: var(--bs-primary);
        }

        .quantity-control {
            display: flex;
            align-items: center;
            background-color: #00000022;
            border-radius: 50rem;
            overflow: hidden;
            border: 1px solid var(--bs-border-color);
        }

        .quantity-btn {
            background-color: transparent;
            border: none;
            color: var(--bs-body-color);
            font-size: 1rem;
            font-weight: bold;
            line-height: 1;
            width: 30px;
            height: 30px;
            transition: background-color .2s ease;
        }

        .quantity-btn:hover {
            background-color: rgba(var(--bs-primary-rgb), 0.2);
        }

        .quantity-input {
            width: 35px;
            text-align: center;
            background-color: transparent;
            border: none;
            color: var(--bs-body-color);
            font-weight: 500;
        }

        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .cart-item-remove-btn {
            font-size: 1.5rem;
            opacity: 0.5;
            transition: all .2s ease;
            color: var(--bs-danger);
        }

        .cart-item-remove-btn:hover {
            opacity: 1;
            transform: scale(1.1);
        }

        .cart-footer {
            padding: 1.5rem;
            background-color: var(--bs-tertiary-bg);
            border-top: 1px solid var(--bs-border-color);
            box-shadow: 0 -5px 15px rgba(0, 0, 0, 0.1);
        }

        .empty-cart-message {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
            text-align: center;
            padding: 2rem;
            color: var(--bs-secondary-color);
        }

        .empty-cart-message .bi {
            font-size: 4rem;
            margin-bottom: 1rem;
        }
    </style>
    @stack('styles')
</head>

<body>
    <header class="sticky-top">
        <nav class="navbar navbar-expand-lg bg-body-tertiary border-bottom shadow-sm">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}"><svg viewBox="0 0 316 316" xmlns="http://www.w3.org/2000/svg" class="navbar-brand-logo me-2">
                        <path fill="currentColor" d="M305.8 81.125C305.77 80.995 305.69 80.885 305.65 80.755C305.56 80.525 305.49 80.285 305.37 80.075C305.29 79.935 305.17 79.815 305.07 79.685C304.94 79.515 304.83 79.325 304.68 79.175C304.55 79.045 304.39 78.955 304.25 78.845C304.09 78.715 303.95 78.575 303.77 78.475L251.32 48.275C249.97 47.495 248.31 47.495 246.96 48.275L194.51 78.475C194.33 78.575 194.19 78.725 194.03 78.845C193.89 78.955 193.73 79.045 193.6 79.175C193.45 79.325 193.34 79.515 193.21 79.685C193.11 79.815 192.99 79.935 192.91 80.075C192.79 80.285 192.71 80.525 192.63 80.755C192.58 80.875 192.51 80.995 192.48 81.125C192.38 81.495 192.33 81.875 192.33 82.265V139.625L148.62 164.795V52.575C148.62 52.185 148.57 51.805 148.47 51.435C148.44 51.305 148.36 51.195 148.32 51.065C148.23 50.835 148.16 50.595 148.04 50.385C147.96 50.245 147.84 50.125 147.74 49.995C147.61 49.825 147.5 49.635 147.35 49.485C147.22 49.355 147.06 49.265 146.92 49.155C146.76 49.025 146.62 48.885 146.44 48.785L93.99 18.585C92.64 17.805 90.98 17.805 89.63 18.585L37.18 48.785C37 48.885 36.86 49.035 36.7 49.155C36.56 49.265 36.4 49.355 36.27 49.485C36.12 49.635 36.01 49.825 35.88 49.995C35.78 50.125 35.66 50.245 35.58 50.385C35.46 50.595 35.38 50.835 35.3 51.065C35.25 51.185 35.18 51.305 35.15 51.435C35.05 51.805 35 52.185 35 52.575V232.235C35 233.795 35.84 235.245 37.19 236.025L142.1 296.425C142.33 296.555 142.58 296.635 142.82 296.725C142.93 296.765 143.04 296.835 143.16 296.865C143.53 296.965 143.9 297.015 144.28 297.015C144.66 297.015 145.03 296.965 145.4 296.865C145.5 296.835 145.59 296.775 145.69 296.745C145.95 296.655 146.21 296.565 146.45 296.435L251.36 236.035C252.72 235.255 253.55 233.815 253.55 232.245V174.885L303.81 145.945C305.17 145.165 306 143.725 306 142.155V82.265C305.95 81.875 305.89 81.495 305.8 81.125ZM144.2 227.205L100.57 202.515L146.39 176.135L196.66 147.195L240.33 172.335L208.29 190.625L144.2 227.205ZM244.75 114.995V164.795L226.39 154.225L201.03 139.625V89.825L219.39 100.395L244.75 114.995ZM249.12 57.105L292.81 82.265L249.12 107.425L205.43 82.265L249.12 57.105ZM114.49 184.425L96.13 194.995V85.305L121.49 70.705L139.85 60.135V169.815L114.49 184.425ZM91.76 27.425L135.45 52.585L91.76 77.745L48.07 52.585L91.76 27.425ZM43.67 60.135L62.03 70.705L87.39 85.305V202.545V202.555V202.565C87.39 202.735 87.44 202.895 87.46 203.055C87.49 203.265 87.49 203.485 87.55 203.695V203.705C87.6 203.875 87.69 204.035 87.76 204.195C87.84 204.375 87.89 204.575 87.99 204.745C87.99 204.745 87.99 204.755 88 204.755C88.09 204.905 88.22 205.035 88.33 205.175C88.45 205.335 88.55 205.495 88.69 205.635L88.7 205.645C88.82 205.765 88.98 205.855 89.12 205.965C89.28 206.085 89.42 206.225 89.59 206.325C89.6 206.325 89.6 206.325 89.61 206.335C89.62 206.335 89.62 206.345 89.63 206.345L139.87 234.775V285.065L43.67 229.705V60.135ZM244.75 229.705L148.58 285.075V234.775L219.8 194.115L244.75 179.875V229.705ZM297.2 139.625L253.49 164.795V114.995L278.85 100.395L297.21 89.825V139.625H297.2Z"></path>
                    </svg><span style="font-weight: 600;">Aura Computers</span></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbarNav"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="mainNavbarNav">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Главная</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('catalog.index') }}">Каталог</a></li>
                    </ul>
                    <form class="d-flex w-50 mx-auto" action="{{-- route('search') --}}" method="GET" role="search"><input class="form-control me-2" type="search" name="query" placeholder="Поиск по сайту..." aria-label="Search"><button class="btn btn-outline-primary" type="submit">Найти</button></form>
                    <ul class="navbar-nav ms-auto align-items-center">
                        <li class="nav-item"><a href="{{ route('favorites.index') }}" class="btn btn-outline-secondary btn-action-icon position-relative" title="Избранное"><i class="bi bi-heart"></i><span id="favoritesCountBadge" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger action-icon-badge">@auth{{ auth()->user()->favorites()->count() }}@else 0 @endauth</span></a></li>
                        <li class="nav-item ms-2"><a href="{{ route('compare.index') }}" class="btn btn-outline-secondary btn-action-icon position-relative" title="Сравнение"><i class="bi bi-bar-chart-line"></i><span id="compareCountBadge" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-info text-dark action-icon-badge">@auth{{ auth()->user()->compares()->count() }}@else 0 @endauth</span></a></li>
                        <li class="nav-item ms-2">
                            <button class="btn btn-primary btn-action-icon position-relative" type="button" title="Корзина" data-bs-toggle="offcanvas" data-bs-target="#cartOffcanvas" aria-controls="cartOffcanvas">
                                <i class="bi bi-cart3"></i>
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger action-icon-badge" id="cart-badge">{{ Cart::count() }}</span>
                            </button>
                        </li>
                        <li class="nav-item dropdown ms-lg-3 ms-2"><a class="btn btn-outline-secondary btn-action-icon" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" title="Выбрать язык"><i class="bi bi-globe"></i></a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item d-flex align-items-center @if(app()->getLocale() == 'tk') active @endif" href="{{ route('locale.switch', 'tk') }}"><span class="flag-icon flag-icon-tm me-2"></span>Türkmençe</a></li>
                                <li><a class="dropdown-item d-flex align-items-center @if(app()->getLocale() == 'ru') active @endif" href="{{ route('locale.switch', 'ru') }}"><span class="flag-icon flag-icon-ru me-2"></span>Русский</a></li>
                                <li><a class="dropdown-item d-flex align-items-center @if(app()->getLocale() == 'en') active @endif" href="{{ route('locale.switch', 'en') }}"><span class="flag-icon flag-icon-gb me-2"></span>English</a></li>
                            </ul>
                        </li>
                        <li class="nav-item ms-lg-3 ms-2"><button id="themeToggleButton" class="btn btn-outline-secondary btn-action-icon" type="button" title="Сменить тему"><i class="bi bi-sun-fill theme-icon-sun d-none"></i><i class="bi bi-moon-stars-fill theme-icon-moon"></i></button></li>
                        @guest
                        <li class="nav-item dropdown ms-lg-3 ms-2"><a class="nav-link dropdown-toggle btn btn-outline-secondary" href="#" role="button" data-bs-toggle="dropdown"><i class="bi bi-person"></i></a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('login') }}">Вход</a></li>@if (Route::has('register'))<li><a class="dropdown-item" href="{{ route('register') }}">Регистрация</a></li>@endif
                            </ul>
                        </li>
                        @else
                        <li class="nav-item dropdown ms-lg-3 ms-2"><a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">{{ Auth::user()->name }}</a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Профиль</a></li>
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

    <footer class="mt-auto bg-body-tertiary border-top py-5">
        <div class="container text-center">
            <p class="text-muted mb-0">© {{ date('Y') }} Aura Computers. Все права защищены.</p>
        </div>
    </footer>

    <div class="offcanvas offcanvas-end" tabindex="-1" id="cartOffcanvas" aria-labelledby="cartOffcanvasLabel" style="width: 450px;">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="cartOffcanvasLabel">Товары в корзине</h5><button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div id="cart-offcanvas-content">
                {{-- Содержимое будет загружено через AJAX --}}
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            const cartOffcanvasEl = document.getElementById('cartOffcanvas');
            const cartOffcanvas = new bootstrap.Offcanvas(cartOffcanvasEl);

            async function apiRequest(url, method = 'POST', body = null) {
                const options = {
                    method,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                };
                if (body && !(body instanceof FormData)) {
                    options.headers['Content-Type'] = 'application/json';
                    options.body = JSON.stringify(body);
                } else if (body) {
                    options.body = body;
                }
                const response = await fetch(url, options);
                if (!response.ok) {
                    const errorData = await response.json();
                    throw new Error(errorData.message || `Ошибка ${response.status}`);
                }
                return response.json();
            }

            document.body.addEventListener('click', function(event) {
                const addToCartBtn = event.target.closest('.add-to-cart-btn');
                if (addToCartBtn) {
                    event.preventDefault();
                    handleAddToCart(addToCartBtn.dataset.productId, 1, addToCartBtn);
                }
                const cartContent = event.target.closest('#cart-offcanvas-content');
                if (cartContent) {
                    handleCartActions(event);
                }
            });

            const productPageForm = document.getElementById('addToCartForm');
            if (productPageForm) {
                productPageForm.addEventListener('submit', function(event) {
                    event.preventDefault();
                    const productId = this.action.split('/').pop();
                    const quantity = this.querySelector('input[name="quantity"]').value;
                    handleAddToCart(productId, quantity, this.querySelector('button[type="submit"]'));
                });
            }

            cartOffcanvasEl.addEventListener('show.bs.offcanvas', loadCartContent);

            async function handleAddToCart(productId, quantity, button = null) {
                let originalButtonHtml;
                if (button) {
                    originalButtonHtml = button.innerHTML;
                    button.disabled = true;
                    button.innerHTML = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>`;
                }

                try {
                    const formData = new FormData();
                    formData.append('quantity', quantity);
                    const data = await apiRequest(`/cart/add/${productId}`, 'POST', formData);
                    renderCart(data);
                    cartOffcanvas.show();
                } catch (error) {
                    console.error('Ошибка добавления в корзину:', error);
                    alert(error.message);
                } finally {
                    if (button) {
                        button.disabled = false;
                        button.innerHTML = originalButtonHtml;
                    }
                }
            }

            async function loadCartContent() {
                document.getElementById('cart-offcanvas-content').innerHTML = '<div class="d-flex justify-content-center p-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Загрузка...</span></div></div>';
                try {
                    const data = await apiRequest('/cart', 'GET');
                    renderCart(data);
                } catch (error) {
                    document.getElementById('cart-offcanvas-content').innerHTML = '<p class="text-danger p-3">Не удалось загрузить корзину</p>';
                }
            }

            function handleCartActions(event) {
                const target = event.target;
                const cartItem = target.closest('.cart-item');
                if (!cartItem) return;
                const rowId = cartItem.dataset.rowId;

                if (target.closest('.minus-btn') || target.closest('.plus-btn')) {
                    const input = cartItem.querySelector('.quantity-input');
                    let quantity = parseInt(input.value);
                    if (target.closest('.plus-btn')) quantity++;
                    if (target.closest('.minus-btn') && quantity > 1) quantity--;
                    input.value = quantity;
                    debouncedUpdateCart(rowId, quantity);
                }
                if (target.closest('.cart-item-remove-btn')) {
                    cartItem.classList.add('removing');
                    setTimeout(() => apiRequest(`/cart/remove/${rowId}`, 'DELETE').then(renderCart), 300);
                }
            }

            let debounceTimer;

            function debouncedUpdateCart(rowId, quantity) {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => {
                    apiRequest(`/cart/update/${rowId}`, 'POST', {
                        quantity
                    }).then(renderCart);
                }, 400);
            }

            function renderCart(data) {
                document.getElementById('cart-badge').textContent = data.count || 0;
                const container = document.getElementById('cart-offcanvas-content');

                if (!data.items || data.items.length === 0) {
                    container.innerHTML = `<div class="empty-cart-message"><i class="bi bi-cart-x"></i><h5>Ваша корзина пуста</h5><p class="small">Самое время что-нибудь в нее добавить!</p></div>`;
                    return;
                }

                const itemsHtml = data.items.map(item => `
                <div class="cart-item" data-row-id="${item.rowId}">
                    <img src="${item.image || '/images/placeholder.jpg'}" class="cart-item-img" alt="${item.name}">
                    <div class="cart-item-details">
                        <a href="/products/${item.slug}" class="text-reset text-decoration-none cart-item-title">${item.name}</a>
                        <div class="d-flex justify-content-between align-items-center mt-2">
                            <div class="quantity-control"><button class="quantity-btn minus-btn">-</button><input type="text" class="quantity-input" value="${item.quantity}" readonly><button class="quantity-btn plus-btn">+</button></div>
                            <div class="cart-item-price">${new Intl.NumberFormat('ru-RU').format(item.price)} m</div>
                        </div>
                    </div>
                    <button class="btn btn-link text-danger cart-item-remove-btn p-0"><i class="bi bi-x-circle-fill"></i></button>
                </div>`).join('');

                const footerHtml = `
                <div class="cart-footer">
                    <div class="d-flex justify-content-between mb-2"><span class="text-muted">Скидка:</span><span class="text-muted">– 0 m</span></div>
                    <div class="d-flex justify-content-between align-items-center mb-3"><span class="fw-bold fs-5">Итого:</span><span id="cart-total" class="fw-bold fs-4 text-primary">${new Intl.NumberFormat('ru-RU').format(data.total)} m</span></div>
                    <a href="#" class="btn btn-primary w-100 fw-bold py-2">ОФОРМИТЬ ЗАКАЗ</a>
                </div>`;

                container.innerHTML = `<div class="cart-list">${itemsHtml}</div>${footerHtml}`;
            }

            const themeToggleButton = document.getElementById('themeToggleButton');
            if (themeToggleButton) {
                const htmlElement = document.documentElement;
                const sunIcon = themeToggleButton.querySelector('.theme-icon-sun');
                const moonIcon = themeToggleButton.querySelector('.theme-icon-moon');
                const getPreferredTheme = () => localStorage.getItem('theme') || 'light';
                const setTheme = (theme) => {
                    htmlElement.setAttribute('data-bs-theme', theme);
                    sunIcon.classList.toggle('d-none', theme === 'dark');
                    moonIcon.classList.toggle('d-none', theme !== 'dark');
                    localStorage.setItem('theme', theme);
                };
                setTheme(getPreferredTheme());
                themeToggleButton.addEventListener('click', () => setTheme(htmlElement.getAttribute('data-bs-theme') === 'light' ? 'dark' : 'light'));
            }
        });
    </script>
</body>

</html>