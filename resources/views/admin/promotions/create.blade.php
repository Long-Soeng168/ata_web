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
        <x-form-header :value="__('Create Promotion')" class="p-4" />

        <form class="w-full" action="{{ route('admin.promotions.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid md:grid-cols-1 md:gap-6">
                <!-- Name -->
                <div>
                    <x-input-label for="title" :value="__('Title')" /><span class="text-red-500">*</span>
                    <x-text-input id="title" class="block w-full mt-1" type="text" name="title" :value="old('title')"
                        autofocus placeholder="Title" />
                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                </div>
            </div>

            <div class="grid mt-4 md:grid-cols-3 md:gap-6">
                <div class="relative z-0 w-full group">
                    <x-input-label for="garage_id" :value="__('Garage')" />
                    <x-select-option id="garage_id" name="garage_id">
                        <option value="">Select Garage...</option>
                        @forelse ($garages as $garage)
                            <option value="{{ $garage->id }}">{{ $garage->name }}</option>
                        @empty
                            <option value=""> --No garage--</option>
                        @endforelse
                    </x-select-option>
                    <x-input-error :messages="$errors->get('garage_id')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="start_date" :value="__('Start Date')" />
                    <x-text-input id="start_date" class="block w-full mt-1" type="date" name="start_date"
                        :value="old('start_date')" placeholder="Start Date" />
                    <x-input-error :messages="$errors->get('start_date')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="end_date" :value="__('End Date')" />
                    <x-text-input id="end_date" class="block w-full mt-1" type="date" name="end_date" :value="old('end_date')"
                        placeholder="End Date" />
                    <x-input-error :messages="$errors->get('end_date')" class="mt-2" />
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
                            <x-input-label required for="image" :value="__('Upload Image (max : 2MB)')" />
                            <x-file-input id="dropzone-file" type="file" name="image"
                                accept="image/png, image/jpeg, image/gif" onchange="displaySelectedImage(event)" />
                            <x-input-error :messages="$errors->get('image')" class="mt-2" />
                        </div>
                    </div>
                </div>

            </div>
            <div>
                <div class="grid md:grid-cols-1 md:gap-6 mb-6">
                <!-- Description -->
                    <div class="mb-5">
                        <x-input-label for="description" :value="__('Description')" />
                        <textarea id="description" name="description" class="block w-full mt-1" rows="4">{{ old('description') }}</textarea>
                    </div>
                </div>
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
