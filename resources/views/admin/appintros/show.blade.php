@extends('admin.layouts.admin')

@section('content')
<div class="p-4">
    <x-form-header :value="__('Category Details')" />
    <div>
        <p><strong>Name:</strong> {{ $appIntro->name }}</p>
        <p><strong>Descriptions:</strong> {{ $appIntro->description }}</p>
        <p><strong>Image:</strong></p>
        <img src="{{ asset('assets/images/appintros/' . $appIntro->image) }}" alt="{{ $appIntro-> name }}" class="max-w-full max-h-40 pr-4" />
    </div>
    <div>
        <a href="{{ route('admin.appintros.edit', $appIntro) }}" class="btn btn-primary">Edit</a>
        <form action="{{ route('admin.appintros.destroy', $appIntro) }}" method="POST" style="display: inline-block;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Delete</button>
        </form>
        <a href="{{ route('admin.appintros.index') }}" class="btn btn-secondary">Back</a>
    </div>
</div>
@endsection
