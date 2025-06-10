@extends('layouts.app')

@section('title', 'Aura Computers')

@push('styles')
<style>
    /* ... Вся ваша секция <style> остается без изменений, она написана отлично ... */
    /* Я скопирую ее полностью для целостности ответа */
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

    .product-tabs-nav {
        justify-content: center;
        margin-bottom: 2.5rem;
        border-bottom: 1px solid #dee2e6;
    }

    .dark .product-tabs-nav {
        border-bottom-color: #374151;
    }

    .product-tabs-nav .nav-item {
        margin-bottom: -1px;
    }

    .product-tabs-nav .nav-link {
        color: #6c757d;
        font-weight: 500;
        font-size: 1.1rem;
        padding: 0.75rem 1.5rem;
        border: 1px solid transparent;
        border-top-left-radius: .375rem;
        border-top-right-radius: .375rem;
        transition: color 0.2s ease, background-color 0.2s ease, border-color 0.2s ease;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .dark .product-tabs-nav .nav-link {
        color: #adb5bd;
    }

    .product-tabs-nav .nav-link:hover {
        color: var(--bs-primary);
        border-color: #e9ecef #e9ecef #dee2e6;
        background-color: #f8f9fa;
    }

    .dark .product-tabs-nav .nav-link:hover {
        color: var(--bs-primary);
        border-color: #374151 #374151 #374151;
        background-color: #2c3648;
    }

    .product-tabs-nav .nav-link.active {
        color: var(--bs-primary);
        font-weight: 600;
        background-color: #fff;
        border-color: #dee2e6 #dee2e6 #fff;
        border-bottom: 3px solid var(--bs-primary);
        box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.05);
    }

    .dark .product-tabs-nav .nav-link.active {
        background-color: var(--bs-body-bg);
        border-color: #374151 #374151 var(--bs-body-bg);
        color: var(--bs-primary);
        box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.15);
    }

    .product-tabs-nav .nav-link .bi {
        margin-right: 0.4rem;
        font-size: 1em;
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
        background: var(--bs-primary);
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

    .product-reviews-section {
        background-color: var(--bs-tertiary-bg);
        padding: 4rem 0;
        margin-top: 3rem;
        overflow: hidden;
    }

    .product-reviews-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }

    .product-reviews-header h2 {
        font-size: 2rem;
        font-weight: 700;
        color: var(--bs-body-color);
        display: inline-block;
        padding-bottom: 0.5rem;
        border-bottom: 3px solid var(--bs-primary);
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .product-reviews-section .slider-nav button {
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

    .product-reviews-section .slider-nav button:hover {
        background-color: var(--bs-primary);
        border-color: var(--bs-primary);
        color: #fff;
        transform: scale(1.1);
    }

    .product-reviews-section .slider-nav button:disabled {
        opacity: 0.5;
        cursor: not-allowed;
        background-color: #e9ecef;
        color: #6c757d;
        border-color: #dee2e6;
    }

    .product-reviews-section .slider-nav button:not(:last-child) {
        margin-right: 0.5rem;
    }

    .product-reviews-slider-track {
        display: flex;
        transition: transform 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        gap: 2rem;
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

    .dark .product-reviews-section {
        background-color: #0c1422;
    }

    .dark .product-reviews-section .slider-nav button {
        background-color: #1e293b;
        color: var(--bs-primary);
        border-color: #374151;
    }

    .dark .product-reviews-section .slider-nav button:hover {
        background-color: var(--bs-primary);
        color: #fff;
    }

    .dark .product-reviews-section .slider-nav button:disabled {
        background-color: #161f31;
        color: #475569;
        border-color: #374151;
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

    .store-reviews-section {
        background-color: var(--bs-tertiary-bg);
        padding: 4rem 0;
        margin-top: 3rem;
        overflow: hidden;
    }

    .store-reviews-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }

    .store-reviews-header h2 {
        font-size: 2rem;
        font-weight: 700;
        color: var(--bs-body-color);
        display: inline-block;
        padding-bottom: 0.5rem;
        border-bottom: 3px solid var(--bs-primary);
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .store-reviews-section .slider-nav button {
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

    .store-reviews-section .slider-nav button:hover {
        background-color: var(--bs-primary);
        border-color: var(--bs-primary);
        color: #fff;
        transform: scale(1.1);
    }

    .store-reviews-section .slider-nav button:disabled {
        opacity: 0.5;
        cursor: not-allowed;
        background-color: #e9ecef;
        color: #6c757d;
        border-color: #dee2e6;
    }

    .store-reviews-section .slider-nav button:not(:last-child) {
        margin-right: 0.5rem;
    }

    .store-reviews-slider-track {
        display: flex;
        transition: transform 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        gap: 2rem;
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

    .dark .store-reviews-section {
        background-color: #0c1422;
    }

    .dark .store-reviews-section .slider-nav button {
        background-color: #1e293b;
        color: var(--bs-primary);
        border-color: #374151;
    }

    .dark .store-reviews-section .slider-nav button:hover {
        background-color: var(--bs-primary);
        color: #fff;
    }

    .dark .store-reviews-section .slider-nav button:disabled {
        background-color: #161f31;
        color: #475569;
        border-color: #374151;
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

        .product-reviews-header h2,
        .store-reviews-header h2 {
            font-size: 1.5rem;
        }
    }

    .about-us-section .image-scroller-wrapper {
        max-width: 100%;
        margin-top: 2.5rem;
        overflow: hidden;
        -webkit-mask-image: linear-gradient(to right, transparent, black 10%, black 90%, transparent);
        mask-image: linear-gradient(to right, transparent, black 10%, black 90%, transparent);
    }

    .about-us-section .image-scroller-track {
        display: flex;
        gap: 1.5rem;
        animation: scrollAnimation 20s linear infinite;
    }

    .about-us-section .image-scroller-wrapper:hover .image-scroller-track {
        animation-play-state: paused;
    }

    @keyframes scrollAnimation {
        from {
            transform: translateX(0);
        }

        to {
            transform: translateX(calc(-100% / 2));
        }
    }

    .about-us-section .scroller-item {
        flex: 0 0 auto;
        width: clamp(180px, 22vw, 250px);
        aspect-ratio: 3 / 4;
    }

    .about-us-section .scroller-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 0.375rem;
        box-shadow: 0 .125rem .25rem rgba(0, 0, 0, .075);
    }

    .dark .about-us-section {
        background-color: var(--bs-body-bg) !important;
    }

    .dark .about-us-section h2,
    .dark .about-us-section p {
        color: var(--bs-body-color);
    }

    .dark .about-us-section strong[style*="color"] {
        color: var(--bs-primary) !important;
    }

    @media (max-width: 767.98px) {
        .about-us-section .image-scroller-track {
            animation-duration: 40s;
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

    .dark #reviewModal .modal-content {
        background-color: #1e293b;
    }

    .dark #reviewModal .form-control {
        background-color: #374151;
        border-color: #4b5563;
        color: #e5e7eb;
    }

    .dark #reviewModal .form-control:focus {
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
</style>
@endpush

@section('content')
{{-- Секция карусели остается без изменений --}}
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

{{-- Секция с табами товаров остается без изменений --}}
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
            <p class="text-center text-muted py-5">Раздел "Популярные товары" скоро появится!</p>
        </div>
    </div>
</div>

{{-- ИЗМЕНЕННАЯ СЕКЦИЯ: ОТЗЫВЫ О ТОВАРАХ --}}
<section class="product-reviews-section">
    <div class="container">
        <div class="product-reviews-header">
            <h2>Отзывы о товаре</h2>
            <div class="slider-nav">
                <button class="btn btn-slider-nav prev-btn" aria-label="Предыдущий отзыв"><i class="bi bi-chevron-left"></i></button>
                <button class="btn btn-slider-nav next-btn" aria-label="Следующий отзыв"><i class="bi bi-chevron-right"></i></button>
            </div>
        </div>
        <div class="slider-viewport product-reviews-slider-viewport">
            <div class="slider-track product-reviews-slider-track">
                {{--
                    Предполагается, что ваш контроллер передает в это представление переменную $productReviews.
                    $productReviews - это коллекция (массив) объектов отзывов на товары.
                    Каждый объект $review должен содержать:
                    - $review->product->image_url (URL картинки товара)
                    - $review->product->name (Название товара)
                    - $review->rating (Оценка от 1 до 5)
                    - $review->author_name (Имя автора)
                    - $review->created_at (Дата создания отзыва)
                    - $review->text (Текст отзыва)
                --}}
                @forelse ($productReviews ?? [] as $review)
                <div class="product-review-card">
                    <div class="product-review-card-header">
                        <img src="{{ $review->product->image_url ?? 'https://placehold.co/160x160/ffffff/000000?text=IMG' }}" alt="{{ $review->product->name ?? 'Изображение товара' }}" class="product-review-product-img">
                        <div class="product-review-product-info">
                            <h5>{{ $review->product->name ?? 'Название товара' }}</h5>
                            <div class="product-review-rating">
                                @for ($i = 1; $i <= 5; $i++)
                                    <i class="bi {{ $i <= $review->rating ? 'bi-star-fill' : 'bi-star' }}"></i>
                                @endfor
                            </div>
                            <span class="product-review-author">{{ $review->author_name ?? 'Аноним' }} · {{ $review->created_at->format('d M Y') }}</span>
                        </div>
                    </div>
                    <p class="product-review-text">{{ $review->text }}</p>
                </div>
                @empty
                    {{-- Этот блок отобразится, если $productReviews пуст --}}
                    <div class="w-100 text-center py-5">
                        <p class="text-muted">Отзывов о товарах пока нет.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</section>

{{-- ИЗМЕНЕННАЯ СЕКЦИЯ: ОТЗЫВЫ О МАГАЗИНЕ --}}
<section class="store-reviews-section">
    <div class="container">
        <div class="store-reviews-header">
            <h2>Отзывы о магазине</h2>
            <div class="d-flex align-items-center">
                <div class="slider-nav">
                    <button class="btn btn-slider-nav prev-btn" aria-label="Предыдущий отзыв"><i class="bi bi-chevron-left"></i></button>
                    <button class="btn btn-slider-nav next-btn" aria-label="Следующий отзыв"><i class="bi bi-chevron-right"></i></button>
                </div>
                <button type="button" class="btn btn-primary ms-lg-4 ms-3" data-bs-toggle="modal" data-bs-target="#reviewModal">
                    <i class="bi bi-pencil-square me-1"></i> Написать отзыв
                </button>
            </div>
        </div>
        <div class="slider-viewport store-reviews-slider-viewport">
            <div class="slider-track store-reviews-slider-track">
                {{--
                    Предполагается, что ваш контроллер передает в это представление переменную $storeReviews.
                    $storeReviews - это коллекция (массив) объектов отзывов о магазине.
                    Каждый объект $review должен содержать:
                    - $review->name (Имя автора)
                    - $review->created_at (Дата создания)
                    - $review->rating (Оценка от 1 до 5)
                    - $review->text (Текст отзыва)
                    - $review->admin_reply (Ответ администратора, может быть null)
                --}}
                @forelse ($storeReviews ?? [] as $review)
                <div class="store-review-card">
                    <div class="store-review-card-header">
                        <div class="store-review-avatar"><i class="bi bi-person-fill"></i></div>
                        <div class="store-review-user-info">
                            <div class="name">{{ $review->name }}</div>
                            {{-- Форматируем дату в нужный вид --}}
                            <div class="date">{{ $review->created_at->translatedFormat('d F Y H:i') }}</div>
                        </div>
                        <div class="store-review-rating">
                            @for ($i = 1; $i <= 5; $i++)
                                <i class="bi bi-star-fill" style="color: {{ $i <= $review->rating ? '#fec923' : '#dee2e6' }};"></i>
                            @endfor
                        </div>
                    </div>
                    <p class="store-review-text">{{ $review->text }}</p>

                    {{-- Показываем ответ администратора, только если он есть --}}
                    @if ($review->admin_reply)
                    <div class="store-review-admin-reply">{{ $review->admin_reply }}</div>
                    @endif
                </div>
                @empty
                    {{-- Этот блок отобразится, если $storeReviews пуст --}}
                    <div class="w-100 text-center py-5">
                        <p class="text-muted">Отзывов о магазине пока нет. Будьте первым!</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</section>

{{-- Секция "О нас" остается без изменений --}}
<section class="about-us-section py-5 bg-white">
    <div class="container">
        <div class="row justify-content-center mb-4">
            <div class="col-lg-10 text-center">
                <h2 class="display-5 fw-bold mb-4">Добро пожаловать в Aura Computers!</h2>
                <p class="lead">Интернет-магазин Aura представляет широкий ассортимент товаров с более двухсот разделов и 10 000 наименований. Мы - ведущая компания, специализирующаяся на продаже компьютерной техники и электроники с <strong style="color: #38a55a;">бесплатной доставкой по всему Туркменистану</strong>.</p>
                <p>Одним из ключевых преимуществ нашей компании является наше долголетнее присутствие на рынке - мы успешно работаем уже более 10 лет. За это время мы завоевали доверие и признание наших клиентов благодаря надежности, качеству и профессионализму нашей работы.</p>
                <p>Так же мы предоставляем полный спектр услуг, включая <strong style="color: #38a55a;">гарантийное обслуживание, сервисный центр</strong>. Наша команда опытных специалистов всегда готова помочь вам с любыми вопросами, связанными с вашей покупкой. Мы стремимся обеспечить высокий уровень сервиса и удовлетворить потребности каждого клиента.</p>
            </div>
        </div>
        <div class="image-scroller-wrapper">
            <div class="image-scroller-track">
                <div class="scroller-item"><img src="https://akyol.com.tm/wa-data/public/site/themes/mastershop_premium/img/Raznoe/Carousel/7.jpg" alt="Вход в магазин Ak Yol"></div>
                <div class="scroller-item"><img src="https://akyol.com.tm/wa-data/public/site/themes/mastershop_premium/img/Raznoe/Carousel/1.jpg" alt="Полки с товарами в магазине"></div>
                <div class="scroller-item"><img src="https://akyol.com.tm/wa-data/public/site/themes/mastershop_premium/img/Raznoe/Carousel/3.jpg" alt="Кассовая зона и покупатели"></div>
                <div class="scroller-item"><img src="https://akyol.com.tm/wa-data/public/site/themes/mastershop_premium/img/Raznoe/Carousel/11.jpg" alt="Ремонт материнской платы в сервисном центре"></div>
                <div class="scroller-item" aria-hidden="true"><img src="https://akyol.com.tm/wa-data/public/site/themes/mastershop_premium/img/Raznoe/Carousel/6.jpg" alt=""></div>
                <div class="scroller-item" aria-hidden="true"><img src="https://akyol.com.tm/wa-data/public/site/themes/mastershop_premium/img/Raznoe/Carousel/9.jpg" alt=""></div>
                <div class="scroller-item" aria-hidden="true"><img src="https://akyol.com.tm/wa-data/public/site/themes/mastershop_premium/img/Raznoe/Carousel/3.jpg" alt=""></div>
                <div class="scroller-item" aria-hidden="true"><img src="https://akyol.com.tm/wa-data/public/site/themes/mastershop_premium/img/Raznoe/Carousel/8.jpg" alt=""></div>
            </div>
        </div>
    </div>
</section>

{{-- Модальное окно и прочие элементы остаются без изменений --}}
<div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reviewModalLabel">Оставить отзыв о магазине</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="reviewForm" action="{{ route('store-reviews.store') }}" method="POST">
                    @csrf
                    <div id="form-errors" class="alert alert-danger d-none"></div>

                    <div class="mb-3">
                        <label for="reviewName" class="form-label">Ваше имя и фамилия</label>
                        <input type="text" class="form-control" id="reviewName" name="name" required value="{{ auth()->user()->name ?? '' }}" placeholder="Представьтесь, пожалуйста">
                    </div>

                    <div class="mb-3">
                        <label for="reviewText" class="form-label">Ваш отзыв</label>
                        <textarea class="form-control" id="reviewText" name="text" rows="4" required placeholder="Поделитесь вашими впечатлениями..."></textarea>
                    </div>
                    <div class="mb-4">
                        <label class="form-label d-block">Ваша оценка</label>
                        <div class="rating-stars" data-rating="0" id="reviewRating">
                            <i class="bi bi-star-fill" data-value="5"></i>
                            <i class="bi bi-star-fill" data-value="4"></i>
                            <i class="bi bi-star-fill" data-value="3"></i>
                            <i class="bi bi-star-fill" data-value="2"></i>
                            <i class="bi bi-star-fill" data-value="1"></i>
                        </div>
                        <input type="hidden" name="rating" id="ratingInput" value="0" required>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Отправить отзыв</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1080">
    <div id="reviewToast" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                Ваш отзыв успешно отправлен! Спасибо, что помогаете нам стать лучше.
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>

<a href="#" class="scroll-to-top d-flex align-items-center justify-content-center">
    <i class="bi bi-arrow-up-short"></i>
</a>
@endsection

@push('scripts')
{{-- Скрипты остаются почти без изменений. Функция addReviewToSlider была немного улучшена. --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var heroCarousel = document.getElementById('heroCarousel');
        if (heroCarousel) {
            var carousel = new bootstrap.Carousel(heroCarousel);
        }

        const scrollToTopButton = document.querySelector('.scroll-to-top');
        if (scrollToTopButton) {
            window.addEventListener('scroll', () => {
                if (window.scrollY > (window.innerHeight * 0.8)) {
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

        const sliderInitializers = {};

        function initializeSlider(sliderSelector) {
            const slider = document.querySelector(sliderSelector);
            if (!slider) return;

            const track = slider.querySelector('.slider-track');
            const prevBtn = slider.querySelector('.prev-btn');
            const nextBtn = slider.querySelector('.next-btn');

            if (!track || !prevBtn || !nextBtn) return;
            
            // Если внутри трека нет карточек (например, там только текст "отзывов нет"),
            // то не инициализируем слайдер и отключаем кнопки.
            if (track.children.length <= 1 && track.querySelector('.store-review-card, .product-review-card') === null) {
                 if(prevBtn) prevBtn.disabled = true;
                 if(nextBtn) nextBtn.disabled = true;
                 return;
            }

            let state = {
                currentIndex: 0,
                itemsPerPage: window.innerWidth >= 768 ? 2 : 1,
                totalItems: track.children.length,
                gap: parseFloat(window.getComputedStyle(track).gap) || 32,
            };

            function updateSlider() {
                if (track.children.length === 0) {
                    if(prevBtn) prevBtn.disabled = true;
                    if(nextBtn) nextBtn.disabled = true;
                    return;
                }
                const maxIndex = Math.max(0, state.totalItems - state.itemsPerPage);
                
                prevBtn.disabled = state.currentIndex === 0;
                nextBtn.disabled = state.currentIndex >= maxIndex;

                state.currentIndex = Math.max(0, Math.min(state.currentIndex, maxIndex));
                const cardWidth = track.children[0].offsetWidth;
                const offset = state.currentIndex * (cardWidth + state.gap);
                track.style.transform = `translateX(-${offset}px)`;
            }

            function handleResize() {
                const newItemsPerPage = window.innerWidth >= 768 ? 2 : 1;
                if (newItemsPerPage !== state.itemsPerPage) {
                    state.itemsPerPage = newItemsPerPage;
                    updateSlider();
                }
            }
            
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
            // Небольшая задержка, чтобы все элементы успели отрисоваться
            setTimeout(updateSlider, 150);

            sliderInitializers[sliderSelector] = {
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

        initializeSlider('.product-reviews-section');
        initializeSlider('.store-reviews-section');

        const reviewModalEl = document.getElementById('reviewModal');
        if (reviewModalEl) {
            const reviewModal = new bootstrap.Modal(reviewModalEl);
            const reviewForm = document.getElementById('reviewForm');
            const ratingStarsContainer = document.getElementById('reviewRating');
            const ratingInput = document.getElementById('ratingInput');
            const reviewToastEl = document.getElementById('reviewToast');
            const reviewToast = new bootstrap.Toast(reviewToastEl);
            const formErrors = document.getElementById('form-errors');

            ratingStarsContainer.addEventListener('click', (e) => {
                if (e.target.matches('.bi-star-fill')) {
                    const ratingValue = e.target.dataset.value;
                    ratingInput.value = ratingValue;
                    ratingStarsContainer.dataset.rating = ratingValue;
                }
            });

            reviewModalEl.addEventListener('hidden.bs.modal', () => {
                reviewForm.reset();
                ratingStarsContainer.dataset.rating = "0";
                ratingInput.value = "0";
                formErrors.classList.add('d-none');
                formErrors.innerHTML = '';
            });

            reviewForm.addEventListener('submit', async function(e) {
                e.preventDefault();
                formErrors.classList.add('d-none');
                formErrors.innerHTML = '';

                if (ratingInput.value === "0") {
                    formErrors.innerHTML = 'Пожалуйста, выберите оценку.';
                    formErrors.classList.remove('d-none');
                    return;
                }

                const formData = new FormData(reviewForm);
                const submitButton = reviewForm.querySelector('button[type="submit"]');
                submitButton.disabled = true;
                submitButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Отправка...';

                try {
                    const response = await fetch(reviewForm.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    });

                    const data = await response.json();

                    if (!response.ok) {
                        if (data.errors) {
                            let errorMessages = '<ul>';
                            for (const key in data.errors) {
                                errorMessages += `<li>${data.errors[key][0]}</li>`;
                            }
                            errorMessages += '</ul>';
                            formErrors.innerHTML = errorMessages;
                            formErrors.classList.remove('d-none');
                        } else {
                            throw new Error(data.message || 'Произошла ошибка.');
                        }
                    } else {
                        reviewModal.hide();
                        reviewToast.show();

                        const newReviewData = {
                            name: formData.get('name'),
                            text: formData.get('text'),
                            rating: parseInt(formData.get('rating'), 10),
                            date: new Date() // Используем текущую дату для отображения
                        };
                        addReviewToSlider(newReviewData);
                    }
                } catch (error) {
                    formErrors.innerHTML = error.message || 'Не удалось отправить отзыв. Пожалуйста, попробуйте снова.';
                    formErrors.classList.remove('d-none');
                } finally {
                    submitButton.disabled = false;
                    submitButton.innerHTML = 'Отправить отзыв';
                }
            });
        }

        // Эта функция добавляет новый отзыв в слайдер для мгновенного отображения.
        // Она была немного улучшена, чтобы правильно генерировать звезды и форматировать дату.
        function addReviewToSlider(data) {
            const track = document.querySelector('.store-reviews-slider-track');
            if (!track) return;
            
            // Если до этого отзывов не было, очищаем надпись "Отзывов нет"
            const emptyMessage = track.querySelector('.w-100.text-center');
            if (emptyMessage) {
                emptyMessage.remove();
            }

            const newCard = document.createElement('div');
            newCard.className = 'store-review-card';

            // Генерация HTML для звезд рейтинга
            let ratingHtml = '';
            for (let i = 1; i <= 5; i++) {
                const color = i <= data.rating ? '#fec923' : '#dee2e6';
                ratingHtml += `<i class="bi bi-star-fill" style="color: ${color};"></i>`;
            }

            // Форматирование даты
            const dateOptions = { year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' };
            const formattedDate = data.date.toLocaleDateString('ru-RU', dateOptions).replace(' г. в', '');

            newCard.innerHTML = `
                <div class="store-review-card-header">
                    <div class="store-review-avatar"><i class="bi bi-person-fill"></i></div>
                    <div class="store-review-user-info">
                        <div class="name">${data.name}</div>
                        <div class="date">${formattedDate}</div>
                    </div>
                    <div class="store-review-rating">${ratingHtml}</div>
                </div>
                <p class="store-review-text">${data.text}</p>
            `;

            track.prepend(newCard); // Добавляем новый отзыв в начало списка

            // Переинициализируем или сбрасываем слайдер
            if (sliderInitializers['.store-reviews-section']) {
                sliderInitializers['.store-reviews-section'].reset();
            } else {
                // Если слайдер не был инициализирован (т.к. отзывов не было), инициализируем его сейчас
                initializeSlider('.store-reviews-section');
            }
        }
    });
</script>
@endpush