@extends('admin.layouts.admin')

@section('content')
<div class="p-4">
    <x-form-header :value="__('Category Details')" />
    <div>
        <p><strong>Name:</strong> {{ $bodyType->name }}</p>
        <p><strong>Name Kh:</strong> {{ $bodyType->name_kh }}</p>
        <p><strong>Image:</strong></p>
        <img src="{{ asset('assets/images/body_types/' . $bodyType->image) }}" alt="BodyType Image" class="max-w-full max-h-40 pr-4" />
    </div>
    <div>
        <a href="{{ route('admin.bodytypes.edit', $bodyType) }}" class="btn btn-primary">Edit</a>
        <form action="{{ route('admin.bodytypes.destroy', $bodyType) }}" method="POST" style="display: inline-block;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Delete</button>
        </form>
        <a href="{{ route('admin.bodytypes.index') }}" class="btn btn-secondary">Back</a>
    </div>
</div>
@endsection
