@extends('layouts.app')

@section('title', $product->name . ' - Aura Computers')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
    body {
        background-color: #f8f9fa;
    }

    .product-gallery-main-img {
        max-height: 550px;
        object-fit: contain;
        background-color: #fff;
        border-radius: 0.5rem;
        border: 1px solid #dee2e6;
    }

    .product-gallery-thumbnail {
        width: 90px;
        height: 90px;
        object-fit: cover;
        border: 2px solid transparent;
        border-radius: 0.375rem;
        cursor: pointer;
        transition: border-color 0.2s ease-in-out, transform 0.2s ease-in-out;
    }

    .product-gallery-thumbnail:hover,
    .product-gallery-thumbnail.active {
        border-color: var(--bs-primary, #0d6efd);
        transform: scale(1.05);
    }

    .product-brand-logo {
        max-height: 40px;
        object-fit: contain;
    }

    .product-price-display {
        color: var(--bs-success, #198754);
    }

    .product-price-currency {
        font-size: 1.2rem;
        color: #6c757d;
    }

    .btn-add-to-cart {
        min-width: 220px;
        font-size: 1.1rem;
        padding-top: 0.75rem;
        padding-bottom: 0.75rem;
    }

    .product-availability i {
        font-size: 0.9em;
        margin-right: 0.3rem;
    }

    .nav-tabs .nav-link {
        color: #495057;
        border: 1px solid transparent;
        border-bottom-color: #dee2e6;
        border-radius: 0.5rem 0.5rem 0 0;
        font-weight: 500;
        padding: 0.75rem 1.25rem;
        transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out;
    }

    .nav-tabs .nav-link.active {
        color: var(--bs-primary, #0d6efd);
        background-color: #fff;
        border-color: #dee2e6 #dee2e6 #fff;
        border-bottom: 3px solid var(--bs-primary, #0d6efd) !important;
        font-weight: 600;
    }

    .nav-tabs .nav-link:hover:not(.active) {
        color: var(--bs-primary-hover, #0b5ed7);
        border-color: #e9ecef #e9ecef #dee2e6;
    }

    .tab-content {
        background-color: #fff;
        border: 1px solid #dee2e6;
        border-top: none;
        border-radius: 0 0 0.5rem 0.5rem;
        padding: 1.5rem;
    }

    .product-specs-table th {
        background-color: #f8f9fa;
        width: 30%;
        font-weight: 500;
    }

    .product-specs-table td,
    .product-specs-table th {
        padding: 0.75rem 1rem;
        vertical-align: top;
    }

    .section-card {
        background-color: #ffffff;
        border-radius: 0.75rem;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
        padding: 2rem;
    }

    .breadcrumb-item a {
        color: var(--bs-primary);
        text-decoration: none;
    }

    .breadcrumb-item a:hover {
        text-decoration: underline;
    }

    .breadcrumb-item.active {
        color: #6c757d;
    }

    .badge-availability {
        font-size: 0.9em;
    }

    .sku-widget .input-group-sm > .form-control,
    .sku-widget .input-group-sm > .btn {
        padding-top: 0.4rem;
        padding-bottom: 0.4rem;
        font-size: 0.875rem;
    }
    .sku-widget .btn i, .sku-widget .btn svg {
        vertical-align: -0.125em;
    }

    .sku-widget .input-group .form-control {
        border-right-width: 1px;
        border-right-color: transparent;
    }
    .sku-widget .input-group .btn-light {
        border-color: #dee2e6;
    }

    .sku-widget .input-group .btn-sku-copy {
        border-left-width: 2px !important;
        /* border-left-color: var(--bs-primary, #0d6efd) !important; */
        margin-left: -1px;
    }
    .sku-widget .input-group .btn-sku-copy:hover,
    .sku-widget .input-group .btn-sku-copy:focus {
        background-color: #e9ecef;
        /* border-color: var(--bs-primary, #0d6efd); */
        z-index: 3;
    }
    .sku-widget .input-group .btn-sku-copy:focus {
         box-shadow: 0 0 0 0.2rem rgba(var(--bs-primary-rgb, 13, 110, 253), .25);
    }

    .sku-widget .input-group .btn-sku-google {
        border-left-width: 2px !important;
        /* border-left-color: var(--bs-danger, #dc3545) !important; */
        margin-left: -1px;
    }

    .sku-widget .input-group .btn-sku-google:hover,
    .sku-widget .input-group .btn-sku-google:focus {
        background-color: #e9ecef;
        /* border-color: var(--bs-danger, #dc3545); */
        z-index: 3;
    }
     .sku-widget .input-group .btn-sku-google:focus {
         box-shadow: 0 0 0 0.2rem rgba(var(--bs-danger-rgb, 220, 53, 69), .25);
    }

    .sku-widget .input-group > .btn {
      position: relative;
      z-index: 2;
    }
</style>
@endpush

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Главная</a></li>
            @if($product->category)
            <li class="breadcrumb-item"><a href="{{ route('catalog.index', ['category' => $product->category->slug]) }}">{{ $product->category->name }}</a></li>
            @endif
            <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="section-card">
        <div class="row g-4">
            <div class="col-lg-6">
                <div class="mb-3 text-center">
                    <img src="{{ $product->thumbnail_url ?? asset('images/placeholder-product.png') }}"
                        alt="{{ $product->name }} - Основное изображение"
                        class="img-fluid product-gallery-main-img"
                        id="mainProductImage">
                </div>
                @if(!empty($product->images) && is_array($product->images) && count($product->images) > 0)
                <div class="d-flex flex-wrap justify-content-center gap-2 mt-3">
                    <img src="{{ $product->thumbnail_url ?? asset('images/placeholder-product.png') }}"
                        alt="Миниатюра основного изображения"
                        class="product-gallery-thumbnail active"
                        onclick="changeMainImage('{{ $product->thumbnail_url ?? asset('images/placeholder-product.png') }}', this)">

                    @foreach($product->images as $index => $imagePath)
                    <img src="{{ $imagePath }}"
                        alt="Миниатюра {{ $index + 1 }}"
                        class="product-gallery-thumbnail"
                        onclick="changeMainImage('{{ $imagePath }}', this)">
                    @endforeach
                </div>
                @else
                <div class="d-flex flex-wrap justify-content-center gap-2 mt-3">
                    <img src="{{ $product->thumbnail_url ?? asset('images/placeholder-product.png') }}"
                        alt="Миниатюра основного изображения"
                        class="product-gallery-thumbnail active"
                        onclick="changeMainImage('{{ $product->thumbnail_url ?? asset('images/placeholder-product.png') }}', this)">
                </div>
                @endif
            </div>

            <div class="col-lg-6">
                @if($product->brand)
                <div class="d-flex align-items-center mb-2">
                    @if($product->brand->logo_url)
                    <img src="{{ $product->brand->logo_url }}" alt="{{ $product->brand->name }}" class="me-2 product-brand-logo">
                    @endif
                    <span class="text-muted small">Производитель: {{ $product->brand->name }}</span>
                </div>
                @endif

                <h1 class="h2 fw-bold mb-2">{{ $product->name }}</h1>

                <div class="sku-widget mb-4">
                    <label for="skuValueInput" class="form-label fw-bold mb-1 text-dark">Партийный номер / Модель</label>
                    <div class="input-group input-group-sm">
                        <input type="text"
                               id="skuValueInput"
                               class="form-control bg-white"
                               value="{{ $product->sku ?? 'N/A' }}"
                               readonly
                               aria-label="Партийный номер или модель товара"
                        >
                        <button
                            class="btn btn-light btn-sku-copy" type="button" id="copySkuButton" title="Копировать артикул"
                            @if(empty($product->sku) || $product->sku === 'N/A') disabled @endif
                        >
                            <i class="bi bi-file-earmark-fill text-primary"></i>
                        </button>
                        <button
                            class="btn btn-light btn-sku-google" type="button" id="searchSkuGoogleButton" title="Искать артикул в Google"
                            @if(empty($product->sku) || $product->sku === 'N/A') disabled @endif
                        >
                            <svg viewBox="0 0 24 24" style="width: 1em; height: 1em; fill: #DB4437; vertical-align: -0.125em;">
                               <path d="M21.456 10.154c.118.69.178 1.394.178 2.097 0 5.903-4.776 10.75-10.634 10.75S.366 18.153.366 12.25C.366 6.35.842 1.5 11 1.5c2.993 0 5.173.99 6.886 2.625l-2.69 2.55c-.975-.93-2.31-1.743-4.196-1.743-3.506 0-6.34 2.857-6.34 6.318s2.834 6.318 6.34 6.318c2.895 0 4.69-.99 5.213-2.572h-5.33v-3.62h8.79c.08.42.12.848.12 1.284Z"/>
                            </svg>
                        </button>
                    </div>
                    <div id="copyFeedback" class="form-text mt-1" style="min-height: 1.2em; height: 1.2em;"></div>
                </div>

                <div class="d-flex align-items-center gap-3 mb-4">
                    <button class="btn btn-outline-secondary btn-sm" type="button" title="Сравнить">
                        <i class="bi bi-arrow-left-right"></i> Сравнить
                    </button>
                    <button class="btn btn-outline-danger btn-sm" type="button" title="Добавить в избранное">
                        <i class="bi bi-heart"></i> В избранное
                    </button>
                </div>

                @if($product->short_description)
                <p class="text-muted mb-4">{{ $product->short_description }}</p>
                @endif

                <div class="mb-4">
                    <span class="h1 fw-bolder product-price-display">{{ number_format($product->price, 2, ',', ' ') }}</span>
                    <span class="product-price-currency">TMT</span>
                    @if(isset($product->old_price) && $product->old_price > $product->price)
                    <s class="text-muted ms-2"><small>{{ number_format($product->old_price, 2, ',', ' ') }} TMT</small></s>
                    <span class="badge bg-danger ms-2">Скидка!</span>
                    @elseif($product->on_sale && isset($product->sale_price) && $product->sale_price < $product->price)
                        <s class="text-muted ms-2"><small>{{ number_format($product->price, 2, ',', ' ') }} TMT</small></s>
                        <span class="badge bg-danger ms-2">Скидка!</span>
                        @endif
                </div>

                <div class="d-grid gap-2 d-sm-flex mb-4">
                    <button class="btn btn-primary btn-lg btn-add-to-cart flex-grow-1" type="button">
                        <i class="bi bi-cart-plus me-2"></i>ДОБАВИТЬ В КОРЗИНУ
                    </button>
                </div>

                <div class="product-availability">
                    @if($product->quantity > 0)
                    <p class="text-success mb-1"><i class="bi bi-check-circle-fill"></i> <span class="badge bg-success-subtle text-success-emphasis rounded-pill badge-availability">В наличии ({{ $product->quantity }} шт.)</span></p>
                    @else
                    <p class="text-danger mb-1"><i class="bi bi-x-circle-fill"></i> <span class="badge bg-danger-subtle text-danger-emphasis rounded-pill badge-availability">Нет в наличии</span></p>
                    @endif
                    <p class="text-muted small"><i class="bi bi-truck"></i> Бесплатная доставка по городу (уточняйте)</p>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-5">
        <ul class="nav nav-tabs mb-0" id="productTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description-tab-pane" type="button" role="tab" aria-controls="description-tab-pane" aria-selected="true">Описание</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="specifications-tab" data-bs-toggle="tab" data-bs-target="#specifications-tab-pane" type="button" role="tab" aria-controls="specifications-tab-pane" aria-selected="false">Характеристики</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews-tab-pane" type="button" role="tab" aria-controls="reviews-tab-pane" aria-selected="false">Отзывы ({{ $product->reviews->count() }})</button>
            </li>
        </ul>
        <div class="tab-content" id="productTabContent">
            <div class="tab-pane fade show active p-4" id="description-tab-pane" role="tabpanel" aria-labelledby="description-tab" tabindex="0">
                <h3 class="h5 mb-3">Подробное описание товара</h3>
                @if($product->long_description)
                {!! nl2br(e($product->long_description)) !!}
                @elseif($product->description)
                {!! nl2br(e($product->description)) !!}
                @else
                <p class="text-muted">Подробное описание для этого товара пока отсутствует.</p>
                @endif
            </div>
            <div class="tab-pane fade p-0" id="specifications-tab-pane" role="tabpanel" aria-labelledby="specifications-tab" tabindex="0">
                @php
                $hasJsonSpecifications = !empty($product->specifications) &&
                (is_array($product->specifications) || is_object($product->specifications)) &&
                count((array)$product->specifications) > 0;

                $hasDedicatedSpecFields = $product->screen_size ||
                $product->resolution ||
                $product->matrix_type ||
                $product->refresh_rate ||
                $product->response_time ||
                $product->ram_size ||
                $product->cpu_type ||
                $product->ssd_volume ||
                $product->gpu_type ||
                $product->os_type;

                $showActualSpecifications = $hasJsonSpecifications || $hasDedicatedSpecFields;
                $categorySlug = $product->category->slug ?? null;
                @endphp

                @if($showActualSpecifications)
                <table class="table table-striped table-hover product-specs-table mb-0">
                    <tbody>
                        @if($hasJsonSpecifications)
                        @foreach((array)$product->specifications as $key => $value)
                        <tr>
                            <th scope="row">{{ Str::title(str_replace('_', ' ', $key)) }}</th>
                            <td>{{ $value }}</td>
                        </tr>
                        @endforeach
                        @endif

                        @if($product->screen_size)<tr>
                            <th scope="row">Диагональ экрана</th>
                            <td>{{ $product->screen_size }}"</td>
                        </tr>@endif
                        @if($product->resolution)<tr>
                            <th scope="row">Разрешение экрана</th>
                            <td>{{ $product->resolution }}</td>
                        </tr>@endif
                        @if($product->matrix_type)<tr>
                            <th scope="row">Тип матрицы</th>
                            <td>{{ $product->matrix_type }}</td>
                        </tr>@endif
                        @if($product->refresh_rate)<tr>
                            <th scope="row">Частота обновления</th>
                            <td>{{ $product->refresh_rate }} Гц</td>
                        </tr>@endif
                        @if($product->response_time)<tr>
                            <th scope="row">Время отклика</th>
                            <td>{{ $product->response_time }} мс</td>
                        </tr>@endif
                        @if($product->ram_size)<tr>
                            <th scope="row">Объем ОЗУ</th>
                            <td>{{ $product->ram_size }} ГБ</td>
                        </tr>@endif
                        @if($product->cpu_type)<tr>
                            <th scope="row">Процессор</th>
                            <td>{{ $product->cpu_type }}</td>
                        </tr>@endif
                        @if($product->ssd_volume)<tr>
                            <th scope="row">Объем SSD</th>
                            <td>{{ $product->ssd_volume }} ГБ</td>
                        </tr>@endif
                        @if($product->gpu_type)<tr>
                            <th scope="row">Видеокарта</th>
                            <td>{{ $product->gpu_type }}</td>
                        </tr>@endif
                        @if($product->os_type)<tr>
                            <th scope="row">Операционная система</th>
                            <td>{{ $product->os_type }}</td>
                        </tr>@endif
                    </tbody>
                </table>
                @else
                <table class="table table-striped table-hover product-specs-table mb-0">
                    <tbody>
                        @if($categorySlug === 'laptops-notebooks')
                        <tr>
                            <th scope="row">Диагональ экрана</th>
                            <td>15.6" </td>
                        </tr>
                        <tr>
                            <th scope="row">Тип матрицы</th>
                            <td>IPS</td>
                        </tr>
                        <tr>
                            <th scope="row">Разрешение дисплея</th>
                            <td>Full HD (1920x1080)</td>
                        </tr>
                        <tr>
                            <th scope="row">Процессор</th>
                            <td>AMD Ryzen 7</td>
                        </tr>
                        <tr>
                            <th scope="row">Кол-во ядер</th>
                            <td>8</td>
                        </tr>
                        <tr>
                            <th scope="row">Кол-во потоков</th>
                            <td>16</td>
                        </tr>
                        <tr>
                            <th scope="row">Кэш память</th>
                            <td>16 МБ</td>
                        </tr>
                        <tr>
                            <th scope="row">Тип памяти</th>
                            <td>DDR5</td>
                        </tr>
                        <tr>
                            <th scope="row">Объём оперативной памяти</th>
                            <td>16 ГБ</td>
                        </tr>
                        <tr>
                            <th scope="row">Объём SSD</th>
                            <td>512 ГБ</td>
                        </tr>
                        <tr>
                            <th scope="row">Цвет</th>
                            <td>серый</td>
                        </tr>
                        <tr>
                            <th scope="row">Порты подключения</th>
                            <td>HDMI / 2 х USB 3.2 gen 1 / 1 х Type-C 3.2 gen 2 / 1 х Type-C 3.2 с поддержкой DP / LAN / AUX</td>
                        </tr>
                        <tr>
                            <th scope="row">Тип видеокарты</th>
                            <td>NVIDIA RTX 3050</td>
                        </tr>
                        <tr>
                            <th scope="row">Тип накопителя</th>
                            <td>SSD</td>
                        </tr>
                        @elseif($categorySlug === 'peripherals-keyboards')
                        <tr>
                            <th scope="row">Тип клавиатуры</th>
                            <td>Механическая / Мембранная</td>
                        </tr>
                        <tr>
                            <th scope="row">Подключение</th>
                            <td>Проводное (USB) / Беспроводное (2.4GHz/Bluetooth)</td>
                        </tr>
                        <tr>
                            <th scope="row">Подсветка</th>
                            <td>RGB / Одноцветная / Отсутствует</td>
                        </tr>
                        <tr>
                            <th scope="row">Количество клавиш</th>
                            <td>Стандартная (104) / TKL / Компактная</td>
                        </tr>
                        <tr>
                            <th scope="row">Материал корпуса</th>
                            <td>Пластик / Алюминий</td>
                        </tr>
                        <tr>
                            <th scope="row">Раскладка</th>
                            <td>Русская / Английская</td>
                        </tr>
                        <tr>
                            <th scope="row">Тип переключателей (для мех.)</th>
                            <td>Зависит от модели</td>
                        </tr>
                        <tr>
                            <th scope="row">Ресурс нажатий</th>
                            <td>От 20 млн.</td>
                        </tr>
                        <tr>
                            <th scope="row">Длина кабеля</th>
                            <td>1.5 - 2.0 м (для проводных)</td>
                        </tr>
                        <tr>
                            <th scope="row">Цвет</th>
                            <td>Черный / Белый / Другой</td>
                        </tr>
                        @elseif($categorySlug === 'peripherals-mice')
                        <tr>
                            <th scope="row">Тип подключения</th>
                            <td>беспроводное</td>
                        </tr>
                        <tr>
                            <th scope="row">Интерфейс подключения</th>
                            <td>2.4 ГГц</td>
                        </tr>
                        <tr>
                            <th scope="row">Радиус действия</th>
                            <td>до 10 м</td>
                        </tr>
                        <tr>
                            <th scope="row">Разрешение сенсора</th>
                            <td>1600 DPI</td>
                        </tr>
                        <tr>
                            <th scope="row">Дополнительные кнопки</th>
                            <td>3</td>
                        </tr>
                        <tr>
                            <th scope="row">Подсветка</th>
                            <td>нет</td>
                        </tr>
                        <tr>
                            <th scope="row">Батарейки в комплекте</th>
                            <td>есть</td>
                        </tr>
                        <tr>
                            <th scope="row">Вес изделия</th>
                            <td>82г</td>
                        </tr>
                        <tr>
                            <th scope="row">Источник питания</th>
                            <td>1xAA</td>
                        </tr>
                        <tr>
                            <th scope="row">Совместимость</th>
                            <td>Windows 10 или выше / Chrome OS</td>
                        </tr>
                        @elseif($categorySlug === 'peripherals-webcams')
                        <tr>
                            <th scope="row">Кол-во мегапикселей</th>
                            <td>2 - 8 Мп (типично)</td>
                        </tr>
                        <tr>
                            <th scope="row">Разрешение видео</th>
                            <td>Full HD (1920x1080) / HD (1280x720)</td>
                        </tr>
                        <tr>
                            <th scope="row">Частота кадров</th>
                            <td>30 FPS / 60 FPS</td>
                        </tr>
                        <tr>
                            <th scope="row">Угол обзора</th>
                            <td>60° - 90°</td>
                        </tr>
                        <tr>
                            <th scope="row">Встроенный микрофон</th>
                            <td>Есть (моно/стерео)</td>
                        </tr>
                        <tr>
                            <th scope="row">Подключение</th>
                            <td>USB 2.0 / USB 3.0 / USB-C</td>
                        </tr>
                        <tr>
                            <th scope="row">Фокусировка</th>
                            <td>Автофокус / Фиксированный фокус</td>
                        </tr>
                        <tr>
                            <th scope="row">Совместимость</th>
                            <td>Windows, macOS, Linux, ChromeOS</td>
                        </tr>
                        <tr>
                            <th scope="row">Крепление</th>
                            <td>Клипса на монитор / Резьба для штатива</td>
                        </tr>
                        <tr>
                            <th scope="row">Цвет</th>
                            <td>Черный / Серый / Белый</td>
                        </tr>
                        @elseif($categorySlug === 'components-cpu')
                        <tr>
                            <th scope="row">Производитель</th>
                            <td>Intel / AMD</td>
                        </tr>
                        <tr>
                            <th scope="row">Семейство процессора</th>
                            <td>Core i-series / Ryzen / Athlon</td>
                        </tr>
                        <tr>
                            <th scope="row">Количество ядер</th>
                            <td>От 2 до 16+</td>
                        </tr>
                        <tr>
                            <th scope="row">Количество потоков</th>
                            <td>От 4 до 32+</td>
                        </tr>
                        <tr>
                            <th scope="row">Тактовая частота</th>
                            <td>Базовая и в режиме Boost</td>
                        </tr>
                        <tr>
                            <th scope="row">Сокет</th>
                            <td>Актуальный для платформы</td>
                        </tr>
                        <tr>
                            <th scope="row">Встроенная графика</th>
                            <td>Присутствует / Отсутствует</td>
                        </tr>
                        <tr>
                            <th scope="row">Техпроцесс</th>
                            <td>Современный (нм)</td>
                        </tr>
                        <tr>
                            <th scope="row">Тепловыделение (TDP)</th>
                            <td>Зависит от модели (Вт)</td>
                        </tr>
                        <tr>
                            <th scope="row">Кэш-память L3</th>
                            <td>Объем в МБ</td>
                        </tr>
                        @elseif($categorySlug === 'components-gpu')
                        <tr>
                            <th scope="row">Производитель GPU</th>
                            <td>NVIDIA / AMD</td>
                        </tr>
                        <tr>
                            <th scope="row">Графический чип</th>
                            <td>GeForce / Radeon</td>
                        </tr>
                        <tr>
                            <th scope="row">Объем видеопамяти</th>
                            <td>От 2 ГБ до 24 ГБ+</td>
                        </tr>
                        <tr>
                            <th scope="row">Тип видеопамяти</th>
                            <td>GDDR5 / GDDR6 / GDDR6X</td>
                        </tr>
                        <tr>
                            <th scope="row">Интерфейс подключения</th>
                            <td>PCI Express x16</td>
                        </tr>
                        <tr>
                            <th scope="row">Разъемы</th>
                            <td>HDMI, DisplayPort</td>
                        </tr>
                        <tr>
                            <th scope="row">Система охлаждения</th>
                            <td>Активная (1-3 вентилятора) / Пассивная</td>
                        </tr>
                        <tr>
                            <th scope="row">Поддержка DirectX / OpenGL</th>
                            <td>Актуальные версии</td>
                        </tr>
                        <tr>
                            <th scope="row">Рекомендуемая мощность БП</th>
                            <td>Зависит от модели (Вт)</td>
                        </tr>
                        <tr>
                            <th scope="row">Длина видеокарты</th>
                            <td>Размеры в мм</td>
                        </tr>
                        @elseif($categorySlug === 'components-ram')
                        <tr>
                            <th scope="row">Тип памяти</th>
                            <td>DDR4 / DDR5</td>
                        </tr>
                        <tr>
                            <th scope="row">Объем одного модуля</th>
                            <td>4 ГБ / 8 ГБ / 16 ГБ / 32 ГБ</td>
                        </tr>
                        <tr>
                            <th scope="row">Количество модулей</th>
                            <td>1 / 2 (для Dual Channel) / 4</td>
                        </tr>
                        <tr>
                            <th scope="row">Тактовая частота</th>
                            <td>От 2400 МГц до 6000+ МГц</td>
                        </tr>
                        <tr>
                            <th scope="row">Пропускная способность</th>
                            <td>PC-XXXXX</td>
                        </tr>
                        <tr>
                            <th scope="row">Тайминги (CAS Latency)</th>
                            <td>CLXX</td>
                        </tr>
                        <tr>
                            <th scope="row">Напряжение питания</th>
                            <td>1.2 В / 1.35 В / 1.1 В</td>
                        </tr>
                        <tr>
                            <th scope="row">Наличие радиатора</th>
                            <td>Есть / Нет</td>
                        </tr>
                        <tr>
                            <th scope="row">Подсветка</th>
                            <td>RGB / Отсутствует</td>
                        </tr>
                        <tr>
                            <th scope="row">Форм-фактор</th>
                            <td>DIMM (для ПК) / SO-DIMM (для ноутбуков)</td>
                        </tr>
                        @elseif($categorySlug === 'smartphones-flagship' || $categorySlug === 'smartphones-budget')
                        <tr>
                            <th scope="row">Операционная система</th>
                            <td>Android / iOS (уточняйте)</td>
                        </tr>
                        <tr>
                            <th scope="row">Диагональ экрана</th>
                            <td>От 6.0" до 6.9"</td>
                        </tr>
                        <tr>
                            <th scope="row">Разрешение экрана</th>
                            <td>Full HD+ / QHD+</td>
                        </tr>
                        <tr>
                            <th scope="row">Тип экрана</th>
                            <td>AMOLED / IPS</td>
                        </tr>
                        <tr>
                            <th scope="row">Процессор</th>
                            <td>Современный многоядерный</td>
                        </tr>
                        <tr>
                            <th scope="row">Объем ОЗУ</th>
                            <td>От 4 ГБ до 16 ГБ</td>
                        </tr>
                        <tr>
                            <th scope="row">Встроенная память</th>
                            <td>От 64 ГБ до 1 ТБ</td>
                        </tr>
                        <tr>
                            <th scope="row">Основная камера</th>
                            <td>Высокое разрешение, несколько модулей</td>
                        </tr>
                        <tr>
                            <th scope="row">Емкость аккумулятора</th>
                            <td>От 4000 мАч</td>
                        </tr>
                        <tr>
                            <th scope="row">Беспроводные интерфейсы</th>
                            <td>Wi-Fi, Bluetooth, NFC, 5G/4G LTE</td>
                        </tr>
                        @elseif($categorySlug === 'home-appliances-tv')
                        <tr>
                            <th scope="row">Диагональ экрана</th>
                            <td>От 32" до 85"+</td>
                        </tr>
                        <tr>
                            <th scope="row">Разрешение экрана</th>
                            <td>HD / Full HD / 4K UHD / 8K</td>
                        </tr>
                        <tr>
                            <th scope="row">Технология экрана</th>
                            <td>LED / QLED / OLED / NanoCell</td>
                        </tr>
                        <tr>
                            <th scope="row">Smart TV</th>
                            <td>Есть (Tizen, webOS, Android TV и др.)</td>
                        </tr>
                        <tr>
                            <th scope="row">Частота обновления</th>
                            <td>50/60 Гц / 100/120 Гц</td>
                        </tr>
                        <tr>
                            <th scope="row">Поддержка HDR</th>
                            <td>HDR10, HLG, Dolby Vision (зависит от модели)</td>
                        </tr>
                        <tr>
                            <th scope="row">Звуковая система</th>
                            <td>Стерео, мощность в Вт, поддержка Dolby</td>
                        </tr>
                        <tr>
                            <th scope="row">Количество HDMI портов</th>
                            <td>2-4</td>
                        </tr>
                        <tr>
                            <th scope="row">Беспроводные интерфейсы</th>
                            <td>Wi-Fi, Bluetooth</td>
                        </tr>
                        <tr>
                            <th scope="row">Цифровые тюнеры</th>
                            <td>DVB-T2/C/S2</td>
                        </tr>
                        @else
                        <tr>
                            <th scope="row">Материал корпуса</th>
                            <td>Соответствует стандартам</td>
                        </tr>
                        <tr>
                            <th scope="row">Цвет</th>
                            <td>Классический дизайн</td>
                        </tr>
                        <tr>
                            <th scope="row">Вес</th>
                            <td>Оптимальный для своей категории</td>
                        </tr>
                        <tr>
                            <th scope="row">Габариты (ШхВхГ)</th>
                            <td>Компактные и эргономичные</td>
                        </tr>
                        <tr>
                            <th scope="row">Гарантия производителя</th>
                            <td>12 месяцев</td>
                        </tr>
                        <tr>
                            <th scope="row">Страна производства</th>
                            <td>Высокотехнологичное производство</td>
                        </tr>
                        <tr>
                            <th scope="row">Комплектация</th>
                            <td>Стандартная, включает необходимое</td>
                        </tr>
                        <tr>
                            <th scope="row">Тип подключения</th>
                            <td>Современные интерфейсы</td>
                        </tr>
                        <tr>
                            <th scope="row">Совместимость</th>
                            <td>Широкая, с популярными устройствами</td>
                        </tr>
                        <tr>
                            <th scope="row">Особенности</th>
                            <td>Инновационные технологии, высокое качество</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
                @endif
            </div>
            <div class="tab-pane fade p-4" id="reviews-tab-pane" role="tabpanel" aria-labelledby="reviews-tab" tabindex="0">
                <h3 class="h5 mb-3">Отзывы покупателей</h3>
                @if($product->reviews->isNotEmpty())
                @foreach($product->reviews as $review)
                <div class="mb-3 border-bottom pb-3">
                    <strong>{{ $review->user_name ?? 'Аноним' }}</strong>
                    <small class="text-muted ms-2">{{ $review->created_at->format('d.m.Y') }}</small>
                    <p class="mt-1 mb-0">{{ $review->comment }}</p>
                </div>
                @endforeach
                @else
                <p class="text-muted">Отзывов пока нет. Будьте первым!</p>
                @endif
            </div>
        </div>
    </div>

    @if(isset($relatedProducts) && $relatedProducts->count() > 0)
    <div class="mt-5">
        <h2 class="h4 mb-4">Похожие товары</h2>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
            @foreach($relatedProducts as $relatedProduct)
            <div class="col">
                @include('catalog.partials.product_card', ['product' => $relatedProduct])
            </div>
            @endforeach
        </div>
    </div>
    @endif

</div>
@endsection

@push('scripts')
<script>
    function changeMainImage(newSrc, clickedThumbnail) {
        document.getElementById('mainProductImage').src = newSrc;
        const thumbnails = document.querySelectorAll('.product-gallery-thumbnail');
        thumbnails.forEach(thumb => thumb.classList.remove('active'));
        if (clickedThumbnail) {
            clickedThumbnail.classList.add('active');
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        const skuValueInput = document.getElementById('skuValueInput');
        const copyButton = document.getElementById('copySkuButton');
        const googleSearchButton = document.getElementById('searchSkuGoogleButton');
        const copyFeedbackElement = document.getElementById('copyFeedback');

        const sku = skuValueInput ? skuValueInput.value.trim() : null;
        const isSkuAvailable = sku && sku !== 'N/A';

        if (copyButton && isSkuAvailable) {
            const originalCopyIconHTML = copyButton.innerHTML;

            copyButton.addEventListener('click', function () {
                navigator.clipboard.writeText(sku).then(function () {
                    copyFeedbackElement.textContent = 'Артикул скопирован!';
                    copyFeedbackElement.classList.remove('text-danger');
                    copyFeedbackElement.classList.add('text-success');

                    copyButton.innerHTML = `<i class="bi bi-check-lg text-success"></i>`;
                    copyButton.disabled = true;

                    setTimeout(() => {
                        copyFeedbackElement.textContent = '';
                        copyButton.innerHTML = originalCopyIconHTML;
                        copyButton.disabled = false;
                    }, 2000);
                }).catch(function (err) {
                    copyFeedbackElement.textContent = 'Ошибка копирования!';
                    copyFeedbackElement.classList.remove('text-success');
                    copyFeedbackElement.classList.add('text-danger');
                    console.error('Could not copy text: ', err);
                    setTimeout(() => {
                        copyFeedbackElement.textContent = '';
                    }, 3000);
                });
            });
        } else if (copyButton) {
            copyButton.disabled = true;
        }

        if (googleSearchButton && isSkuAvailable) {
            googleSearchButton.addEventListener('click', function () {
                const googleSearchUrl = `https://www.google.com/search?q=${encodeURIComponent(sku)}`;
                window.open(googleSearchUrl, '_blank');
            });
        } else if (googleSearchButton) {
            googleSearchButton.disabled = true;
        }
    });
</script>
@endpush