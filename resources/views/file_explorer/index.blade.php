@extends('admin.layouts.admin')

@section('content')
    <div class="container p-6 mx-auto bg-white rounded-lg "
        x-data="{
            isAddFile : false,
            isAddFolder : false
        }"
    >
        <div class="flex items-center justify-between mb-4">
            <h1 class="flex items-center gap-2 text-2xl font-bold">
                <img src="{{ asset('assets/icons/folder-structure.png') }}" class="w-10 h-10" alt="">
                <p>File Explorer</p>
            </h1>
           <div>
                <button @click="isAddFile = !isAddFile" type="submit"  >
                    <p x-cloak x-show="!isAddFile" class="p-2 text-white bg-blue-500 rounded">Add File</p>
                    <p x-cloak x-show="isAddFile" class="p-2 text-white bg-gray-500 rounded">Cancel</p>
                </button>
                <button @click="isAddFolder = !isAddFolder" type="submit"  >
                    <p x-cloak x-show="!isAddFolder" class="p-2 text-white bg-green-500 rounded">Add Folder</p>
                    <p x-cloak x-show="isAddFolder" class="p-2 text-white bg-gray-500 rounded">Cancel</p>
                </button>
           </div>
        </div>


        <h2 class="mb-4 text-xl font-semibold">Current Path:
            <span class="text-gray-700">
                @php
                    $parts = $path ? explode('/', $path) : [];
                    $currentPath = '';
                @endphp
                @foreach ($parts as $index => $part)
                    @php
                        $currentPath .= $part . '/';
                    @endphp
                    @if ($part)
                        / <a href="{{ route('file.explorer.folder', str_replace('/', '-', trim($currentPath, '/'))) }}"
                            class="text-blue-500 capitalize hover:underline">
                            {{ $part }}
                        </a>
                    @endif
                @endforeach
            </span>
        </h2>



        <form x-show="isAddFile" x-cloak action="{{ route('file.explorer.upload') }}" method="POST" enctype="multipart/form-data" class="mb-4" >
            @csrf
            <div class="flex items-center">
                <input multiple type="file" name="file[]" class="p-2 mr-2 border border-gray-300 rounded" accept=".pdf">
                <input type="hidden" name="path" value="{{ $path ?? '/' }}">
                <button type="submit" class="p-2 text-white bg-blue-500 rounded">
                    Upload File
                </button>
            </div>
        </form>

        <form  x-show="isAddFolder" x-cloak action="{{ route('file.explorer.createFolder') }}" method="POST" class="mb-6">
            @csrf
            <div class="flex items-center">
                <input type="text" name="folder_name" placeholder="Folder Name"
                    class="p-2 mr-2 border border-gray-300 rounded">
                <input type="hidden" name="path" value="{{ $path ?? '/' }}">
                <button type="submit" class="p-2 text-white bg-green-500 rounded">Create Folder</button>
            </div>
        </form>

        <div class="mb-6">
            {{-- <h3 class="mb-2 text-lg font-semibold">Folders</h3> --}}
            <ul class="pl-5 list-disc" >
                @foreach ($folders as $folder)
                    <li class="flex items-center mb-1" x-data="{ isEdit: false }">
                        <a href="{{ route('file.explorer.folder', str_replace('/', '-', $folder)) }}"
                            class="flex text-blue-500 hover:underline">
                            <img class="w-6 h-6 mr-2" src="{{ asset('assets/icons/folder.png') }}" alt="">
                            {{ basename($folder) }}
                        </a>
                        <form x-show="isEdit" x-cloak action="{{ route('file.explorer.rename') }}" method="POST" class="flex items-center ml-4">
                            @csrf
                            <input type="hidden" name="path" value="{{ $path }}">
                            <input type="hidden" name="old_name" value="{{ basename($folder) }}">
                            <input type="hidden" name="old_path" value="{{ $folder }}">
                            <input type="text" name="new_name" placeholder="New name"
                                class="p-1 mr-2 border border-gray-300 rounded">
                            <button type="submit" class="p-1 text-white bg-yellow-500 rounded">Rename</button>
                        </form>
                        <form x-show="isEdit" x-cloak action="{{ route('file.explorer.delete') }}" onsubmit="return confirmDelete();" method="POST" class="ml-2">
                            @csrf
                            <input type="hidden" name="path" value="{{ $path }}">
                            <input type="hidden" name="name" value="{{ basename($folder) }}">
                            <button type="submit" class="flex items-center justify-center">
                                <img src="{{ asset('assets/icons/delete.png') }}" class="h-8" alt="">
                                {{-- Delete --}}
                            </button>
                        </form>
                        <button @click="isEdit = !isEdit" type="submit" class="">
                            <img src="{{ asset('assets/icons/edit.png') }}" class="h-4 mx-2" alt="">
                        </button>
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="mb-6">
            {{-- <h3 class="mb-2 text-lg font-semibold">Files</h3> --}}
            <ul class="pl-5 list-disc">
                @foreach ($files as $file)
                    <li class="flex items-center mb-1" x-data="{ isEdit: false }">

                        <a href="{{ url('show_pdf_file/'. $path . '/' . basename($file))  }}" target="_blank" class="flex cursor-pointer hover:underline">
                            <img class="w-6 h-6 mr-2" src="{{ asset('assets/icons/file.png') }}" alt="">
                            {{ basename($file) }}
                            {{-- "{{ $path . '/' . basename($file) }}" --}}
                        </a>
                        <form x-show="isEdit" x-cloak action="{{ route('file.explorer.rename') }}" method="POST"
                            class="flex items-center ml-4">
                            @csrf
                            <input type="hidden" name="path" value="{{ $path }}">
                            <input type="hidden" name="old_name" value="{{ basename($file) }}">
                            <input type="hidden" name="old_path" value="{{ $file }}">
                            <input type="text" name="new_name" placeholder="New name"
                                class="p-1 mr-2 border border-gray-300 rounded">
                            <button type="submit" class="p-1 text-white bg-yellow-500 rounded">Rename</button>
                        </form>
                        <form x-show="isEdit" x-cloak action="{{ route('file.explorer.delete') }}" onsubmit="return confirmDelete();" method="POST" class="ml-2">
                            @csrf
                            <input type="hidden" name="path" value="{{ $path }}">
                            <input type="hidden" name="name" value="{{ basename($file) }}">
                            <button type="submit" class="flex items-center justify-center">
                                <img src="{{ asset('assets/icons/delete.png') }}" class="h-8" alt="">
                                {{-- Delete --}}
                            </button>
                        </form>

                        <button @click="isEdit = !isEdit" type="submit" class="">
                            <img src="{{ asset('assets/icons/edit.png') }}" class="w-4 h-4 mx-2" alt="">
                        </button>
                    </li>
                @endforeach
            </ul>
        </div>

    </div>
    <script>
        function confirmDelete() {
            return confirm("Are you sure you want to delete this item?");
        }
    </script>

@endsection
