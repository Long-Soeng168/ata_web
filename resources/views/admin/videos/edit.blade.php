@extends('admin.layouts.admin')

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <h1>Edit Video</h1>
    <form action="{{ route('admin.videos.update', ['video' => $video->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <label for="title">Title:</label>
        <input type="text" name="title" value="{{ $video->title }}" required>
        <label for="description">Description:</label>
        <textarea name="description">{{ $video->description }}</textarea>
        <label for="status">Status:</label>
        <select name="status" required>
            <option value="free" {{ $video->status === 'free' ? 'selected' : '' }}>Free</option>
            <option value="price" {{ $video->status === 'price' ? 'selected' : '' }}>Price</option>
        </select>
        <button type="submit">Update</button>
    </form>
@endsection
