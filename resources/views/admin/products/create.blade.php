@extends('admin.layouts.admin')

@section('content')
@if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
<div class="p-4">
    <x-form-header :value="__('Create Products')" class="p-4"/>

    <form class="w-full" action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="grid md:grid-cols-2 md:gap-6">
            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Name')" /><span class="text-red-500">*</span>
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus placeholder="Name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>
        </div>

        <div class="grid md:grid-cols-3 md:gap-6 mt-4">
            <!-- Code and Price -->
            <div>
                <x-input-label for="code" :value="__('Code or Barcode')" />
                <x-text-input id="code" class="block mt-1 w-full" type="text" name="code" :value="old('code')" placeholder="Code" />
                <x-input-error :messages="$errors->get('code')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="price" :value="__('Price')" />
                <x-text-input id="price" class="block mt-1 w-full" type="number" name="price" :value="old('price')" required placeholder="Price" />
                <x-input-error :messages="$errors->get('price')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="discount" :value="__('Discount % ')" />
                <x-text-input id="discount" class="block mt-1 w-full" type="number" name="discount_percent" :value="old('discount')" placeholder="Discount" />
                <x-input-error :messages="$errors->get('discount_percent')" class="mt-2" />
            </div>
        </div>

        <div class="grid md:grid-cols-2 md:gap-6 mt-4">
            <!-- Category, Brand, Model, and Type -->
            <div class="relative z-0 w-full mb-5 group">
                <x-input-label for="brand_id" :value="__('Brands')" />
                <x-select-option id="brand_id" name="brand_id">
                    <option>Select Brand...</option>
                    @forelse ($brands as $brand)
                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                    @empty
                        <option> --No Brand--</option>
                    @endforelse
                </x-select-option>
                <x-input-error :messages="$errors->get('brand_id')" class="mt-2" />
            </div>
            <div class="relative z-0 w-full mb-5 group">
                <x-input-label for="model_id" :value="__('Models')" />
                <x-select-option id="model_id" name="model_id">
                    <option>Select Model...</option>
                    @forelse ($models as $model)
                        <option value="{{ $model->id }}">{{ $model->name }}</option>
                    @empty
                        <option> --No Model--</option>
                    @endforelse
                </x-select-option>
                <x-input-error :messages="$errors->get('model_id')" class="mt-2" />
            </div>
            <div class="relative z-0 w-full mb-5 group">
                <x-input-label for="category_id" :value="__('Categories')" />
                <x-select-option id="category_id" name="category_id">
                    <option>Select Category...</option>
                    @forelse ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @empty
                        <option> --No Category--</option>
                    @endforelse
                </x-select-option>
                <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
            </div>
            <div class="relative z-0 w-full mb-5 group">
                <x-input-label for="type_id" :value="__('Types')" />
                <x-select-option id="type_id" name="type_id">
                    <option>Select Type...</option>
                    @forelse ($types as $type)
                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                    @empty
                        <option>--No Type--</option>
                    @endforelse
                </x-select-option>
                <x-input-error :messages="$errors->get('type_id')" class="mt-2" />
            </div>
            <div class="relative z-0 w-full mb-5 group">
                <x-input-label for="body_type_id" :value="__('Body Types')" />
                <x-select-option id="body_type_id" name="body_type_id">
                    <option>Select Body Type...</option>
                    @forelse ($body_types as $body_type)
                        <option value="{{ $body_type->id }}">{{ $body_type->name }}</option>
                    @empty
                        <option>--No Body Type--</option>
                    @endforelse
                </x-select-option>
                <x-input-error :messages="$errors->get('body_type_id')" class="mt-2" />
            </div>
        </div>

        <!-- Image Upload -->
        <div class="mb-5">
            <div class="flex items-center space-4">
                <div class="max-w-40">
                    <img id="selected-image" src="#" alt="Selected Image" class="hidden max-w-full max-h-40 pr-4" />
                </div>
                <div class="flex-1">
                    <x-input-label for="image" :value="__('Upload Image (max : 2MB)')" />
                    <x-file-input id="dropzone-file" type="file" name="image" accept="image/png, image/jpeg, image/gif" onchange="displaySelectedImage(event)" />
                </div>
            </div>
        </div>

        <!-- Description -->
        <div class="mb-5">
            <x-input-label for="description" :value="__('Description')" />
            <textarea id="description" name="description" class="block mt-1 w-full" rows="4">{{ old('description') }}</textarea>
        </div>

        <div>
            <x-outline-button href="{{ URL::previous() }}">
                Go back
            </x-outline-button>
            <x-submit-button>
                Submit
            </x-submit-button>
        </div>
    </form>
</div>

<script>
    function displaySelectedImage(event) {
        const fileInput = event.target;
        const file = fileInput.files[0];
        const imgElement = document.getElementById('selected-image');

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imgElement.src = e.target.result;
                imgElement.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        } else {
            imgElement.src = "#";
            imgElement.classList.add('hidden');
        }
    }
</script>
@endsection
