@extends('admin.layouts.admin')

@section('content')
    <div class="container p-6 mx-auto">
        <h1 class="mb-6 text-3xl font-bold">Upload New PDF</h1>
        <form action="{{ route('admin.pdfs.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div>
                <label for="title" class="block mb-2 font-bold text-gray-700">Title:</label>
                <input type="text" name="title" id="title" required class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline">
            </div>
            <div>
                <label for="pdf" class="block mb-2 font-bold text-gray-700">PDF File:</label>
                <input type="file" name="pdf" id="pdf" accept="application/pdf" required class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline">
            </div>
            <button type="submit" class="px-4 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700">Upload</button>
        </form>
    </div>
@endsection
