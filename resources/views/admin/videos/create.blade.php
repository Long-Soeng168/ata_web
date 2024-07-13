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
    @if (session('error'))
        <p class="text-red-400">{{ session('error') }}</p>
    @endif

    <div class="p-4">
        <x-form-header :value="__('Create Video')" class="p-4" />

        <form id="video-form" class="w-full" action="{{ route('admin.videos.store') }}" method="POST" enctype="multipart/form-data">
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
                    <x-input-label for="status" :value="__('Status')" />
                    <select name="status" required>
                        <option value="free">Free</option>
                        <option value="price">Price</option>
                    </select>
                    <x-input-error :messages="$errors->get('status')" class="mt-2" />
                </div>
            </div>
            <div class="relative z-0 w-full group">
                    <x-input-label for="user_id" :value="__('Video Category')" />
                    <x-select-option id="user_id" name="category_id">
                        <option value="">Select Video Category...</option>
                        @forelse ($category as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @empty
                            <option value=""> --No Video Category--</option>
                        @endforelse
                    </x-select-option>
                    <x-input-error :messages="$errors->get('user_id')" class="mt-2" />
                </div>
            <div class="grid mt-4 md:grid-cols-2 md:gap-6">
                <div class="mt-5 mb-5">
                    <div class="flex items-center space-4">
                        <div class="max-w-40">
                            <img id="selected-image" src="#" alt="Selected Image"
                                class="hidden max-w-full pr-4 max-h-40" />
                        </div>
                        <div class="flex-1">
                            <x-input-label required for="video" :value="__('Upload Video')" />
                            <x-file-input id="dropzone-file" type="file" name="video"
                                accept="video/mp4, video/avi, video/mov" onchange="displaySelectedImage(event)" />
                            <x-input-error :messages="$errors->get('video')" class="mt-2" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-5">
                <x-input-label for="description" :value="__('Description')" />
                <textarea id="description" name="description" class="block w-full mt-1" rows="4">{{ old('description') }}</textarea>
            </div>

            <div>
                <x-outline-button href="{{ URL::previous() }}">
                    Go back
                </x-outline-button>
                <button type="button" onclick="submitForm()" class="px-4 py-2 mt-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700">
                    Submit
                </button>
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

        function submitForm() {
            const form = document.getElementById('video-form');
            form.submit();
        }
    </script>
@endsection
