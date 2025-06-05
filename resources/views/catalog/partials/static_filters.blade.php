{{-- Фильтр по брендам --}}
@if(isset($availableBrands) && $availableBrands->count() > 0)
@php $isBrandFilterApplied = isset($selectedBrandSlugs) && count($selectedBrandSlugs) > 0; @endphp
<div class="filter-section mb-3 card">
    <h6 class="filter-section-title card-header bg-white d-flex justify-content-between align-items-center fw-bold" role="button" data-bs-toggle="collapse" data-bs-target="#collapseBrandsFilterContentNew" aria-expanded="{{ $isBrandFilterApplied ? 'true' : 'false' }}" aria-controls="collapseBrandsFilterContentNew">
        <span>Бренд</span> <i class="bi {{ $isBrandFilterApplied ? 'bi-chevron-up' : 'bi-chevron-down' }} filter-arrow"></i>
    </h6>
    <div class="collapse {{ $isBrandFilterApplied ? 'show' : '' }}" id="collapseBrandsFilterContentNew">
        <div class="card-body filter-section-body">
            @foreach($availableBrands as $brand)
            <div class="form-check">
                <input class="form-check-input filter-input" type="checkbox" name="brands[]" value="{{ $brand->slug }}" id="brand-filter-{{ $brand->slug }}" @if(isset($selectedBrandSlugs) && in_array($brand->slug, $selectedBrandSlugs)) checked @endif>
                <label class="form-check-label" for="brand-filter-{{ $brand->slug }}">{{ $brand->name }}</label>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif

{{-- Фильтр по цене --}}
@if(isset($overallMinPrice) && isset($overallMaxPrice) && $overallMaxPrice > $overallMinPrice)
@php $isPriceFilterApplied = (request('min_price') !== null && request('min_price') != ($overallMinPrice ?? 0)) || (request('max_price') !== null && ($overallMaxPrice === null || request('max_price') != ($overallMaxPrice ?? 0))); @endphp
<div class="filter-section mb-3 card">
    <h6 class="filter-section-title card-header bg-white d-flex justify-content-between align-items-center fw-bold" role="button" data-bs-toggle="collapse" data-bs-target="#collapsePriceFilterContentNew" aria-expanded="{{ $isPriceFilterApplied ? 'true' : 'false' }}" aria-controls="collapsePriceFilterContentNew">
        <span>Цена, TMT</span> <i class="bi {{ $isPriceFilterApplied ? 'bi-chevron-up' : 'bi-chevron-down' }} filter-arrow"></i>
    </h6>
    <div class="collapse {{ $isPriceFilterApplied ? 'show' : '' }}" id="collapsePriceFilterContentNew">
        <div class="card-body filter-section-body">
            <div class="d-flex align-items-center mb-2">
                <input type="number" class="form-control form-control-sm text-center filter-input" name="min_price" id="min_price_filter" placeholder="{{ number_format($overallMinPrice ?? 0, 0, '.', '') }}" value="{{ request('min_price', '') }}" min="{{ $overallMinPrice ?? 0 }}" max="{{ $overallMaxPrice ?? 1000 }}" aria-label="Минимальная цена">
                <span class="mx-2 text-muted">–</span>
                <input type="number" class="form-control form-control-sm text-center filter-input" name="max_price" id="max_price_filter" placeholder="{{ number_format($overallMaxPrice ?? 1000, 0, '.', '') }}" value="{{ request('max_price', '') }}" min="{{ $overallMinPrice ?? 0 }}" max="{{ $overallMaxPrice ?? 1000 }}" aria-label="Максимальная цена">
            </div>
            <div id="price-slider" class="mt-1"></div>
        </div>
    </div>
</div>
@endif

{{-- Фильтр "Особенности" --}}
@php $isFeaturesFilterApplied = request('is_new') == '1' || !empty(request('availability')); @endphp
<div class="filter-section mb-3 card">
    <h6 class="filter-section-title card-header bg-white d-flex justify-content-between align-items-center fw-bold" role="button" data-bs-toggle="collapse" data-bs-target="#collapseFeaturesFilterContentNew" aria-expanded="{{ $isFeaturesFilterApplied ? 'true' : 'false' }}" aria-controls="collapseFeaturesFilterContentNew">
        <span>Особенности</span> <i class="bi {{ $isFeaturesFilterApplied ? 'bi-chevron-up' : 'bi-chevron-down' }} filter-arrow"></i>
    </h6>
    <div class="collapse {{ $isFeaturesFilterApplied ? 'show' : '' }}" id="collapseFeaturesFilterContentNew">
        <div class="card-body filter-section-body">
            <div class="form-check">
                <input class="form-check-input filter-input" type="checkbox" name="is_new" value="1" id="filter_is_new" @if(request('is_new')=='1' ) checked @endif>
                <label class="form-check-label" for="filter_is_new">Только новинки</label>
            </div>
            <div class="mt-2">
                <label for="filter_availability" class="form-label visually-hidden">Наличие</label>
                <select name="availability" id="filter_availability" class="form-select form-select-sm filter-input">
                    <option value="" @if(!request('availability')) selected @endif>Любое наличие</option>
                    <option value="in_stock" @if(request('availability')=='in_stock' ) selected @endif>В наличии</option>
                    <option value="out_of_stock" @if(request('availability')=='out_of_stock' ) selected @endif>Нет в наличии</option>
                </select>
            </div>
        </div>
    </div>
</div>

{{-- Динамические специфические фильтры (если они были у вас ранее и вы хотите их оставить как общие) --}}
@if(isset($availableSpecificFiltersData) && !empty($availableSpecificFiltersData))
@foreach($availableSpecificFiltersData as $filterKey => $filterConfig)
@if(!empty($filterConfig['options']))
@php
$currentRequestValue = request($filterKey);
$isThisSpecificFilterApplied = $currentRequestValue !== null && $currentRequestValue !== '' && (!is_array($currentRequestValue) || !empty($currentRequestValue));
@endphp
<div class="filter-section mb-3 card">
    <h6 class="filter-section-title card-header bg-white d-flex justify-content-between align-items-center fw-bold" role="button" data-bs-toggle="collapse" data-bs-target="#collapseFilterContentNew{{ Str::studly($filterKey) }}" aria-expanded="{{ $isThisSpecificFilterApplied ? 'true' : 'false' }}" aria-controls="collapseFilterContentNew{{ Str::studly($filterKey) }}">
        <span>{{ $filterConfig['label'] }}</span> 
        <i class="bi {{ $isThisSpecificFilterApplied ? 'bi-chevron-up' : 'bi-chevron-down' }} filter-arrow"></i>
    </h6>
    <div class="collapse {{ $isThisSpecificFilterApplied ? 'show' : '' }}" id="collapseFilterContentNew{{ Str::studly($filterKey) }}">
        <div class="card-body filter-section-body">
            @if($filterConfig['type'] === 'select')
            <select name="{{ $filterKey }}" class="form-select form-select-sm filter-input">
                <option value="" @if(empty($currentRequestValue)) selected @endif>Любой</option>
                @foreach($filterConfig['options'] as $value => $label)
                <option value="{{ $value }}" @if((string)$currentRequestValue==(string)$value && $currentRequestValue !==null && $currentRequestValue !=='' ) selected @endif>{{ $label }}</option>
                @endforeach
            </select>
            @elseif($filterConfig['type'] === 'checkbox')
            @php $requestArray = (array) $currentRequestValue; @endphp
            @foreach($filterConfig['options'] as $value => $label)
            <div class="form-check">
                <input class="form-check-input filter-input" type="checkbox" name="{{ $filterKey }}[]" value="{{ $value }}" id="filter_{{ $filterKey }}_{{ Str::slug($value) }}" @if(in_array((string)$value, $requestArray)) checked @endif>
                <label class="form-check-label" for="filter_{{ $filterKey }}_{{ Str::slug($value) }}">{{ $label }}</label>
            </div>
            @endforeach
            @endif
        </div>
    </div>
</div>
@endif
@endforeach
@endif