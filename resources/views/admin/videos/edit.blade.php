{{-- @extends('admin.layouts.admin')

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
    <h1>Edit Video</h1>
    <form action="{{ route('admin.videos.update', ['video' => $video->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <label for="title">Title:</label>
        <input type="text" name="title" value="{{ $video->title }}" required>
        <label for="description">Description:</label>
        <textarea name="description">{{ $video->description }}</textarea>
        <label for="status">Status:</label>
        <select name="status" required>
            <option value="free" {{ $video->status === 'free' ? 'selected' : '' }}>Free</option>
            <option value="price" {{ $video->status === 'price' ? 'selected' : '' }}>Price</option>
        </select>
        <button type="submit">Update</button>
    </form>
@endsection --}}
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
        <x-form-header :value="__('Update Video')" class="p-4" />

        <form id="video-form" class="w-full" action="{{ route('admin.videos.update', ['video' => $video->id]) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT') <!-- Add this to specify the HTTP method -->
            <div class="grid md:grid-cols-1 md:gap-6">
                <!-- Name -->
                <div>
                    <x-input-label for="title" :value="__('Title')" /><span class="text-red-500">*</span>
                    <x-text-input id="title" class="block w-full mt-1" type="text" name="title" :value="old('title', $video->title)"
                        autofocus placeholder="Title" />
                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                </div>
            </div>
            <div class="grid pt-4 mb-4 md:grid-cols-2 md:gap-6">
                <div class="relative z-0 w-full group">
                    <x-input-label for="status" :value="__('Status')" />
                    <x-select-option id="status" name="status">
                        <option value="" disabled>Select Status...</option>
                        <option value="free" {{ $video->status === 'free' ? 'selected' : '' }}>Free</option>
                        <option value="price" {{ $video->status === 'price' ? 'selected' : '' }}>Price</option>
                    </x-select-option>
                    <x-input-error :messages="$errors->get('status')" class="mt-2" />
                </div>
                <div class="relative z-0 w-full group">
                    <x-input-label for="category_id" :value="__('Video Category')" />
                    <x-select-option id="category_id" name="category_id">
                        <option value="">Select Video Category...</option>
                        @forelse ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ old('category_id', $video->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @empty
                            <option value=""> -- No Video Category -- </option>
                        @endforelse
                    </x-select-option>
                    <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                </div>

            </div>

            <!-- Image Upload -->
            <div class="flex items-center mb-4 space-x-4">
                <div class="flex-1">
                    <x-input-label for="image" :value="__('Upload Image (max : 2MB)')" />
                    <x-file-input id="image" name="image" accept="image/png, image/jpeg, image/gif" onchange="displaySelectedImage(event)" />
                    <x-input-error :messages="$errors->get('image')" class="mt-2" />
                </div>
            </div>

            <!-- Video Upload -->
            <div class="flex items-center mb-4 space-x-4">
                <div class="flex-1">
                    <x-input-label for="video" :value="__('Upload Video')" required />
                    <x-file-input id="dropzone-file" type="file" name="video" accept="video/mp4, video/avi, video/mov" onchange="displaySelectedImage(event)" />
                    <x-input-error :messages="$errors->get('video')" class="mt-2" />
                </div>
            </div>

            <div class="mb-5">
                <x-input-label for="description" :value="__('Description')" />
                <textarea id="description" name="description" class="block w-full p-2 mt-1 border border-gray-300 rounded" rows="4">{{ old('description', $video->description) }}</textarea>
            </div>

            <div>
                <x-outline-button href="{{ URL::previous() }}">
                    Go back
                </x-outline-button>
                <button type="button" onclick="submitForm()"
                    class="px-4 py-2 mt-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700">
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
