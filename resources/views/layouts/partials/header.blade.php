<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<nav class="navbar navbar-expand-lg sticky-top" id="appNavbar">
    <div class="container-fluid">
        <!-- Logo and Store Name -->
        <a class="navbar-brand d-none d-md-inline-flex align-items-center me-lg-3" href="{{ route('dashboard') }}" data-bs-toggle="tooltip" data-bs-placement="bottom" title="На главную">
            <x-application-logo class="d-inline-block align-text-top me-2" style="height: 40px; width: auto;" />
            <span class="" style="font-family: 'Cascadia Code', var(--bs-font-sans-serif);">Aura Computers</span>
        </a>

        <!-- Vertical Rule (Desktop only) -->
        <li class="nav-item d-none d-lg-block ms-lg-1 me-lg-1">
            <hr class="vr app-navbar-vr">
        </li>

        <!-- Left Side: Categories and Brands -->
        <div class="d-flex align-items-center" id="navbarLeftItems">
            <ul class="navbar-nav flex-row">
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center px-2" href="{{ route('catalog.index') }}" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Категории">
                        <i class="bi bi-grid me-1 fs-5"></i>
                        <span style="font-family: 'Cascadia Code', var(--bs-font-sans-serif);" class="d-none d-md-inline">Категории</span>
                    </a>
                </li>
                <li class="nav-item ms-md-2">
                    <a class="nav-link d-flex align-items-center px-2" href="#" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Бренды">
                        <i class="bi bi-tags me-1 fs-5"></i>
                        <span style="font-family: 'Cascadia Code', var(--bs-font-sans-serif);" class="d-none d-md-inline">Бренды</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Hamburger Toggler -->
        <button class="navbar-toggler ms-auto ms-md-2" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Переключить навигацию" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Открыть меню">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Center: Search Bar -->
            <div class="position-relative mx-lg-auto my-2 my-lg-0 app-search-container">
                <form class="d-flex app-search-form" role="search" id="appSearchForm">
                    <input style="font-family: 'Cascadia Code', var(--bs-font-sans-serif);" class="form-control app-search-input" type="search" placeholder="Поиск товара по названию..." aria-label="Search" id="appSearchInput">
                    <button class="btn app-search-button" type="submit" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Найти"><i class="bi bi-search"></i></button>
                </form>
                <div id="searchResultsDropdown" class="search-results-dropdown"></div>
            </div>

            <!-- Right Side: Icons and Auth -->
            <ul class="navbar-nav ms-lg-auto d-flex align-items-center">
                <!-- Language Dropdown (Desktop) -->
                <li class="nav-item dropdown d-none d-lg-block">
                    <a class="nav-link nav-icon-btn dropdown-toggle" href="#" id="languageDropdownDesktop" role="button" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Выбрать язык" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Выбрать язык">
                        <i class="bi bi-translate fs-5"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end animate slideIn" aria-labelledby="languageDropdownDesktop" id="languageMenuDesktop">
                        <li>
                            <a class="dropdown-item d-flex align-items-center lang-option" href="#" data-lang="tm">
                                <img src="{{ asset('images/flags/tm.svg') }}" width="20" alt="Türkmen dili" class="me-2 lang-flag"> <span style="font-family: 'Cascadia Code', var(--bs-font-sans-serif);">Türkmen dili</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center lang-option active" href="#" data-lang="ru">
                                <img src="{{ asset('images/flags/ru.svg') }}" width="20" alt="Русский" class="me-2 lang-flag"> <span style="font-family: 'Cascadia Code', var(--bs-font-sans-serif);">Русский</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center lang-option" href="#" data-lang="en">
                                <img src="{{ asset('images/flags/us.svg') }}" width="20" alt="English" class="me-2 lang-flag"> <span style="font-family: 'Cascadia Code', var(--bs-font-sans-serif);">English</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item d-none d-lg-block ms-lg-1 me-lg-1">
                    <hr class="vr app-navbar-vr">
                </li>
                <!-- Theme Toggler (Desktop) -->
                <li class="nav-item d-none d-lg-block">
                    <button id="themeTogglerDesktop" type="button" class="nav-link nav-icon-btn" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Переключить тему">
                        <i class="bi bi-sun-fill theme-icon-light fs-5"></i>
                        <i class="bi bi-moon-stars-fill theme-icon-dark fs-5" style="display: none;"></i>
                    </button>
                </li>


                @guest
                <li style="font-family: 'Cascadia Code', var(--bs-font-sans-serif);" class="nav-item d-none d-lg-block ms-lg-2">
                    <a href="{{ route('login') }}" class="nav-link d-flex align-items-center px-2 {{ request()->routeIs('login') ? 'active' : '' }}" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Войти в аккаунт">
                        <i class="bi bi-box-arrow-in-right fs-5 me-1"></i> Войти
                    </a>
                </li>
                <li style="font-family: 'Cascadia Code', var(--bs-font-sans-serif);" class="nav-item d-none d-lg-block ms-lg-2">
                    <a href="{{ route('register') }}" class="nav-link d-flex align-items-center px-2 {{ request()->routeIs('register') ? 'active' : '' }}" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Создать новый аккаунт">
                        <i class="bi bi-person-plus fs-5 me-1"></i> Регистрация
                    </a>
                </li>
                @else
                <li class="nav-item dropdown d-none d-lg-block ms-lg-2">
                    @php
                    $userName = Auth::user()->name;
                    $nameParts = explode(' ', $userName);
                    $displayLastName = !empty($nameParts) && end($nameParts) !== false ? end($nameParts) : $userName;
                    @endphp
                    <a class="nav-link dropdown-toggle d-flex align-items-center px-2" href="#" id="navbarDropdownUserDesktop" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Меню пользователя: {{ $displayLastName }}">
                        <i class="bi bi-person-circle fs-5 me-1"></i> <span style="font-family: 'Cascadia Code', var(--bs-font-sans-serif);">{{ $displayLastName }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end animate slideIn" aria-labelledby="navbarDropdownUserDesktop">
                        <li style="font-family: 'Cascadia Code', var(--bs-font-sans-serif);">
                            <h6 class="dropdown-header">Управление аккаунтом</h6>
                        </li>
                        <li style="font-family: 'Cascadia Code', var(--bs-font-sans-serif);"><a class="dropdown-item" href="{{ route('profile.edit') }}" data-bs-toggle="tooltip" data-bs-placement="left" title="Перейти в профиль"><i class="bi bi-person-circle me-2"></i>Профиль</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li style="font-family: 'Cascadia Code', var(--bs-font-sans-serif);">
                            <form method="POST" action="{{ route('logout') }}" id="logoutFormDesktop">
                                @csrf
                                <a class="dropdown-item text-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logoutFormDesktop').submit();" data-bs-toggle="tooltip" data-bs-placement="left" title="Выйти из аккаунта"><i class="bi bi-box-arrow-right me-2"></i>Выйти</a>
                            </form>
                        </li>
                    </ul>
                </li>
                @endguest

                <li class="nav-item d-none d-lg-block ms-lg-1 me-lg-1">
                    <hr class="vr app-navbar-vr">
                </li>

                <li class="nav-item d-none d-lg-block">
                    <a href="#" class="nav-link nav-icon-btn" aria-label="Мои заказы" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Мои заказы">
                        <i class="bi bi-box-seam fs-5"></i>
                    </a>
                </li>
                <li class="nav-item d-none d-lg-block">
                    <a href="{{-- route('wishlist.index') --}}" class="nav-link nav-icon-btn position-relative" aria-label="Избранное" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Список избранного">
                        <i class="bi bi-heart fs-5"></i>
                        {{-- <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger wishlist-count" style="font-size: 0.6em;">3</span> --}}
                    </a>
                </li>
                <li class="nav-item d-none d-lg-block">
                    <a href="{{-- route('cart.index') --}}" class="nav-link nav-icon-btn position-relative" aria-label="Корзина" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Перейти в корзину">
                        <i class="bi bi-cart3 fs-5"></i>
                        {{-- <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary cart-count" style="font-size: 0.6em;">1</span> --}}
                    </a>
                </li>

                <!-- Mobile Menu Items -->
                <li class="nav-item d-lg-none">
                    <hr class="dropdown-divider">
                </li>
                <li class="nav-item d-lg-none">
                    <a class="navbar-brand d-flex align-items-center mobile-menu-item" href="{{ route('dashboard') }}">
                        <x-application-logo class="d-inline-block align-text-top me-2" style="height: 24px; width: auto;" />
                        <span class="fw-bold" style="font-family: 'Cascadia Code', var(--bs-font-sans-serif);">Aura Computers</span>
                    </a>
                </li>
                <li class="nav-item d-lg-none">
                    <hr class="dropdown-divider">
                </li>
                <li class="nav-item d-lg-none">
                    <a class="nav-link d-flex align-items-center mobile-menu-item" href="{{ route('catalog.index') }}"><i class="bi bi-grid fs-5 me-2"></i> <span style="font-family: 'Cascadia Code', var(--bs-font-sans-serif);">Категории</span></a>
                </li>
                <li class="nav-item d-lg-none">
                    <a class="nav-link d-flex align-items-center mobile-menu-item" href="#"><i class="bi bi-tags fs-5 me-2"></i> <span style="font-family: 'Cascadia Code', var(--bs-font-sans-serif);">Бренды</span></a>
                </li>
                <li class="nav-item d-lg-none">
                    <hr class="dropdown-divider">
                </li>

                <li class="nav-item d-lg-none">
                    <button id="themeTogglerMobile" type="button" class="btn btn-link nav-link d-flex align-items-center w-100 text-start mobile-menu-item">
                        <i class="bi bi-sun-fill theme-icon-light fs-5 me-2"></i>
                        <i class="bi bi-moon-stars-fill theme-icon-dark fs-5 me-2" style="display: none;"></i>
                        <span style="font-family: 'Cascadia Code', var(--bs-font-sans-serif);" class="theme-toggler-text">Переключить на темную тему</span>
                    </button>
                </li>
                <li class="nav-item d-lg-none">
                    <a style="font-family: 'Cascadia Code', var(--bs-font-sans-serif);" href="#" class="nav-link d-flex align-items-center mobile-menu-item">
                        <i class="bi bi-box-seam fs-5 me-2"></i> Мои заказы
                    </a>
                </li>
                <li class="nav-item d-lg-none">
                    <a style="font-family: 'Cascadia Code', var(--bs-font-sans-serif);" href="{{-- route('wishlist.index') --}}" class="nav-link d-flex align-items-center mobile-menu-item">
                        <i class="bi bi-heart fs-5 me-2"></i> Избранное
                    </a>
                </li>
                <li class="nav-item d-lg-none">
                    <a style="font-family: 'Cascadia Code', var(--bs-font-sans-serif);" href="{{-- route('cart.index') --}}" class="nav-link d-flex align-items-center mobile-menu-item">
                        <i class="bi bi-cart3 fs-5 me-2"></i> Корзина
                    </a>
                </li>
                <li class="nav-item dropdown d-lg-none">
                    <a style="font-family: 'Cascadia Code', var(--bs-font-sans-serif);" class="nav-link dropdown-toggle d-flex align-items-center mobile-menu-item" href="#" id="languageDropdownMobileToggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-translate fs-5 me-2"></i> Выбрать язык
                    </a>
                    <ul class="dropdown-menu animate slideIn" aria-labelledby="languageDropdownMobileToggle" id="languageMenuMobile">
                        <li>
                            <a class="dropdown-item d-flex align-items-center lang-option" href="#" data-lang="tm">
                                <img src="{{ asset('images/flags/tm.svg') }}" width="20" alt="Türkmen dili" class="me-2 lang-flag"> <span style="font-family: 'Cascadia Code', var(--bs-font-sans-serif);">Türkmen dili</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center lang-option active" href="#" data-lang="ru">
                                <img src="{{ asset('images/flags/ru.svg') }}" width="20" alt="Русский" class="me-2 lang-flag"> <span style="font-family: 'Cascadia Code', var(--bs-font-sans-serif);">Русский</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center lang-option" href="#" data-lang="en">
                                <img src="{{ asset('images/flags/us.svg') }}" width="20" alt="English" class="me-2 lang-flag"> <span style="font-family: 'Cascadia Code', var(--bs-font-sans-serif);">English</span>
                            </a>
                        </li>
                    </ul>
                </li>

                @guest
                <li class="nav-item d-lg-none">
                    <hr class="dropdown-divider">
                </li>
                <li class="nav-item d-lg-none">
                    <a style="font-family: 'Cascadia Code', var(--bs-font-sans-serif);" href="{{ route('login') }}" class="nav-link {{ request()->routeIs('login') ? 'active' : '' }} mobile-menu-item d-flex align-items-center">
                        <i class="bi bi-box-arrow-in-right fs-5 me-2"></i> Войти
                    </a>
                </li>
                <li class="nav-item d-lg-none">
                    <a style="font-family: 'Cascadia Code', var(--bs-font-sans-serif);" href="{{ route('register') }}" class="nav-link {{ request()->routeIs('register') ? 'active' : '' }} mobile-menu-item d-flex align-items-center">
                        <i class="bi bi-person-plus fs-5 me-2"></i> Регистрация
                    </a>
                </li>
                @else
                <li class="nav-item d-lg-none">
                    <hr class="dropdown-divider">
                </li>
                <li class="nav-item dropdown d-lg-none">
                    <a class="nav-link dropdown-toggle d-flex align-items-center mobile-menu-item" href="#" id="navbarDropdownUserMobile" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="me-2"><i class="bi bi-person-circle fs-3"></i></div>
                        <div>
                            <div class="fw-medium" style="font-family: 'Cascadia Code', var(--bs-font-sans-serif);">{{ $displayLastName }}</div>
                            <div class="small text-muted" style="font-family: 'Cascadia Code', var(--bs-font-sans-serif);">{{ Auth::user()->email }}</div>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end animate slideIn" aria-labelledby="navbarDropdownUserMobile">
                        <li class="dropdown-header" style="font-family: 'Cascadia Code', var(--bs-font-sans-serif);">@ {{ $displayLastName }}</li>
                        <li style="font-family: 'Cascadia Code', var(--bs-font-sans-serif);"><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="bi bi-person-circle me-2"></i>Профиль</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li style="font-family: 'Cascadia Code', var(--bs-font-sans-serif);">
                            <form method="POST" action="{{ route('logout') }}" id="logoutFormMobile">
                                @csrf
                                <a class="dropdown-item text-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logoutFormMobile').submit();"><i class="bi bi-box-arrow-right me-2"></i>Выйти</a>
                            </form>
                        </li>
                    </ul>
                </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>

<style>
    #appNavbar {
        padding-top: 0.6rem;
        padding-bottom: 0.6rem;
        transition: background-color 0.3s ease-in-out, border-color 0.3s ease-in-out;
        opacity: 0;
        animation: fadeInNavbar 0.5s ease-out forwards;
        animation-delay: 0.1s;
        box-shadow: none !important;
        /* Ensure no Bootstrap shadow is applied if added by default */
    }

    @keyframes fadeInNavbar {
        to {
            opacity: 1;
        }
    }

    [data-bs-theme="light"] #appNavbar {
        background-color: #ffffff;
        border-bottom: 1px solid #e0e0e0;
        /* Subtle border for light theme */
    }

    [data-bs-theme="dark"] #appNavbar {
        background-color: var(--bs-dark-bg-subtle, #212529);
        /* Dark theme background */
        border-bottom: 1px solid #495057;
        /* Subtle border for dark theme */
    }

    .navbar-brand {
        color: var(--bs-nav-link-color);
        font-size: 1.1rem;
        /* Slightly smaller for better balance */
    }

    .navbar-brand:hover {
        color: var(--bs-nav-link-hover-color);
    }

    #navbarLeftItems {
        margin-left: 0;
    }

    @media (max-width: 991.98px) {

        /* md breakpoint is 768, lg is 992. Use lg for when navbar is collapsed */
        #navbarLeftItems {
            margin-left: 0;
            /* Ensure no extra margin on small screens */
        }

        .navbar-toggler.ms-auto {
            /* Ensure toggler is to the far right */
            margin-left: auto !important;
        }
    }

    #navbarLeftItems .navbar-nav .nav-link {
        color: var(--bs-body-color);
        /* Use body color for better theme adaptation */
        font-weight: 500;
    }

    #navbarLeftItems .navbar-nav .nav-link i {
        color: var(--bs-secondary-color);
        /* Use secondary color for icons */
    }


    /* Search Bar Styling */
    .app-search-container {
        flex-grow: 1;
        max-width: 550px;
        margin-left: 1rem !important;
        /* Default margin */
        margin-right: 1rem !important;
        /* Default margin */
    }

    @media (min-width: 992px) {

        /* lg breakpoint, when navbar is not collapsed */
        .app-search-container {
            margin-left: auto !important;
            /* Center on larger screens */
            margin-right: auto !important;
            /* Center on larger screens */
        }
    }

    .app-search-form {
        width: 100%;
    }

    .app-search-input {
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
        background-color: var(--bs-tertiary-bg);
        /* Use theme variable */
        border: 1px solid var(--bs-tertiary-bg);
        box-shadow: none;
        flex-grow: 1;
    }

    .app-search-input::placeholder {
        color: var(--bs-secondary-color);
    }

    .app-search-input:focus {
        background-color: var(--bs-body-bg);
        /* Focus background */
        border-color: var(--bs-primary);
        box-shadow: 0 0 0 0.2rem rgba(var(--bs-primary-rgb), 0.25);
    }

    .app-search-button {
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
        background-color: var(--bs-tertiary-bg);
        border: 1px solid var(--bs-tertiary-bg);
        color: var(--bs-emphasis-color);
        /* Use emphasis color for icon */
    }

    .app-search-button:hover,
    .app-search-button:focus {
        background-color: var(--bs-secondary-bg);
        /* Slightly darker hover */
        border-color: var(--bs-secondary-bg);
        color: var(--bs-primary);
    }

    .search-results-dropdown {
        display: none;
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background-color: var(--bs-body-bg);
        border: 1px solid var(--bs-border-color-translucent);
        border-top: none;
        z-index: 1050;
        max-height: 300px;
        overflow-y: auto;
        border-bottom-left-radius: .375rem;
        border-bottom-right-radius: .375rem;
        box-shadow: var(--bs-box-shadow-lg);
    }

    .search-results-dropdown a.dropdown-item {
        display: block;
        width: 100%;
        padding: .5rem 1rem;
        clear: both;
        font-weight: 400;
        color: var(--bs-body-color);
        text-align: inherit;
        text-decoration: none;
        white-space: nowrap;
        background-color: transparent;
        border: 0;
        font-family: 'Cascadia Code', var(--bs-font-sans-serif);
    }

    .search-results-dropdown a.dropdown-item strong {
        font-weight: 700;
    }

    .search-results-dropdown a.dropdown-item:hover {
        color: var(--bs-emphasis-color);
        background-color: var(--bs-tertiary-bg);
    }

    .search-results-dropdown .no-results {
        padding: .5rem 1rem;
        color: var(--bs-secondary-color);
        font-family: 'Cascadia Code', var(--bs-font-sans-serif);
    }

    /* General Nav Link Styling */
    .navbar-nav .nav-link {
        color: var(--bs-nav-link-color);
        transition: color 0.2s ease-in-out, background-color 0.2s ease-in-out;
        border-radius: 0.375rem;
        /* Standard border radius */
        padding: 0.6rem 0.5rem;
        /* Consistent padding */
        display: flex;
        align-items: center;
    }

    .navbar-nav .nav-link i.fs-5 {
        color: var(--bs-secondary-color);
        /* Icon color */
        vertical-align: middle;
    }

    [data-bs-theme="light"] .navbar-nav .nav-link:not(.nav-icon-btn):not(.dropdown-toggle):hover,
    [data-bs-theme="light"] .navbar-nav .nav-link:not(.nav-icon-btn):not(.dropdown-toggle):focus {
        color: var(--bs-primary);
        background-color: rgba(0, 0, 0, 0.03);
        /* Subtle hover for light theme */
    }

    [data-bs-theme="dark"] .navbar-nav .nav-link:not(.nav-icon-btn):not(.dropdown-toggle):hover,
    [data-bs-theme="dark"] .navbar-nav .nav-link:not(.nav-icon-btn):not(.dropdown-toggle):focus {
        color: var(--bs-primary);
        background-color: rgba(255, 255, 255, 0.05);
        /* Subtle hover for dark theme */
    }

    /* Nav Icon Button Styling (for Wishlist, Cart, Language, Theme) */
    .nav-icon-btn {
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        width: 40px;
        /* Square button */
        height: 40px;
        padding: 0 !important;
        font-size: 1.1rem;
        /* Icon size */
        color: var(--bs-nav-link-color) !important;
        /* Default icon color */
    }

    .nav-icon-btn i {
        line-height: 1;
    }

    /* Ensure icon is centered */

    .nav-icon-btn:hover,
    .nav-icon-btn:focus {
        color: var(--bs-primary) !important;
        /* Primary color on hover/focus */
        background-color: rgba(var(--bs-primary-rgb), 0.1) !important;
        /* Subtle background on hover */
    }

    .nav-icon-btn.dropdown-toggle::after {
        margin-left: 0.1em;
    }

    /* Adjust caret position if needed */


    /* Vertical Rule Styling */
    .app-navbar-vr {
        height: 22px !important;
        border-left: 1px solid var(--bs-border-color-translucent);
        /* Use theme variable */
        display: inline-block;
        vertical-align: middle;
        opacity: 0.7;
    }

    /* Dropdown Menu Styling */
    .dropdown-menu.animate {
        animation-duration: 0.3s;
        animation-fill-mode: both;
        border-radius: 0.5rem;
        /* Softer radius for dropdowns */
        box-shadow: var(--bs-box-shadow-lg);
        /* Standard Bootstrap shadow */
        padding-top: 0.25rem;
        padding-bottom: 0.25rem;
    }

    .dropdown-menu.animate.slideIn {
        animation-name: slideIn;
    }

    @keyframes slideIn {
        0% {
            transform: translateY(-15px) scale(0.98);
            opacity: 0;
        }

        100% {
            transform: translateY(0) scale(1);
            opacity: 1;
        }
    }

    .dropdown-menu .dropdown-item {
        padding: 0.5rem 1rem;
        transition: background-color 0.2s ease, color 0.2s ease;
    }

    .dropdown-menu .dropdown-item .lang-flag {
        /* Language flag specific */
        border: 1px solid var(--bs-border-color-translucent);
        border-radius: 2px;
        object-fit: cover;
        /* Ensure flag aspect ratio is maintained */
    }

    .dropdown-menu .dropdown-item.lang-option.active {
        color: var(--bs-dropdown-link-active-color, #fff);
        background-color: var(--bs-dropdown-link-active-bg, var(--bs-primary));
        font-weight: 500;
    }

    .dropdown-menu .dropdown-item.lang-option.active:hover {
        filter: brightness(95%);
        /* Slightly darken active item on hover */
    }


    /* Navbar Toggler (Hamburger) Styling */
    .navbar-toggler {
        border-color: transparent;
        padding: .25rem .5rem;
    }

    .navbar-toggler:focus {
        box-shadow: 0 0 0 0.2rem rgba(var(--bs-primary-rgb), 0.25);
    }

    .navbar-toggler-icon {
        width: 1.2em;
        height: 1.2em;
        transition: transform 0.2s ease-in-out;
    }

    .navbar-toggler[aria-expanded="true"] .navbar-toggler-icon {
        transform: rotate(90deg);
        /* Rotate icon when menu is open */
    }

    /* Mobile Menu Specific Styling */
    .navbar-collapse .mobile-menu-item {
        padding: 0.75rem 1rem;
        color: var(--bs-body-color);
    }

    .navbar-collapse .mobile-menu-item i {
        margin-right: 0.6rem;
        /* Space between icon and text */
        width: 1.5em;
        /* Fixed width for icon alignment */
        text-align: center;
    }

    .navbar-collapse .dropdown-divider {
        margin-top: 0.5rem;
        margin-bottom: 0.5rem;
        border-top-color: rgba(var(--bs-emphasis-color-rgb), 0.08);
        /* Subtle divider */
    }

    [data-bs-theme="light"] .navbar-collapse .mobile-menu-item:hover {
        background-color: rgba(0, 0, 0, 0.04);
        color: var(--bs-primary);
    }

    [data-bs-theme="dark"] .navbar-collapse .mobile-menu-item:hover {
        background-color: rgba(255, 255, 255, 0.08);
        color: var(--bs-primary);
    }

    .dropdown-toggle::after {
        color: inherit;
    }

    /* Ensure caret color matches text */
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const themeTogglerDesktop = document.getElementById('themeTogglerDesktop');
        const themeTogglerMobile = document.getElementById('themeTogglerMobile');
        const lightIcons = document.querySelectorAll('.theme-icon-light');
        const darkIcons = document.querySelectorAll('.theme-icon-dark');
        const themeTogglerTexts = document.querySelectorAll('.theme-toggler-text');
        const htmlElement = document.documentElement;
        let isDarkMode = localStorage.getItem('darkMode') === 'true';

        function applyTheme() {
            if (isDarkMode) {
                htmlElement.setAttribute('data-bs-theme', 'dark');
                lightIcons.forEach(icon => icon.style.display = 'none');
                darkIcons.forEach(icon => icon.style.display = 'inline-block');
                themeTogglerTexts.forEach(text => text.textContent = 'Переключить на светлую тему');
                if (themeTogglerDesktop) themeTogglerDesktop.setAttribute('title', 'Переключить на светлую тему');
            } else {
                htmlElement.setAttribute('data-bs-theme', 'light');
                lightIcons.forEach(icon => icon.style.display = 'inline-block');
                darkIcons.forEach(icon => icon.style.display = 'none');
                themeTogglerTexts.forEach(text => text.textContent = 'Переключить на темную тему');
                if (themeTogglerDesktop) themeTogglerDesktop.setAttribute('title', 'Переключить на темную тему');
            }
            localStorage.setItem('darkMode', isDarkMode.toString());
            // Re-initialize tooltips if they get messed up by dynamic content change
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function(tooltipTriggerEl) {
                const tooltip = bootstrap.Tooltip.getInstance(tooltipTriggerEl);
                if (tooltip) {
                    tooltip.setContent({
                        '.tooltip-inner': tooltipTriggerEl.getAttribute('title')
                    });
                }
                return tooltip || new bootstrap.Tooltip(tooltipTriggerEl);
            });
        }

        function toggleDarkMode() {
            isDarkMode = !isDarkMode;
            applyTheme();
            // Simple fade transition on body (optional, can be removed)
            document.body.classList.add('theme-changing');
            setTimeout(() => {
                document.body.classList.remove('theme-changing');
            }, 300);
        }

        if (themeTogglerDesktop) {
            themeTogglerDesktop.addEventListener('click', toggleDarkMode);
        }
        if (themeTogglerMobile) {
            themeTogglerMobile.addEventListener('click', toggleDarkMode);
        }
        applyTheme(); // Apply theme on initial load

        const navbarCollapsibleElement = document.getElementById('navbarSupportedContent');
        if (navbarCollapsibleElement) {
            navbarCollapsibleElement.addEventListener('show.bs.collapse', function() {
                let items = Array.from(this.querySelectorAll('.nav-item, .dropdown-divider, .app-search-container, .navbar-brand.mobile-menu-item'));
                items.forEach((item, index) => {
                    item.style.opacity = '0';
                    item.style.transform = 'translateY(-10px)';
                    setTimeout(() => {
                        item.style.transition = `opacity 0.2s ease-out ${index * 0.03}s, transform 0.2s ease-out ${index * 0.03}s`;
                        item.style.opacity = '1';
                        item.style.transform = 'translateY(0)';
                    }, 50);
                });
            });
            navbarCollapsibleElement.addEventListener('hide.bs.collapse', function() {
                let items = Array.from(this.querySelectorAll('.nav-item, .dropdown-divider, .app-search-container, .navbar-brand.mobile-menu-item'));
                items.forEach((item) => {
                    item.style.opacity = '0';
                    item.style.transform = 'translateY(-10px)';
                    item.style.removeProperty('transition');
                });
            });
            navbarCollapsibleElement.addEventListener('hidden.bs.collapse', function() {
                let items = Array.from(this.querySelectorAll('.nav-item, .dropdown-divider, .app-search-container, .navbar-brand.mobile-menu-item'));
                items.forEach((item) => {
                    item.style.removeProperty('opacity');
                    item.style.removeProperty('transform');
                });
            });
        }

        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })

        const languageOptionsDesktop = document.querySelectorAll('#languageMenuDesktop .lang-option');
        const languageOptionsMobile = document.querySelectorAll('#languageMenuMobile .lang-option');
        const allLanguageOptions = [...languageOptionsDesktop, ...languageOptionsMobile];
        const defaultLang = 'ru';
        let currentLang = localStorage.getItem('selectedLanguage') || defaultLang;

        function setActiveLanguage(selectedLang) {
            allLanguageOptions.forEach(option => {
                option.classList.remove('active');
                if (option.dataset.lang === selectedLang) {
                    option.classList.add('active');
                }
            });
            console.log("Language changed to: " + selectedLang);
        }

        allLanguageOptions.forEach(option => {
            option.addEventListener('click', function(event) {
                event.preventDefault();
                const lang = this.dataset.lang;
                localStorage.setItem('selectedLanguage', lang);
                currentLang = lang;
                setActiveLanguage(lang);

                const parentDropdown = this.closest('.dropdown-menu');
                if (parentDropdown) {
                    const parentDropdownToggle = parentDropdown.previousElementSibling;
                    if (parentDropdownToggle && parentDropdownToggle.classList.contains('dropdown-toggle')) {
                        const bsDropdown = bootstrap.Dropdown.getInstance(parentDropdownToggle);
                        if (bsDropdown) bsDropdown.hide();
                    }
                }
            });
        });
        setActiveLanguage(currentLang);

        const searchInput = document.getElementById('appSearchInput');
        const searchResultsDropdown = document.getElementById('searchResultsDropdown');
        const appSearchForm = document.getElementById('appSearchForm');

        const sampleProducts = [
            "Ноутбук Apple MacBook Air 13", "Смартфон Samsung Galaxy S23", "Наушники Sony WH-1000XM5", "Клавиатура Aura Pro Mechanical",
            "Мышь Logitech MX Master 3S", "Монитор Dell UltraSharp U2723QE", "Планшет Apple iPad Pro 11", "Игровая консоль Sony PlayStation 5",
            "Фотоаппарат Canon EOS R6", "Кофемашина De'Longhi Dinamica", "Фитнес-трекер Xiaomi Mi Band 8", "Видеокарта NVIDIA GeForce RTX 4080",
            "Процессор Intel Core i7-13700K", "SSD накопитель Samsung 980 PRO 1TB", "Оперативная память Kingston Fury Beast 32GB", "AuraBook X1", "AuraPhone Z"
        ];

        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.trim().toLowerCase();
            searchResultsDropdown.innerHTML = '';

            if (searchTerm.length === 0) {
                searchResultsDropdown.style.display = 'none';
                return;
            }

            const filteredProducts = sampleProducts.filter(product =>
                product.toLowerCase().includes(searchTerm)
            );

            if (filteredProducts.length > 0) {
                filteredProducts.forEach(product => {
                    const item = document.createElement('a');
                    item.href = '#';
                    item.classList.add('dropdown-item');

                    const matchStart = product.toLowerCase().indexOf(searchTerm);
                    const matchEnd = matchStart + searchTerm.length;

                    if (matchStart !== -1) {
                        item.innerHTML = product.substring(0, matchStart) +
                            '<strong>' + product.substring(matchStart, matchEnd) + '</strong>' +
                            product.substring(matchEnd);
                    } else {
                        item.textContent = product;
                    }

                    item.addEventListener('click', function(e) {
                        e.preventDefault();
                        searchInput.value = product;
                        searchResultsDropdown.style.display = 'none';
                        console.log("Selected product:", product);
                    });
                    searchResultsDropdown.appendChild(item);
                });
                searchResultsDropdown.style.display = 'block';
            } else {
                const noResultsItem = document.createElement('div');
                noResultsItem.classList.add('no-results');
                noResultsItem.textContent = 'Ничего не найдено';
                searchResultsDropdown.appendChild(noResultsItem);
                searchResultsDropdown.style.display = 'block';
            }
        });

        appSearchForm.addEventListener('submit', function(event) {
            event.preventDefault();
            const searchTerm = searchInput.value.trim();
            if (searchTerm) {
                console.log("Searching for:", searchTerm);
                searchResultsDropdown.style.display = 'none';
            }
        });

        document.addEventListener('click', function(event) {
            if (!appSearchForm.contains(event.target) && !searchResultsDropdown.contains(event.target)) {
                searchResultsDropdown.style.display = 'none';
            }
        });
        searchInput.addEventListener('focus', function() {
            if (this.value.trim().length > 0 && searchResultsDropdown.children.length > 0) {
                searchResultsDropdown.style.display = 'block';
            }
        });

    });
</script>