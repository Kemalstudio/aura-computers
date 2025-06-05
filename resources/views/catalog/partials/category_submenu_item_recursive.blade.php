@props([
    'categoryItem',
    'selectedCategorySlug',
    'allSpecificFilterKeys', // Renamed from allDynamicFilterKeys to match usage
    'keysToClearOnNavigateOrReset', // Added this
    'level' => 0,
    'categoryNameMapping' => [],
    'categoryIconMapping' => [],
    'defaultCategoryIconPath' => ''
])

@php
    $displayName = $categoryNameMapping[$categoryItem->slug] ?? $categoryItem->name;
    $subcategoriesToDisplayCollection = $categoryItem->children()->where('is_visible', true)->orderBy('sort_order')->orderBy('name')->get() ?? collect([]);
    $hasChildren = $subcategoriesToDisplayCollection->isNotEmpty();

    $isActiveCategory = isset($selectedCategorySlug) && $selectedCategorySlug == $categoryItem->slug;

    $isParentOfActive = false;
    if ($hasChildren && isset($selectedCategorySlug)) {
        $checkActiveDescendant = function ($children, $slugToCheck) use (&$checkActiveDescendant, &$isParentOfActive) {
            foreach ($children as $child) {
                if ($child->slug == $slugToCheck) {
                    $isParentOfActive = true;
                    return;
                }
                if (isset($child->children) && $child->children->isNotEmpty()) {
                    $checkActiveDescendant($child->children, $slugToCheck);
                    if ($isParentOfActive) return;
                }
            }
        };
        $checkActiveDescendant($subcategoriesToDisplayCollection, $selectedCategorySlug);
    }

    $linkClass = 'list-group-item-action d-flex align-items-center category-link';
    if ($isActiveCategory) {
        $linkClass .= ' active';
    } elseif ($isParentOfActive) {
        $linkClass .= ' active-parent';
    }

    $iconUrl = $categoryItem->full_icon_url ?? ($categoryIconMapping[$categoryItem->slug] ?? $defaultCategoryIconPath);
    $currentParamsToKeep = request()->except(array_merge(['category', 'page'], $allSpecificFilterKeys, $keysToClearOnNavigateOrReset));
@endphp

<li class="list-group-item {{ $hasChildren ? 'has-submenu' : '' }}">
    <a href="{{ route('catalog.index', array_merge($currentParamsToKeep, ['category' => $categoryItem->slug, 'page' => 1])) }}"
       class="{{ $linkClass }}"
       style="padding-left: {{ 0.75 + ($level * 0.8) }}rem;">
        <img src="{{ $iconUrl }}" alt="" class="category-icon me-2">
        <span class="category-text flex-grow-1">{{ $displayName }}</span>
        @if($hasChildren)
            <i class="bi bi-chevron-right submenu-indicator ms-auto"></i>
        @endif
    </a>

    @if($hasChildren)
        <ul class="list-group submenu shadow-lg rounded-3 py-1 submenu-level-{{ $level + 1 }}">
            @if($level === 0 && $isActiveCategory) {{-- Show "All in..." only if current category is active --}}
                <li class="list-group-item">
                    <a href="{{ route('catalog.index', array_merge($currentParamsToKeep, ['category' => $categoryItem->slug, 'page' => 1])) }}"
                       class="list-group-item-action subcategory-link d-flex align-items-center active"
                       style="padding-left: {{ 0.75 + (($level + 1) * 0.8) }}rem;">
                        <img src="{{ $iconUrl }}" alt="" class="category-icon me-2">
                        <span class="category-text flex-grow-1">Все в "{{ $displayName }}"</span>
                    </a>
                </li>
            @endif
            @foreach($subcategoriesToDisplayCollection as $subCategory)
                @include('catalog.partials.category_submenu_item_recursive', [
                    'categoryItem' => $subCategory,
                    'selectedCategorySlug' => $selectedCategorySlug,
                    'allSpecificFilterKeys' => $allSpecificFilterKeys,
                    'keysToClearOnNavigateOrReset' => $keysToClearOnNavigateOrReset,
                    'level' => $level + 1,
                    'categoryNameMapping' => $categoryNameMapping,
                    'categoryIconMapping' => $categoryIconMapping,
                    'defaultCategoryIconPath' => $defaultCategoryIconPath
                ])
            @endforeach
        </ul>
    @endif
</li>