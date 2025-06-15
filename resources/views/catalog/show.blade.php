@extends('layouts.app')

@section('title', $product->meta_title ?: ($product->name . ' - Aura Computers'))

@push('styles')
<style>
    /* --- Ваши стили остаются без изменений --- */
    .product-card {
        border-radius: 0.75rem;
        overflow: hidden;
        background-color: var(--bs-tertiary-bg);
        border: 1px solid var(--bs-border-color);
    }

    .product-carousel-item img {
        max-height: 500px;
        object-fit: contain; /* ИЗМЕНЕНО: Изображение полностью помещается в контейнер */
        width: 100%;
        height: 500px; 
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

    .product-gallery-thumbnail:hover,
    .product-gallery-thumbnail.active {
        opacity: 1;
        transform: scale(2.05);
    }

    .product-gallery-thumbnail.active {
        border-color: var(--bs-primary, #0d6efd);
    }

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

    .compare-checkbox:checked+label {
        background-color: var(--bs-info-bg-subtle);
        border-color: var(--bs-info-border-subtle);
        color: var(--bs-info-text-emphasis);
    }
    
    .image-zoom-container {
        position: relative;
    }

    .product-carousel-item {
        position: relative; 
    }

    .product-carousel-item img {
        cursor: crosshair;
    }
    
    .zoom-result {
        border: 1px solid var(--bs-border-color);
        position: absolute;
        top: 0;
        left: 100%;
        margin-left: 1rem; 
        width: 100%; 
        height: 500px;
        background-repeat: no-repeat;
        z-index: 1050;
        pointer-events: none;
        background-color: var(--bs-body-bg);
        border-radius: 0.375rem;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        visibility: hidden;
        opacity: 0;
        transition: opacity 0.2s linear, visibility 0.2s linear;
    }

    .zoom-lens {
        position: absolute;
        border: 2px solid var(--bs-primary); 
        background-color: rgba(255, 255, 255, 0.3);
        width: 150px; 
        height: 150px; 
        pointer-events: none;
        z-index: 1051;
        visibility: hidden;
        opacity: 0;
        transition: opacity 0.2s linear, visibility 0.2s linear;
    }

    @media (max-width: 991.98px) {
        .zoom-result,
        .zoom-lens {
            display: none !important;
        }
        .product-carousel-item img {
            cursor: default;
        }
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
                    <div class="image-zoom-container">
                        @php
                        $galleryImages = [];
                        if ($product->thumbnail_url) { $galleryImages[] = $product->thumbnail_url; }
                        if (!empty($product->images) && is_array($product->images)) { $galleryImages = array_merge($galleryImages, $product->images); }
                        @endphp
                        @if(!empty($galleryImages))
                        <div id="productImageCarousel" class="carousel slide">
                            <div class="carousel-inner rounded">
                                @foreach($galleryImages as $image)
                                <div class="carousel-item @if ($loop->first) active @endif product-carousel-item">
                                    <img src="{{ $image }}" class="d-block w-100" alt="Изображение товара {{ $loop->iteration }}" data-zoom-image="{{ $image }}">
                                    <div class="zoom-lens"></div>
                                </div>
                                @endforeach
                            </div>
                            @if(count($galleryImages) > 1)
                            <button class="carousel-control-prev" type="button" data-bs-target="#productImageCarousel" data-bs-slide="prev"><span class="carousel-control-prev-icon" aria-hidden="true"></span><span class="visually-hidden">Previous</span></button>
                            <button class="carousel-control-next" type="button" data-bs-target="#productImageCarousel" data-bs-slide="next"><span class="carousel-control-next-icon" aria-hidden="true"></span><span class="visually-hidden">Next</span></button>
                            @endif
                        </div>
                        
                        <div id="zoom-result" class="zoom-result"></div>

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
                </div>

                {{-- Product Info Section (остается без изменений) --}}
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
                        <form id="addToCartForm" action="{{ route('cart.add', $product) }}" method="POST" class="d-grid gap-2">
                            @csrf
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="btn btn-primary btn-lg btn-add-to-cart">
                                <i class="bi bi-cart-plus-fill me-2"></i>Добавить в корзину
                            </button>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-outline-secondary w-100 product-action-favorite" data-product-id="{{ $product->id }}">
                                    <i class="bi bi-heart-fill icon-filled"></i>
                                    <i class="bi bi-heart icon-empty"></i>
                                    <span class="text-in-favorites ms-1">В избранном</span>
                                    <span class="text-add-to-favorites ms-1">В избранное</span>
                                </button>
                                <div class="w-100 d-grid">
                                    <input type="checkbox" class="btn-check compare-checkbox" id="compareCheck-{{ $product->id }}" value="{{ $product->id }}" autocomplete="off" data-product-id="{{ $product->id }}">
                                    <label class="btn btn-outline-secondary" for="compareCheck-{{ $product->id }}"><i class="bi bi-bar-chart-line me-1"></i>Сравнить</label>
                                </div>
                            </div>
                        </form>
                        @else
                        <div class="alert alert-warning" role="alert"><i class="bi bi-info-circle-fill me-2"></i>К сожалению, этого товара сейчас нет в наличии.</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabs with Description, Specifications and Reviews (остается без изменений) --}}
    <div class="mt-5">
        <ul class="nav nav-tabs" id="productTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description-tab-pane" type="button" role="tab" aria-controls="description-tab-pane" aria-selected="true">Описание</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="specifications-tab" data-bs-toggle="tab" data-bs-target="#specifications-tab-pane" type="button" role="tab" aria-controls="specifications-tab-pane" aria-selected="false">Характеристики</button>
            </li>
            <li class="nav-item" role="presentation">
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

            <div class="tab-pane fade p-0" id="specifications-tab-pane" role="tabpanel" aria-labelledby="specifications-tab" tabindex="0">
                @php
                $displayableAttributes = method_exists($product, 'getDisplayableAttributes') ? $product->getDisplayableAttributes() : ($product->attributes ?? collect());
                @endphp
                @if($displayableAttributes->isNotEmpty())
                <table class="table table-striped table-hover product-specs-table mb-0">
                    <tbody>
                        @foreach($displayableAttributes as $attribute)
                        <tr>
                            <th scope="row">
                                {{ $attribute->name ?? $attribute->attribute->name }}
                            </th>
                            <td>
                                @if(isset($attribute->value))
                                {{ $attribute->value }}
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
    // --- Вспомогательные функции и старая логика (без изменений) ---
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    const productId = "{{ $product->id }}";
    async function apiRequest(url, method = 'POST', body = null) {
        try {
            const options = { method, headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' } };
            const response = await fetch(url, options);
            if (!response.ok) {
                const errorData = await response.json();
                throw new Error(errorData.message || `Ошибка ${response.status}`);
            }
            return response.json();
        } catch (error) {
            console.error('Ошибка API запроса:', error);
            alert('Произошла ошибка. Пожалуйста, попробуйте позже.');
            throw error;
        }
    }
    const favoriteBtn = document.querySelector('.product-action-favorite');
    if (favoriteBtn) {
        favoriteBtn.addEventListener('click', function() {
            this.disabled = true;
            apiRequest(`/favorites/toggle/${productId}`).then(data => {
                this.classList.toggle('is-favorite', data.is_favorite);
                const favoritesBadge = document.getElementById('favoritesCountBadge');
                if (favoritesBadge) favoritesBadge.textContent = data.count;
            }).finally(() => { this.disabled = false; });
        });
    }
    const compareCheckbox = document.querySelector('.compare-checkbox');
    if (compareCheckbox) {
        compareCheckbox.addEventListener('change', function() {
            const label = this.nextElementSibling;
            label.style.pointerEvents = 'none';
            apiRequest(`/compare/toggle/${productId}`).then(data => {
                this.checked = data.in_compare;
                const compareBadge = document.getElementById('compareCountBadge');
                if (compareBadge) compareBadge.textContent = data.count;
            }).finally(() => { label.style.pointerEvents = 'auto'; });
        });
    }
    @auth
    function checkInitialStatus() {
        const favorites = {!! json_encode(auth()->user()->favorites->pluck('id')) !!};
        const compares = {!! json_encode(session('compare', [])) !!};
        if (favoriteBtn && favorites.includes(parseInt(productId))) { favoriteBtn.classList.add('is-favorite'); }
        if (compareCheckbox && compares.includes(parseInt(productId))) { compareCheckbox.checked = true; }
    }
    checkInitialStatus();
    @endauth
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
        const carouselInstance = new bootstrap.Carousel(productImageCarouselEl, { interval: false });
        productImageCarouselEl.addEventListener('slide.bs.carousel', function(event) {
            thumbnails.forEach(thumb => thumb.classList.remove('active'));
            const activeThumb = document.querySelector(`.product-gallery-thumbnail[data-bs-slide-to="${event.to}"]`);
            if (activeThumb) { activeThumb.classList.add('active'); }
        });
        thumbnails.forEach(thumb => {
            thumb.addEventListener('click', function() {
                const slideIndex = this.getAttribute('data-bs-slide-to');
                carouselInstance.to(parseInt(slideIndex));
            })
        })
    }

    // --- НОВАЯ, ПОЛНОСТЬЮ ПЕРЕРАБОТАННАЯ ЛОГИКА ZOOM ---
    function imageZoom(carouselItem) {
        if (window.matchMedia('(max-width: 991.98px)').matches) return;

        let img, lens, result, nativeImage;
        let xOffset = 0, yOffset = 0, renderedWidth = 0, renderedHeight = 0;
        let bgWidth, bgHeight;
        let zoomRatioX, zoomRatioY;

        img = carouselItem.querySelector('img[data-zoom-image]');
        lens = carouselItem.querySelector('.zoom-lens');
        result = document.getElementById('zoom-result');

        if (!img || !lens || !result) return;
        
        carouselItem.removeEventListener('mousemove', moveLens);
        carouselItem.addEventListener('mouseenter', showZoom);
        carouselItem.addEventListener('mouseleave', hideZoom);

        nativeImage = new Image();
        nativeImage.src = img.dataset.zoomImage;

        nativeImage.onload = function() {
            const boxWidth = img.clientWidth;
            const boxHeight = img.clientHeight;
            const nativeWidth = nativeImage.width;
            const nativeHeight = nativeImage.height;
            const boxAspectRatio = boxWidth / boxHeight;
            const nativeAspectRatio = nativeWidth / nativeHeight;

            // Логика для `object-fit: contain`
            if (nativeAspectRatio > boxAspectRatio) {
                renderedWidth = boxWidth;
                renderedHeight = renderedWidth / nativeAspectRatio;
            } else {
                renderedHeight = boxHeight;
                renderedWidth = renderedHeight * nativeAspectRatio;
            }
            
            xOffset = (boxWidth - renderedWidth) / 2;
            yOffset = (boxHeight - renderedHeight) / 2;
            
            zoomRatioX = nativeWidth / renderedWidth;
            zoomRatioY = nativeHeight / renderedHeight;

            bgWidth = result.offsetWidth * zoomRatioX;
            bgHeight = result.offsetHeight * zoomRatioY;

            result.style.backgroundImage = "url('" + nativeImage.src + "')";
            result.style.backgroundSize = bgWidth + "px " + bgHeight + "px";

            carouselItem.addEventListener('mousemove', moveLens);
        }

        function showZoom(e) {
            lens.style.visibility = 'visible';
            lens.style.opacity = '1';
            result.style.visibility = 'visible';
            result.style.opacity = '1';
            moveLens(e); 
        }

        function hideZoom() {
            lens.style.visibility = 'hidden';
            lens.style.opacity = '0';
            result.style.visibility = 'hidden';
            result.style.opacity = '0';
        }
        
        function moveLens(e) {
            e.preventDefault();
            const pos = getCursorPos(e);

            let lensX = pos.x - (lens.offsetWidth / 2);
            let lensY = pos.y - (lens.offsetHeight / 2);
            if (lensX < 0) lensX = 0;
            if (lensY < 0) lensY = 0;
            if (lensX > img.clientWidth - lens.offsetWidth) lensX = img.clientWidth - lens.offsetWidth;
            if (lensY > img.clientHeight - lens.offsetHeight) lensY = img.clientHeight - lens.offsetHeight;
            lens.style.left = lensX + "px";
            lens.style.top = lensY + "px";

            const imgCursorX = pos.x - xOffset;
            const imgCursorY = pos.y - yOffset;
            
            let bgX = - (imgCursorX * zoomRatioX - result.offsetWidth / 2);
            let bgY = - (imgCursorY * zoomRatioY - result.offsetHeight / 2);

            const maxBgX = -(bgWidth - result.offsetWidth);
            const maxBgY = -(bgHeight - result.offsetHeight);

            if (bgX > 0) bgX = 0;
            if (bgY > 0) bgY = 0;
            if (bgX < maxBgX) bgX = maxBgX;
            if (bgY < maxBgY) bgY = maxBgY;

            result.style.backgroundPosition = bgX + "px " + bgY + "px";
        }

        function getCursorPos(e) {
            e = e || window.event;
            const rect = e.currentTarget.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            return {x : x, y : y};
        }
    }

    if (productImageCarouselEl) {
        const initialActiveItem = productImageCarouselEl.querySelector('.carousel-item.active');
        if (initialActiveItem) {
             const img = initialActiveItem.querySelector('img');
             if (img.complete) {
                 imageZoom(initialActiveItem);
             } else {
                 img.addEventListener('load', () => imageZoom(initialActiveItem));
             }
        }

        productImageCarouselEl.addEventListener('slid.bs.carousel', function (event) {
            const img = event.relatedTarget.querySelector('img');
            if (img.complete) {
                imageZoom(event.relatedTarget);
            } else {
                img.addEventListener('load', () => imageZoom(event.relatedTarget));
            }
        });
    }
});
</script>
@endpush