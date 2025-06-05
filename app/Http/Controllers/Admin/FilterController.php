<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Filter;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class FilterController extends Controller
{
    public function index()
    {
        $filters = Filter::with('category')->orderBy('category_id')->orderBy('position')->paginate(20);
        return view('admin.filters.index', compact('filters'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->pluck('name', 'id');
        $filterTypes = ['checkbox' => 'Checkbox', 'select' => 'Select'];
        return view('admin.filters.create', compact('categories', 'filterTypes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'nullable|exists:categories,id',
            'name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-z0-9_]+$/', // Ensure it's a valid query parameter key
                Rule::unique('filters')->where(function ($query) use ($request) {
                    return $query->where('category_id', $request->input('category_id'));
                }),
            ],
            'label' => 'required|string|max:255',
            'db_column' => 'required|string|max:255|regex:/^[a-z0-9_]+$/', // Column in products table
            'type' => ['required', Rule::in(['checkbox', 'select'])],
            'value_prefix' => 'nullable|string|max:50',
            'value_suffix' => 'nullable|string|max:50',
            'sort_numeric' => 'sometimes|boolean',
            'cast_to_numeric' => 'sometimes|boolean',
            'options_map' => 'nullable|json',
            'position' => 'sometimes|integer',
            'is_active' => 'sometimes|boolean',
        ]);

        $validated['sort_numeric'] = $request->has('sort_numeric');
        $validated['cast_to_numeric'] = $request->has('cast_to_numeric');
        $validated['is_active'] = $request->has('is_active');
        if (empty($validated['options_map'])) {
            $validated['options_map'] = null;
        }


        Filter::create($validated);

        return redirect()->route('admin.filters.index')->with('success', 'Filter created successfully.');
    }

    public function edit(Filter $filter)
    {
        $categories = Category::orderBy('name')->pluck('name', 'id');
        $filterTypes = ['checkbox' => 'Checkbox', 'select' => 'Select'];
        return view('admin.filters.edit', compact('filter', 'categories', 'filterTypes'));
    }

    public function update(Request $request, Filter $filter)
    {
        $validated = $request->validate([
            'category_id' => 'nullable|exists:categories,id',
            'name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-z0-9_]+$/',
                Rule::unique('filters')->where(function ($query) use ($request) {
                    return $query->where('category_id', $request->input('category_id'));
                })->ignore($filter->id),
            ],
            'label' => 'required|string|max:255',
            'db_column' => 'required|string|max:255|regex:/^[a-z0-9_]+$/',
            'type' => ['required', Rule::in(['checkbox', 'select'])],
            'value_prefix' => 'nullable|string|max:50',
            'value_suffix' => 'nullable|string|max:50',
            'sort_numeric' => 'sometimes|boolean',
            'cast_to_numeric' => 'sometimes|boolean',
            'options_map' => 'nullable|json',
            'position' => 'sometimes|integer',
            'is_active' => 'sometimes|boolean',
        ]);

        $validated['sort_numeric'] = $request->has('sort_numeric');
        $validated['cast_to_numeric'] = $request->has('cast_to_numeric');
        $validated['is_active'] = $request->has('is_active');
        if (empty($validated['options_map'])) {
            $validated['options_map'] = null;
        }


        $filter->update($validated);

        return redirect()->route('admin.filters.index')->with('success', 'Filter updated successfully.');
    }

    public function destroy(Filter $filter)
    {
        $filter->delete();
        return redirect()->route('admin.filters.index')->with('success', 'Filter deleted successfully.');
    }
}