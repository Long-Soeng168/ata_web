@extends('admin.layouts.admin')

@section('content')
    <div class="container p-6 mx-auto">
        <h1 class="mb-6 text-3xl font-bold">Edit PDF</h1>
        <form action="{{ route('admin.pdfs.update', $pdf->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label for="title" class="block mb-2 font-bold text-gray-700">Title:</label>
                <input type="text" name="title" id="title" value="{{ $pdf->title }}" required class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline">
            </div>
            <div>
                <label for="pdf" class="block mb-2 font-bold text-gray-700">PDF File (optional):</label>
                <input type="file" name="pdf" id="pdf" class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline">
            </div>
            <div>
                <label for="description" class="block mb-2 font-bold text-gray-700">Description:</label>
                <textarea name="description" id="description" class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline">{{ $pdf->description }}</textarea>
            </div>
            <div>
                <label for="status" class="block mb-2 font-bold text-gray-700">Status:</label>
                <select name="status" id="status" class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline">
                    <option value="free" {{ $pdf->status == 'free' ? 'selected' : '' }}>Free</option>
                    <option value="price" {{ $pdf->status == 'price' ? 'selected' : '' }}>Price</option>
                </select>
            </div>
            <div>
                <label for="category_id" class="block mb-2 font-bold text-gray-700">Category:</label>
                <select name="category_id" id="category_id" class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline">
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ $pdf->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="px-4 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700">Update</button>
        </form>
    </div>
@endsection
