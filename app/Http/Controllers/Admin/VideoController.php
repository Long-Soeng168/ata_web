<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Video;
use App\Models\VideoCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        if ($search) {
            $videos = Video::where('title', 'LIKE', "%$search%")->paginate(10);
        } else {
            $videos = Video::paginate(10);
        }
        return view('admin.videos.index', compact('videos'));
    }

    public function create()
    {
        $category = VideoCategory::all();
        return view('admin.videos.create', compact('category'));
    }

    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'title' => 'required',
            'video' => 'required|mimes:mp4,avi,mov|max:20000',
            'description' => 'nullable',
            'status' => 'required|in:free,price',
            'category_id' => 'required',
        ]);

        // Handle the video file upload
        $file = $request->file('video');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $destinationPath = storage_path('videos/original');
        $file->move($destinationPath, $fileName);
        $video_name = $fileName;

        // Save the video information to the database
        Video::create([
            'title' => $request->title,
            'description' => $request->description,
            'video_name' => $video_name,
            'status' => $request->status,
            'category_id' => $request->category_id,
        ]);

        // Redirect with success message
        return redirect()->route('admin.videos.index')->with('success', 'Video uploaded successfully.');
    }

    public function show(Video $video)
    {
        return view('admin.videos.show', compact('video'));
    }

    public function edit(Video $video)
    {
        $categories = VideoCategory::all();
        return view('admin.videos.edit', compact('video', 'categories'));
    }

    public function update(Request $request, Video $video)
    {
        $request->validate([
            'title' => 'required',
            'video' => 'nullable|mimes:mp4,avi,mov|max:20000', // Allow null to skip file update
            'description' => 'nullable',
            'status' => 'required|in:free,price',
            'category_id' => 'required',
        ]);

        // Update the video fields
        $video->title = $request->title;
        $video->description = $request->description;
        $video->status = $request->status;
        $video->category_id = $request->category_id;

        // Check if a new video file is uploaded
        if ($request->hasFile('video')) {
            $file = $request->file('video');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $destinationPath = storage_path('videos/original');
            $file->move($destinationPath, $fileName);
            $video_name = $fileName;

            // Update the path in the video model
            $video->video_name = $video_name;
        }

        // Save the updated video record
        $video->save();

        return redirect()->route('admin.videos.index')->with('success', 'Video updated successfully.');
    }

    public function destroy(Video $video)
    {
        // Delete video file from storage
        try {
            Storage::delete(storage_path('video/original/'.$video->video_name));
        } catch (\Exception $e) {
            // Handle file deletion error
            return redirect()->back()->with('error', 'Failed to delete video file.');
        }

        $video->delete();

        return redirect()->route('admin.videos.index')->with('success', 'Video deleted successfully.');
    }

    public function stream(Video $video, $path)
    {

        // Ensure that only authorized users can access the stream
        if (!auth()->check()) {
            abort(403);
        }

        $filePath = storage_path('videos/'. $path. '/'. $video->video_name);

        // return $filePath;
        if (!file_exists($filePath)) {
            abort(404); // File not found
        }

        $stream = new \Symfony\Component\HttpFoundation\StreamedResponse(function () use ($filePath) {
            $stream = fopen($filePath, 'r');
            fpassthru($stream);
            fclose($stream);
        });

        $stream->headers->set('Content-Type', 'video/mp4');
        $stream->headers->set('Content-Length', filesize($filePath));

        return $stream;
    }
}
