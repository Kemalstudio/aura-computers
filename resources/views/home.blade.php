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

    .product-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.12);
        border-color: var(--bs-primary);
    }

    .product-card .card-body {
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    .product-card .card-footer {
        margin-top: auto;
    }

    .dark .product-card {
        background-color: #1e293b;
        border-color: #374151;
    }

    .dark .product-card:hover {
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.3);
        border-color: var(--bs-primary);
    }

    .product-card .card-img-top-wrapper {
        aspect-ratio: 4 / 3;
        padding: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #ffffff;
        border-top-left-radius: inherit;
        border-top-right-radius: inherit;
    }

    .product-card .card-img-top {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }

    .dark .product-card .card-img-top-wrapper {
        background-color: #374151;
    }

    .product-card .card-title {
        font-size: 1.1rem;
        font-weight: 600;
        min-height: 3.3em;
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
        min-height: 2.6em;
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

    .product-category-section .section-title {
        font-size: 1.8rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin: 0;
        padding-bottom: 0.5rem;
        border-bottom: 3px solid var(--bs-primary);
    }

    .dark body {
        background-color: #0f172a;
        color: #cbd5e1;
    }

    .scroll-to-top {
        position: fixed;
        bottom: 30px;
        right: 30px;
        width: 50px;
        height: 50px;
        text-align: center;
        color: #fff;
        background: #0d6efd;
        line-height: 46px;
        border-radius: 50%;
        z-index: 1040;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        opacity: 0;
        visibility: hidden;
        transition: all 0.4s ease;
    }

    .scroll-to-top.visible {
        opacity: 0.85;
        visibility: visible;
    }

    .scroll-to-top:hover {
        opacity: 1;
        transform: translateY(-3px) scale(1.05);
    }

    .scroll-to-top i {
        font-size: 1.8rem;
        position: relative;
        top: 2px;
    }

    .reviews-section {
        background-color: var(--bs-tertiary-bg);
        padding: 4rem 0;
        margin-top: 3rem;
        overflow: hidden;
    }

    .reviews-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .reviews-header h2 {
        font-size: 2rem;
        font-weight: 700;
        color: var(--bs-body-color);
        display: inline-block;
        padding-bottom: 0.5rem;
        border-bottom: 3px solid var(--bs-primary);
        text-transform: uppercase;
        letter-spacing: 1px;
        margin: 0;
    }

    .reviews-section .slider-nav button {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        background-color: #fff;
        color: var(--bs-primary);
        border: 1px solid #dee2e6;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        font-size: 1.2rem;
        transition: all 0.3s ease;
    }

    .reviews-section .slider-nav button:hover {
        background-color: var(--bs-primary);
        border-color: var(--bs-primary);
        color: #fff;
        transform: scale(1.1);
    }

    .reviews-section .slider-nav button:disabled {
        opacity: 0.5;
        cursor: not-allowed;
        background-color: #e9ecef;
        color: #6c757d;
        border-color: #dee2e6;
    }

    .reviews-section .slider-nav button:not(:last-child) {
        margin-right: 0.5rem;
    }

    .slider-track {
        display: flex;
        transition: transform 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        gap: 2rem;
    }

    .dark .reviews-section {
        background-color: #0c1422;
    }

    .dark .reviews-section .slider-nav button {
        background-color: #1e293b;
        color: var(--bs-primary);
        border-color: #374151;
    }

    .dark .reviews-section .slider-nav button:hover {
        background-color: var(--bs-primary);
        color: #fff;
    }

    .dark .reviews-section .slider-nav button:disabled {
        background-color: #161f31;
        color: #475569;
        border-color: #374151;
    }

    .product-review-card {
        flex: 0 0 calc(50% - 1rem);
        background-color: var(--bs-body-bg);
        padding: 2rem;
        border-radius: 0.75rem;
        border: 1px solid var(--bs-border-color);
        position: relative;
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }

    .product-review-card::after {
        content: '”';
        position: absolute;
        bottom: -15px;
        right: 15px;
        font-size: 8rem;
        font-family: Georgia, serif;
        color: var(--bs-tertiary-bg);
        line-height: 1;
        z-index: 1;
    }

    .product-review-card-header {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        margin-bottom: 1.5rem;
        position: relative;
        z-index: 2;
    }

    .product-review-product-img {
        width: 80px;
        height: 80px;
        object-fit: contain;
        border-radius: 0.5rem;
        background-color: #fff;
        border: 1px solid var(--bs-border-color);
        padding: 5px;
        flex-shrink: 0;
    }

    .product-review-product-info h5 {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--bs-body-color);
        margin-bottom: 0.25rem;
    }

    .product-review-rating {
        color: #fec923;
        margin-bottom: 0.35rem;
    }

    .product-review-author {
        font-size: 0.85rem;
        color: var(--bs-secondary-color);
    }

    .product-review-text {
        font-size: 1rem;
        color: var(--bs-body-color);
        line-height: 1.6;
        position: relative;
        z-index: 2;
        flex-grow: 1;
    }

    .dark .product-review-card {
        background-color: #1e293b;
        border-color: #374151;
    }

    .dark .product-review-card::after {
        color: rgba(255, 255, 255, 0.03);
    }

    .dark .product-review-product-img {
        background-color: #374151;
        border-color: #4b5563;
    }

    .store-review-card {
        flex: 0 0 calc(50% - 1rem);
        background-color: var(--bs-body-bg);
        padding: 2rem;
        border-radius: 0.75rem;
        border: 1px solid var(--bs-border-color);
        position: relative;
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }

    .store-review-card::after {
        content: '”';
        position: absolute;
        bottom: -15px;
        right: 15px;
        font-size: 8rem;
        font-family: Georgia, serif;
        color: var(--bs-tertiary-bg);
        line-height: 1;
        z-index: 1;
    }

    .store-review-card-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .store-review-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background-color: #e9ecef;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #adb5bd;
        font-size: 1.5rem;
        flex-shrink: 0;
    }

    .store-review-user-info .name {
        font-weight: 600;
        font-size: 1.1rem;
        color: var(--bs-body-color);
    }

    .store-review-user-info .date {
        font-size: 0.85rem;
        color: var(--bs-secondary-color);
    }

    .store-review-rating {
        color: #fec923;
        margin-left: auto;
    }

    .store-review-text {
        color: var(--bs-body-color);
        line-height: 1.6;
        position: relative;
        z-index: 2;
        flex-grow: 1;
        margin-bottom: 1.5rem;
    }

    .store-review-admin-reply {
        background-color: #e9f5e9;
        padding: 1rem;
        border-radius: 0.5rem;
        font-size: 0.95rem;
        color: #3d523d;
        z-index: 2;
        position: relative;
    }

    .dark .store-review-card {
        background-color: #1e293b;
        border-color: #374151;
    }

    .dark .store-review-card::after {
        color: rgba(255, 255, 255, 0.03);
    }

    .dark .store-review-avatar {
        background-color: #374151;
        color: #9ca3af;
    }

    .dark .store-review-admin-reply {
        background-color: #1c3b2f;
        color: #a3e635;
    }

    @media (max-width: 991.98px) {

        .product-review-card,
        .store-review-card {
            flex: 0 0 calc(50% - 1rem);
        }
    }

    @media (max-width: 767.98px) {

        .product-review-card,
        .store-review-card {
            flex: 0 0 100%;
        }

        .reviews-header h2 {
            font-size: 1.5rem;
        }
    }

    .rating-stars {
        display: inline-flex;
        flex-direction: row-reverse;
        justify-content: flex-end;
    }

    .rating-stars .bi-star-fill {
        font-size: 1.75rem;
        color: #d1d5db;
        cursor: pointer;
        transition: color 0.2s ease-in-out;
        padding: 0 0.15rem;
    }

    .rating-stars:hover .bi-star-fill {
        color: #fec923 !important;
    }

    .rating-stars .bi-star-fill:hover~.bi-star-fill {
        color: #d1d5db !important;
    }

    .rating-stars[data-rating="0"] .bi-star-fill {
        color: #d1d5db;
    }

    .rating-stars[data-rating="1"] .bi-star-fill:nth-child(n+5),
    .rating-stars[data-rating="2"] .bi-star-fill:nth-child(n+4),
    .rating-stars[data-rating="3"] .bi-star-fill:nth-child(n+3),
    .rating-stars[data-rating="4"] .bi-star-fill:nth-child(n+2),
    .rating-stars[data-rating="5"] .bi-star-fill:nth-child(n+1) {
        color: #fec923;
    }

    .dark .modal-content {
        background-color: #1e293b;
    }

    .dark .modal-content .form-control {
        background-color: #374151;
        border-color: #4b5563;
        color: #e5e7eb;
    }

    .dark .modal-content .form-control:focus {
        background-color: #374151;
        border-color: var(--bs-primary);
        color: #e5e7eb;
    }

    .dark .rating-stars .bi-star-fill {
        color: #4b5563;
    }

    .dark .rating-stars:hover .bi-star-fill {
        color: #fec923 !important;
    }

    .dark .rating-stars .bi-star-fill:hover~.bi-star-fill {
        color: #4b5563 !important;
    }

    .product-search-wrapper {
        position: relative;
    }

    .product-autocomplete-results {
        display: none;
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background-color: var(--bs-body-bg);
        border: 1px solid var(--bs-border-color);
        border-top: none;
        border-radius: 0 0 .375rem .375rem;
        z-index: 1056;
        max-height: 200px;
        overflow-y: auto;
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
    }

    .product-autocomplete-results ul {
        list-style: none;
        margin: 0;
        padding: 0.5rem 0;
    }

    .product-autocomplete-results li {
        padding: 0.5rem 1rem;
        cursor: pointer;
        transition: background-color 0.2s ease;
    }

    .product-autocomplete-results li:hover,
    .product-autocomplete-results li.active {
        background-color: var(--bs-primary);
        color: #fff;
    }

    .product-autocomplete-results li.no-results {
        cursor: default;
        color: var(--bs-secondary-color);
    }

    .product-autocomplete-results li.no-results:hover {
        background-color: transparent;
        color: var(--bs-secondary-color);
    }

    .dark .product-autocomplete-results li.active {
        background-color: var(--bs-primary);
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
                    <p class="carousel-text d-none d-md-block">Создайте свой идеальный игровой ПК с лучшими компонентами и производительностью.</p> <a href="{{ route('catalog.index', ['category' => 'pc-components']) }}" class="btn btn-primary">Собрать Свой ПК <i class="bi bi-tools ms-1"></i></a>
                </div>
            </div>
        </div>
        <div class="carousel-item"> <img src="https://images.unsplash.com/photo-1587831990711-23ca6441447b?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1631&q=80" alt="Комплектующие для ПК">
            <div class="carousel-caption">
                <div class="carousel-caption-content">
                    <h2 class="carousel-title">Сердце Вашего Компьютера</h2>
                    <p class="carousel-text d-none d-md-block">Откройте для себя широкий выбор комплектующих для апгрейда или сборки с нуля.</p> <a href="{{ route('catalog.index', ['category' => 'pc-components']) }}" class="btn btn-primary">Выбрать Компоненты <i class="bi bi-cpu-fill ms-1"></i></a>
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

{{-- ========================================================= --}}
{{-- ============= НАЧАЛО НОВОГО БЛОКА КАТЕГОРИЙ ============= --}}
{{-- ========================================================= --}}

<div class="container mt-5">
    @if(isset($categoriesWithProducts) && !empty($categoriesWithProducts))
    @foreach ($categoriesWithProducts as $data)
    <section class="product-category-section mb-5 pb-md-3">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="section-title">{{ $data['category']->name }}</h2>
            {{-- Ссылка "Смотреть все" ведет на страницу каталога с фильтром по этой родительской категории --}}
            <a href="{{ route('catalog.index', ['category' => $data['category']->slug]) }}" class="btn btn-outline-primary d-none d-sm-inline-flex">
                Смотреть все <i class="bi bi-arrow-right-short ms-1"></i>
            </a>
        </div>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
            @foreach ($data['products'] as $product)
            @include('catalog.partials.product_card', ['product' => $product])
            @endforeach
        </div>
        <div class="d-sm-none text-center mt-4">
            <a href="{{ route('catalog.index', ['category' => $data['category']->slug]) }}" class="btn btn-primary">
                Смотреть все {{ $data['category']->name }}
            </a>
        </div>
    </section>
    @endforeach
    @else
    <div class="text-center py-5">
        <p class="text-muted fs-4">Товары скоро появятся!</p>
        <p>Мы активно работаем над наполнением каталога.</p>
    </div>
    @endif
</div>

{{-- ========================================================= --}}
{{-- ============== КОНЕЦ НОВОГО БЛОКА КАТЕГОРИЙ ============== --}}
{{-- ========================================================= --}}


<section class="reviews-section" id="product-reviews-section">
    <div class="container">
        <div class="reviews-header">
            <h2>Отзывы о товарах</h2>
            <div class="d-flex align-items-center">
                <div class="slider-nav">
                    <button class="btn btn-slider-nav prev-btn" aria-label="Предыдущий отзыв"><i class="bi bi-chevron-left"></i></button>
                    <button class="btn btn-slider-nav next-btn" aria-label="Следующий отзыв"><i class="bi bi-chevron-right"></i></button>
                </div>
                <button type="button" class="btn btn-primary ms-lg-4 ms-3" data-bs-toggle="modal" data-bs-target="#productReviewModal"><i class="bi bi-pencil-square me-1"></i> Написать отзыв</button>
            </div>
        </div>
        <div class="slider-viewport product-reviews-slider-viewport">
            <div class="slider-track product-reviews-slider-track">
                @forelse ($productReviews ?? [] as $review)
                <div class="product-review-card">
                    <div class="product-review-card-header">
                        <img src="{{ $review->product->thumbnail_url ?? 'https://placehold.co/160x160/ffffff/000000?text=IMG' }}" alt="{{ $review->product->name ?? 'Изображение товара' }}" class="product-review-product-img">
                        <div class="product-review-product-info">
                            <h5>{{ $review->product->name ?? 'Название товара' }}</h5>
                            <div class="product-review-rating">
                                @for ($i = 1; $i <= 5; $i++)
                                    <i class="bi {{ $i <= $review->rating ? 'bi-star-fill' : 'bi-star' }}"></i>
                                    @endfor
                            </div>
                            <span class="product-review-author">{{ $review->name ?? 'Аноним' }} · {{ $review->created_at->format('d M Y') }}</span>
                        </div>
                    </div>
                    <p class="product-review-text">{{ $review->text }}</p>
                </div>
                @empty
                <div class="w-100 text-center py-5">
                    <p class="text-muted">Отзывов о товарах пока нет. Будьте первым!</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</section>

<section class="reviews-section" id="store-reviews-section">
    <div class="container">
        <div class="reviews-header">
            <h2>Отзывы о магазине</h2>
            <div class="d-flex align-items-center">
                <div class="slider-nav">
                    <button class="btn btn-slider-nav prev-btn" aria-label="Предыдущий отзыв"><i class="bi bi-chevron-left"></i></button>
                    <button class="btn btn-slider-nav next-btn" aria-label="Следующий отзыв"><i class="bi bi-chevron-right"></i></button>
                </div>
                <button type="button" class="btn btn-primary ms-lg-4 ms-3" data-bs-toggle="modal" data-bs-target="#storeReviewModal"><i class="bi bi-pencil-square me-1"></i> Написать отзыв</button>
            </div>
        </div>
        <div class="slider-viewport store-reviews-slider-viewport">
            <div class="slider-track store-reviews-slider-track">
                @forelse ($storeReviews ?? [] as $review)
                <div class="store-review-card">
                    <div class="store-review-card-header">
                        <div class="store-review-avatar"><i class="bi bi-person-fill"></i></div>
                        <div class="store-review-user-info">
                            <div class="name">{{ $review->name }}</div>
                            <div class="date">{{ $review->created_at->translatedFormat('d F Y H:i') }}</div>
                        </div>
                        <div class="store-review-rating">
                            @for ($i = 1; $i <= 5; $i++)
                                <i class="bi bi-star-fill" style="color: {{ $i <= $review->rating ? '#fec923' : '#dee2e6' }};"></i>
                                @endfor
                        </div>
                    </div>
                    <p class="store-review-text">{{ $review->text }}</p>
                    @if ($review->admin_reply)
                    <div class="store-review-admin-reply">{{ $review->admin_reply }}</div>
                    @endif
                </div>
                @empty
                <div class="w-100 text-center py-5">
                    <p class="text-muted">Отзывов о магазине пока нет. Будьте первым!</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</section>

{{-- === МОДАЛЬНОЕ ОКНО ДЛЯ ОТЗЫВА О ТОВАРЕ === --}}
<div class="modal fade" id="productReviewModal" tabindex="-1" aria-labelledby="productReviewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="productReviewModalLabel">Оставить отзыв о товаре</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="productReviewForm" action="" method="POST" novalidate>
                    @csrf
                    <div class="alert alert-danger d-none"></div>
                    <div class="mb-3">
                        <label for="productReviewName" class="form-label">Ваше имя</label>
                        <input type="text" class="form-control" id="productReviewName" name="name" required value="{{ auth()->user()->name ?? '' }}" placeholder="Представьтесь, пожалуйста">
                    </div>
                    <div class="mb-3">
                        <label for="productNameInput" class="form-label">Название товара</label>
                        <div class="product-search-wrapper">
                            <input type="text" class="form-control" id="productNameInput" name="product_name" required placeholder="Начните вводить название товара..." autocomplete="off">
                            <div id="productAutocompleteResults" class="product-autocomplete-results"></div>
                        </div>
                        <input type="hidden" name="product_id" id="productIdInput" value="">
                    </div>
                    <div class="mb-3">
                        <label for="productReviewText" class="form-label">Ваш отзыв</label>
                        <textarea class="form-control" id="productReviewText" name="text" rows="4" required placeholder="Поделитесь вашими впечатлениями о товаре..."></textarea>
                    </div>
                    <div class="mb-4">
                        <label class="form-label d-block">Оценка товара</label>
                        <div class="rating-stars" data-rating="0" id="productReviewRating">
                            <i class="bi bi-star-fill" data-value="5"></i><i class="bi bi-star-fill" data-value="4"></i><i class="bi bi-star-fill" data-value="3"></i><i class="bi bi-star-fill" data-value="2"></i><i class="bi bi-star-fill" data-value="1"></i>
                        </div>
                        <input type="hidden" name="rating" id="productRatingInput" value="0" required>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary" disabled>Отправить отзыв</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="storeReviewModal" tabindex="-1" aria-labelledby="storeReviewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="storeReviewModalLabel">Оставить отзыв о магазине</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="storeReviewForm" action="{{ route('store-reviews.store') }}" method="POST" novalidate>
                    @csrf
                    <div class="alert alert-danger d-none"></div>
                    <div class="mb-3">
                        <label for="storeReviewName" class="form-label">Ваше имя и фамилия</label>
                        <input type="text" class="form-control" id="storeReviewName" name="name" required value="{{ auth()->user()->name ?? '' }}" placeholder="Представьтесь, пожалуйста">
                    </div>
                    <div class="mb-3">
                        <label for="storeReviewText" class="form-label">Ваш отзыв</label>
                        <textarea class="form-control" id="storeReviewText" name="text" rows="4" required placeholder="Поделитесь вашими впечатлениями..."></textarea>
                    </div>
                    <div class="mb-4">
                        <label class="form-label d-block">Ваша оценка</label>
                        <div class="rating-stars" data-rating="0" id="storeReviewRating">
                            <i class="bi bi-star-fill" data-value="5"></i><i class="bi bi-star-fill" data-value="4"></i><i class="bi bi-star-fill" data-value="3"></i><i class="bi bi-star-fill" data-value="2"></i><i class="bi bi-star-fill" data-value="1"></i>
                        </div>
                        <input type="hidden" name="rating" id="storeRatingInput" value="0" required>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Отправить отзыв</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- === TOAST-УВЕДОМЛЕНИЕ И КНОПКА "НАВЕРХ" === --}}
<div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1080">
    <div id="reviewToast" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body"></div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>
<a href="#" class="scroll-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
@endsection

@push('scripts')
<script>
    // Весь ваш JS код для слайдеров, модальных окон и т.д. остается здесь без изменений
    document.addEventListener('DOMContentLoaded', function() {
        // ... ваш код для инициализации слайдеров остается без изменений ...
        // ... initializeSlider, sliderInitializers и т.д. ...
        const sliderInitializers = {};

        function initializeSlider(containerSelector) {
            const container = document.querySelector(containerSelector);
            if (!container) return;
            const track = container.querySelector('.slider-track');
            const prevBtn = container.querySelector('.prev-btn');
            const nextBtn = container.querySelector('.next-btn');
            if (!track || !prevBtn || !nextBtn || (track.children.length <= 1 && !track.querySelector('.store-review-card, .product-review-card'))) {
                if (prevBtn) prevBtn.disabled = true;
                if (nextBtn) nextBtn.disabled = true;
                return;
            }
            let state = {
                currentIndex: 0,
                itemsPerPage: window.innerWidth >= 768 ? 2 : 1,
                totalItems: track.children.length,
                gap: parseFloat(window.getComputedStyle(track).gap) || 32
            };

            function updateSlider() {
                if (track.children.length === 0) {
                    if (prevBtn) prevBtn.disabled = true;
                    if (nextBtn) nextBtn.disabled = true;
                    return;
                }
                state.totalItems = track.children.length;
                const maxIndex = Math.max(0, state.totalItems - state.itemsPerPage);
                prevBtn.disabled = state.currentIndex === 0;
                nextBtn.disabled = state.currentIndex >= maxIndex;
                state.currentIndex = Math.max(0, Math.min(state.currentIndex, maxIndex));
                const cardWidth = track.children[0].offsetWidth;
                const offset = state.currentIndex * (cardWidth + state.gap);
                track.style.transform = `translateX(-${offset}px)`;
            }
            const handleResize = () => {
                const newItemsPerPage = window.innerWidth >= 768 ? 2 : 1;
                if (newItemsPerPage !== state.itemsPerPage) {
                    state.itemsPerPage = newItemsPerPage;
                    updateSlider();
                }
            };
            nextBtn.addEventListener('click', () => {
                const maxIndex = Math.max(0, state.totalItems - state.itemsPerPage);
                if (state.currentIndex < maxIndex) {
                    state.currentIndex++;
                    updateSlider();
                }
            });
            prevBtn.addEventListener('click', () => {
                if (state.currentIndex > 0) {
                    state.currentIndex--;
                    updateSlider();
                }
            });
            window.addEventListener('resize', handleResize);
            setTimeout(updateSlider, 150);
            sliderInitializers[containerSelector] = {
                update: () => {
                    state.totalItems = track.children.length;
                    updateSlider();
                },
                reset: () => {
                    state.currentIndex = 0;
                    state.totalItems = track.children.length;
                    updateSlider();
                }
            };
        }
        initializeSlider('#product-reviews-section');
        initializeSlider('#store-reviews-section');

        const reviewToastEl = document.getElementById('reviewToast');
        const reviewToast = reviewToastEl ? new bootstrap.Toast(reviewToastEl) : null;

        function setupReviewForm(modalId) {
            const modalEl = document.getElementById(modalId);
            if (!modalEl) return;

            const modal = new bootstrap.Modal(modalEl);
            const form = modalEl.querySelector('form');
            const ratingStarsContainer = modalEl.querySelector('.rating-stars');
            const ratingInput = modalEl.querySelector('input[name="rating"]');
            const formErrorsContainer = modalEl.querySelector('.alert-danger');
            const submitButton = form.querySelector('button[type="submit"]');

            const displayErrors = (errors) => {
                formErrorsContainer.innerHTML = '';
                let errorList = '<ul>';
                for (const key in errors) {
                    errorList += `<li>${errors[key][0]}</li>`;
                }
                errorList += '</ul>';
                formErrorsContainer.innerHTML = errorList;
                formErrorsContainer.classList.remove('d-none');
            };

            ratingStarsContainer.addEventListener('click', (e) => {
                if (e.target.matches('.bi-star-fill')) {
                    const ratingValue = e.target.dataset.value;
                    if (ratingInput) ratingInput.value = ratingValue;
                    if (ratingStarsContainer) ratingStarsContainer.dataset.rating = ratingValue;
                }
            });

            form.addEventListener('submit', async function(e) {
                e.preventDefault();
                formErrorsContainer.classList.add('d-none');
                formErrorsContainer.innerHTML = '';

                const formData = new FormData(form);
                const originalButtonText = submitButton.innerHTML;
                submitButton.disabled = true;
                submitButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Отправка...';

                try {
                    const response = await fetch(form.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    });
                    const data = await response.json();
                    if (!response.ok) throw data;

                    modal.hide();
                    if (reviewToast) {
                        reviewToastEl.querySelector('.toast-body').textContent = data.message;
                        reviewToast.show();
                    }

                } catch (errorData) {
                    if (errorData && errorData.errors) {
                        displayErrors(errorData.errors);
                    } else {
                        formErrorsContainer.innerHTML = '<ul><li>' + (errorData.message || 'Произошла непредвиденная ошибка.') + '</li></ul>';
                        formErrorsContainer.classList.remove('d-none');
                    }
                } finally {
                    submitButton.disabled = false;
                    submitButton.innerHTML = originalButtonText;
                }
            });

            modalEl.addEventListener('hidden.bs.modal', () => {
                form.reset();
                if (ratingStarsContainer) ratingStarsContainer.dataset.rating = "0";
                if (ratingInput) ratingInput.value = "0";
                if (formErrorsContainer) formErrorsContainer.classList.add('d-none');
                const productNameInput = document.getElementById('productNameInput');
                if (productNameInput) {
                    const resultsContainer = document.getElementById('productAutocompleteResults');
                    productNameInput.value = '';
                    resultsContainer.style.display = 'none';
                    resultsContainer.innerHTML = '';
                }
                if (submitButton && modalId === 'productReviewModal') submitButton.disabled = true;
            });

            if (modalId === 'productReviewModal') {
                const productNameInput = document.getElementById('productNameInput');
                const resultsContainer = document.getElementById('productAutocompleteResults');
                const hiddenIdInput = document.getElementById('productIdInput');
                setupAutocomplete(productNameInput, resultsContainer, hiddenIdInput, submitButton);
            }
        }

        function setupAutocomplete(input, resultsContainer, hiddenInput, submitButton) {
            let debounceTimeout;
            let activeIndex = -1;
            const fetchAndRenderResults = async () => {
                const query = input.value.trim();
                if (query.length < 2) {
                    resultsContainer.style.display = 'none';
                    return;
                }
                try {
                    const response = await fetch(`{{ route('api.products.search') }}?q=${encodeURIComponent(query)}`);
                    const products = await response.json();
                    resultsContainer.innerHTML = '';
                    if (products.length > 0) {
                        const ul = document.createElement('ul');
                        products.forEach(product => {
                            const li = document.createElement('li');
                            li.textContent = product.name;
                            li.dataset.id = product.id;
                            li.dataset.name = product.name;
                            ul.appendChild(li);
                        });
                        resultsContainer.appendChild(ul);
                    } else {
                        resultsContainer.innerHTML = '<ul><li class="no-results">Товары не найдены</li></ul>';
                    }
                    resultsContainer.style.display = 'block';
                    activeIndex = -1;
                } catch (error) {
                    console.error("Autocomplete error:", error);
                }
            };
            const selectProduct = (element) => {
                if (!element) return;
                input.value = element.dataset.name;
                hiddenInput.value = element.dataset.id;
                resultsContainer.style.display = 'none';
                if (submitButton) submitButton.disabled = false;
            };
            input.addEventListener('input', () => {
                clearTimeout(debounceTimeout);
                if (submitButton) submitButton.disabled = true;
                hiddenInput.value = '';
                debounceTimeout = setTimeout(fetchAndRenderResults, 300);
            });
            input.addEventListener('keydown', (e) => {
                const items = resultsContainer.querySelectorAll('li:not(.no-results)');
                if (!items.length) return;
                if (e.key === 'ArrowDown') {
                    e.preventDefault();
                    activeIndex = (activeIndex + 1) % items.length;
                    items.forEach((item, i) => item.classList.toggle('active', i === activeIndex));
                } else if (e.key === 'ArrowUp') {
                    e.preventDefault();
                    activeIndex = (activeIndex - 1 + items.length) % items.length;
                    items.forEach((item, i) => item.classList.toggle('active', i === activeIndex));
                } else if (e.key === 'Enter') {
                    e.preventDefault();
                    if (activeIndex > -1) {
                        selectProduct(items[activeIndex]);
                    }
                } else if (e.key === 'Escape') {
                    resultsContainer.style.display = 'none';
                }
            });
            resultsContainer.addEventListener('click', (e) => {
                if (e.target.tagName === 'LI' && !e.target.classList.contains('no-results')) {
                    selectProduct(e.target);
                }
            });
            document.addEventListener('click', (e) => {
                if (!input.contains(e.target) && !resultsContainer.contains(e.target)) {
                    resultsContainer.style.display = 'none';
                }
            });
        }

        setupReviewForm('productReviewModal');
        setupReviewForm('storeReviewModal');
    });
</script>
@endpush