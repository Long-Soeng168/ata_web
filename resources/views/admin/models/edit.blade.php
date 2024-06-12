@extends('admin.layouts.admin')

@section('content')
<div class="p-4">
    <x-form-header :value="__('Edit Model')" />
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form class="w-full" action="{{ route('admin.models.update', $model->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="grid md:grid-cols-2 md:gap-6">
            <div>
                <x-input-label for="name" :value="__('Name')" /><span class="text-red-500">*</span>
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" value="{{ old('name', $model->name) }}" required autofocus placeholder="Name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="name_kh" :value="__('Name Kh')" /><span class="text-red-500">*</span>
                <x-text-input id="name_kh" class="block mt-1 w-full" type="text" name="name_kh" value="{{ old('name_kh', $model->name_kh) }}" required autofocus placeholder="Name in Khmer" />
                <x-input-error :messages="$errors->get('name_kh')" class="mt-2" />
            </div>
            <div class="relative z-0 w-full mb-5 group">
                <x-input-label for="brands" :value="__('Brand')" />
                <x-select-option id="brands" name="brand_id">
                    <option>Select Brand...</option>
                    @forelse ($brands as $brand)
                        <option value="{{ $brand->id }}" {{ $brand->id == $model->brand_id ? 'selected' : '' }}>{{ $brand->name }}</option>
                    @empty
                        <option>--No Brand--</option>
                    @endforelse
                </x-select-option>
                <x-input-error :messages="$errors->get('brand_id')" class="mt-2" />
            </div>
        </div>

        <div class="my-4 mb-6">
            <div class="flex items-center space-4">
                <div class="max-w-40">
                    @if ($model->image)
                        <img id="selected-image" src="{{ asset('assets/images/models/' . $model->image) }}" alt="Selected Image" class="max-w-full max-h-40 pr-4" />
                    @else
                        <img id="selected-image" src="#" alt="Selected Image" class="hidden max-w-full max-h-40 pr-4" />
                    @endif
                </div>
                <div class="flex-1">
                    <x-input-label for="types" :value="__('Upload Image (max : 2MB)')" />
                    <x-file-input id="dropzone-file" name="image" accept="image/png, image/jpeg, image/gif" onchange="displaySelectedImage(event)" />
                </div>
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
