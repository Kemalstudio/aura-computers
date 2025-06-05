{{-- resources/views/catalog/partials/dynamic_filters_block.blade.php --}}
@if(isset($showCondition) && $showCondition && isset($filtersConfig) && is_array($filtersConfig))
    @foreach($filtersConfig as $filter)
        @php
            $currentFilterKey = $filter['key'] ?? null;
            $currentFilterLabel = $filter['label'] ?? 'Фильтр';
            $currentFilterType = $filter['type'] ?? 'select';
            $currentFilterOptions = $filter['options'] ?? [];

            if (!$currentFilterKey) {
                continue;
            }

            $isCurrentFilterAppliedVarName = 'is_' . Str::snake($currentFilterKey) . '_applied';
            $isCurrentFilterApplied = isset($$isCurrentFilterAppliedVarName) ? $$isCurrentFilterAppliedVarName : false;
            $hasContentToShow = !empty($currentFilterOptions) || $currentFilterType === 'single_checkbox';
        @endphp

        @if($hasContentToShow)
        <div class="filter-section mb-3 card">
            <h6 class="filter-section-title card-header bg-white d-flex justify-content-between align-items-center fw-bold" role="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ Str::studly($currentFilterKey) }}" aria-expanded="{{ $isCurrentFilterApplied ? 'true' : 'false' }}" aria-controls="collapse{{ Str::studly($currentFilterKey) }}">
                <span>{{ $currentFilterLabel }}</span>
                <i class="bi {{ $isCurrentFilterApplied ? 'bi-chevron-up' : 'bi-chevron-down' }} filter-arrow"></i>
            </h6>
            <div class="collapse {{ $isCurrentFilterApplied ? 'show' : '' }}" id="collapse{{ Str::studly($currentFilterKey) }}">
                <div class="card-body filter-section-body">
                    @if($currentFilterType === 'select')
                        <select name="{{ $currentFilterKey }}" id="{{ $currentFilterKey }}_filter" class="form-select form-select-sm filter-input">
                            <option value="" @if(!request($currentFilterKey)) selected @endif>Любой</option>
                            @foreach($currentFilterOptions as $label => $value)
                                <option value="{{ $value }}" @if(request($currentFilterKey) == (string)$value) selected @endif>{{ $label }}</option>
                            @endforeach
                        </select>
                    @elseif($currentFilterType === 'checkbox')
                        @php $selectedValues = (array) request($currentFilterKey, []); @endphp
                        @foreach($currentFilterOptions as $label => $value)
                        <div class="form-check">
                            <input class="form-check-input filter-input" type="checkbox" name="{{ $currentFilterKey }}[]" value="{{ $value }}" id="{{ $currentFilterKey }}_{{ Str::slug($label) }}_filter" @if(in_array((string)$value, $selectedValues)) checked @endif>
                            <label class="form-check-label" for="{{ $currentFilterKey }}_{{ Str::slug($label) }}_filter">{{ $label }}</label>
                        </div>
                        @endforeach
                    @elseif($currentFilterType === 'single_checkbox')
                        @php
                            $checkboxValue = '';
                            $checkboxLabel = 'Да';
                            if (!empty($currentFilterOptions)) {
                                $checkboxValue = array_values($currentFilterOptions)[0];
                                $checkboxLabel = array_keys($currentFilterOptions)[0];
                            }
                        @endphp
                        @if($checkboxValue !== '')
                        <div class="form-check">
                            <input class="form-check-input filter-input" type="checkbox" name="{{ $currentFilterKey }}" value="{{ $checkboxValue }}" id="{{ $currentFilterKey }}_filter" @if(request($currentFilterKey) == $checkboxValue) checked @endif>
                            <label class="form-check-label" for="{{ $currentFilterKey }}_filter">{{ $checkboxLabel }}</label>
                        </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
        @endif
    @endforeach
@endif