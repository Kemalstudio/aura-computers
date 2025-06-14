@php $isAnyStaticFilterRendered = false; @endphp

@if(isset($availableBrands) && $availableBrands->count() > 0)
    @php
    $isBrandFilterApplied = isset($selectedBrandSlugs) && count($selectedBrandSlugs) > 0;
    $sortedBrands = $availableBrands->sortBy('name');
    @endphp
    <div class="filter-section">
        <h6 class="filter-section-title card-header bg-white d-flex justify-content-between align-items-center fw-bold @if($isAnyStaticFilterRendered) border-top mt-3 @endif" role="button" data-bs-toggle="collapse" data-bs-target="#collapseBrandsFilter" aria-expanded="{{ $isBrandFilterApplied ? 'true' : 'false' }}" aria-controls="collapseBrandsFilter">
            <span>Бренд</span>
            <i class="bi {{ $isBrandFilterApplied ? 'bi-chevron-up' : 'bi-chevron-down' }} filter-arrow"></i>
        </h6>
        <div class="collapse {{ $isBrandFilterApplied ? 'show' : '' }}" id="collapseBrandsFilter">
            <div class="card-body filter-section-body">
                <div class="mb-3">
                    <input type="text" id="brand-search-input" class="form-control form-control-sm" placeholder="Поиск бренда...">
                </div>
                <div id="brands-list">
                    @php $currentLetter = ''; @endphp
                    @foreach($sortedBrands as $brand)
                        @php
                        $firstLetter = mb_strtoupper(mb_substr($brand->name, 0, 1));
                        @endphp
                        @if ($firstLetter !== $currentLetter && $currentLetter !== '')
                        <hr class="my-2 brand-separator">
                        @endif
                        <div class="form-check brand-item">
                            <input class="form-check-input filter-input" type="checkbox" name="brands[]" value="{{ $brand->slug }}" id="brand-filter-{{ $brand->slug }}" @if(isset($selectedBrandSlugs) && in_array($brand->slug, $selectedBrandSlugs)) checked @endif>
                            <label class="form-check-label" for="brand-filter-{{ $brand->slug }}">{{ $brand->name }}</label>
                        </div>
                        @php
                        $currentLetter = $firstLetter;
                        @endphp
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @php $isAnyStaticFilterRendered = true; @endphp
@endif

@if(isset($overallMinPrice) && isset($overallMaxPrice) && $overallMaxPrice > $overallMinPrice)
    @php $isPriceFilterApplied = (request('min_price') !== null && request('min_price') != ($overallMinPrice ?? 0)) || (request('max_price') !== null && ($overallMaxPrice === null || request('max_price') != ($overallMaxPrice ?? 0))); @endphp
    <div class="filter-section">
        <h6 class="filter-section-title card-header bg-white d-flex justify-content-between align-items-center fw-bold @if($isAnyStaticFilterRendered) border-top mt-3 @endif" role="button" data-bs-toggle="collapse" data-bs-target="#collapsePriceFilter" aria-expanded="{{ $isPriceFilterApplied ? 'true' : 'false' }}" aria-controls="collapsePriceFilter">
            <span>Цена, TMT</span> 
            <i class="bi {{ $isPriceFilterApplied ? 'bi-chevron-up' : 'bi-chevron-down' }} filter-arrow"></i>
        </h6>
        <div class="collapse {{ $isPriceFilterApplied ? 'show' : '' }}" id="collapsePriceFilter">
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
    @php $isAnyStaticFilterRendered = true; @endphp
@endif

@php
$selectedAvailability = (array) request('availability', []);
$isFeaturesFilterApplied = request('is_new') == '1' || !empty($selectedAvailability);
@endphp
<div class="filter-section">
    <h6 class="filter-section-title card-header bg-white d-flex justify-content-between align-items-center fw-bold @if($isAnyStaticFilterRendered) border-top mt-3 @endif" role="button" data-bs-toggle="collapse" data-bs-target="#collapseFeaturesFilter" aria-expanded="{{ $isFeaturesFilterApplied ? 'true' : 'false' }}" aria-controls="collapseFeaturesFilter">
        <span>Особенности</span> <i class="bi {{ $isFeaturesFilterApplied ? 'bi-chevron-up' : 'bi-chevron-down' }} filter-arrow"></i>
    </h6>
    <div class="collapse {{ $isFeaturesFilterApplied ? 'show' : '' }}" id="collapseFeaturesFilter">
        <div class="card-body filter-section-body">
            <div class="form-check">
                <input class="form-check-input filter-input" type="checkbox" name="is_new" value="1" id="filter_is_new" @if(request('is_new')=='1' ) checked @endif>
                <label class="form-check-label" for="filter_is_new">Только новинки</label>
            </div>
            <hr class="my-2">
            <div class="form-check">
                <input class="form-check-input filter-input" type="checkbox" name="availability[]" value="in_stock" id="filter_in_stock" @if(in_array('in_stock', $selectedAvailability)) checked @endif>
                <label class="form-check-label" for="filter_in_stock">В наличии</label>
            </div>
            <div class="form-check">
                <input class="form-check-input filter-input" type="checkbox" name="availability[]" value="out_of_stock" id="filter_out_of_stock" @if(in_array('out_of_stock', $selectedAvailability)) checked @endif>
                <label class="form-check-label" for="filter_out_of_stock">Нет в наличии</label>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('brand-search-input');
        if (searchInput) {
            searchInput.addEventListener('keyup', function() {
                const searchTerm = this.value.toLowerCase();
                const brandItems = document.querySelectorAll('#brands-list .brand-item');

                brandItems.forEach(item => {
                    const label = item.querySelector('label');
                    const brandName = label.textContent.toLowerCase();
                    if (brandName.includes(searchTerm)) {
                        item.style.display = '';
                    } else {
                        item.style.display = 'none';
                    }
                });

                updateSeparators();
            });
        }

        function updateSeparators() {
            const separators = document.querySelectorAll('#brands-list .brand-separator');
            separators.forEach(hr => {
                let nextElement = hr.nextElementSibling;
                let groupHasVisibleItem = false;

                while (nextElement && !nextElement.classList.contains('brand-separator')) {
                    if (nextElement.style.display !== 'none') {
                        groupHasVisibleItem = true;
                        break;
                    }
                    nextElement = nextElement.nextElementSibling;
                }

                hr.style.display = groupHasVisibleItem ? '' : 'none';
            });
        }

        const brandCollapse = document.getElementById('collapseBrandsFilter');
        if (brandCollapse) {
            brandCollapse.addEventListener('shown.bs.collapse', function() {
                updateSeparators();
            });
        }
    });
</script>