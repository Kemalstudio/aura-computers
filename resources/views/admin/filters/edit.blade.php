@extends('layouts.admin') {{-- Or your admin layout --}}

@section('content')
<div class="container">
    <h1>Edit Filter: {{ $filter->label }}</h1>
    <form action="{{ route('admin.filters.update', $filter) }}" method="POST">
        @method('PUT')
        @include('admin.filters._form', ['filter' => $filter])
    </form>
</div>
@endsection