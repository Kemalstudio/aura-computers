@php use Illuminate\Support\Facades\Log; @endphp
@props(['filterKey', 'filterData']) {{-- $filterKey is 'attr_SLUG' --}}

@php
    $optionsToUse = $filterData['options'] ?? []; // Product-derived options
    $definedOptions = $filterData['defined_options'] ?? []; // Options from Attribute model definition

    // If type is 'select' and has defined_options, prioritize them for display,
    // but only show product-derived options if defined_options is empty or not suitable.
    // For checkboxes, usually show what's available from products.
    if ($filterData['type'] === 'select') {
        if (!empty($definedOptions)) {
            $tempOptions = [];
            // If defined_options is simple array ['val1', 'val2']
            if (isset($definedOptions[0]) && !is_array($definedOptions[0])) {
                foreach($definedOptions as $val) {
                    $label = (string)$val;
                    if ($filterData['unit'] && !Str::contains($label, $filterData['unit'])) $label .= ' ' . $filterData['unit'];
                    $tempOptions[(string)$val] = $label;
                }
            } else { // Associative array [value => label]
                foreach($definedOptions as $valKey => $valLabel) {
                    $label = (string)$valLabel;
                    if ($filterData['unit'] && !Str::contains($label, $filterData['unit'])) $label .= ' ' . $filterData['unit'];
                    $tempOptions[(string)$valKey] = $label;
                }
            }
            $optionsToUse = $tempOptions; // Use these defined options for the select dropdown
        } elseif (empty($optionsToUse) && !empty($definedOptions)) {
             // Fallback if optionsFromProducts was empty but definedOptions exist
             // This case should be rare if mapAttributeTypeToFilterInputType decides 'select' based on definedOptions
             $optionsToUse = collect($definedOptions)->mapWithKeys(function($labelOrValue, $keyOrValue) use ($filterData) {
                $value = is_int($keyOrValue) ? $labelOrValue : $keyOrValue;
                $label = $labelOrValue;
                if ($filterData['unit'] && is_string($label) && !Str::contains($label, $filterData['unit'])) $label .= ' ' . $filterData['unit'];
                return [(string)$value => $label];
            })->all();
        }
    }


    $isThisFilterApplied = false;
    $currentRequestValue = request($filterKey);
    if ($currentRequestValue !== null && $currentRequestValue !== '' && (!is_array($currentRequestValue) || !empty(array_filter($currentRequestValue)))) {
        $isThisFilterApplied = true;
    }
@endphp

@if(!empty($optionsToUse))
    <div class="filter-section mb-3 card">
        <h6 class="filter-section-title card-header bg-white d-flex justify-content-between align-items-center fw-bold"
            role="button" data-bs-toggle="collapse" data-bs-target="#collapseFilterContentNew{{ Str::studly($filterKey) }}"
            aria-expanded="{{ $isThisFilterApplied ? 'true' : 'false' }}"
            aria-controls="collapseFilterContentNew{{ Str::studly($filterKey) }}">
            <span>{{ $filterData['label'] }} @if($filterData['unit'] && $filterData['type'] !== 'select') ({{ $filterData['unit'] }}) @endif</span>
            <i class="bi {{ $isThisFilterApplied ? 'bi-chevron-up' : 'bi-chevron-down' }} filter-arrow"></i>
        </h6>
        <div class="collapse {{ $isThisFilterApplied ? 'show' : '' }}" id="collapseFilterContentNew{{ Str::studly($filterKey) }}">
            <div class="card-body filter-section-body">
                @if($filterData['type'] === 'select')
                    <select name="{{ $filterKey }}" class="form-select form-select-sm filter-input">
                        <option value="">Все {{ Str::lower($filterData['label']) }}</option>
                        @foreach($optionsToUse as $value => $label)
                            <option value="{{ $value }}" {{ (string)request($filterKey) === (string)$value && request($filterKey) !== null && request($filterKey) !== '' ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                @elseif($filterData['type'] === 'checkbox')
                    @php $selectedValues = (array) request($filterKey, []); @endphp
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
                @elseif($filterData['type'] === 'single_checkbox') {{-- For boolean attributes --}}
                @php
                    // For boolean, optionsToUse might be like [ '1' => 'Yes' ] if coming from products.
                    // Or defined_options would be used by mapAttributeTypeToFilterInputType
                    $boolValueForInput = '1'; // Value to submit for "true"
                    $actualLabel = $filterData['label']; // The label for the filter itself
                    // If optionsToUse has a specific label for '1' or true, use it
                    if(isset($optionsToUse['1'])) $actualLabel = $optionsToUse['1'];
                    else if (isset($optionsToUse[true])) $actualLabel = $optionsToUse[true];

                @endphp
                <div class="form-check">
                    <input class="form-check-input filter-input" type="checkbox"
                           name="{{ $filterKey }}"
                           value="{{ $boolValueForInput }}"
                           id="filter-{{ Str::slug($filterKey) }}"
                        {{ (string)request($filterKey) === (string)$boolValueForInput ? 'checked' : '' }}>
                    <label class="form-check-label" for="filter-{{ Str::slug($filterKey) }}">
                        {{-- Label is usually the attribute name itself e.g., "Touchscreen" --}}
                        {{ $filterData['label'] }}
                    </label>
                </div>
                @endif
            </div>
        </div>
    </div>
@else
    {{-- Optional: Log or display a message if an attribute was expected but had no options --}}
    {{-- <p class="text-muted small">No options for {{ $filterData['label'] }}</p> --}}
    @php
        Log::debug("Dynamic filter item: No options to display for filter key '{$filterKey}' (Label: '{$filterData['label']}')");
    @endphp
@endif
