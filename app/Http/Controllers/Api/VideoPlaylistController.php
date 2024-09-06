<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\VideoPlaylist;
use Illuminate\Http\Request;

class VideoPlaylistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search;
        if($search){
            $videoPlaylists = VideoPlaylist::where('name', 'LIKE', "%$search%")
                                ->with('teacher')->withCount('videos')
                                ->paginate(10);
        }else {
            $videoPlaylists = VideoPlaylist::with('teacher')->withCount('videos')
                                ->paginate(10);
        }
        return response()->json($videoPlaylists);
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
    public function show(string $id)
    {
        $category = VideoPlaylist::find($id);
        if (!$category) {
            return redirect()->back()->withErrors(['error' => 'Category not found']);
        }

        return response()->json($category);
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