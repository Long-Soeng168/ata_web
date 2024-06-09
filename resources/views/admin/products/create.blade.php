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
        <x-form-header :value="__('Create Products')" class="p-4" />

        <form class="w-full" action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid md:grid-cols-1 md:gap-6">
                <!-- Name -->
                <div>
                    <x-input-label for="name" :value="__('Name')" /><span class="text-red-500">*</span>
                    <x-text-input id="name" class="block w-full mt-1" type="text" name="name" :value="old('name')"
                        autofocus placeholder="Name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>
            </div>

            <div class="grid mt-4 md:grid-cols-3 md:gap-6">
                <!-- Code and Price -->
                <div>
                    <x-input-label for="code" :value="__('Code or Barcode')" />
                    <x-text-input id="code" class="block w-full mt-1" type="text" name="code" :value="old('code')"
                        placeholder="Code" />
                    <x-input-error :messages="$errors->get('code')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="price" :value="__('Price')" />
                    <x-text-input id="price" class="block w-full mt-1" type="number" name="price" :value="old('price')"
                        placeholder="Price" />
                    <x-input-error :messages="$errors->get('price')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="discount" :value="__('Discount % ')" />
                    <x-text-input id="discount" class="block w-full mt-1" type="number" name="discount_percent"
                        :value="old('discount')" placeholder="Discount" />
                    <x-input-error :messages="$errors->get('discount_percent')" class="mt-2" />
                </div>
            </div>

            <div class="grid mt-4 md:grid-cols-2 md:gap-6">
                <!-- Category, Brand, Model, and Type -->
                <div class="relative z-0 w-full group">
                    <x-input-label for="brand_id" :value="__('Brands')" />
                    <x-select-option id="brand_id" name="brand_id">
                        <option value="">Select Brand...</option>
                        @forelse ($brands as $brand)
                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                        @empty
                            <option value=""> --No Brand--</option>
                        @endforelse
                    </x-select-option>
                    <x-input-error :messages="$errors->get('brand_id')" class="mt-2" />
                </div>
                <div class="relative z-0 w-full group">
                    <x-input-label for="model_id" :value="__('Models')" />
                    <x-select-option id="model_id" name="model_id">
                        <option value="">Select Model...</option>
                        @forelse ($models as $model)
                            <option value="{{ $model->id }}">{{ $model->name }}</option>
                        @empty
                            <option value=""> --No Model--</option>
                        @endforelse
                    </x-select-option>
                    <x-input-error :messages="$errors->get('model_id')" class="mt-2" />
                </div>
                <div class="relative z-0 w-full group">
                    <x-input-label for="category_id" :value="__('Categories')" />
                    <x-select-option id="category_id" name="category_id">
                        <option value="">Select Category...</option>
                        @forelse ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @empty
                            <option value=""> --No Category--</option>
                        @endforelse
                    </x-select-option>
                    <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                </div>
                <div class="relative z-0 w-full group">
                    <x-input-label for="body_type_id" :value="__('Body Types')" />
                    <x-select-option id="body_type_id" name="body_type_id">
                        <option value="">Select Body Type...</option>
                        @forelse ($body_types as $body_type)
                            <option value="{{ $body_type->id }}">{{ $body_type->name }}</option>
                        @empty
                            <option value="">--No Body Type--</option>
                        @endforelse
                    </x-select-option>
                    <x-input-error :messages="$errors->get('body_type_id')" class="mt-2" />
                </div>
                <div class="relative z-0 w-full group">
                    <x-input-label for="shop_id" :value="__('Shops')" />
                    <x-select-option id="shop_id" name="shop_id">
                        <option value="">Select Shop...</option>
                        @forelse ($shops as $shop)
                            <option value="{{ $shop->id }}">{{ $shop->name }}</option>
                        @empty
                            <option value="">--No Shop--</option>
                        @endforelse
                    </x-select-option>
                    <x-input-error :messages="$errors->get('shop_id')" class="mt-2" />
                </div>
            </div>

            <!-- Image Upload -->
            <div class="mt-5 mb-5">
                <div class="flex items-center space-4">
                    <div class="max-w-40">
                        <img id="selected-image" src="#" alt="Selected Image"
                            class="hidden max-w-full pr-4 max-h-40" />
                    </div>
                    <div class="flex-1">
                        <x-input-label required for="image" :value="__('Upload Image (max : 2MB)')" />
                        <x-file-input id="dropzone-file" type="file" name="image"
                            accept="image/png, image/jpeg, image/gif" onchange="displaySelectedImage(event)" />
                        <x-input-error :messages="$errors->get('image')" class="mt-2" />
                    </div>
                </div>
            </div>

            <!-- Description -->
            <div class="mb-5">
                <x-input-label for="description" :value="__('Description')" />
                <textarea id="description" name="description" class="block w-full mt-1" rows="4">{{ old('description') }}</textarea>
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
