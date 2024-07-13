@extends('admin.layouts.admin')

@section('content')
    <div class="container p-6 mx-auto">
        <h1 class="mb-4 text-3xl font-bold">{{ $pdf->title }}</h1>
        <p class="mb-2 text-gray-700">{{ $pdf->description }}</p>
        <a href="{{ route('admin.pdfs.stream', $pdf->id) }}" class="px-4 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700">View PDF</a>
    </div>
@endsection
