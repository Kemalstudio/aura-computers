@extends('layouts.app')

@section('title', $product->meta_title ?: ($product->name . ' - Aura Computers'))

@push('styles')
<link rel="shortcut icon" href="/images/logo/logo.svg" type="image/x-icon">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
    body {
        /* Используем переменные Bootstrap для совместимости с темной/светлой темой */
        background-color: var(--bs-body-bg);
    }

    .product-card {
        border-radius: 0.75rem;
        overflow: hidden;
        background-color: var(--bs-tertiary-bg);
        border: 1px solid var(--bs-border-color);
    }

    /* Стили для Карусели изображений */
    .product-carousel-item img {
        max-height: 500px;
        object-fit: contain;
        width: 100%;
    }

    .carousel-control-prev-icon,
    .carousel-control-next-icon {
        background-color: rgba(0, 0, 0, 0.3);
        border-radius: 50%;
        padding: 1.2rem;
        background-size: 50%;
    }

    .product-gallery-thumbnail {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border: 2px solid var(--bs-border-color);
        border-radius: 0.375rem;
        cursor: pointer;
        transition: border-color 0.2s ease-in-out, transform 0.2s ease-in-out;
        opacity: 0.6;
    }

    .product-gallery-thumbnail:hover {
        opacity: 1;
        transform: scale(1.05);
    }

    .product-gallery-thumbnail.active {
        border-color: var(--bs-primary, #0d6efd);
        opacity: 1;
        transform: scale(1.05);
    }

    /* Стили для Артикула */
    .sku-input-group .form-control {
        border-right: 0;
        background-color: var(--bs-body-bg);
    }

    .sku-input-group .btn {
        border-color: var(--bs-border-color);
    }

    .sku-input-group .btn-google {
        font-weight: bold;
        color: #db4437;
    }

    .sku-input-group .btn:hover {
        background-color: var(--bs-tertiary-bg);
    }

    /* Стили для блока "Добавить в корзину" */
    .quantity-selector {
        max-width: 150px;
    }

    .product-price-display {
        font-weight: 700;
    }

    .product-brand-logo {
        max-height: 20px;
        width: auto;
    }

    .nav-tabs {
        border-bottom: 2px solid var(--bs-border-color);
    }

    .nav-tabs .nav-link {
        color: var(--bs-secondary-color);
        border: none;
        border-bottom: 2px solid transparent;
        border-radius: 0;
        font-weight: 500;
        padding: 0.75rem 1rem;
        margin-bottom: -2px;
        transition: color 0.15s ease-in-out, border-color 0.15s ease-in-out;
    }

    .nav-tabs .nav-link.active {
        color: var(--bs-primary);
        background-color: transparent;
        border-color: var(--bs-primary);
        font-weight: 600;
    }

    .tab-content-wrapper {
        background-color: var(--bs-tertiary-bg);
        border: 1px solid var(--bs-border-color);
        border-top: none;
        border-radius: 0 0 0.5rem 0.5rem;
    }

    .product-specs-table th {
        background-color: var(--bs-body-bg);
        width: 35%;
        font-weight: 500;
    }

    /* Fix for number input arrows in Chrome/Safari */
    .quantity-input {
        -webkit-appearance: textfield;
        -moz-appearance: textfield;
        appearance: textfield;
    }

    .quantity-input::-webkit-outer-spin-button,
    .quantity-input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* === СТИЛИ ДЛЯ АКТИВНОЙ КНОПКИ "ИЗБРАННОЕ" === */
    .product-action-favorite .icon-filled,
    .product-action-favorite .text-in-favorites {
        display: none;
    }

    .product-action-favorite.is-favorite {
        background-color: var(--bs-danger-bg-subtle);
        border-color: var(--bs-danger-border-subtle);
        color: var(--bs-danger-text-emphasis);
    }

    .product-action-favorite.is-favorite .icon-filled,
    .product-action-favorite.is-favorite .text-in-favorites {
        display: inline-block;
    }

    .product-action-favorite.is-favorite .icon-empty,
    .product-action-favorite.is-favorite .text-add-to-favorites {
        display: none;
    }
</style>
@endpush

@section('content')
<div class="container py-4 py-lg-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Главная</a></li>
            @if($product->category)
            <li class="breadcrumb-item"><a href="{{ route('catalog.index', ['category' => $product->category->slug]) }}">{{ $product->category->name }}</a></li>
            @endif
            <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($product->name, 50) }}</li>
        </ol>
    </nav>

    <div class="card product-card shadow-sm">
        <div class="card-body p-lg-4">
            <div class="row g-4 g-lg-5">
                {{-- Carousel Section --}}
                <div class="col-lg-6">
                    @php
                    $galleryImages = [];
                    if ($product->thumbnail_url) { $galleryImages[] = $product->thumbnail_url; }
                    if (!empty($product->images) && is_array($product->images)) { $galleryImages = array_merge($galleryImages, $product->images); }
                    @endphp
                    @if(!empty($galleryImages))
                    <div id="productImageCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner rounded">
                            @foreach($galleryImages as $image)
                            <div class="carousel-item @if ($loop->first) active @endif product-carousel-item">
                                <img src="{{ $image }}" class="d-block w-100" alt="Изображение товара {{ $loop->iteration }}">
                            </div>
                            @endforeach
                        </div>
                        @if(count($galleryImages) > 1)
                        <button class="carousel-control-prev" type="button" data-bs-target="#productImageCarousel" data-bs-slide="prev"><span class="carousel-control-prev-icon" aria-hidden="true"></span><span class="visually-hidden">Previous</span></button>
                        <button class="carousel-control-next" type="button" data-bs-target="#productImageCarousel" data-bs-slide="next"><span class="carousel-control-next-icon" aria-hidden="true"></span><span class="visually-hidden">Next</span></button>
                        @endif
                    </div>
                    @if(count($galleryImages) > 1)
                    <div class="d-flex flex-wrap justify-content-center gap-2 mt-3" id="productThumbnails">
                        @foreach($galleryImages as $image)
                        <img src="{{ $image }}" alt="Миниатюра {{ $loop->iteration }}" class="product-gallery-thumbnail @if ($loop->first) active @endif" data-bs-target="#productImageCarousel" data-bs-slide-to="{{ $loop->index }}">
                        @endforeach
                    </div>
                    @endif
                    @else
                    <img src="{{ asset('images/placeholder-product.png') }}" class="img-fluid rounded" alt="Нет изображения">
                    @endif
                </div>

                <div class="col-lg-6 d-flex flex-column">
                    @if($product->brand)
                    <div class="d-flex align-items-center mb-2">
                        @if($product->brand->logo_url)
                        <img src="{{ $product->brand->logo_url }}" alt="{{ $product->brand->name }}" class="me-2 product-brand-logo">
                        @else
                        <span class="text-muted small">Производитель: {{ $product->brand->name }}</span>
                        @endif
                    </div>
                    @endif
                    <h1 class="h2 fw-bold mb-3">{{ $product->name }}</h1>
                    <div class="mb-3">
                        <label for="skuInput" class="form-label small text-muted">Артикул / Модель</label>
                        <div class="input-group sku-input-group">
                            <input type="text" id="skuInput" class="form-control" value="{{ $product->sku ?? 'N/A' }}" readonly>
                            <button class="btn btn-outline-secondary" type="button" id="copySkuBtn" title="Копировать артикул"><i class="bi bi-clipboard"></i></button>
                            <a href="https://www.google.com/search?q={{ urlencode($product->name . ' ' . ($product->sku ?? '')) }}" target="_blank" class="btn btn-outline-secondary btn-google" title="Искать в Google">G</a>
                        </div>
                    </div>
                    <div class="d-flex align-items-center text-muted small mb-3">
                        @if($product->quantity > 0)
                        <span class="text-success fw-medium"><i class="bi bi-check-circle-fill me-1"></i>В наличии</span>
                        @else
                        <span class="text-danger fw-medium"><i class="bi bi-x-circle-fill me-1"></i>Нет в наличии</span>
                        @endif
                    </div>

                    {{-- Price and Actions Block --}}
                    <div class="mt-auto">
                        <div class="bg-body-tertiary p-3 rounded-3 mb-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="h2 fw-bolder text-primary product-price-display">{{ number_format($product->sale_price ?? $product->price, 0, ',', ' ') }}</span>
                                    <span class="ms-1 text-muted">TMT</span>
                                    @if(isset($product->sale_price) && $product->sale_price < $product->price)
                                        <s class="text-muted ms-2 d-block"><small>{{ number_format($product->price, 0, ',', ' ') }} TMT</small></s>
                                        @endif
                                </div>
                                @if(isset($product->sale_price) && $product->sale_price < $product->price)
                                    <span class="badge bg-danger fs-6">СКИДКА</span>
                                    @endif
                            </div>
                        </div>

                        @if($product->quantity > 0)
                        <form action="{{-- route('cart.add', $product) --}}" method="POST" class="mb-3">
                            @csrf
                            <div class="d-flex gap-2">
                                <div class="input-group quantity-selector">
                                    <button class="btn btn-outline-secondary" type="button" onclick="this.nextElementSibling.stepDown()">-</button>
                                    <input type="number" name="quantity" class="form-control text-center quantity-input" value="1" min="1" max="{{ $product->quantity }}" aria-label="Количество">
                                    <button class="btn btn-outline-secondary" type="button" onclick="this.previousElementSibling.stepUp()">+</button>
                                </div>
                                <button type="submit" class="btn btn-primary btn-lg flex-grow-1">
                                    <i class="bi bi-cart2 me-2"></i>Добавить в корзину
                                </button>
                            </div>
                        </form>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-outline-secondary w-50 product-action-favorite" data-product-id="{{ $product->id }}">
                                <i class="bi bi-heart-fill icon-filled"></i>
                                <i class="bi bi-heart icon-empty"></i>
                                <span class="text-in-favorites ms-1">В избранном</span>
                                <span class="text-add-to-favorites ms-1">В избранное</span>
                            </button>
                            <div class="w-50 d-grid">
                                <input type="checkbox"
                                    class="btn-check compare-checkbox"
                                    id="compareCheck-{{ $product->id }}"
                                    value="{{ $product->id }}"
                                    autocomplete="off">
                                <label class="btn btn-outline-secondary" for="compareCheck-{{ $product->id }}">
                                    <i class="bi bi-bar-chart-line me-1"></i> Сравнить
                                </label>
                            </div>
                        </div>
                        @else
                        <div class="alert alert-warning" role="alert"><i class="bi bi-info-circle-fill me-2"></i>К сожалению, этого товара сейчас нет в наличии.</div>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-outline-primary w-50"><i class="bi bi-bell me-1"></i> Сообщить о поступлении</button>
                            <div class="w-50 d-grid">
                                <input type="checkbox" class="btn-check compare-checkbox" id="compareCheck-{{ $product->id }}" value="{{ $product->id }}" autocomplete="off">
                                <label class="btn btn-outline-secondary" for="compareCheck-{{ $product->id }}"><i class="bi bi-bar-chart-line me-1"></i> Сравнить</label>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabs with Description and Specifications --}}
    <div class="mt-5">
        <ul class="nav nav-tabs" id="productTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description-tab-pane" type="button" role="tab" aria-controls="description-tab-pane" aria-selected="true">Описание</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="specifications-tab" data-bs-toggle="tab" data-bs-target="#specifications-tab-pane" type="button" role="tab" aria-controls="specifications-tab-pane" aria-selected="false">Характеристики</button>
            </li>
            <li class="nav-item" role="presentation">
                {{-- Предполагаем, что у вас может быть связь reviews() на модели Product --}}
                <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews-tab-pane" type="button" role="tab" aria-controls="reviews-tab-pane" aria-selected="false">Отзывы ({{ $product->reviews->count() ?? 0 }})</button>
            </li>
        </ul>
        <div class="tab-content tab-content-wrapper" id="productTabContent">
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

            <!-- ========================================================= -->
            <!-- ВОССТАНОВЛЕНО: Блок "Характеристики" из вашего второго примера -->
            <!-- ========================================================= -->
            <div class="tab-pane fade p-0" id="specifications-tab-pane" role="tabpanel" aria-labelledby="specifications-tab" tabindex="0">
                @php
                // Используем метод getDisplayableAttributes(), как в вашем рабочем примере.
                // Если такого метода нет, замените его на `$product->attributes`
                $displayableAttributes = method_exists($product, 'getDisplayableAttributes') ? $product->getDisplayableAttributes() : ($product->attributes ?? collect());
                @endphp
                @if($displayableAttributes->isNotEmpty())
                <table class="table table-striped table-hover product-specs-table mb-0">
                    <tbody>
                        @foreach($displayableAttributes as $attribute)
                        <tr>
                            <th scope="row">
                                {{-- В зависимости от структуры, может быть $attribute->name или $attribute->attribute->name --}}
                                {{ $attribute->name ?? $attribute->attribute->name }}
                            </th>
                            <td>
                                @if(isset($attribute->value))
                                {{ $attribute->value }}
                                {{-- Если это стандартная связь many-to-many, то значение в pivot таблице --}}
                                @elseif(isset($attribute->pivot))
                                {{ $attribute->pivot->value }}
                                @endif

                                @if(isset($attribute->unit))
                                {{ $attribute->unit }}
                                @elseif(isset($attribute->attribute->unit))
                                {{ $attribute->attribute->unit }}
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <div class="p-4">
                    <p class="text-muted">Подробные характеристики для этого товара пока отсутствуют.</p>
                </div>
                @endif
            </div>

            <div class="tab-pane fade p-4" id="reviews-tab-pane" role="tabpanel" aria-labelledby="reviews-tab" tabindex="0">
                <p class="text-muted">Отзывы пока отсутствуют. Станьте первым!</p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const copyBtn = document.getElementById('copySkuBtn');
        if (copyBtn) {
            const skuInput = document.getElementById('skuInput');
            const originalIcon = copyBtn.innerHTML;
            copyBtn.addEventListener('click', function() {
                navigator.clipboard.writeText(skuInput.value).then(() => {
                    copyBtn.innerHTML = '<i class="bi bi-check-lg text-success"></i>';
                    copyBtn.title = 'Скопировано!';
                    setTimeout(() => {
                        copyBtn.innerHTML = originalIcon;
                        copyBtn.title = 'Копировать артикул';
                    }, 2000);
                });
            });
        }

        const productImageCarouselEl = document.getElementById('productImageCarousel');
        if (productImageCarouselEl) {
            const thumbnails = document.querySelectorAll('#productThumbnails .product-gallery-thumbnail');
            const carouselInstance = new bootstrap.Carousel(productImageCarouselEl);

            productImageCarouselEl.addEventListener('slide.bs.carousel', function(event) {
                thumbnails.forEach(thumb => thumb.classList.remove('active'));
                const activeThumb = document.querySelector(`.product-gallery-thumbnail[data-bs-slide-to="${event.to}"]`);
                if (activeThumb) {
                    activeThumb.classList.add('active');
                }
            });

            thumbnails.forEach(thumb => {
                thumb.addEventListener('click', function() {
                    const slideIndex = this.getAttribute('data-bs-slide-to');
                    carouselInstance.to(parseInt(slideIndex));
                })
            })
        }

        const favoriteBtn = document.querySelector('.product-action-favorite');
        if (favoriteBtn) {

            favoriteBtn.addEventListener('click', function() {
                const productId = this.dataset.productId;
                const isFavorite = this.classList.contains('is-favorite');

                //     if (data.success) {
                this.classList.toggle('is-favorite');
                //     }
                // });

                this.classList.toggle('is-favorite');
            });
        }
    });
</script>
@endpush