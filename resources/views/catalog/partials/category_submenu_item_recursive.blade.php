@props([
'categoryItem',
'selectedCategorySlug',
'allSpecificFilterKeys',
'level' => 0,
'categoryNameMapping' => []
])

@php
$displayName = $categoryNameMapping[$categoryItem->slug] ?? $categoryItem->name;
// Убедитесь, что $categoryItem->children загружены в контроллере
$subcategoriesToDisplayCollection = $categoryItem->children ?? collect([]);
$hasChildren = $subcategoriesToDisplayCollection->isNotEmpty();

$isActiveParent = isset($selectedCategorySlug) && $selectedCategorySlug == $categoryItem->slug;
$isChildActive = false;
if ($hasChildren && isset($selectedCategorySlug)) {
$checkActiveDescendant = function ($children, $slugToCheck) use (&$checkActiveDescendant, &$isChildActive) {
foreach ($children as $child) {
if ($child->slug == $slugToCheck) {
$isChildActive = true;
return;
}
// Важно: проверяем, что $child->children существует и не пуст перед рекурсивным вызовом
if (isset($child->children) && $child->children instanceof \Illuminate\Support\Collection && $child->children->isNotEmpty()) {
$checkActiveDescendant($child->children, $slugToCheck);
if ($isChildActive) return;
}
}
};
$checkActiveDescendant($subcategoriesToDisplayCollection, $selectedCategorySlug);
}

$linkClass = 'list-group-item-action d-flex justify-content-between align-items-center category-link';
if ($level > 0) {
$linkClass = 'list-group-item-action subcategory-link d-flex justify-content-between align-items-center';
}
$currentLinkIsActive = $isActiveParent && !$isChildActive;
if ($level > 0 && isset($selectedCategorySlug) && $selectedCategorySlug == $categoryItem->slug) {
$currentLinkIsActive = true;
}
@endphp

<li class="list-group-item {{ $hasChildren ? 'has-submenu' : '' }}">
    <a href="{{ route('catalog.index', array_merge(request()->except(array_merge(['page', 'brands', 'min_price', 'max_price', 'availability', 'is_new'], $allSpecificFilterKeys)), ['category' => $categoryItem->slug])) }}"
        class="{{ $linkClass }} {{ $currentLinkIsActive ? 'active' : '' }}"
        style="padding-left: {{ 0.75 + ($level * 0.8) }}rem;"> {{-- Отступ для визуальной иерархии --}}
        <span>{{ $displayName }}</span>
        @if($hasChildren)
        <i class="bi bi-chevron-right submenu-indicator"></i>
        @endif
    </a>

    @if($hasChildren)
    <ul class="list-group submenu shadow-lg rounded-3 submenu-level-{{ $level + 1 }}">
        {{-- Ссылка "Все в..." только для первого уровня подменю (когда основной элемент категории имеет детей) --}}
        @if($level === 0)
        <li class="list-group-item">
            <a href="{{ route('catalog.index', array_merge(request()->except(array_merge(['page', 'brands', 'min_price', 'max_price', 'availability', 'is_new'], $allSpecificFilterKeys)), ['category' => $categoryItem->slug])) }}"
                class="list-group-item-action subcategory-link {{ $isActiveParent && !$isChildActive ? 'active' : '' }}"
                style="padding-left: {{ 0.75 + (($level + 1) * 0.8) }}rem;">
                Все в "{{ $displayName }}"
            </a>
        </li>
        @endif
        @foreach($subcategoriesToDisplayCollection as $subCategory)
        {{-- Рекурсивный вызов для дочерних элементов --}}
        @include('catalog.partials.category_submenu_item_recursive', [
        'categoryItem' => $subCategory,
        'selectedCategorySlug' => $selectedCategorySlug,
        'allSpecificFilterKeys' => $allSpecificFilterKeys,
        'level' => $level + 1,
        'categoryNameMapping' => $categoryNameMapping
        ])
        @endforeach
    </ul>
    @endif
</li>