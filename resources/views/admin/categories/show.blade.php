@extends('admin.layouts.admin')

@section('content')
<div class="p-4">
    <x-form-header :value="__('Category Details')" />
    <div>
        <p><strong>Name:</strong> {{ $category->name }}</p>
        <p><strong>Name Kh:</strong> {{ $category->name_kh }}</p>
        <p><strong>Code:</strong> {{ $category->code }}</p>
        <p><strong>Image:</strong></p>
        <img src="{{ asset('assets/images/categories/' . $category->image) }}" alt="Category Image" class="max-w-full max-h-40 pr-4" />
    </div>
    <div>
        <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-primary">Edit</a>
        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" style="display: inline-block;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Delete</button>
        </form>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Back</a>
    </div>
</div>
@endsection
