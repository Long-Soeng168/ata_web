@extends('admin.layouts.admin')

@section('content')
    @if ($errors->any())
        <div class="p-4 mb-4 text-red-700 bg-red-100 border border-red-400 rounded">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (session('error'))
        <p class="p-4 mb-4 text-red-700 bg-red-100 border border-red-400 rounded">{{ session('error') }}</p>
    @endif

    <div class="p-6 bg-white rounded-lg shadow-md">
        <x-form-header :value="__('Create Video')" class="mb-4" />

        <form id="video-form" class="w-full space-y-6" action="{{ route('admin.videos.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Title -->
            <div>
                <x-input-label for="title" :value="__('Title')" /><span class="text-red-500">*</span>
                <x-text-input id="title" class="block w-full mt-1" type="text" name="title" :value="old('title')" autofocus placeholder="Title" />
                <x-input-error :messages="$errors->get('title')" class="mt-2" />
            </div>

            <!-- Status -->
            <div class="grid pt-4 md:grid-cols-2 md:gap-6">
                <div class="relative z-0 w-full group">
                    <x-input-label for="status" :value="__('Status')" />
                    <x-select-option id="status" name="status">
                        <option value="" disabled>Select Status...</option>
                        <option value="free">Free</option>
                        <option value="price">Price</option>
                    </x-select-option>
                    <x-input-error :messages="$errors->get('status')" class="mt-2" />
                </div>
                <div class="relative z-0 w-full group">
                    <x-input-label for="category_id" :value="__('Video Category')" />
                    <x-select-option id="category_id" name="category_id">
                        <option value="">Select Video Category...</option>
                        @forelse ($category as $cat)
                            <option value="{{ $cat->id }}"
                                {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @empty
                            <option value=""> -- No Video Category -- </option>
                        @endforelse
                    </x-select-option>
                    <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                </div>

            </div>
            <!-- Video Upload -->
            <div class="flex items-center space-x-4">
                <div class="flex-1">
                    <x-input-label for="video" :value="__('Upload Video')" required />
                    <x-file-input id="dropzone-file" type="file" name="video" accept="video/mp4, video/avi, video/mov" onchange="displaySelectedImage(event)" />
                    <x-input-error :messages="$errors->get('video')" class="mt-2" />
                </div>
            </div>

            <!-- Description -->
            <div>
                <x-input-label for="description" :value="__('Description')" />
                <textarea id="description" name="description" class="block w-full p-2 mt-1 border border-gray-300 rounded" rows="4">{{ old('description') }}</textarea>
            </div>

            <!-- Buttons -->
            <div class="flex items-center space-x-4">
                <x-outline-button href="{{ URL::previous() }}">
                    Go back
                </x-outline-button>
                <button type="submit" class="px-4 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700">
                    Submit
                </button>
            </div>
        </form>
    </div>
@endsection
