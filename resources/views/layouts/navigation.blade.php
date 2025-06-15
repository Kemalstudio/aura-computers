      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

      <nav class="navbar navbar-expand-lg sticky-top shadow-sm" id="appNavbar" style="z-index: 2000;">
          <div class="container-fluid">
              <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
                  <x-application-logo class="d-inline-block align-text-top me-2" style="height: 36px; width: auto;" />
                  <span class="fw-bold fs-5 d-none d-md-inline-block">Aura Computers</span>
              </a>

              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
              </button>

              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                  <ul class="navbar-nav me-auto mb-2 mb-lg-0"></ul>

                  <ul class="navbar-nav ms-auto mb-2 mb-lg-0 d-flex align-items-center">
                      <li class="nav-item d-none d-lg-block">
                          <button id="themeTogglerDesktop" type="button" class="btn btn-link nav-link nav-icon-btn" aria-label="">
                              <i class="bi bi-sun-fill theme-icon-light fs-5"></i>
                              <i class="bi bi-moon-stars-fill theme-icon-dark fs-5" style="display: none;"></i>
                          </button>
                      </li>
                      <li class="nav-item d-none d-lg-block">
                          <a href="#" class="nav-link nav-icon-btn position-relative" aria-label="@lang('nav.favorites')">
                              <i class="bi bi-heart fs-5"></i>
                          </a>
                      </li>
                      <li class="nav-item d-none d-lg-block">
                          <a href="#" class="nav-link nav-icon-btn position-relative" aria-label="@lang('nav.cart')">
                              <i class="bi bi-cart3 fs-5"></i>
                          </a>
                      </li>

                      <li class="nav-item dropdown d-none d-lg-block">
                          <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="languageDropdownDesktop" role="button" data-bs-toggle="dropdown" aria-expanded="false" aria-label="@lang('nav.select_language')">
                              <img src="{{ $locales[$currentLocale]['flag'] }}" width="20" alt="{{ $locales[$currentLocale]['name'] }}" class="me-2">
                              <span class="d-none d-xl-inline">{{ $locales[$currentLocale]['name'] }}</span>
                              <span class="d-inline d-xl-none">{{ strtoupper($currentLocale) }}</span>
                          </a>
                          <ul class="dropdown-menu dropdown-menu-end animate slideIn" aria-labelledby="languageDropdownDesktop">
                              @include('partials._language-menu-items')
                          </ul>
                      </li>

                      @guest
                      <li class="nav-item ms-lg-2">
                          <a href="{{ route('login') }}" class="nav-link">@lang('nav.login')</a>
                      </li>
                      @else
                      <li class="nav-item d-none d-lg-block ms-lg-2 me-lg-1">
                          <hr class="vr h-100 my-auto">
                      </li>
                      <li class="nav-item dropdown">
                          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                              {{ Auth::user()->name }}
                          </a>
                          <ul class="dropdown-menu dropdown-menu-end animate slideIn">
                              <li>
                                  <h6 class="dropdown-header">@lang('nav.manage_account')</h6>
                              </li>
                              <li><a class="dropdown-item" href="{{ route('profile.edit') }}">@lang('nav.profile')</a></li>
                              <li>
                                  <hr class="dropdown-divider">
                              </li>
                              <li>
                                  <form method="POST" action="{{ route('logout') }}">
                                      @csrf
                                      <button type="submit" class="dropdown-item text-danger">@lang('nav.logout')</button>
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

          .user-avatar-initials {
              width: 32px;
              height: 32px;
              color: white;
              font-weight: 500;
              font-size: 0.85rem;
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

              const themeStrings = {
                  light: "@lang('nav.switch_theme_dark')",
                  dark: "@lang('nav.switch_theme_light')"
              };

              let isDarkMode = localStorage.getItem('darkMode') === 'true';

              function applyTheme() {
                  if (isDarkMode) {
                      htmlElement.setAttribute('data-bs-theme', 'dark');
                      lightIcons.forEach(icon => icon.style.display = 'none');
                      darkIcons.forEach(icon => icon.style.display = 'inline-block');
                      themeTogglerTexts.forEach(text => text.textContent = themeStrings.dark);
                      if (themeTogglerDesktop) themeTogglerDesktop.setAttribute('aria-label', themeStrings.dark);
                  } else {
                      htmlElement.setAttribute('data-bs-theme', 'light');
                      lightIcons.forEach(icon => icon.style.display = 'inline-block');
                      darkIcons.forEach(icon => icon.style.display = 'none');
                      themeTogglerTexts.forEach(text => text.textContent = themeStrings.light);
                      if (themeTogglerDesktop) themeTogglerDesktop.setAttribute('aria-label', themeStrings.light);
                  }
                  localStorage.setItem('darkMode', isDarkMode.toString());
              }

              function toggleDarkMode() {
                  isDarkMode = !isDarkMode;
                  applyTheme();
              }

              if (themeTogglerDesktop) {
                  themeTogglerDesktop.addEventListener('click', toggleDarkMode);
              }
              if (themeTogglerMobile) {
                  themeTogglerMobile.addEventListener('click', toggleDarkMode);
              }

              applyTheme();
          });
      </script>