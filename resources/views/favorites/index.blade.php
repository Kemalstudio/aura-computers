@extends('layouts.app')

@section('title', 'Избранные товары')

@section('content')
<div class="container py-4 py-lg-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0 h2">Избранные товары</h1>
        @if($products->total() > 0)
        <span class="text-muted">Всего: {{ $products->total() }}</span>
        @endif
    </div>

    @if($products->isNotEmpty())
    {{-- Сетка для отображения товаров --}}
    <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 row-cols-xl-4 g-4">
        @foreach($products as $product)
        <div class="col">
            {{-- Здесь мы переиспользуем вашу стандартную карточку товара --}}
            {{-- Убедитесь, что путь правильный! Возможно, 'components.product-card' --}}
            @include('catalog.partials.product_card', ['product' => $product])
        </div>
        @endforeach
    </div>

    {{-- Пагинация (появится, если товаров будет больше 12) --}}
    <div class="mt-5 d-flex justify-content-center">
        {{ $products->links() }}
    </div>

    @else
    {{-- Красивое сообщение, если избранное пустое --}}
    <div class="text-center py-5 my-5" style="background-color: var(--bs-light-bg-subtle); border-radius: .75rem;">
        <i class="bi bi-heart-fill" style="font-size: 4rem; color: var(--bs-secondary-color);"></i>
        <h3 class="mt-3">Ваш список избранного пуст</h3>
        <p class="text-muted mb-4">Добавляйте товары, нажимая на сердечко, чтобы не потерять их.</p>
        <a href="{{ route('catalog.index') }}" class="btn btn-primary">Перейти в каталог</a>
    </div>
    @endif
</div>
@endsection