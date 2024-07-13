@extends('admin.layouts.admin')

@section('content')
    <div class="container p-6 mx-auto">
        @include('admin.components.success')
        <h1 class="mb-6 text-3xl font-bold">PDFs</h1>
        <a href="{{ route('admin.pdfs.create') }}" class="inline-block px-4 py-2 mb-6 font-bold text-white bg-blue-500 rounded hover:bg-blue-700">Upload New PDF</a>
        <form class="mb-6">
            <div class="flex">
                <input type="text" name="search" placeholder="Search PDFs" class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline">
                <button type="submit" class="px-4 py-2 ml-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700">Search</button>
            </div>
        </form>
        <table class="min-w-full bg-white border">
            <thead>
                <tr>
                    <th class="px-4 py-2 border-b">Title</th>
                    <th class="px-4 py-2 border-b">Description</th>
                    <th class="px-4 py-2 border-b">Status</th>
                    <th class="px-4 py-2 border-b">Category</th>
                    <th class="px-4 py-2 border-b">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pdfs as $pdf)
                    <tr class="hover:bg-gray-100">
                        <td class="px-4 py-2 border-b">{{ $pdf->title }}</td>
                        <td class="px-4 py-2 border-b">{{ $pdf->description }}</td>
                        <td class="px-4 py-2 border-b">{{ $pdf->status }}</td>
                        <td class="px-4 py-2 border-b">{{ $pdf->category?->name }}</td>
                        <td class="px-4 py-2 border-b">
                            <a href="{{ route('admin.pdfs.show', $pdf->id) }}" class="text-blue-500 hover:text-blue-700">View</a>
                            <a href="{{ route('admin.pdfs.edit', $pdf->id) }}" class="ml-4 text-yellow-500 hover:text-yellow-700">Edit</a>
                            <form action="{{ route('admin.pdfs.destroy', $pdf->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="ml-4 text-red-500 hover:text-red-700">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-6">
            {{ $pdfs->links() }}
        </div>
    </div>
@endsection
