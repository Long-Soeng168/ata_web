@extends('admin.layouts.admin')

@section('content')
<div class="max-w-4xl p-4 mx-auto rounded-lg">
    <div class="flex items-center justify-between">
        <h1 class="text-3xl font-bold text-gray-800">{{ $video->title }}</h1>
        <a href="{{ route('admin.videos.index') }}" class="font-bold text-blue-500 inline-blockfont-semibold hover:text-blue-700 hover:underline">
            &larr; Back
        </a>
    </div>

    <video controls class="w-full border border-gray-300 rounded-lg" controlsList="nodownload">
        <source src="{{ route('admin.videos.stream',['video'=>$video->id, 'path' => 'original']) }}">
    </video>


</div>

@endsection

{{-- @extends('admin.layouts.admin')

@section('content')
    <h1>{{ $video->title }}</h1>
    <video controls>
        <source src="{{ asset('storage/videos' . $video->path_360p) }}" label="360p" type="video/mp4">
        <source src="{{ asset('storage/videos' . $video->path_480p) }}" label="480p" type="video/mp4">
        <source src="{{ asset('storage/videos' . $video->path_720p) }}" label="720p" type="video/mp4">
        <source src="{{ asset('storage/videos' . $video->path_1080p) }}" label="1080p" type="video/mp4">
    </video>
    <a href="{{ route('admin.videos.index') }}">Back to Videos</a>
@endsection --}}

{{-- @extends('admin.layouts.admin')

@section('content')
    <h1>{{ $video->title }}</h1>
    <video controls>
        <source src="{{ Storage::disk('storage')->url($video->path_360p) }}" label="360p" type="video/mp4">
        <source src="{{ Storage::disk('storage')->url($video->path_480p) }}" label="480p" type="video/mp4">
        <source src="{{ Storage::disk('storage')->url($video->path_720p) }}" label="720p" type="video/mp4">
        <source src="{{ Storage::disk('storage')->url($video->path_1080p) }}" label="1080p" type="video/mp4">
    </video>
    <a href="{{ route('admin.videos.index') }}">Back to Videos</a>
@endsection --}}

{{-- @extends('admin.layouts.admin')

@section('content')
    @if ($video)
        <div>
            <h1>{{ $video->title }}</h1>
            <video controls>
                <source src="{{ Storage::disk('public')->url($video->original_path) }}" label="Original" type="video/mp4">
                <source src="{{ Storage::disk('public')->url($video->path_360p) }}" label="360p" type="video/mp4">
                <source src="{{ Storage::disk('public')->url($video->path_480p) }}" label="480p" type="video/mp4">
                <source src="{{ Storage::disk('public')->url($video->path_720p) }}" label="720p" type="video/mp4">
                <source src="{{ Storage::disk('public')->url($video->path_1080p) }}" label="1080p" type="video/mp4">
            </video>
            <a href="{{ route('admin.videos.index') }}">Back to Videos</a>
        </div>
    @else
        <p>No video found.</p>
    @endif
@endsection --}}


