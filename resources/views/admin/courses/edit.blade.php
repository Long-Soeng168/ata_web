@extends('admin.layouts.admin')

@section('content')
    <div class="p-4">
        <x-form-header :value="__('Update Course')" class="p-4" />

        <form class="w-full" action="{{ route('admin.courses.update', $item) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid mb-4 md:grid-cols-2 md:gap-6">
                <!-- Name Address -->
                <div>
                    <x-input-label for="title" :value="__('Title')" /><span class="text-red-500">*</span>
                    <x-text-input id="title" class="block w-full mt-1" type="text" name="title" :value="old('title', $item->title)"
                        required autofocus placeholder="Title" />
                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="price" :value="__('Price')" />
                    <x-text-input id="price" class="block w-full mt-1" type="number" name="price" :value="old('price', $item->price)"
                         autofocus placeholder="Price" step="0.01" min="0" />
                    <x-input-error :messages="$errors->get('price')" class="mt-2" />
                </div>
            </div>
            <div class="grid md:grid-cols-2 md:gap-6">
                <div>
                    <x-input-label for="start" :value="__('Start')" />
                    <x-text-input id="start" class="block w-full mt-1" type="date" name="start" :value="old('start', $item->start)"
                         autofocus placeholder="Start Date" />
                    <x-input-error :messages="$errors->get('start')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="end" :value="__('End')" />
                    <x-text-input id="end" class="block w-full mt-1" type="date" name="end" :value="old('end', $item->end)"
                         autofocus placeholder="End Date" />
                    <x-input-error :messages="$errors->get('end')" class="mt-2" />
                </div>

            </div>

            <div class="">
                <div class="flex items-center space-4">
                    <div class="max-w-40">
                        <img id="selected-image" src="{{ asset('assets/images/courses/' . $item->image) }}"
                            alt="Selected Image" class="hidden max-w-full pr-4 max-h-40" />
                    </div>
                    <div class="flex-1">
                        <x-input-label for="types" :value="__('Upload Image (max : 2MB)')" />
                        <x-file-input id="dropzone-file" type="file" name="image"
                            accept="image/png, image/jpeg, image/gif" onchange="displaySelectedImage(event)" />
                        <x-input-error :messages="$errors->get('image')" class="mt-2" />
                    </div>
                </div>
            </div>

            <div class="grid mb-5 md:grid-cols-1 md:gap-6">
                <!-- Description -->
                <div class="">
                    <x-input-label for="description" :value="__('Description')" />
                    <textarea id="description" name="description" class="block w-full p-2 mt-1 border" rows="4">{{ old('description', $item->description) }}</textarea>
                </div>
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
