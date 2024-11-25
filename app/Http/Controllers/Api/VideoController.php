<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Video;
use App\Models\VideoPlaylistUser;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Retrieve request parameters with defaults
        $search = $request->input('search', '');
        $playlistId = $request->input('playlistId');
        $sortBy = $request->input('sortBy', 'title'); // Default sort by 'id'
        $sortOrder = $request->input('sortOrder', 'asc'); // Default order 'asc'
        $perPage = $request->input('perPage', 50); // Default 50 items per page

        // Start building the query
        $query = Video::query();

        // Apply search filter
        if (!empty($search)) {
            $query->where('title', 'LIKE', "%{$search}%");
        }

        // Apply playlist filter
        if (!empty($playlistId)) {
            $query->where('playlist_id', $playlistId);
        }

        // Apply sorting
        $query->orderBy($sortBy, $sortOrder);

        // Paginate the results
        $videos = $query->paginate($perPage);

        // Return JSON response
        return response()->json($videos);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Video $video)
    {
        $video->update([
            'views_count' => $video->views_count + 1
        ]);
        return response()->json($video);
    }

    public function getVideosByCategory($id) {
        $videos = Video::where("category_id", $id)->paginate(10);
        return response()->json($videos);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
