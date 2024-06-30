<div>

    <div class="p-4">
        <x-form-header :value="__('Create Products')" class="p-4" />

        <form class="w-full" {{-- action="{{ route('admin.products.store') }}"
            method="POST"
            enctype="multipart/form-data"  --}}>
            @csrf
            <div class="grid md:grid-cols-1 md:gap-6">
                <!-- Name -->
                <div>
                    <x-input-label for="name" :value="__('Name')" /><span class="text-red-500">*</span>
                    <x-text-input id="name" class="block w-full mt-1" type="text" wire:model='name'
                        :value="old('name')" autofocus placeholder="Name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>
            </div>

            <div class="grid mt-4 md:grid-cols-3 md:gap-6">
                <!-- Code and Price -->
                <div>
                    <x-input-label for="price" :value="__('Price')" /><span class="text-red-500">*</span>
                    <x-text-input id="price" class="block w-full mt-1" type="number" wire:model="price"
                        :value="old('price')" placeholder="Price" />
                    <x-input-error :messages="$errors->get('price')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="code" :value="__('Code or Barcode')" />
                    <x-text-input id="code" class="block w-full mt-1" type="text" wire:model="code"
                        :value="old('code')" placeholder="Code" />
                    <x-input-error :messages="$errors->get('code')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="discount" :value="__('Discount % ')" />
                    <x-text-input id="discount" class="block w-full mt-1" type="number" wire:model="discount_percent"
                        :value="old('discount')" placeholder="Discount" />
                    <x-input-error :messages="$errors->get('discount_percent')" class="mt-2" />
                </div>
            </div>

            <div class="grid mt-4 md:grid-cols-2 md:gap-6">
                <!-- Category, Brand, Model, and Type -->
                <div class="relative z-0 w-full group">
                    <label class ='mb-4 text-sm font-medium text-gray-600 dark:text-white'>
                        Brands {{ $brand_id }}
                    </label>
                    <x-select-option id="brand_id" wire:model.live="brand_id">
                        <option value=""> Select Brand...</option>
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
                    <x-select-option id="model_id" wire:model="model_id">
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
                    <x-select-option id="category_id" wire:model="category_id">
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
                    <x-select-option id="body_type_id" wire:model="body_type_id">
                        <option value="">Select Body Type...</option>
                        @forelse ($body_types as $body_type)
                            <option value="{{ $body_type->id }}">{{ $body_type->name }}</option>
                        @empty
                            <option value="">--No Body Type--</option>
                        @endforelse
                    </x-select-option>
                    <x-input-error :messages="$errors->get('body_type_id')" class="mt-2" />
                </div>
                <div class="relative z-0 w-full col-span-2 group">
                    <x-input-label for="shop_id" :value="__('Shops')" />
                    <x-select-option id="shop_id" wire:model="shop_id">
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
            <div class="mt-5 ">
                <div class="">
                    <div class="">
                        <x-input-label required for="image" :value="__('Upload Image (max: 2MB)')" />
                        <input type="file" id="dropzone-file" name="image"
                            accept="image/png, image/jpeg, image/gif" wire:model="image"
                            class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" />

                        <div  wire:loading wire:target="image">
                            <div class="flex gap-2 pt-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-loader-circle animate-spin"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg>
                                <span>Uploading...</span>
                            </div>
                        </div>

                        <x-input-error :messages="$errors->get('image')" class="mt-2" />
                    </div>
                    <div class="flex flex-wrap max-w-full gap-2 mt-4">
                        @if ($image)
                                <img src="{{ $image->temporaryUrl() }}" alt="Selected Image"
                                    class="max-w-full pr-4 mb-2 max-h-40" />
                        @endif
                    </div>
                </div>
            </div>

            {{-- <div class="mt-5 mb-5">
                <div class="flex items-center space-x-4">
                    <div class="max-w-40">
                        @if ($image)
                            <img id="selected-image" src="{{ $image->temporaryUrl() }}" alt="Selected Image" class="max-w-full pr-4 max-h-40" />
                        @else
                            <img id="selected-image" src="#" alt="Selected Image" class="hidden max-w-full pr-4 max-h-40" />
                        @endif
                    </div>
                    <div class="flex-1">
                        <x-input-label required for="image" :value="__('Upload Image (max: 2MB)')" />
                        <input type="file" id="dropzone-file" name="image" accept="image/png, image/jpeg, image/gif"
                            wire:model="image"
                            class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" />
                            <div wire:loading wire:target='image'>
                                <div class="flex gap-2 pt-2">
                                    <svg aria-hidden="true" class="w-6 h-6 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                                        <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                                    </svg>
                                    <span>Uploading...</span>
                                </div>
                            </div>
                        <x-input-error :messages="$errors->get('image')" class="mt-2" />
                    </div>
                </div>
            </div> --}}

            <!-- Description -->
            <div class="mb-5">
                <x-input-label for="description" :value="__('Description')" />
                <textarea id="description" wire:model="description" class="block w-full p-2 mt-1 border" rows="4">{{ old('description') }}</textarea>
            </div>

            <div>
                <x-outline-button href="{{ URL::previous() }}">
                    Go back
                </x-outline-button>
                <x-submit-button wire:click.prevent='save'>
                    Submit
                </x-submit-button>
            </div>
        </form>
    </div>

</div>
