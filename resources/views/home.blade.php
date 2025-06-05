@extends('layouts.app')

@section('title', 'Aura Computers')

@push('styles')
<style>
    #heroCarousel {
        max-height: 55vh;
        min-height: 380px;
        max-width: 1400px;
        margin-left: auto;
        margin-right: auto;
        overflow: hidden;
        border-bottom: 4px solid var(--bs-primary);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        position: relative;
        border-radius: 0.75rem;
    }

    .dark #heroCarousel {
        border-bottom-color: var(--bs-primary);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.4);
    }

    .carousel-inner {
        border-radius: inherit;
    }

    .carousel-item {
        height: 55vh;
        min-height: 380px;
        transition: opacity 1s ease-in-out;
        opacity: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        position: relative;
    }

    .carousel-item.active {
        opacity: 1;
    }

    .carousel-item img {
        object-fit: cover;
        width: 100%;
        height: 100%;
        transform: scale(1.15);
        opacity: 0;
        transition: transform 2.5s cubic-bezier(0.22, 0.61, 0.36, 1) 0.2s, opacity 1.2s ease-out 0.2s;
    }

    .carousel-item.active img {
        transform: scale(1);
        opacity: 1;
    }

    .carousel-caption {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: flex-start;
        padding: 3rem 5%;
        text-align: left;
        background: linear-gradient(to right, rgba(0, 0, 0, 0.7) 0%, rgba(0, 0, 0, 0.55) 35%, rgba(0, 0, 0, 0) 75%);
    }

    .dark .carousel-caption {
        background: linear-gradient(to right, rgba(10, 10, 20, 0.75) 0%, rgba(10, 10, 20, 0.6) 35%, rgba(10, 10, 20, 0) 75%);
    }

    .carousel-caption-content {
        max-width: 550px;
    }

    .carousel-caption .carousel-title {
        font-size: clamp(1.8rem, 4.5vw, 3rem);
        font-family: 'Cascadia Code', 'Consolas', monospace;
        font-weight: 700;
        color: #ffffff;
        text-shadow: 0 2px 8px rgba(0, 0, 0, 0.5);
        margin-bottom: 1rem;
        opacity: 0;
        transform: translateY(40px);
        transition: opacity 0.8s ease-out 0.6s, transform 0.8s ease-out 0.6s;
    }

    .carousel-caption .carousel-text {
        font-size: clamp(0.9rem, 2.2vw, 1.15rem);
        font-family: 'Cascadia Code', 'Consolas', monospace;
        margin-bottom: 1.75rem;
        color: #f0f0f0;
        text-shadow: 0 1px 6px rgba(0, 0, 0, 0.4);
        max-width: 500px;
        opacity: 0;
        transform: translateY(40px);
        transition: opacity 0.8s ease-out 0.8s, transform 0.8s ease-out 0.8s;
    }

    .carousel-caption .btn {
        padding: 0.8rem 2.2rem;
        font-family: 'Cascadia Code', 'Consolas', monospace;
        font-size: clamp(0.9rem, 2vw, 1.1rem);
        font-weight: 600;
        border-radius: 8px;
        transition: all 0.3s ease, opacity 0.8s ease-out 1s, transform 0.8s ease-out 1s;
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3);
        text-transform: uppercase;
        letter-spacing: 0.8px;
        opacity: 0;
        transform: translateY(40px);
    }

    .carousel-item.active .carousel-caption .carousel-title,
    .carousel-item.active .carousel-caption .carousel-text,
    .carousel-item.active .carousel-caption .btn {
        opacity: 1;
        transform: translateY(0);
    }

    .carousel-caption .btn-primary {
        background-color: var(--bs-primary);
        border-color: var(--bs-primary);
        color: #fff;
    }

    .carousel-caption .btn:hover {
        transform: translateY(-4px) scale(1.03);
        box-shadow: 0 10px 20px rgba(var(--bs-primary-rgb), 0.5);
    }

    .carousel-indicators {
        bottom: 20px;
    }

    .carousel-indicators [data-bs-target] {
        background-color: rgba(255, 255, 255, 0.5);
        width: 12px;
        height: 12px;
        border-radius: 50%;
        margin: 0 6px;
        border: 1px solid rgba(0, 0, 0, 0.2);
        transition: all 0.4s ease;
    }

    .carousel-indicators .active {
        background-color: var(--bs-primary);
        width: 16px;
        height: 16px;
        border-color: var(--bs-primary);
        transform: scale(1.1);
        box-shadow: 0 0 8px rgba(var(--bs-primary-rgb), 0.7);
    }

    .dark .carousel-indicators [data-bs-target] {
        background-color: rgba(200, 200, 200, 0.4);
        border-color: rgba(255, 255, 255, 0.15);
    }

    .dark .carousel-indicators .active {
        background-color: var(--bs-primary);
        border-color: var(--bs-primary);
    }

    .carousel-control-prev,
    .carousel-control-next {
        width: 50px;
        height: 50px;
        background: rgba(0, 0, 0, 0.25);
        border-radius: 8px;
        opacity: 0.7;
        transition: opacity 0.3s ease, background-color 0.3s ease, transform 0.3s ease;
        top: 50%;
        transform: translateY(-50%);
        margin: 0 1.5rem;
    }

    .carousel-control-prev:hover,
    .carousel-control-next:hover {
        opacity: 1;
        background-color: rgba(var(--bs-primary-rgb), 0.8);
        transform: translateY(-50%) scale(1.05);
    }

    .carousel-control-prev-icon,
    .carousel-control-next-icon {
        background-image: none;
        width: 1.5em;
        height: 1.5em;
        display: inline-block;
        fill: white;
    }

    .product-card {
        transition: transform 0.3s ease, box-shadow 0.35s ease, border-color 0.3s ease;
        border: 1px solid #dee2e6;
        border-radius: 0.5rem;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .product-card .card-body {
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    .product-card .card-footer {
        margin-top: auto;
    }


    .product-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.12);
        border-color: var(--bs-primary);
    }

    .dark .product-card {
        background-color: #1e293b;
        border-color: #374151;
    }

    .dark .product-card:hover {
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.3);
        border-color: var(--bs-primary);
    }

    .product-card .card-img-top {
        aspect-ratio: 4 / 3;
        object-fit: contain;
        padding: 1.5rem;
        background-color: #ffffff;
    }

    .dark .product-card .card-img-top {
        background-color: #374151;
    }

    .product-card .card-title {
        font-size: 1.15rem;
        font-weight: 600;
        min-height: 3.45em;
        margin-bottom: 0.5rem;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .dark .product-card .card-title,
    .dark .product-card .card-text {
        color: #e5e7eb;
    }

    .product-card .card-text {
        font-size: 0.875rem;
        min-height: 3em;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        margin-bottom: 0.75rem;
    }


    .product-card .product-price {
        font-size: 1.3rem;
        font-weight: 700;
        color: var(--bs-primary);
        margin-top: 0.5rem;
        margin-bottom: 1rem;
    }

    .dark .product-card .product-price {
        color: var(--bs-primary);
    }

    .product-card .btn {
        border-radius: 6px;
        font-weight: 500;
    }

    .dark body {
        background-color: #0f172a;
        color: #cbd5e1;
    }

    .dark .bg-body-tertiary {
        background-color: #1e293b !important;
    }

    .scroll-to-top {
        position: fixed;
        bottom: 30px;
        left: 97.3%;
        transform: translateX(-50%);
        width: 50px;
        height: 50px;
        text-align: center;
        color: #fff;
        background: var(--bs-primary);
        line-height: 46px;
        border-radius: 50%;
        z-index: 1040;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.4s ease-in-out, visibility 0s linear 0.4s, transform 0.3s ease-in-out, background-color 0.3s ease-in-out;
    }

    .scroll-to-top.visible {
        opacity: 0.85;
        visibility: visible;
        transition: opacity 0.4s ease-in-out, visibility 0s linear 0s, transform 0.3s ease-in-out, background-color 0.3s ease-in-out;
    }

    .scroll-to-top:hover {
        opacity: 1;
        background: #0b5ed7;
        transform: translateX(-50%) translateY(-3px) scale(1.05);
        box-shadow: 0 6px 16px rgba(var(--bs-primary-rgb), 0.4);
    }

    .scroll-to-top i {
        font-size: 1.8rem;
        position: relative;
        top: 2px;
    }

    .dark .scroll-to-top {
        background: var(--bs-primary);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.4);
    }

    .dark .scroll-to-top:hover {
        background: #0a58ca;
    }

    .product-tabs-nav {
        justify-content: center;
        margin-bottom: 2.5rem;
        border-bottom: 1px solid #dee2e6;
        /* Более тонкая общая линия */
    }

    .dark .product-tabs-nav {
        border-bottom-color: #374151;
    }

    .product-tabs-nav .nav-item {
        margin-bottom: -1px;
        /* Чтобы активная рамка перекрывала общую */
    }

    .product-tabs-nav .nav-link {
        color: #6c757d;
        /* Менее насыщенный цвет для неактивных */
        font-weight: 500;
        /* Чуть менее жирный */
        font-size: 1.1rem;
        /* Немного уменьшил для баланса */
        padding: 0.75rem 1.5rem;
        border: 1px solid transparent;
        border-top-left-radius: .375rem;
        border-top-right-radius: .375rem;
        transition: color 0.2s ease, background-color 0.2s ease, border-color 0.2s ease;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        position: relative;
    }

    .dark .product-tabs-nav .nav-link {
        color: #adb5bd;
    }

    .product-tabs-nav .nav-link:hover {
        color: var(--bs-primary);
        border-color: #e9ecef #e9ecef #dee2e6;
        /* Рамка при наведении */
        background-color: #f8f9fa;
        /* Легкий фон при наведении */
    }

    .dark .product-tabs-nav .nav-link:hover {
        color: var(--bs-primary);
        border-color: #374151 #374151 #374151;
        background-color: #2c3648;
    }

    .product-tabs-nav .nav-link.active {
        color: var(--bs-primary);
        font-weight: 600;
        /* Более жирный для активного */
        background-color: #fff;
        /* Фон совпадает с фоном страницы */
        border-color: #dee2e6 #dee2e6 #fff;
        /* Рамка активного таба, нижняя часть прозрачна (белая) */
        border-bottom: 3px solid var(--bs-primary);
        /* Яркая линия снизу для активного */
        box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.05);
        /* Легкая тень сверху */
    }

    .dark .product-tabs-nav .nav-link.active {
        background-color: #161f31;
        /* Фон совпадает с темным фоном страницы */
        border-color: #374151 #374151 #161f31;
        color: var(--bs-primary);
        box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.15);
    }

    .product-tabs-nav .nav-link .bi {
        margin-right: 0.4rem;
        font-size: 1em;
        /* Размер иконки относительно текста */
    }


    @media (max-width: 1450px) {
        #heroCarousel {
            max-width: 95%;
            border-radius: 0.5rem;
        }

        .carousel-control-prev {
            margin-left: 1rem;
        }

        .carousel-control-next {
            margin-right: 1rem;
        }
    }

    @media (max-width: 991.98px) {
        #heroCarousel {
            max-height: 50vh;
            min-height: 350px;
            border-radius: 0.375rem;
        }

        .carousel-item {
            height: 50vh;
            min-height: 350px;
        }

        .carousel-caption {
            padding: 2rem 4%;
            background: linear-gradient(to right, rgba(0, 0, 0, 0.8) 0%, rgba(0, 0, 0, 0.65) 45%, rgba(0, 0, 0, 0) 85%);
        }

        .dark .carousel-caption {
            background: linear-gradient(to right, rgba(10, 10, 20, 0.85) 0%, rgba(10, 10, 20, 0.7) 45%, rgba(10, 10, 20, 0) 85%);
        }

        .carousel-caption .carousel-title {
            font-size: clamp(1.6rem, 4vw, 2.5rem);
        }

        .carousel-caption .carousel-text {
            font-size: clamp(0.85rem, 2vw, 1.05rem);
        }

        .carousel-caption-content {
            max-width: 80%;
        }
    }

    @media (max-width: 767.98px) {
        #heroCarousel {
            max-height: 45vh;
            min-height: 320px;
            margin-left: 10px;
            margin-right: 10px;
            max-width: calc(100% - 20px);
            border-radius: 0.25rem;
        }

        .carousel-item {
            height: 45vh;
            min-height: 320px;
        }

        .carousel-caption {
            padding: 1.5rem 5%;
            align-items: center;
            text-align: center;
            background: rgba(0, 0, 0, 0.6);
        }

        .dark .carousel-caption {
            background: rgba(10, 10, 20, 0.7);
        }

        .carousel-caption-content {
            max-width: 100%;
        }

        .carousel-caption .carousel-title {
            font-size: clamp(1.4rem, 5.5vw, 2rem);
        }

        .carousel-caption .carousel-text {
            font-size: clamp(0.8rem, 3vw, 1rem);
            margin-bottom: 1.25rem;
        }

        .carousel-caption .btn {
            padding: 0.7rem 1.8rem;
            font-size: clamp(0.8rem, 2.5vw, 1rem);
        }

        .carousel-control-prev,
        .carousel-control-next {
            width: 40px;
            height: 40px;
            margin: 0 0.5rem;
        }

        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            width: 1.2em;
            height: 1.2em;
        }

        .carousel-indicators {
            bottom: 10px;
        }

        .carousel-indicators [data-bs-target] {
            width: 10px;
            height: 10px;
            margin: 0 4px;
        }

        .carousel-indicators .active {
            width: 12px;
            height: 12px;
        }

        .product-tabs-nav .nav-link {
            font-size: 0.9rem;
            padding: 0.6rem 0.8rem;
        }

        .product-tabs-nav .nav-link .bi {
            margin-right: 0.25rem;
        }

        .scroll-to-top {
            width: 40px;
            height: 40px;
            line-height: 38px;
        }

        .scroll-to-top i {
            font-size: 1.5rem;
        }
    }
</style>
@endpush

@section('content')
<section style="margin-top: 60px;" id="heroCarousel" class="carousel slide carousel-fade mb-5" data-bs-ride="carousel" data-bs-interval="3000">
    <div class="carousel-indicators"> <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" aria-label="Slide 1" class="active" aria-current="true"></button> <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button> <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button> </div>
    <div class="carousel-inner">
        <div class="carousel-item active"> <img src="https://images.unsplash.com/photo-1593640408182-31c70c8268f5?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1770&q=80" alt="Мощный игровой ПК">
            <div class="carousel-caption">
                <div class="carousel-caption-content">
                    <h2 class="carousel-title">Мощные Игровые Миры Ждут Вас</h2>
                    <p class="carousel-text d-none d-md-block">Создайте свой идеальный игровой ПК с лучшими компонентами и производительностью.</p> <a href="{{ route('catalog.index', ['category' => 'gaming-pc']) }}" class="btn btn-primary">Собрать Свой ПК <i class="bi bi-tools ms-1"></i></a>
                </div>
            </div>
        </div>
        <div class="carousel-item"> <img src="https://images.unsplash.com/photo-1587831990711-23ca6441447b?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1631&q=80" alt="Комплектующие для ПК">
            <div class="carousel-caption">
                <div class="carousel-caption-content">
                    <h2 class="carousel-title">Сердце Вашего Компьютера</h2>
                    <p class="carousel-text d-none d-md-block">Откройте для себя широкий выбор комплектующих для апгрейда или сборки с нуля.</p> <a href="{{ route('catalog.index', ['category' => 'components']) }}" class="btn btn-primary">Выбрать Компоненты <i class="bi bi-cpu-fill ms-1"></i></a>
                </div>
            </div>
        </div>
        <div class="carousel-item"> <img src="https://images.unsplash.com/photo-1550439062-609e1531270e?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1770&q=80" alt="Аксессуары для геймеров">
            <div class="carousel-caption">
                <div class="carousel-caption-content">
                    <h2 class="carousel-title">Точность и Комфорт в Каждой Игре</h2>
                    <p class="carousel-text d-none d-md-block">Лучшие игровые аксессуары для полного погружения и максимального контроля.</p> <a href="{{ route('catalog.index', ['category' => 'peripherals']) }}" class="btn btn-primary">Подобрать Аксессуары <i class="bi bi-keyboard ms-1"></i></a>
                </div>
            </div>
        </div>
    </div> <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev"> <svg class="carousel-control-prev-icon" viewBox="0 0 16 16">
            <path d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z" />
        </svg> <span class="visually-hidden">Previous</span> </button> <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next"> <svg class="carousel-control-next-icon" viewBox="0 0 16 16">
            <path d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z" />
        </svg> <span class="visually-hidden">Next</span> </button>
</section>

<div class="container mt-5 pt-md-4 mb-5">
    <ul class="nav nav-tabs product-tabs-nav" id="productTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="featured-tab" data-bs-toggle="tab" data-bs-target="#featured-tab-pane" type="button" role="tab" aria-controls="featured-tab-pane" aria-selected="true">
                <i class="bi bi-star-fill"></i> Рекомендуемые
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="new-tab" data-bs-toggle="tab" data-bs-target="#new-tab-pane" type="button" role="tab" aria-controls="new-tab-pane" aria-selected="false">
                <i class="bi bi-brightness-high-fill"></i> Новые
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="popular-tab" data-bs-toggle="tab" data-bs-target="#popular-tab-pane" type="button" role="tab" aria-controls="popular-tab-pane" aria-selected="false">
                <i class="bi bi-graph-up-arrow"></i> Популярные
            </button>
        </li>
    </ul>

    <div class="tab-content pt-4" id="productTabsContent">
        <div class="tab-pane fade show active" id="featured-tab-pane" role="tabpanel" aria-labelledby="featured-tab" tabindex="0">
            @if(isset($featuredProducts) && $featuredProducts->isNotEmpty())
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
                @foreach($featuredProducts as $product)
                @include('catalog.partials.product_card', ['product' => $product])
                @endforeach
            </div>
            @else
            <p class="text-center text-muted py-5">Рекомендуемых товаров пока нет.</p>
            @endif
        </div>

        <div class="tab-pane fade" id="new-tab-pane" role="tabpanel" aria-labelledby="new-tab" tabindex="0">
            @if(isset($newProducts) && $newProducts->isNotEmpty())
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
                @foreach($newProducts as $product)
                @include('catalog.partials.product_card', ['product' => $product])
                @endforeach
            </div>
            @else
            <p class="text-center text-muted py-5">Новых товаров пока нет.</p>
            @endif
        </div>

        <div class="tab-pane fade" id="popular-tab-pane" role="tabpanel" aria-labelledby="popular-tab" tabindex="0">
            @if(isset($popularProducts) && $popularProducts->isNotEmpty())
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
                @foreach($popularProducts as $product)
                @include('catalog.partials.product_card', ['product' => $product])
                @endforeach
            </div>
            @else
            <p class="text-center text-muted py-5">Раздел "Популярные товары" скоро появится!</p>
            @endif
        </div>
    </div>
</div>

<a href="#" class="scroll-to-top d-flex align-items-center justify-content-center">
    <i class="bi bi-arrow-up-short"></i>
</a>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var heroCarousel = document.getElementById('heroCarousel');
        if (heroCarousel) {
            var carousel = new bootstrap.Carousel(heroCarousel);
        }

        const scrollToTopButton = document.querySelector('.scroll-to-top');
        const scrollThreshold = window.innerHeight * 0.8;

        if (scrollToTopButton) {
            window.addEventListener('scroll', () => {
                if (window.scrollY > scrollThreshold) {
                    scrollToTopButton.classList.add('visible');
                } else {
                    scrollToTopButton.classList.remove('visible');
                }
            });

            scrollToTopButton.addEventListener('click', (e) => {
                e.preventDefault();
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
        }

        const productTabs = document.querySelectorAll('#productTabs button[data-bs-toggle="tab"]');
        const activeTabKey = 'activeProductHomePageTab';

        productTabs.forEach(tab => {
            tab.addEventListener('shown.bs.tab', event => {
                localStorage.setItem(activeTabKey, event.target.id);
            });
        });

        const storedActiveTabId = localStorage.getItem(activeTabKey);
        if (storedActiveTabId) {
            const tabToActivate = document.getElementById(storedActiveTabId);
            if (tabToActivate) {
                const tab = new bootstrap.Tab(tabToActivate);
                tab.show();
            }
        }
    });
</script>
@endpush