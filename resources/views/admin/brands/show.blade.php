@extends('admin.layouts.admin')

@section('content')
<div class="p-4">
    <x-form-header :value="__('Brand Details')" />
    <div>
        <p><strong>Name:</strong> {{ $brand->name }}</p>
        <p><strong>Name Kh:</strong> {{ $brand->name_kh }}</p>
        <p><strong>Code:</strong> {{ $brand->name_kh }}</p>
        <p><strong>Image:</strong></p>
        <img src="{{ asset('assets/images/body_types/' . $brand->image) }}" alt="brand Image" class="max-w-full max-h-40 pr-4" />
    </div>
    <div>
        <a href="{{ route('admin.brands.edit', $brand) }}" class="btn btn-primary">Edit</a>
        <form action="{{ route('admin.brands.destroy', $brand) }}" method="POST" style="display: inline-block;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Delete</button>
        </form>
        <a href="{{ route('admin.brands.index') }}" class="btn btn-secondary">Back</a>
    </div>
</div>
@endsection
