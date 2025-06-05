@extends('layouts.admin') {{-- Or your admin layout --}}

@section('content')
<div class="container">
    <h1>Create New Filter</h1>
    <form action="{{ route('admin.filters.store') }}" method="POST">
        @include('admin.filters._form', ['filter' => null])
    </form>
</div>
@endsection