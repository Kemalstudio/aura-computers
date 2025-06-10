@if(isset($availableSpecificFiltersData) && !empty($availableSpecificFiltersData))
    @foreach($availableSpecificFiltersData as $filterKey => $filterData)
        @include('catalog.partials.dynamic_filter_item', [
            'filterKey' => $filterKey,
            'filterData' => $filterData
        ])
    @endforeach
@endif