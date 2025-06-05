@extends('layouts.app')

@section('title', $product->meta_title ?: ($product->name . ' - Aura Computers'))

@push('styles')
{{-- Your existing styles from the provided file --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
    body { background-color: #f8f9fa; }
    .product-gallery-main-img { max-height: 550px; object-fit: contain; background-color: #fff; border-radius: 0.5rem; border: 1px solid #dee2e6; }
    .product-gallery-thumbnail { width: 90px; height: 90px; object-fit: cover; border: 2px solid transparent; border-radius: 0.375rem; cursor: pointer; transition: border-color 0.2s ease-in-out, transform 0.2s ease-in-out; }
    .product-gallery-thumbnail:hover, .product-gallery-thumbnail.active { border-color: var(--bs-primary, #0d6efd); transform: scale(1.05); }
    /* ... All your other existing styles for product page ... */
    .nav-tabs .nav-link { color: #495057; border: 1px solid transparent; border-bottom-color: #dee2e6; border-radius: 0.5rem 0.5rem 0 0; font-weight: 500; padding: 0.75rem 1.25rem; transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out; }
    .nav-tabs .nav-link.active { color: var(--bs-primary, #0d6efd); background-color: #fff; border-color: #dee2e6 #dee2e6 #fff; border-bottom: 3px solid var(--bs-primary, #0d6efd) !important; font-weight: 600; }
    .tab-content { background-color: #fff; border: 1px solid #dee2e6; border-top: none; border-radius: 0 0 0.5rem 0.5rem; padding: 1.5rem; }
    .product-specs-table th { background-color: #f8f9fa; width: 30%; font-weight: 500; }
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
            {{-- Product Gallery Column --}}
            <div class="col-lg-6">
                {{-- ... Your existing gallery HTML ... --}}
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

            {{-- Product Info Column --}}
            <div class="col-lg-6">
                {{-- ... Your existing product info (brand, name, SKU, price, add to cart) ... --}}
                 @if($product->brand)
                <div class="d-flex align-items-center mb-2">
                    @if($product->brand->logo_url)
                    <img src="{{ $product->brand->logo_url }}" alt="{{ $product->brand->name }}" class="me-2 product-brand-logo">
                    @endif
                    <span class="text-muted small">Производитель: {{ $product->brand->name }}</span>
                </div>
                @endif
                <h1 class="h2 fw-bold mb-2">{{ $product->name }}</h1>
                {{-- SKU Widget --}}
                {{-- Price --}}
                {{-- Add to cart, availability --}}
                 <div class="mb-4">
                    <span class="h1 fw-bolder product-price-display">{{ number_format($product->sale_price ?? $product->price, 2, ',', ' ') }}</span>
                    <span class="product-price-currency">TMT</span>
                    @if(isset($product->sale_price) && $product->sale_price < $product->price)
                        <s class="text-muted ms-2"><small>{{ number_format($product->price, 2, ',', ' ') }} TMT</small></s>
                        <span class="badge bg-danger ms-2">Скидка!</span>
                    @elseif($product->on_sale && isset($product->old_price) && $product->old_price > $product->price) {{-- Assuming old_price is a field you might use --}}
                        <s class="text-muted ms-2"><small>{{ number_format($product->old_price, 2, ',', ' ') }} TMT</small></s>
                        <span class="badge bg-danger ms-2">Скидка!</span>
                    @endif
                </div>
                 <div class="product-availability">
                    @if($product->quantity > 0)
                    <p class="text-success mb-1"><i class="bi bi-check-circle-fill"></i> <span class="badge bg-success-subtle text-success-emphasis rounded-pill badge-availability">В наличии ({{ $product->quantity }} шт.)</span></p>
                    @else
                    <p class="text-danger mb-1"><i class="bi bi-x-circle-fill"></i> <span class="badge bg-danger-subtle text-danger-emphasis rounded-pill badge-availability">Нет в наличии</span></p>
                    @endif
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
                    // Product model's getDisplayableAttributes() will handle fetching and sorting.
                    // Ensure it's eager loaded in controller: $product->load('MappedAttributes.attributeDefinition', 'category.attributes');
                    $displayableAttributes = $product->getDisplayableAttributes();
                @endphp

                @if($displayableAttributes->isNotEmpty())
                    <table class="table table-striped table-hover product-specs-table mb-0">
                        <tbody>
                            @foreach($displayableAttributes as $attribute)
                                <tr>
                                    <th scope="row">{{ $attribute->name }}</th>
                                    <td>
                                        {{ $attribute->value }}
                                        @if($attribute->unit)
                                            {{ $attribute->unit }}
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
                {{-- ... Your existing reviews display ... --}}
            </div>
        </div>
    </div>

    @if(isset($relatedProducts) && $relatedProducts->count() > 0)
        {{-- ... Your related products display ... --}}
    @endif
</div>
@endsection

@push('scripts')
{{-- Your existing scripts for gallery, SKU copy --}}
<script>
    function changeMainImage(newSrc, clickedThumbnail) { /* ... */ }
    document.addEventListener('DOMContentLoaded', function () { /* ... SKU copy logic ... */ });
</script>
@endpush