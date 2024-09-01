@extends('admin.layouts.admin')

@section('content')
<div class="p-4">
    <x-form-header :value="__('model Details')" />
    <div>
        <p><strong>Name:</strong> {{ $model->name }}</p>
        <p><strong>Name Kh:</strong> {{ $model->name_kh }}</p>
        <p><strong>Code:</strong> {{ $model->name_kh }}</p>
        <p><strong>Image:</strong></p>
        {{-- <img src="{{ asset('assets/images/models/' . $model->image) }}" alt="model Image" class="max-w-full pr-4 max-h-40" /> --}}
    </div>
    <div>
        <a href="{{ route('admin.models.edit', $model) }}" class="btn btn-primary">Edit</a>
        <form action="{{ route('admin.models.destroy', $model) }}" method="POST" style="display: inline-block;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Delete</button>
        </form>
        <a href="{{ route('admin.models.index') }}" class="btn btn-secondary">Back</a>
    </div>
</div>
@endsection
