@extends('admin.layouts.admin')

@section('content')
<div class="p-4">
    <x-form-header :value="__('Type Details')" />
    <div>
        <p><strong>Name:</strong> {{ $types->name }}</p>
        <p><strong>Name Kh:</strong> {{ $types->name_kh }}</p>
        <p><strong>Code:</strong> {{ $types->name_kh }}</p>
        <p><strong>Image:</strong></p>
        <img src="{{ asset('assets/images/types/' . $types->image) }}" alt="types Image" class="max-w-full max-h-40 pr-4" />
    </div>
    <div>
        <a href="{{ route('admin.types.edit', $types) }}" class="btn btn-primary">Edit</a>
        <form action="{{ route('admin.types.destroy', $types) }}" method="POST" style="display: inline-block;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Delete</button>
        </form>
        <a href="{{ route('admin.types.index') }}" class="btn btn-secondary">Back</a>
    </div>
</div>
@endsection





