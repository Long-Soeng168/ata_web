<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Video;
use App\Models\VideoCategory;
use FFMpeg\FFMpeg;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use FFMpeg\Coordinate\Dimension;

class VideoController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        if($search){
            $videos = Video::where('title', 'LIKE', "%$search%")->paginate(10);
        }else {
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
        $request->validate([
            'title' => 'required',
            'video' => 'required|mimes:mp4,avi,mov|max:20000',
            'description' => 'nullable',
            'status' => 'required|in:free,price',
            'category_id' => 'required',
        ]);

        $file = $request->file('video');
        $originalPath = $file->store('videos/original', 'public');
        // dd($request->file('video'));
        // Transcode video to different qualities
        try {
            $path360p = $this->transcodeVideo($originalPath, '360p', 640, 360);
            $path480p = $this->transcodeVideo($originalPath, '480p', 854, 480);
            $path720p = $this->transcodeVideo($originalPath, '720p', 1280, 720);
            $path1080p = $this->transcodeVideo($originalPath, '1080p', 1920, 1080);
        } catch (\Exception $e) {
            // Handle transcoding error
            return redirect()->back()->with('error', 'Failed to transcode video.');
        }

        // Save video info to database
        $video = Video::create([
            'title' => $request->title,
            'description' => $request->description,
            'original_path' => $originalPath,
            'path_360p' => $path360p,
            'path_480p' => $path480p,
            'path_720p' => $path720p,
            'path_1080p' => $path1080p,
            'status' => $request->status,
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('admin.videos.index')->with('success', 'Video uploaded and transcoded successfully.');
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
        $originalPath = $file->store('videos/original', 'public');

        // Transcode video to different qualities
        try {
            $path360p = $this->transcodeVideo($originalPath, '360p', 640, 360);
            $path480p = $this->transcodeVideo($originalPath, '480p', 854, 480);
            $path720p = $this->transcodeVideo($originalPath, '720p', 1280, 720);
            $path1080p = $this->transcodeVideo($originalPath, '1080p', 1920, 1080);

            // Update paths in the video model
            $video->original_path = $originalPath;
            $video->path_360p = $path360p;
            $video->path_480p = $path480p;
            $video->path_720p = $path720p;
            $video->path_1080p = $path1080p;
        } catch (\Exception $e) {
            // Handle transcoding error
            return redirect()->back()->with('error', 'Failed to transcode video: ' . $e->getMessage());
        }
    }

    // Save the updated video record
    $video->save();

    return redirect()->route('admin.videos.index')->with('success', 'Video updated successfully.');
}

    public function destroy(Video $video)
    {
        // Delete video files from storage
        try {
            Storage::disk('public')->delete([
                'videos/original/' . basename($video->original_path),
                'videos/360p/' . basename($video->path_360p),
                'videos/480p/' . basename($video->path_480p),
                'videos/720p/' . basename($video->path_720p),
                'videos/1080p/' . basename($video->path_1080p),
            ]);
        } catch (\Exception $e) {
            // Handle file deletion error
            return redirect()->back()->with('error', 'Failed to delete video files.');
        }

        $video->delete();

        return redirect()->route('admin.videos.index')->with('success', 'Video deleted successfully.');
    }

    public function stream(Video $video, $quality)
    {
        // Ensure that only authorized users can access the stream
        if (!auth()->check()) {
            abort(403);
        }

        $filePath = '';

        switch ($quality) {
            case '360p':
                $filePath = storage_path('app/public/' . $video->path_360p);
                break;
            case '480p':
                $filePath = storage_path('app/public/' . $video->path_480p);
                break;
            case '720p':
                $filePath = storage_path('app/public/' . $video->path_720p);
                break;
            case '1080p':
                $filePath = storage_path('app/public/' . $video->path_1080p);
                break;
            default:
                abort(404); // Invalid quality
        }

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

    private function transcodeVideo($originalPath, $quality, $width, $height)
    {
        $outputPath = 'videos/' . $quality . '/' . basename($originalPath);
        $outputDirectory = dirname(storage_path('app/public/' . $outputPath));

        if (!file_exists($outputDirectory)) {
            // Create the directory if it doesn't exist
            mkdir($outputDirectory, 0777, true);
        }

        $ffmpeg = FFMpeg::create();
        $video = $ffmpeg->open(storage_path('app/public/' . $originalPath));

        $video->filters()
            ->resize(new Dimension($width, $height))
            ->synchronize();

        $format = new \FFMpeg\Format\Video\X264();
        $format->setAudioCodec("libmp3lame");

        $video->save($format, storage_path('app/public/' . $outputPath));

        return $outputPath;
    }
}
