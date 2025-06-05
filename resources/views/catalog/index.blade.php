@extends('layouts.app')

@php
$allPossibleSpecificFilterKeysFromController = isset($activeSpecificFiltersConfig) ? array_keys($activeSpecificFiltersConfig) : [];
$keysToClearOnNavigateOrReset = array_unique(array_merge(
['page', 'brands', 'min_price', 'max_price', 'availability', 'is_new'],
$allPossibleSpecificFilterKeysFromController
));

$isAnyFilterApplied = false;
if ((request('brands') && !empty(request('brands'))) ||
(request('min_price') !== null && request('min_price') != ($overallMinPrice ?? 0)) ||
(request('max_price') !== null && ($overallMaxPrice === null || request('max_price') != ($overallMaxPrice ?? 1000000))) ||
request('availability') ||
(request('is_new') == '1')) {
$isAnyFilterApplied = true;
}
if (!$isAnyFilterApplied && isset($activeSpecificFiltersConfig) && is_array($activeSpecificFiltersConfig)) {
foreach (array_keys($activeSpecificFiltersConfig) as $specificFilterKey) {
$requestVal = request($specificFilterKey);
if ($requestVal !== null && $requestVal !== '' && (!is_array($requestVal) || !empty($requestVal))) {
$isAnyFilterApplied = true;
break;
}
}
}
$showResetButtons = $isAnyFilterApplied;


$categoryNameMapping = [
'laptops-and-other' => 'Ноутбуки и прочее',
'laptops-notebooks' => 'Ноутбуки',
'laptops-bags-backpacks' => 'Сумки и рюкзаки',
'pc-components' => 'Комплектующие для ПК',
'components-cpu' => 'Процессоры (CPU)',
'components-gpu' => 'Видеокарты (GPU)',
'components-ram' => 'Оперативная память (RAM)',
'components-ssd-hdd' => 'Накопители (SSD/HDD)',
'peripherals' => 'Периферия',
'peripherals-keyboards' => 'Клавиатуры',
'peripherals-mice' => 'Мыши',
'peripherals-headsets' => 'Наушники и гарнитуры',
'home-appliances' => 'Бытовая техника',
'home-appliances-tv' => 'Телевизоры',
'bytovaya-tehnika-vacuums' => 'Пылесосы',
'bytovaya-tehnika-kettles' => 'Чайники',
'smartphones' => 'Смартфоны',
'smartphones-flagship' => 'Флагманы',
'smartphones-budget' => 'Бюджетные смартфоны',
];

$categoryIconMapping = [
'laptops-and-other' => 'https://sumbar-computer.com/storage/c/szSI0hREMu.png',
'laptops-notebooks' => 'https://sumbar-computer.com/storage/c/0TXKFi5JV9.png',
'peripherals' => 'https://sumbar-computer.com/storage/c/2yC7wYe2nJ.png', 
'peripherals-mice' => 'https://sumbar-computer.com/storage/c/1bzwb23MUD.png',
];

$pageTitle = 'Каталог товаров';
$headerCategoryName = 'Каталог товаров';

if (isset($selectedCategory) && $selectedCategory instanceof \App\Models\Category) {
$currentSlugForTitle = $selectedCategory->slug;
$headerCategoryName = $categoryNameMapping[$currentSlugForTitle] ?? $selectedCategory->name;
$pageTitle = $headerCategoryName . ' - Каталог Aura Computers';
} elseif (isset($selectedCategorySlug) && !empty($selectedCategorySlug)) {
$headerCategoryName = $categoryNameMapping[$selectedCategorySlug] ?? Str::title(str_replace('-', ' ', $selectedCategorySlug));
$pageTitle = $headerCategoryName . ' - Каталог Aura Computers';
}

$defaultCategoryIconPath = asset('https://sumbar-computer.com/storage/c/gfqhF8K7rq.png');

@endphp

@section('title', $pageTitle)

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-lg-3">
            <aside style="position: sticky; top: calc(var(--navbar-height, 70px) + 1.5rem); z-index: 1000;">
                <form id="filterForm" action="{{ route('catalog.index') }}" method="GET" class="filters-sidebar">
                    @if(request('sort')) <input type="hidden" name="sort" value="{{ request('sort') }}"> @endif
                    @if($selectedCategorySlug) <input type="hidden" name="category" value="{{ $selectedCategorySlug }}"> @endif
                    <input type="hidden" name="page" value="1">

                    <div class="category-controls mb-4">
                        <a href="{{ route('catalog.index', array_merge(request()->except($keysToClearOnNavigateOrReset), ['category' => null, 'page' => 1])) }}" class="btn btn-primary w-100 mb-2 d-flex align-items-center justify-content-center fw-semibold">
                            <i class="bi bi-list me-2"></i> ВСЕ ТОВАРЫ
                        </a>
                        <button class="btn btn-secondary w-100 d-flex align-items-center justify-content-center fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCategoriesList" aria-expanded="true" aria-controls="collapseCategoriesList">
                            <i class="bi bi-arrow-down-short me-2"></i> КАТЕГОРИИ
                        </button>
                        <div class="collapse show mt-2" id="collapseCategoriesList">
                            <div class="card">
                                <ul class="list-group list-group-flush list-group-categories-styled">
                                    @forelse($categories as $categoryItem)
                                    @php
                                    $displayName = $categoryNameMapping[$categoryItem->slug] ?? $categoryItem->name;
                                    $hasChildren = $categoryItem->children && $categoryItem->children->isNotEmpty();

                                    $specificIconForItem = $categoryIconMapping[$categoryItem->slug] ?? null;
                                    $iconUrl = $categoryItem->full_icon_url ?: ($specificIconForItem ?: $defaultCategoryIconPath);

                                    $categoryLinkClass = '';
                                    if ($selectedCategorySlug === $categoryItem->slug) {
                                    $categoryLinkClass = 'active';
                                    } elseif (isset($selectedCategory) && $selectedCategory->parent_id === $categoryItem->id) {
                                    $categoryLinkClass = 'active-parent';
                                    } elseif (isset($selectedCategory, $selectedCategory->parent) && $selectedCategory->parent->parent_id === $categoryItem->id) {
                                    $categoryLinkClass = 'active-parent';
                                    }
                                    @endphp
                                    <li class="list-group-item {{ $hasChildren ? 'has-submenu' : '' }}">
                                        <a href="{{ route('catalog.index', array_merge(request()->except($keysToClearOnNavigateOrReset), ['category' => $categoryItem->slug, 'page' => 1])) }}" class="list-group-item-action d-flex align-items-center category-link {{ $categoryLinkClass }}">
                                            <img src="{{ $iconUrl }}" alt="" class="category-icon me-2">
                                            <span class="category-text flex-grow-1">{{ $displayName }}</span>
                                            @if($hasChildren)
                                            <i class="bi bi-chevron-right submenu-indicator ms-auto"></i>
                                            @endif
                                        </a>
                                        @if($hasChildren)
                                        <ul class="list-group submenu shadow-lg rounded-3 py-1">
                                            @foreach($categoryItem->children as $subCategory)
                                            @php
                                            $subDisplayName = $categoryNameMapping[$subCategory->slug] ?? $subCategory->name;

                                            $specificIconForSubItem = $categoryIconMapping[$subCategory->slug] ?? null;
                                            $subIconUrl = $subCategory->full_icon_url ?: ($specificIconForSubItem ?: $defaultCategoryIconPath);

                                            $subHasChildren = $subCategory->children && $subCategory->children->isNotEmpty();
                                            $subCategoryLinkClass = ($selectedCategorySlug === $subCategory->slug) ? 'active' : '';
                                            if (!$subCategoryLinkClass && isset($selectedCategory) && $selectedCategory->parent_id === $subCategory->id) {
                                            $subCategoryLinkClass = 'active-parent';
                                            }
                                            @endphp
                                            <li class="list-group-item {{ $subHasChildren ? 'has-submenu' : '' }}">
                                                <a href="{{ route('catalog.index', array_merge(request()->except($keysToClearOnNavigateOrReset), ['category' => $subCategory->slug, 'page' => 1])) }}" class="list-group-item-action subcategory-link d-flex align-items-center {{ $subCategoryLinkClass }}">
                                                    <img src="{{ $subIconUrl }}" alt="" class="category-icon me-2">
                                                    <span class="category-text flex-grow-1">{{ $subDisplayName }}</span>
                                                    @if($subHasChildren)
                                                    <i class="bi bi-chevron-right submenu-indicator ms-auto"></i>
                                                    @endif
                                                </a>
                                                @if($subHasChildren)
                                                <ul class="list-group submenu shadow-lg rounded-3 py-1 submenu-left">
                                                    @foreach($subCategory->children as $subSubCategory)
                                                    @php
                                                    $subSubDisplayName = $categoryNameMapping[$subSubCategory->slug] ?? $subSubCategory->name;

                                                    $specificIconForSubSubItem = $categoryIconMapping[$subSubCategory->slug] ?? null;
                                                    $subSubIconUrl = $subSubCategory->full_icon_url ?: ($specificIconForSubSubItem ?: $defaultCategoryIconPath);

                                                    $subSubCategoryLinkClass = ($selectedCategorySlug === $subSubCategory->slug) ? 'active' : '';
                                                    @endphp
                                                    <li class="list-group-item">
                                                        <a href="{{ route('catalog.index', array_merge(request()->except($keysToClearOnNavigateOrReset), ['category' => $subSubCategory->slug, 'page' => 1])) }}" class="list-group-item-action subcategory-link d-flex align-items-center {{ $subSubCategoryLinkClass }}">
                                                            <img src="{{ $subSubIconUrl }}" alt="" class="category-icon me-2">
                                                            <span class="category-text flex-grow-1">{{ $subSubDisplayName }}</span>
                                                        </a>
                                                    </li>
                                                    @endforeach
                                                </ul>
                                                @endif
                                            </li>
                                            @endforeach
                                        </ul>
                                        @endif
                                    </li>
                                    @empty
                                    <li class="list-group-item text-muted p-3"><i class="bi bi-info-circle me-2"></i>Категории не найдены.</li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    </div>

                    @include('catalog.partials.static_filters')

                    @if(isset($availableSpecificFiltersData) && !empty($availableSpecificFiltersData))
                    @foreach($availableSpecificFiltersData as $filterKey => $filterItemData)
                    @include('catalog.partials.dynamic_filter_item', ['filterKey' => $filterKey, 'filterData' => $filterItemData])
                    @endforeach
                    @endif

                    <button type="submit" class="btn btn-primary w-100 mt-3"><i class="bi bi-funnel-fill me-1"></i> Применить фильтры</button>
                    @if($showResetButtons)
                    <a href="{{ route('catalog.index', ['category' => $selectedCategorySlug, 'sort' => request('sort')]) }}" class="btn btn-outline-danger w-100 mt-2"><i class="bi bi-x-lg me-1"></i> Сбросить фильтры</a>
                    @endif
                </form>
            </aside>
        </div>

        <div class="col-lg-9">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4 pb-2 border-bottom">
                <div>
                    <h1 class="h2 mb-0 fw-bold">{{ $headerCategoryName }}</h1>
                    @if(isset($products) && $products->total() > 0)
                    <small class="text-muted">
                        Найдено товаров: {{ $products->total() }}
                        @php
                        $activeFilterPartsSummary = [];
                        if(isset($selectedBrandSlugs) && !empty($selectedBrandSlugs) && isset($availableBrands) && $availableBrands->count() > 0) {
                        $brandNames = $availableBrands->whereIn('slug', $selectedBrandSlugs)->pluck('name')->implode(', ');
                        if ($brandNames) $activeFilterPartsSummary[] = "бренды: " . Str::limit($brandNames, 30);
                        }
                        $minPriceReqVal = request('min_price'); $maxPriceReqVal = request('max_price');
                        $priceFilterString = "";
                        if ($minPriceReqVal !== null && $minPriceReqVal != ($overallMinPrice ?? 0)) $priceFilterString .= " от " . number_format((float)$minPriceReqVal,0,'.',' ');
                        if ($maxPriceReqVal !== null && ($overallMaxPrice === null || $maxPriceReqVal != ($overallMaxPrice ?? 1000000))) $priceFilterString .= " до " . number_format((float)$maxPriceReqVal,0,'.',' ');
                        if (!empty(trim($priceFilterString))) $activeFilterPartsSummary[] = "цена" . trim($priceFilterString) . " TMT";

                        if(request('availability') == 'in_stock') $activeFilterPartsSummary[] = "в наличии";
                        elseif(request('availability') == 'out_of_stock') $activeFilterPartsSummary[] = "нет в наличии";
                        if(request('is_new') == '1') $activeFilterPartsSummary[] = "новинки";

                        if (isset($availableSpecificFiltersData) && is_array($availableSpecificFiltersData)) {
                        foreach ($availableSpecificFiltersData as $filterKey => $filterItemDataForSummary) {
                        $requestValue = request($filterKey);
                        if ($requestValue !== null && $requestValue !== '' && (!is_array($requestValue) || !empty($requestValue))) {
                        $filterLabel = $filterItemDataForSummary['label'] ?? Str::title(str_replace('_', ' ', $filterKey));
                        $displayValue = '';
                        if (is_array($requestValue)) {
                        $labels = [];
                        foreach($requestValue as $val) {
                        $labels[] = $filterItemDataForSummary['options'][(string)$val] ?? Str::title(str_replace('_', ' ', $val));
                        }
                        $displayValue = implode(', ', array_unique($labels));
                        } else {
                        $displayValue = $filterItemDataForSummary['options'][(string)$requestValue] ?? Str::title(str_replace('_', ' ', (string) $requestValue));
                        }
                        if ($displayValue) {
                        $activeFilterPartsSummary[] = Str::lower($filterLabel) . ": " . $displayValue;
                        }
                        }
                        }
                        }
                        @endphp
                        @if(count($activeFilterPartsSummary) > 0)
                        <span class="d-block d-md-inline">(по фильтрам: {{ implode('; ', $activeFilterPartsSummary) }})</span>
                        @endif
                    </small>
                    @endif
                </div>
                @if((isset($products) && $products->total() > 0) || request()->has('sort') || $showResetButtons )
                <div class="dropdown mt-3 mt-md-0">
                    <button class="btn btn-outline-secondary dropdown-toggle rounded-pill" type="button" id="sortDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="min-width: 220px;">
                        <i class="bi bi-sort-down me-1"></i> Сортировка:
                        <span class="fw-medium">{{ (isset($sortOptions) && isset($sortBy) && isset($sortOptions[$sortBy])) ? strip_tags($sortOptions[$sortBy]) : 'По умолчанию' }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-lg animate slideIn border-0 rounded-3" aria-labelledby="sortDropdown">
                        @if(isset($sortOptions) && is_array($sortOptions))
                        @foreach($sortOptions as $key => $value)
                        <li>
                            <a class="dropdown-item py-2 {{ (isset($sortBy) && $sortBy == $key) ? 'active fw-semibold' : '' }}" href="{{ route('catalog.index', array_merge(request()->query(), ['sort' => $key, 'page' => 1])) }}">
                                {!! $value !!}
                            </a>
                        </li>
                        @endforeach
                        @endif
                    </ul>
                </div>
                @endif
            </div>

            @if(isset($products) && $products->count())
            <div class="row row-cols-1 row-cols-sm-2 row-cols-xl-3 g-4" id="products-grid">
                @foreach($products as $product)
                <div class="col d-flex">@include('catalog.partials.product_card', ['product' => $product])</div>
                @endforeach
            </div>
            <div class="mt-5" id="pagination-links">
                {{ $products->appends(request()->query())->links() }}
            </div>
            @else
            <div class="alert alert-light text-center shadow-sm rounded-3 p-4 border">
                <i class="bi bi-cart-x fs-1 d-block mx-auto mb-3 text-secondary"></i>
                <h4 class="alert-heading fw-semibold">Товары не найдены</h4>
                <p class="mb-2 text-muted">
                    К сожалению, по вашему запросу
                    @if(isset($selectedCategory) && $selectedCategory && $headerCategoryName !== 'Каталог товаров')
                    в категории <strong class="fw-semibold">"{{ $headerCategoryName }}"</strong>
                    @elseif(isset($selectedCategorySlug) && $selectedCategorySlug && $headerCategoryName !== 'Каталог товаров')
                    в категории <strong class="fw-semibold">"{{ $headerCategoryName }}"</strong>
                    @endif
                    @if($showResetButtons) с учетом выбранных фильтров @endif
                    товары отсутствуют.
                </p>
                <hr class="my-3">
                <p class="mb-0 small">
                    Попробуйте <a href="{{ route('catalog.index', ['category' => $selectedCategorySlug, 'sort' => request('sort')]) }}" class="alert-link fw-medium">сбросить фильтры</a> (оставив категорию и сортировку) или <a href="{{ route('catalog.index') }}" class="alert-link fw-medium">вернитесь на главную страницу каталога</a>.
                </p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.7.1/nouislider.min.css" integrity="sha512-qveKnGrvOBAmgpVftctWXDKMcHPFJQKNtSYeKiHC8OUQ5SF9DGGHGv+NkQA2HYFJA丿A5gRV4xBYhEq8q9AoQL8g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
    :root {
        --navbar-height: 60px;
        --bs-primary-rgb: 13, 110, 253;
        --bs-primary: #0d6efd;
        --bs-primary-bg-subtle: #cfe2ff;
        --bs-list-group-color: #212529;
        --bs-list-group-bg: #fff;
        --bs-list-group-border-color: rgba(0, 0, 0, .08);
        --bs-list-group-hover-bg: #f0f0f0;
        --bs-list-group-hover-color: var(--bs-primary);
        --bs-list-group-active-color: #fff;
        --bs-list-group-active-bg: var(--bs-primary);
        --bs-list-group-active-border-color: var(--bs-primary);
        --bs-border-radius: .375rem;
    }

    body {
        padding-top: var(--navbar-height);
    }

    #appNavbar {
        z-index: 1030;
    }

    .dropdown-menu.animate {
        animation-duration: 0.25s;
        animation-fill-mode: both;
    }

    .dropdown-menu.animate.slideIn {
        animation-name: slideInSubtle;
    }

    @keyframes slideInSubtle {
        0% {
            transform: translateY(-5px);
            opacity: 0;
        }

        100% {
            transform: translateY(0);
            opacity: 1;
        }
    }

    .list-group-categories-styled .list-group-item {
        border: none;
        padding: 0;
        position: relative;
    }

    .list-group-categories-styled .list-group-item .category-link,
    .list-group-categories-styled .list-group-item .subcategory-link {
        padding: 0.6rem 1rem;
        font-size: 0.875rem;
        text-decoration: none;
        color: var(--bs-list-group-color);
        display: flex;
        align-items: center;
        width: 100%;
        transition: background-color 0.15s ease-in-out, color 0.15s ease-in-out;
        border-radius: var(--bs-border-radius);
    }

    .list-group-categories-styled .list-group-item .category-link:hover,
    .list-group-categories-styled .list-group-item .subcategory-link:hover {
        background-color: var(--bs-list-group-hover-bg);
        color: var(--bs-list-group-hover-color);
    }

    .list-group-categories-styled .list-group-item .category-link.active,
    .list-group-categories-styled .list-group-item .subcategory-link.active {
        color: var(--bs-list-group-active-color);
        background-color: var(--bs-list-group-active-bg);
        font-weight: 500;
    }

    .list-group-categories-styled .list-group-item .category-link.active-parent {
        background-color: var(--bs-primary-bg-subtle);
        color: var(--bs-primary);
        font-weight: 500;
    }

    .list-group-categories-styled .list-group-item .category-icon {
        flex-shrink: 0;
        width: 20px;
        height: 20px;
        object-fit: contain;
    }

    .list-group-categories-styled .list-group-item .category-text {
        flex-grow: 1;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        margin-right: 0.5rem;
    }

    .list-group-categories-styled .list-group-item .submenu-indicator {
        transition: transform 0.2s ease-in-out;
        font-size: 0.8em;
    }

    .list-group-categories-styled .list-group-item.has-submenu .submenu {
        display: block;
        visibility: hidden;
        opacity: 0;
        position: absolute;
        left: 100%;
        top: -1px;
        min-width: 250px;
        z-index: 1025;
        padding-left: 0;
        list-style: none;
        background-color: var(--bs-list-group-bg, #fff);
        border: 1px solid var(--bs-list-group-border-color, rgba(0, 0, 0, .1));
        margin-top: 0;
        border-radius: 0 var(--bs-border-radius) var(--bs-border-radius) 0;
        box-shadow: 0.125rem 0.25rem 0.5rem rgba(0, 0, 0, .1);
        transform: translateX(10px);
        transition: opacity 0.2s ease-out, visibility 0s linear 0.2s, transform 0.2s ease-out;
    }

    .list-group-categories-styled .list-group-item.has-submenu:hover>.submenu,
    .list-group-categories-styled .list-group-item.has-submenu .submenu:hover {
        visibility: visible;
        opacity: 1;
        transform: translateX(0);
        transition-delay: 0s, 0s, 0s;
    }

    .list-group-categories-styled .list-group-item.has-submenu .submenu.submenu-left {
        left: auto;
        right: 100%;
        transform: translateX(-10px);
        border-radius: var(--bs-border-radius) 0 0 var(--bs-border-radius);
    }

    .list-group-categories-styled .list-group-item.has-submenu .submenu.submenu-left .list-group-item {
        padding-left: 0.5rem;
    }

    .list-group-categories-styled .list-group-item.has-submenu:hover>.submenu.submenu-left,
    .list-group-categories-styled .list-group-item.has-submenu .submenu.submenu-left:hover {
        transform: translateX(0);
    }

    .filter-section.card {
        border: 1px solid #e9ecef;
    }

    .filter-section-title {
        cursor: pointer;
        font-size: 0.95rem;
        padding: 0.6rem 1rem;
    }

    .filter-section-title:hover {
        background-color: #f8f9fa;
    }

    .filter-section-body {
        padding: 0.75rem 1rem;
        max-height: 250px;
        overflow-y: auto;
        font-size: 0.875rem;
    }

    .filter-section-body .form-check {
        margin-bottom: 0.5rem;
        padding-left: 1.9em;
    }

    .filter-section .filter-arrow {
        transition: transform 0.2s ease-in-out;
    }

    .filter-section-title[aria-expanded="false"] .filter-arrow {
        transform: rotate(-90deg);
    }

    #price-slider {
        margin-top: 1rem;
        margin-bottom: 0.25rem;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.7.1/nouislider.min.js" integrity="sha512-UOJe4paV6hYWBnS0c9GnUkMkfLAIUPGohistPKSf管UoXDrsr9wU2YsfRoGxxxsKPdws79H99fSO3GNK2kX/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    const overallMinPriceJSValue = {
        {
            $overallMinPrice ?? 0
        }
    };
    const overallMaxPriceJSValue = {
        {
            $overallMaxPrice ?? 100000
        }
    };
    const overallMaxPriceJS = overallMaxPriceJSValue > overallMinPriceJSValue ? overallMaxPriceJSValue : (overallMinPriceJSValue + 1000);

    document.addEventListener('DOMContentLoaded', function() {
        const appNavbar = document.getElementById('appNavbar');
        if (appNavbar) {
            const setNavbarHeight = () => {
                document.documentElement.style.setProperty('--navbar-height', appNavbar.offsetHeight + 'px');
            };
            setNavbarHeight();
            new ResizeObserver(setNavbarHeight).observe(appNavbar);
        }

        const priceSlider = document.getElementById('price-slider');
        if (priceSlider && typeof noUiSlider !== 'undefined' && overallMaxPriceJS > overallMinPriceJSValue) {
            const minPriceInput = document.getElementById('min_price_filter');
            const maxPriceInput = document.getElementById('max_price_filter');

            if (minPriceInput && maxPriceInput) {
                let startMin = parseFloat(minPriceInput.value) || overallMinPriceJSValue;
                let startMax = parseFloat(maxPriceInput.value) || overallMaxPriceJS;
                startMin = Math.max(overallMinPriceJSValue, Math.min(startMin, overallMaxPriceJS));
                startMax = Math.max(startMin, Math.min(startMax, overallMaxPriceJS));

                noUiSlider.create(priceSlider, {
                    start: [startMin, startMax],
                    connect: true,
                    step: 1,
                    range: {
                        'min': [overallMinPriceJSValue],
                        'max': [overallMaxPriceJS]
                    },
                    format: {
                        to: v => parseInt(v),
                        from: v => parseInt(v)
                    }
                });
                priceSlider.noUiSlider.on('update', (values) => {
                    minPriceInput.value = values[0];
                    maxPriceInput.value = values[1];
                });

                function updateSliderFromInput(inputElement, sliderHandleIndex) {
                    let value = parseFloat(inputElement.value);
                    let sliderValues = priceSlider.noUiSlider.get();

                    if (sliderHandleIndex === 0) {
                        value = Math.max(overallMinPriceJSValue, Math.min(value, parseFloat(sliderValues[1])));
                        inputElement.value = value;
                        priceSlider.noUiSlider.set([value, null]);
                    } else {
                        value = Math.min(overallMaxPriceJS, Math.max(value, parseFloat(sliderValues[0])));
                        inputElement.value = value;
                        priceSlider.noUiSlider.set([null, value]);
                    }
                }
                minPriceInput.addEventListener('change', () => updateSliderFromInput(minPriceInput, 0));
                maxPriceInput.addEventListener('change', () => updateSliderFromInput(maxPriceInput, 1));
            }
        } else if (priceSlider) {
            priceSlider.style.display = 'none';
        }

        document.querySelectorAll('.filter-section .filter-section-title[data-bs-toggle="collapse"]').forEach(header => {
            const collapseTargetId = header.getAttribute('data-bs-target') || header.getAttribute('href');
            if (collapseTargetId) {
                const collapseEl = document.querySelector(collapseTargetId);
                if (collapseEl) {
                    const icon = header.querySelector('.filter-arrow');
                    if (!icon) return;
                    if (!collapseEl.classList.contains('show')) {
                        icon.style.transform = 'rotate(-90deg)';
                    } else {
                        icon.style.transform = 'rotate(0deg)';
                    }
                    collapseEl.addEventListener('show.bs.collapse', function() {
                        icon.style.transform = 'rotate(0deg)';
                    });
                    collapseEl.addEventListener('hide.bs.collapse', function() {
                        icon.style.transform = 'rotate(-90deg)';
                    });
                }
            }
        });

        document.querySelectorAll('.list-group-categories-styled .list-group-item.has-submenu').forEach(function(element) {
            const submenu = element.querySelector(':scope > .submenu');
            if (submenu) {
                element.addEventListener('mouseenter', function() {
                    const rect = element.getBoundingClientRect();
                    const submenuRect = submenu.getBoundingClientRect();
                    const viewportWidth = window.innerWidth;
                    const viewportHeight = window.innerHeight;

                    if (submenu.classList.contains('submenu-left')) {
                        if (rect.left - submenuRect.width < 0) {
                            submenu.style.right = 'auto';
                            submenu.style.left = '100%';
                            submenu.classList.remove('submenu-left');
                        }
                    } else {
                        if (rect.right + submenuRect.width > viewportWidth) {
                            submenu.style.left = 'auto';
                            submenu.style.right = '100%';
                            submenu.classList.add('submenu-left');
                        }
                    }

                    if (submenuRect.bottom > viewportHeight) {
                        submenu.style.top = -(submenuRect.bottom - viewportHeight + 10) + 'px';
                    } else if (submenuRect.top < 0) {
                        submenu.style.top = '0px';
                    }

                });
                element.addEventListener('mouseleave', function() {
                    if (submenu) {
                        submenu.style.top = '-1px';
                        submenu.style.left = '100%';
                        submenu.style.right = 'auto';
                        submenu.classList.remove('submenu-left');
                    }
                });
            }
        });
    });
</script>
@endpush