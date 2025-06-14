@php
    $optionsToUse = $filterData['options'] ?? [];
    $selectedValues = (array) request($filterKey, []);
    $isThisFilterApplied = !empty($selectedValues);
    $isFirst = $isFirst ?? false;
@endphp

@if(!empty($optionsToUse))
<div class="filter-section">
    <h6 class="filter-section-title card-header bg-white d-flex justify-content-between align-items-center fw-bold @if(!$isFirst) border-top mt-3 @endif"
        role="button" data-bs-toggle="collapse" data-bs-target="#collapseFilterContent-{{ Str::studly($filterKey) }}"
        aria-expanded="{{ $isThisFilterApplied ? 'true' : 'false' }}">
        <span>{{ $filterData['label'] }} @if(!empty($filterData['unit'])) ({{ $filterData['unit'] }}) @endif</span>
        <i class="bi {{ $isThisFilterApplied ? 'bi-chevron-up' : 'bi-chevron-down' }} filter-arrow"></i>
    </h6>
    <div class="collapse {{ $isThisFilterApplied ? 'show' : '' }}" id="collapseFilterContent-{{ Str::studly($filterKey) }}">
        <div class="card-body filter-section-body">
            @foreach($optionsToUse as $value => $label)
                <div class="form-check">
                    <input class="form-check-input filter-input" type="checkbox"
                        name="{{ $filterKey }}[]"
                        value="{{ $value }}"
                        id="filter-{{ Str::slug($filterKey) }}-{{ Str::slug((string)$value) }}"
                        @if(in_array((string)$value, $selectedValues)) checked @endif>
                    <label class="form-check-label" for="filter-{{ Str::slug($filterKey) }}-{{ Str::slug((string)$value) }}">
                        {{ $label }}
                    </label>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endif