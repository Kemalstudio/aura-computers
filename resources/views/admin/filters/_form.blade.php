@csrf
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="mb-3">
    <label for="category_id" class="form-label">Category (Optional)</label>
    <select name="category_id" id="category_id" class="form-control">
        <option value="">-- Global Filter (All Categories) --</option>
        @foreach($categories as $id => $name)
            <option value="{{ $id }}" {{ (old('category_id', $filter->category_id ?? null) == $id) ? 'selected' : '' }}>
                {{ $name }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label for="name" class="form-label">Name (Request Key) <span class="text-danger">*</span></label>
    <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $filter->name ?? '') }}" required placeholder="e.g. screen_size">
    <small class="form-text text-muted">Unique identifier for URL query. Use lowercase letters, numbers, and underscores.</small>
</div>

<div class="mb-3">
    <label for="label" class="form-label">Label <span class="text-danger">*</span></label>
    <input type="text" name="label" id="label" class="form-control" value="{{ old('label', $filter->label ?? '') }}" required placeholder="e.g. Диагональ экрана">
</div>

<div class="mb-3">
    <label for="db_column" class="form-label">Product DB Column <span class="text-danger">*</span></label>
    <input type="text" name="db_column" id="db_column" class="form-control" value="{{ old('db_column', $filter->db_column ?? '') }}" required placeholder="e.g. screen_size_inches">
    <small class="form-text text-muted">Actual column name in the 'products' table.</small>
</div>

<div class="mb-3">
    <label for="type" class="form-label">Filter Type <span class="text-danger">*</span></label>
    <select name="type" id="type" class="form-control" required>
        @foreach($filterTypes as $value => $text)
            <option value="{{ $value }}" {{ (old('type', $filter->type ?? '') == $value) ? 'selected' : '' }}>
                {{ $text }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label for="value_prefix" class="form-label">Value Prefix</label>
    <input type="text" name="value_prefix" id="value_prefix" class="form-control" value="{{ old('value_prefix', $filter->value_prefix ?? '') }}" placeholder="e.g. $">
</div>

<div class="mb-3">
    <label for="value_suffix" class="form-label">Value Suffix</label>
    <input type="text" name="value_suffix" id="value_suffix" class="form-control" value="{{ old('value_suffix', $filter->value_suffix ?? '') }}" placeholder='e.g. " or ГБ'>
</div>

<div class="mb-3">
    <label for="options_map" class="form-label">Options Map (JSON)</label>
    <textarea name="options_map" id="options_map" class="form-control" rows="3" placeholder='e.g. {"1": "Yes", "0": "No"}' >{{ old('options_map', isset($filter->options_map) ? json_encode($filter->options_map, JSON_PRETTY_PRINT) : '') }}</textarea>
    <small class="form-text text-muted">JSON object for mapping stored values to display labels. E.g., if `db_column` stores `1` for "16GB", you might map `{"16": "16 GB RAM"}`. Leave empty if not needed.</small>
</div>

<div class="mb-3">
    <label for="position" class="form-label">Position</label>
    <input type="number" name="position" id="position" class="form-control" value="{{ old('position', $filter->position ?? 0) }}">
    <small class="form-text text-muted">Order in which filters appear (lower numbers first).</small>
</div>

<div class="form-check mb-3">
    <input type="checkbox" name="sort_numeric" id="sort_numeric" class="form-check-input" value="1" {{ old('sort_numeric', $filter->sort_numeric ?? false) ? 'checked' : '' }}>
    <label for="sort_numeric" class="form-check-label">Sort Options Numerically</label>
</div>

<div class="form-check mb-3">
    <input type="checkbox" name="cast_to_numeric" id="cast_to_numeric" class="form-check-input" value="1" {{ old('cast_to_numeric', $filter->cast_to_numeric ?? false) ? 'checked' : '' }}>
    <label for="cast_to_numeric" class="form-check-label">Cast Value to Numeric</label>
    <small class="form-text text-muted">For DB queries, treat values as numbers.</small>
</div>

<div class="form-check mb-3">
    <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" {{ old('is_active', $filter->is_active ?? true) ? 'checked' : '' }}>
    <label for="is_active" class="form-check-label">Active</label>
</div>

<button type="submit" class="btn btn-success">
    {{ isset($filter) ? 'Update Filter' : 'Create Filter' }}
</button>
<a href="{{ route('admin.filters.index') }}" class="btn btn-secondary">Cancel</a>