@extends('admin.layouts.admin')

@section('content')
    <div class="p-4">
        <x-form-header :value="__('Update Garage Post')" class="p-4" />

        <form class="w-full" action="{{ route('admin.garageposts.update', $garagepost->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="grid md:grid-cols-1 md:gap-6">
                <!-- Name Address -->
                <div>
                    <x-input-label for="name" :value="__('Name')" /><span class="text-red-500">*</span>
                    <x-text-input id="name" class="block w-full mt-1" type="text" name="name" :value="old('name', $garagepost->name)"
                        required autofocus placeholder="Name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>
                <div class="relative z-0 w-full group">
                    <x-input-label for="garage_id" :value="__('Garage Name')" />
                    <x-select-option id="garage_id" name="garage_id">
                        <option value="">Select Garage...</option>
                        @forelse ($garages as $garage)
                        {{-- <option value="{{ $garage->id }}" {{ $promotion->garage_id == $garage->id ? 'selected' : '' }}>{{ $garage->name }}</option> --}}
                            <option value="{{ $garage->id }}" {{ $garagepost->garage_id == $garage->id ? 'selected' : '' }}>{{ $garage->name }}</option>
                        @empty
                            <option value=""> --No garage--</option>
                        @endforelse
                    </x-select-option>
                    <x-input-error :messages="$errors->get('garage_id')" class="mt-2" />
                </div>

            </div>
            <div class="my-5">
                <div class="flex items-center space-4">
                    <div class="max-w-40">
                        @if ($garagepost->image)
                            <img id="selected-image" src="{{ asset('assets/images/garageposts/thumb/' . $garagepost->image) }}" alt="Selected Image"
                                class="max-w-full pr-4 max-h-40" />
                        @else
                            <img id="selected-image" src="#" alt="Selected Image"
                                class="hidden max-w-full pr-4 max-h-40" />
                        @endif
                    </div>
                    <div class="flex-1">
                        <x-input-label for="image" :value="__('Upload Image (max : 2MB)')" />
                        <x-file-input id="dropzone-file" type="file" name="image"
                            accept="image/png, image/jpeg, image/gif" onchange="displaySelectedImage(event)" />
                        <x-input-error :messages="$errors->get('image')" class="mt-2" />
                    </div>
                </div>
            </div>
            <div class="mb-5">
                <x-input-label for="description" :value="__('Description')" />
                <textarea id="description" name="description" class="block w-full p-2 mt-1 border rounded-md" rows="4">{{ old('description',$garagepost->description) }}</textarea>
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
