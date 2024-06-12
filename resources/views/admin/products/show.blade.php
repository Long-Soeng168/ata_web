@extends('admin.layouts.admin')

@section('content')
<div class="p-4">
    <x-form-header :value="__('Product Details')" class="p-4"/>

    <div class="grid md:grid-cols-2 md:gap-6">
        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <p class="mt-1">{{ $product->name }}</p>
        </div>
    </div>

    <div class="grid md:grid-cols-3 md:gap-6 mt-4">
        <!-- Code and Price -->
        <div>
            <x-input-label for="code" :value="__('Code or Barcode')" />
            <p class="mt-1">{{ $product->code }}</p>
        </div>
        <div>
            <x-input-label for="price" :value="__('Price')" />
            <p class="mt-1">{{ $product->price }}</p>
        </div>
        <div>
            <x-input-label for="discount" :value="__('Discount % ')" />
            <p class="mt-1">{{ $product->discount_percent }}</p>
        </div>
    </div>

    <div class="grid md:grid-cols-2 md:gap-6 mt-4">
        <!-- Category, Brand, Model, and Type -->
        <div>
            <x-input-label for="brand_id" :value="__('Brand')" />
            <p class="mt-1">{{ $product->brand?->name }}</p>
        </div>
        <div>
            <x-input-label for="model_id" :value="__('Model')" />
            <p class="mt-1">{{ $product->brand_model?->name }}</p>
        </div>
        <div>
            <x-input-label for="category_id" :value="__('Category')" />
            <p class="mt-1">{{ $product->categories?->name }}</p>
        </div>
        <div>
            <x-input-label for="body_type_id" :value="__('Body Type')" />
            <p class="mt-1">{{ $product->body_type?->name }}</p>
        </div>
    </div>

    <!-- Image Display -->
    <div class="mt-4">
        <x-input-label for="image" :value="__('Image')" />
        @if ($product->image)
            <div class="mt-1">
                <img src="{{ asset('assets/images/products/' . $product->image) }}" alt="{{ $product->name }}" class="max-w-full max-h-40" />
            </div>
        @else
            <p class="mt-1">No image available</p>
        @endif
    </div>

    <!-- Description -->
    <div class="mt-4">
        <x-input-label for="description" :value="__('Description')" />
        <p class="mt-1">{{ $product->description }}</p>
    </div>

    <div class="mt-4">
        <x-outline-button href="{{ route('admin.products.index') }}">
            Go back
        </x-outline-button>
    </div>
</div>
@endsection
