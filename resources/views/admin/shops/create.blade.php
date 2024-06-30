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
        <x-form-header :value="__('Create Shop')" class="p-4" />

        <form class="w-full" action="{{ route('admin.shops.store') }}" method="POST" enctype="multipart/form-data">
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
                    <x-input-label for="adress" :value="__('Address')" /><span class="text-red-500">*</span>
                    <x-text-input id="address" class="block w-full mt-1" type="text" name="address" :value="old('address')"
                        placeholder="address" />
                    <x-input-error :messages="$errors->get('address')" class="mt-2" />
                </div>
                <div class="relative z-0 w-full group">
                    <x-input-label for="user_id" :value="__('Users')" />
                    <x-select-option id="user_id" name="owner_user_id">
                        <option value="">Select User...</option>
                        @forelse ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @empty
                            <option value=""> --No User--</option>
                        @endforelse
                    </x-select-option>
                    <x-input-error :messages="$errors->get('user_id')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="phone" :value="__('Phone')" />
                    <x-text-input id="phone" class="block w-full mt-1" type="number" name="phone" :value="old('phone')"
                        placeholder="phone" />
                    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="unlike" :value="__('Vat Percent')" />
                    <x-text-input id="vat_percent" class="block w-full mt-1" type="number" name="vat_percent" :value="old('vat_percent')"
                        placeholder="vat_percent" />
                    <x-input-error :messages="$errors->get('vat_percent')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="exchange_rate_riel" :value="__('Exchange Rate Riel')" />
                    <x-text-input id="exchange_rate_riel" class="block w-full mt-1" type="number" name="exchange_rate_riel" :value="old('exchange_rate_riel')"
                        placeholder="exchange_rate_riel" />
                    <x-input-error :messages="$errors->get('exchange_rate_riel')" class="mt-2" />
                </div>
            </div>

            <div class="grid mt-4 md:grid-cols-2 md:gap-6">
                <!-- Category, Brand, Model, and Type -->


                <!-- Image Upload -->
                <div class="mt-5 mb-5">
                    <div class="flex items-center space-4">
                        <div class="max-w-40">
                            <img id="selected-image" src="#" alt="Selected Image"
                                class="hidden max-w-full pr-4 max-h-40" />
                        </div>
                        <div class="flex-1">
                            <x-input-label required for="image" :value="__('Upload Logo Image (max : 2MB)')" />
                            <x-file-input id="dropzone-file" type="file" name="logo"
                                accept="image/png, image/jpeg, image/gif" onchange="displaySelectedImage(event)" />
                            <x-input-error :messages="$errors->get('image')" class="mt-2" />
                        </div>
                    </div>
                </div>
                {{-- <div class="mt-5 mb-5">
                    <div class="flex items-center space-4">
                        <div class="max-w-40">
                            <img id="selected-image" src="#" alt="Selected Image"
                                class="hidden max-w-full pr-4 max-h-40" />
                        </div>
                        <div class="flex-1">
                            <x-input-label required for="image" :value="__('Upload Cover Image (max : 2MB)')" />
                            <x-file-input id="dropzone-file" type="file" name="banner"
                                accept="image/png, image/jpeg, image/gif" onchange="displaySelectedImage(event)" />
                            <x-input-error :messages="$errors->get('image')" class="mt-2" />
                        </div>
                    </div>
                </div> --}}

                <!-- Description -->
            </div>
                <!-- Description -->
            <div class="mb-5">
                <x-input-label for="description" :value="__('Description EN')" />
                <textarea id="description" name="description" class="block w-full mt-1" rows="4">{{ old('description') }}</textarea>
            </div>
            <!-- Description KH -->
            <div class="mb-5">
                <x-input-label for="description_kh" :value="__('Description KH')" />
                <textarea id="description_kh" name="description_kh" class="block w-full mt-1" rows="4">{{ old('description_kh') }}</textarea>
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
