{{-- Файл: resources/views/compare/index.blade.php (улучшенный дизайн) --}}

@extends('layouts.app')

@section('title', 'Сравнение товаров')

@push('styles')
<style>
    .compare-page-wrapper {
        --compare-border-color: var(--bs-border-color);
        --compare-header-bg: var(--bs-tertiary-bg);
    }
    .compare-table {
        table-layout: fixed;
        border-collapse: separate;
        border-spacing: 0;
    }
    .compare-table th,
    .compare-table td {
        border: 1px solid var(--compare-border-color);
        padding: 1rem;
        vertical-align: middle;
    }
    .compare-table thead th {
        vertical-align: top;
        min-width: 250px;
        border-top: none;
    }
    .compare-table th:first-child,
    .compare-table td:first-child {
        position: sticky;
        left: 0;
        z-index: 2;
        width: 20%;
        min-width: 200px;
        background-color: var(--compare-header-bg);
        border-left: none;
    }
    .compare-table td:first-child {
        font-weight: 500;
        background-color: var(--bs-body-bg);
    }
    .compare-table tr:hover td:first-child {
        background-color: var(--compare-header-bg);
    }
    .compare-table th:last-child,
    .compare-table td:last-child {
        border-right: none;
    }
    .compare-table tbody tr:last-child td {
        border-bottom: none;
    }
    .product-header img {
        width: 100%;
        max-height: 180px;
        object-fit: contain;
        margin-bottom: 1rem;
    }
    .product-header .product-title {
        font-size: 1rem;
        font-weight: 600;
        min-height: 48px; /* 2 строки текста */
    }
    .product-header .product-price {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--bs-primary);
    }
    .empty-compare {
        min-height: 60vh;
    }
</style>
@endpush


@section('content')
<div class="container py-5">
    @if($products->isEmpty())
        <div class="d-flex flex-column align-items-center justify-content-center text-center empty-compare">
            <i class="bi bi-files-alt" style="font-size: 5rem; color: var(--bs-secondary-color);"></i>
            <h1 class="h2 mt-4">Список сравнения пуст</h1>
            <p class="lead text-muted">Добавьте товары для сравнения, чтобы увидеть их характеристики здесь.</p>
            <a href="{{ route('catalog.index') }}" class="btn btn-primary btn-lg mt-3">
                <i class="bi bi-box-seam me-2"></i>Перейти в каталог
            </a>
        </div>
    @else
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h2 mb-0">Сравнение товаров ({{ $products->count() }})</h1>
            {{-- TODO: Добавить форму для очистки списка --}}
        </div>

        <div class="table-responsive compare-page-wrapper">
            <table class="table compare-table text-center">
                <thead>
                    <tr>
                        <th></th> {{-- Пустая ячейка для выравнивания --}}
                        @foreach ($products as $product)
                            <th>
                                <div class="product-header">
                                    <a href="{{ route('product.show', $product->slug) }}">
                                        <img src="{{ $product->thumbnail_url ?? 'https://placehold.co/200x180/FFFFFF/E0E0E0?text=No+Image' }}" alt="{{ $product->name }}" class="img-fluid rounded mb-3">
                                    </a>
                                    <h5 class="product-title mb-2">
                                        <a href="{{ route('product.show', $product->slug) }}" class="text-body text-decoration-none">{{ $product->name }}</a>
                                    </h5>
                                    <div class="product-price mb-3">{{ number_format($product->price, 0, '.', ' ') }} TMT</div>
                                    
                                    <div class="d-grid gap-2">
                                         <button class="btn btn-primary">
                                            <i class="bi bi-cart-plus"></i> В корзину
                                        </button>
                                        <form action="{{ route('compare.toggle', $product->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-secondary w-100">
                                                <i class="bi bi-trash"></i> Убрать
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    @foreach ($comparisonData as $attribute => $values)
                    <tr>
                        <td>{{ $attribute }}</td>
                        @foreach ($values as $value)
                            <td>{!! $value !!}</td>
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection