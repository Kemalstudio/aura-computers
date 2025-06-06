<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<nav class="navbar navbar-expand-lg sticky-top shadow-sm" id="appNavbar" style="z-index: 2000;">
    <div class="container-fluid">
        <!-- Левая сторона: Логотип и название магазина -->
        <a class="navbar-brand d-flex align-items-center" href="{{ route('dashboard') }}">
            <x-application-logo class="d-inline-block align-text-top me-2" style="height: 36px; width: auto;" />
            <span class="fw-bold fs-5 d-none d-md-inline-block">Aura Computers</span>
        </a>

        <!-- Переключатель-гамбургер -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Переключить навигацию">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            </ul>

            <!-- Правая сторона: Иконки и авторизация -->
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 d-flex align-items-center">
                @php
                $currentLocale = app()->getLocale();
                $locales = [
                'tm' => ['name' => 'Türkmençe', 'flag' => 'https://flagcdn.com/w20/tm.png', 'flag_srcset' => 'https://flagcdn.com/w40/tm.png 2x'],
                'ru' => ['name' => 'Русский', 'flag' => 'https://flagcdn.com/w20/ru.png', 'flag_srcset' => 'https://flagcdn.com/w40/ru.png 2x'],
                'en' => ['name' => 'English', 'flag' => 'https://flagcdn.com/w20/gb.png', 'flag_srcset' => 'https://flagcdn.com/w40/gb.png 2x'],
                ];
                @endphp

                <!-- Переключатель темы (Десктоп) -->
                <li class="nav-item d-none d-lg-block">
                    <button id="themeTogglerDesktop" type="button" class="btn btn-link nav-link nav-icon-btn" aria-label="Переключить тему">
                        <i class="bi bi-sun-fill theme-icon-light fs-5"></i>
                        <i class="bi bi-moon-stars-fill theme-icon-dark fs-5" style="display: none;"></i>
                    </button>
                </li>

                <!-- Избранное (Десктоп) -->
                <li class="nav-item d-none d-lg-block">
                    <a href="{{-- route('wishlist.index') --}}" class="nav-link nav-icon-btn position-relative" aria-label="Избранное">
                        <i class="bi bi-heart fs-5"></i>
                        {{-- Опциональный счетчик: <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">3 <span class="visually-hidden">товаров в избранном</span></span> --}}
                    </a>
                </li>

                <!-- Корзина (Десктоп) -->
                <li class="nav-item d-none d-lg-block">
                    <a href="{{-- route('cart.index') --}}" class="nav-link nav-icon-btn position-relative" aria-label="Корзина">
                        <i class="bi bi-cart3 fs-5"></i>
                        {{-- Опциональный счетчик: <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">5 <span class="visually-hidden">товаров в корзине</span></span> --}}
                    </a>
                </li>

                <!-- Переключатель языков (Десктоп) -->
                <li class="nav-item dropdown d-none d-lg-block">
                    <a class="nav-link nav-icon-btn dropdown-toggle" href="#" id="languageDropdownDesktop" role="button" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Выбрать язык">
                        <i class="bi bi-translate fs-5"></i> 
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end animate slideIn" aria-labelledby="languageDropdownDesktop">
                        @foreach ($locales as $localeCode => $properties)
                        <li>
                            <a class="dropdown-item d-flex align-items-center @if($currentLocale == $localeCode) active @endif"
                                href="{{ route('locale.switch', $localeCode) }}"> {{-- Предполагаем, что есть маршрут для смены языка --}}
                                <img src="{{ $properties['flag'] }}" srcset="{{ $properties['flag_srcset'] }}" width="20" alt="{{ $properties['name'] }}" class="me-2">
                                {{ $properties['name'] }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </li>


                <!-- Разделитель для визуальной ясности в мобильном виде -->
                <li class="nav-item d-lg-none">
                    <hr class="dropdown-divider">
                </li>

                <!-- Переключатель темы (Мобильный) -->
                <li class="nav-item d-lg-none">
                    <button id="themeTogglerMobile" type="button" class="btn btn-link nav-link d-flex align-items-center w-100 text-start mobile-menu-item">
                        <i class="bi bi-sun-fill theme-icon-light fs-5 me-2"></i>
                        <i class="bi bi-moon-stars-fill theme-icon-dark fs-5 me-2" style="display: none;"></i>
                        <span class="theme-toggler-text">Переключить на темную тему</span>
                    </button>
                </li>

                <!-- Избранное (Мобильный) -->
                <li class="nav-item d-lg-none">
                    <a href="{{-- route('wishlist.index') --}}" class="nav-link d-flex align-items-center mobile-menu-item">
                        <i class="bi bi-heart fs-5 me-2"></i> Избранное
                    </a>
                </li>

                <!-- Корзина (Мобильный) -->
                <li class="nav-item d-lg-none">
                    <a href="{{-- route('cart.index') --}}" class="nav-link d-flex align-items-center mobile-menu-item">
                        <i class="bi bi-cart3 fs-5 me-2"></i> Корзина
                    </a>
                </li>

                <!-- Переключатель языков (Мобильный) -->
                <li class="nav-item dropdown d-lg-none">
                    <a class="nav-link dropdown-toggle d-flex align-items-center mobile-menu-item" href="#" id="languageDropdownMobile" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-translate fs-5 me-2"></i> Выбрать язык
                    </a>
                    <ul class="dropdown-menu animate slideIn" aria-labelledby="languageDropdownMobile">
                        @foreach ($locales as $localeCode => $properties)
                        <li>
                            <a class="dropdown-item d-flex align-items-center @if($currentLocale == $localeCode) active @endif"
                                href="{{ route('locale.switch', $localeCode) }}">
                                <img src="{{ $properties['flag'] }}" srcset="{{ $properties['flag_srcset'] }}" width="20" alt="{{ $properties['name'] }}" class="me-2">
                                {{ $properties['name'] }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </li>


                <!-- Ссылки/Выпадающее меню аутентификации -->
                @guest
                <li class="nav-item d-lg-none">
                    <hr class="dropdown-divider">
                </li>
                <li class="nav-item">
                    <a href="{{ route('login') }}" class="nav-link {{ request()->routeIs('login') ? 'active' : '' }} mobile-menu-item">
                        <i class="bi bi-box-arrow-in-right fs-5 me-2 d-lg-none"></i>
                        <i class="bi bi-box-arrow-in-right fs-5 me-1 d-none d-lg-inline-flex align-items-center"></i>
                        <span class="ms-1">Войти</span>
                    </a>
                </li>
                @else
                <li class="nav-item d-none d-lg-block ms-lg-2 me-lg-1">
                    <hr class="vr h-100 my-auto app-navbar-vr">
                </li>
                <li class="nav-item d-lg-none">
                    <hr class="dropdown-divider">
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center mobile-menu-item" href="#" id="navbarDropdownUser" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        @php
                        $user = Auth::user();
                        $nameParts = explode(' ', $user->name, 2);
                        $initials = '';
                        if (isset($nameParts[0][0])) {
                        $initials .= strtoupper($nameParts[0][0]);
                        }
                        if (isset($nameParts[1][0])) {
                        $initials .= strtoupper($nameParts[1][0]);
                        } else if (strlen($nameParts[0]) > 1 && !isset($nameParts[1][0])) {
                        // Если только имя и оно длиннее 1 символа, берем 2 первые буквы имени
                        $initials = strtoupper(substr($nameParts[0], 0, 2));
                        }
                        if (empty($initials) && isset($user->email[0])) { // Если имя пустое, берем первую букву email
                        $initials = strtoupper($user->email[0]);
                        }
                        @endphp
                        @if(filter_var($user->profile_photo_url, FILTER_VALIDATE_URL))
                        <img class="rounded-circle me-2 user-avatar" src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}" width="32" height="32">
                        @else
                        <span class="d-inline-flex align-items-center justify-content-center rounded-circle me-2 user-avatar-initials"
                            data-bg-color="{{ \App\Helpers\ColorHelper::stringToColor($user->name) }}">
                            {{ $initials }}
                        </span>
                        @endif
                        <span class="d-none d-lg-inline">{{ $user->name }}</span>
                        <div class="d-lg-none">
                            <div class="fw-medium">{{ $user->name }}</div>
                            <div class="small text-muted">{{ $user->email }}</div>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end animate slideIn" aria-labelledby="navbarDropdownUser">
                        <li class="dropdown-header d-lg-none">@ {{ $user->name }}</li>
                        <li>
                            <h6 class="dropdown-header d-none d-lg-block">Управление аккаунтом</h6>
                        </li>
                        <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="bi bi-person-circle me-2"></i>Профиль</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}" id="logoutForm">
                                @csrf
                                <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logoutForm').submit();">
                                    <i class="bi bi-box-arrow-right me-2"></i>Выйти
                                </a>
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
        padding-top: 0.65rem;
        padding-bottom: 0.65rem;
        transition: background-color 0.3s ease-in-out, border-color 0.3s ease-in-out;
        opacity: 0;
        animation: fadeInNavbar 0.5s ease-out forwards;
        animation-delay: 0.2s;
    }

    @keyframes fadeInNavbar {
        to {
            opacity: 1;
        }
    }

    [data-bs-theme="light"] #appNavbar {
        background-color: var(--bs-light-bg-subtle, #f8f9fa);
        border-bottom: 1px solid var(--bs-border-color-translucent, rgba(0, 0, 0, 0.1));
    }

    [data-bs-theme="dark"] #appNavbar {
        background-color: var(--bs-dark-bg-subtle, #212529);
        border-bottom: 1px solid var(--bs-border-color-translucent, rgba(255, 255, 255, 0.1));
    }

    #appNavbar .navbar-brand span {
        font-weight: 700;
    }

    .app-navbar-vr {
        height: 25px !important;
        border-left: 1px solid rgba(var(--bs-emphasis-color-rgb), 0.1);
        display: inline-block;
        vertical-align: middle;
    }

    .nav-icon-btn {
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        width: 44px;
        height: 44px;
        padding: 0 !important;
        font-size: 1.2rem;
        border-radius: 0.375rem;
        transition: background-color 0.2s ease, color 0.2s ease, transform 0.2s ease;
    }

    .nav-icon-btn:hover {
        background-color: rgba(var(--bs-primary-rgb), 0.1);
        color: var(--bs-primary);
        transform: scale(1.1);
    }

    .nav-icon-btn i {
        line-height: 1;
        transition: transform 0.2s ease;
    }

    .nav-icon-btn:hover i.bi-heart {
        transform: scale(1.2) rotate(-5deg);
    }

    .nav-icon-btn:hover i.bi-cart3 {
        transform: scale(1.15) translateX(-1px);
    }


    #themeTogglerDesktop i,
    #themeTogglerMobile i,
    #languageDropdownDesktop i,
    #languageDropdownMobile i {
        transition: opacity 0.3s ease-in-out, transform 0.3s ease-in-out, color 0.2s ease;
    }

    #themeTogglerDesktop:hover .theme-icon-light,
    #themeTogglerMobile:hover .theme-icon-light {
        color: #f39c12;
        transform: scale(1.15) rotate(15deg);
    }

    #themeTogglerDesktop:hover .theme-icon-dark,
    #themeTogglerMobile:hover .theme-icon-dark {
        color: #745DDC;
        transform: scale(1.15) rotate(-10deg);
    }

    #languageDropdownDesktop:hover i,
    #languageDropdownMobile:hover i,
    #languageDropdownDesktop.show i,
    #languageDropdownMobile.show i {
        color: var(--bs-primary);
        transform: scale(1.15) rotate(5deg);
    }


    .dropdown-menu.animate {
        animation-duration: 0.3s;
        animation-fill-mode: both;
        border-radius: 0.5rem;
        box-shadow: var(--bs-box-shadow-lg);
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

    .navbar-nav .nav-link {
        transition: color 0.2s ease-in-out, background-color 0.2s ease-in-out;
        border-radius: 0.375rem;
        padding: 0.6rem 0.75rem;
        display: flex;
        align-items: center;
    }

    .navbar-nav .nav-link:not(.nav-icon-btn) i {
        margin-right: 0.35rem;
    }


    [data-bs-theme="light"] .navbar-nav .nav-link:hover,
    [data-bs-theme="light"] .navbar-nav .nav-link:focus {
        background-color: rgba(0, 0, 0, 0.04);
        color: var(--bs-primary);
    }

    [data-bs-theme="dark"] .navbar-nav .nav-link:hover,
    [data-bs-theme="dark"] .navbar-nav .nav-link:focus {
        background-color: rgba(255, 255, 255, 0.08);
        color: var(--bs-primary);
    }

    .navbar-nav .nav-link.active,
    .navbar-nav .dropdown-item.active {
        font-weight: 600;
        color: var(--bs-primary) !important;
    }

    [data-bs-theme="light"] .navbar-nav .nav-link.active,
    [data-bs-theme="light"] .navbar-nav .dropdown-item.active {
        background-color: rgba(var(--bs-primary-rgb), 0.1);
    }

    [data-bs-theme="dark"] .navbar-nav .nav-link.active,
    [data-bs-theme="dark"] .navbar-nav .dropdown-item.active {
        background-color: rgba(var(--bs-primary-rgb), 0.2);
    }

    #navbarDropdownUser img.user-avatar,
    #navbarDropdownUser span.user-avatar-initials {
        border: 2px solid transparent;
        transition: border-color 0.2s ease-in-out, transform 0.2s ease;
        object-fit: cover;
    }

    #navbarDropdownUser:hover img.user-avatar,
    #navbarDropdownUser.show img.user-avatar,
    #navbarDropdownUser:hover span.user-avatar-initials,
    #navbarDropdownUser.show span.user-avatar-initials {
        border-color: var(--bs-primary);
        transform: scale(1.05);
    }

    .navbar-toggler {
        border-color: transparent;
    }

    .navbar-toggler:focus {
        box-shadow: 0 0 0 0.2rem rgba(var(--bs-primary-rgb), 0.25);
        border-color: rgba(var(--bs-primary-rgb), 0.25);
    }

    .navbar-toggler-icon {
        transition: transform 0.2s ease-in-out;
    }

    .navbar-toggler[aria-expanded="true"] .navbar-toggler-icon {
        transform: rotate(90deg);
    }

    .nav-link i,
    .dropdown-item i {
        vertical-align: middle;
        width: 1.5em;
    }

    .navbar-nav .dropdown .nav-link .d-lg-none div.small {
        line-height: 1.2;
        font-size: 0.8rem;
    }

    .dropdown-menu .dropdown-header.d-lg-none {
        font-size: 0.9rem;
        color: var(--bs-secondary-color);
    }

    .dropdown-menu .dropdown-item {
        padding: 0.5rem 1rem;
        transition: background-color 0.2s ease, color 0.2s ease;
    }

    .dropdown-menu .dropdown-item img {
        border: 1px solid rgba(0, 0, 0, 0.1);
        border-radius: 2px;
    }

    [data-bs-theme="light"] .dropdown-menu .dropdown-item:active {
        background-color: var(--bs-primary);
        color: #fff;
    }

    [data-bs-theme="dark"] .dropdown-menu .dropdown-item:active {
        background-color: var(--bs-primary);
        color: #fff;
    }

    .navbar-collapse .mobile-menu-item {
        padding: 0.75rem 1rem;
    }

    .navbar-collapse .mobile-menu-item i {
        margin-right: 0.6rem;
    }

    .navbar-collapse .dropdown-divider {
        margin-top: 0.5rem;
        margin-bottom: 0.5rem;
        border-top-color: rgba(var(--bs-emphasis-color-rgb), 0.08);
    }

    .user-avatar-initials {
        width: 32px;
        height: 32px;
        color: white;
        font-weight: 500;
        font-size: 0.85rem;
    }

    .user-avatar-initials[data-bg-color] {
        background-color: var(--bg-color);
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const themeTogglerDesktop = document.getElementById('themeTogglerDesktop');
        const themeTogglerMobile = document.getElementById('themeTogglerMobile');
        const lightIcons = document.querySelectorAll('.theme-icon-light');
        const darkIcons = document.querySelectorAll('.theme-icon-dark');
        const themeTogglerTexts = document.querySelectorAll('.theme-toggler-text');
        const htmlElement = document.documentElement;
        const navbarCollapsibleElement = document.getElementById('navbarSupportedContent');
        const bsCollapseInstance = navbarCollapsibleElement ? new bootstrap.Collapse(navbarCollapsibleElement, {
            toggle: false
        }) : null;

        let isDarkMode = localStorage.getItem('darkMode') === 'true';

        function applyTheme() {
            if (isDarkMode) {
                htmlElement.setAttribute('data-bs-theme', 'dark');
                lightIcons.forEach(icon => icon.style.display = 'none');
                darkIcons.forEach(icon => icon.style.display = 'inline-block');
                themeTogglerTexts.forEach(text => text.textContent = 'Переключить на светлую тему');
            } else {
                htmlElement.setAttribute('data-bs-theme', 'light');
                lightIcons.forEach(icon => icon.style.display = 'inline-block');
                darkIcons.forEach(icon => icon.style.display = 'none');
                themeTogglerTexts.forEach(text => text.textContent = 'Переключить на темную тему');
            }
            localStorage.setItem('darkMode', isDarkMode.toString());
        }

        function toggleDarkMode() {
            isDarkMode = !isDarkMode;
            applyTheme();

            document.body.classList.add('theme-changing');
            setTimeout(() => {
                document.body.classList.remove('theme-changing');
            }, 300);
        }

        if (themeTogglerDesktop) {
            themeTogglerDesktop.addEventListener('click', toggleDarkMode);
        }
        if (themeTogglerMobile) {
            themeTogglerMobile.addEventListener('click', () => {
                toggleDarkMode();
            });
        }

        applyTheme();

        if (navbarCollapsibleElement) {
            navbarCollapsibleElement.addEventListener('show.bs.collapse', function() {
                const items = this.querySelectorAll('.nav-item, .dropdown-divider');
                items.forEach((item, index) => {
                    item.style.opacity = '0';
                    item.style.transform = 'translateY(-10px)';
                    setTimeout(() => {
                        item.style.transition = `opacity 0.2s ease-out ${index * 0.04}s, transform 0.2s ease-out ${index * 0.04}s`;
                        item.style.opacity = '1';
                        item.style.transform = 'translateY(0)';
                    }, 50);
                });
            });
            navbarCollapsibleElement.addEventListener('hide.bs.collapse', function() {
                const items = this.querySelectorAll('.nav-item, .dropdown-divider');
                items.forEach((item) => {
                    item.style.opacity = '0';
                    item.style.transform = 'translateY(-10px)';
                    item.style.removeProperty('transition');
                });
            });
            navbarCollapsibleElement.addEventListener('hidden.bs.collapse', function() {
                const items = this.querySelectorAll('.nav-item, .dropdown-divider');
                items.forEach((item) => {
                    item.style.removeProperty('opacity');
                    item.style.removeProperty('transform');
                });
            });
        }

        document.querySelectorAll('.user-avatar-initials[data-bg-color]').forEach(el => {
            el.style.setProperty('--bg-color', el.dataset.bgColor);
        });
    });
</script>