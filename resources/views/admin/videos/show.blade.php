@extends('admin.layouts.admin')

@section('content')
    <h1>{{ $video->title }}</h1>
    <video controls>
        <source src="{{ route('admin.videos.stream', ['video' => $video, 'quality' => '360p']) }}" label="360p">
        <source src="{{ route('admin.videos.stream', ['video' => $video, 'quality' => '480p']) }}" label="480p">
        <source src="{{ route('admin.videos.stream', ['video' => $video, 'quality' => '720p']) }}" label="720p">
        <source src="{{ route('admin.videos.stream', ['video' => $video, 'quality' => '1080p']) }}" label="1080p">
    </video>
    <a href="{{ route('admin.videos.index') }}">Back to Videos</a>
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


