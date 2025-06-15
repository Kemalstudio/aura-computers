<div class="card shadow-sm product-card border-0 rounded-3 overflow-hidden d-flex flex-column h-100">
    <div class="product-card-top-actions position-absolute top-0 end-0 m-2 d-flex align-items-center" style="z-index: 10;">
        {{-- Элемент для Сравнения (работает с JS из layouts/app.blade.php) --}}
        <label class="product-action-control d-flex align-items-center p-1 rounded me-1" for="compareCheckbox_{{ $product->id ?? Str::random(5) }}" title="Сравнить" style="font-size: 12px; line-height: 1; cursor:pointer;">
            <input class="form-check-input m-0 me-1 shadow-none compare-checkbox" type="checkbox" value="{{ $product->id ?? '' }}" id="compareCheckbox_{{ $product->id ?? Str::random(5) }}" style="width: 1em; height: 1em;">
            Сравнить
        </label>

        {{-- Кнопка Zoom (восстановлена) --}}
        <button type="button" class="product-action-control btn btn-light btn-sm p-0 me-1 d-flex align-items-center justify-content-center" style="width: 24px; height: 24px;" aria-label="Zoom" title="Zoom">
            <i class="bi bi-zoom-in" style="font-size: 13px;"></i>
        </button>

        {{-- Кнопка "Избранное" (работает с JS из layouts/app.blade.php) --}}
        <button
            type="button"
            class="product-action-control product-action-favorite btn btn-light btn-sm p-0 d-flex align-items-center justify-content-center"
            style="width: 24px; height: 24px;"
            aria-label="Добавить в избранное"
            title="Добавить в избранное"
            data-product-id="{{ $product->id }}">
            <i class="bi bi-heart" style="font-size: 13px;"></i>
        </button>
    </div>

    <a href="{{ route('product.show', $product->slug) }}" class="text-decoration-none product-card-image-link">
        @if($product->thumbnail_url)
        <img src="{{ $product->thumbnail_url }}" class="card-img-top product-card-img" alt="{{ $product->name }}">
        @else
        <div class="product-card-img-placeholder d-flex align-items-center justify-content-center">
            <i class="bi bi-image text-muted" style="font-size: 3rem;"></i>
        </div>
        @endif
    </a>

    <div class="card-body d-flex flex-column p-3">
        <h5 class="card-title mb-1 fs-6">
            <a href="{{ route('product.show', $product->slug) }}" class="text-blue text-decoration-none product-name-link stretched-link">
                {{ Str::limit($product->name, 50) }}
            </a>
        </h5>
        @if($product->category)
        <small class="text-muted mb-2 d-block product-category-link" style="font-size: 0.8em;">
            <a href="{{ route('catalog.index', ['category' => $product->category->slug] + request()->except(['category', 'page'])) }}" class="text-muted text-decoration-none">
                {{ $product->category->name }}
            </a>
        </small>
        @endif
        <p class="card-text small text-muted mb-3 flex-grow-1 product-description" style="font-size: 0.85em; min-height: 60px;">
            {{ Str::limit($product->description ?? 'Описание товара скоро появится.', 75) }}
        </p>
        <div class="d-flex justify-content-between align-items-center mt-auto pt-2 border-top-dashed">
            <p class="fw-bold fs-5 mb-0 text-primary product-price">
                {{ number_format($product->price ?? 0, 0, ',', ' ') }} <small class="text-muted" style="font-size:0.7em; font-weight:normal;">TMT</small>
            </p>
            <button class="btn btn-sm btn-primary rounded-pill px-3 add-to-cart-btn"
                data-product-id="{{ $product->id }}"
                aria-label="Добавить в корзину {{ $product->name }}">
                <span class="btn-icon"><i class="bi bi-cart-plus"></i></span>
                <span class="btn-text d-none d-sm-inline ms-1">В корзину</span>
            </button>
        </div>
    </div>

    {{-- Бейджи "Новинка", "Скидка" и т.д. --}}
    @if(isset($product->is_new) && $product->is_new) <span class="badge bg-info position-absolute top-0 start-0 m-2 shadow-sm product-badge">Новинка</span> @endif
    @if(isset($product->on_sale_price) && $product->on_sale_price < $product->price) <span class="badge bg-danger position-absolute top-0 end-0 m-2 shadow-sm product-badge">Скидка</span> @endif
        @if(isset($product->quantity) && $product->quantity !== null && $product->quantity == 0) <span class="badge bg-warning text-dark position-absolute top-0 end-0 m-2 shadow-sm product-badge" style="right: auto !important; left: 0 !important; top: 2rem !important;">Нет в наличии</span> @endif
</div>

{{-- Этот блок будет добавлен только один раз на страницу, даже если карточек много --}}
@once
@push('styles')
<style>
    :root {
        --product-bg: rgba(255, 255, 255, 0.85);
        --product-border: #e9ecef;
        --product-shadow: 0 1px 3px rgba(0, 0, 0, 0.06);
        --product-icon-color: #495057;
        --product-hover-bg: rgba(255, 255, 255, 1);
        --product-hover-border: #adb5bd;
        --product-hover-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
        --product-hover-icon-color: #212529;
        --product-focus-border: var(--bs-primary, #0d6efd);
        --product-focus-shadow: 0 0 0 0.2rem rgba(var(--bs-primary-rgb, 13, 110, 253), 0.25);
        --product-favorite-active-color: var(--bs-danger, #dc3545);
        --product-favorite-active-bg: rgba(var(--bs-danger-rgb, 220, 53, 69), 0.1);
    }

    .product-card {
        position: relative;
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.65rem 1.2rem rgba(var(--bs-dark-rgb, 0, 0, 0), .12) !important;
    }

    .product-card-top-actions {
        opacity: 0;
        visibility: hidden;
        transform: translateY(5px);
        transition: all 0.25s ease-out;
    }

    .product-card:hover .product-card-top-actions {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    .product-action-control {
        background-color: var(--product-bg);
        border: 1px solid var(--product-border);
        box-shadow: var(--product-shadow);
        color: var(--product-icon-color);
        border-radius: .25rem;
        transition: all 0.2s ease-out;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.25rem 0.5rem;
    }

    .product-action-control.btn-sm {
        padding: 0;
    }

    .product-action-control:hover,
    label.product-action-control:hover {
        background-color: var(--product-hover-bg);
        border-color: var(--product-hover-border);
        box-shadow: var(--product-hover-shadow);
        color: var(--product-hover-icon-color);
        transform: scale(1.05) translateY(-1px);
        z-index: 1;
    }

    .product-action-control:focus,
    .product-action-control:focus-visible,
    label.product-action-control:focus-within {
        outline: none;
        border-color: var(--product-focus-border);
        box-shadow: var(--product-focus-shadow), var(--product-hover-shadow);
        z-index: 2;
    }

    .product-action-control .bi {
        color: var(--product-icon-color);
        transition: all 0.2s ease-out;
        vertical-align: middle;
    }

    .product-action-control:hover .bi,
    label.product-action-control:hover .bi {
        color: var(--product-hover-icon-color);
    }

    label.product-action-control .form-check-input {
        border-color: var(--product-border);
        background-color: transparent;
        transition: border-color 0.2s ease-out;
    }

    label.product-action-control:hover .form-check-input {
        border-color: var(--product-hover-border);
    }

    label.product-action-control .form-check-input:checked {
        background-color: var(--bs-primary, #0d6efd);
        border-color: var(--bs-primary, #0d6efd);
    }

    label.product-action-control .form-check-input:focus {
        box-shadow: none;
    }

    .product-card-img,
    .product-card-img-placeholder {
        height: 300px;
        object-fit: cover;
        background-color: #f8f9fa;
    }

    .product-card-img-placeholder {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .product-name-link:hover {
        color: var(--bs-primary) !important;
    }

    .product-category-link a:hover {
        text-decoration: underline !important;
    }

    .border-top-dashed {
        border-top: 1px dashed var(--bs-border-color-translucent, rgba(0, 0, 0, 0.1));
    }

    .product-badge {
        font-size: 0.7em;
        padding: 0.35em 0.6em;
        letter-spacing: 0.05em;
        z-index: 5;
    }

    /* === Стили для плавной анимации иконки "Избранное" === */
    .product-action-favorite.is-favorite {
        background-color: var(--product-favorite-active-bg);
        border-color: var(--product-favorite-active-color);
    }

    .product-action-favorite.is-favorite .bi {
        color: var(--product-favorite-active-color);
        transform: scale(1.1);
    }

    .product-action-favorite.is-favorite .bi-heart::before {
        content: "\f415";
        font-weight: bold;
    }
</style>
@endpush
@endonce