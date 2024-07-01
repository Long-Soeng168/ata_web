@extends('admin.layouts.admin')

@section('content')
    <div class="p-4">
        <x-form-header :value="__('Create DTC')" class="p-4" />
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form class="w-full" action="{{ route('admin.dtcs.store') }}" method="POST" enctype="multipart/form-data">
            @csrf


            <div class="grid mt-4 md:grid-cols-1 md:gap-6">
                <div>
                    <x-input-label for="dtc_code" :value="__('DTC Code')" />
                    <x-text-input id="dtc_code" class="block w-full mt-1" type="text" name="dtc_code" :value="old('dtc_code')"
                        placeholder="dtc_code" />
                    <x-input-error :messages="$errors->get('dtc_code')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="description_en" :value="__('description_en')" />
                    <textarea id="description_en" name="description_en" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 border"></textarea>
                </div>
                <div>
                    <x-input-label for="description_kh" :value="__('Description KH')" />
                    <textarea id="description_kh" name="description_kh" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 border"></textarea>
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
