<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Garage;
use App\Models\User;
use Illuminate\Http\Request;
use Image;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;

class GarageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $garages = Garage::all();
        return view('admin.garages.index', compact('garages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        return view('admin.garages.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            // 'user_id' => 'required|exists:users,id',
            'like' => 'integer',
            'unlike' => 'integer',
            'rate' => 'integer',
            'comment' => 'nullable|string',
            'logo' => 'nullable|sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
            'banner' => 'nullable|sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
            'bio' => 'nullable|string',
        ]);

        $input = $request->all();

        // Ensure the directories exist
        $logoPath = public_path('assets/images/garages/logo/');
        $thumbPath = public_path('assets/images/garages/thumb/');

        if (!File::exists($logoPath)) {
            File::makeDirectory($logoPath, 0755, true);
        }

        if (!File::exists($thumbPath)) {
            File::makeDirectory($thumbPath, 0755, true);
        }

        // Handle logo upload
        if ($request->hasFile('logo')) {
            $input['logo'] = $this->processImage($request->file('logo'), 'logo');
        }

        // Handle banner upload
        if ($request->hasFile('banner')) {
            $input['banner'] = $this->processImage($request->file('banner'), 'banner');
        }

        // Add the authenticated user's ID
        $input['user_id'] = $request->user()->id;

        // Create the garage
        $garage = Garage::create($input);

        return redirect()->route('admin.garages.index')->with('success', 'Garage created successfully.');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $garage = Garage::find($id);
        // $users = User::all();
        return view('admin.garages.show', compact('garage',));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // $users = User::all();
        $garage = Garage::findOrFail($id);
        return view('admin.garages.edit', compact('garage',));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'like' => 'integer',
            'unlike' => 'integer',
            'rate' => 'integer',
            'comment' => 'nullable|string',
            'logo' => 'nullable|sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
            'banner' => 'nullable|sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
            'bio' => 'nullable|string',
        ]);

        $garage = Garage::findOrFail($id);
        $input = $request->all();

        // Handle logo upload
        if ($request->hasFile('logo')) {
            $input['logo'] = $this->processImage($request->file('logo'), 'logo');
        }

        // Handle banner upload
        if ($request->hasFile('banner')) {
            $input['banner'] = $this->processImage($request->file('banner'), 'banner');
        }

        $garage->update($input);

        return redirect()->route('admin.garages.index')->with('success', 'Garage updated successfully.');
    }


    private function processImage($image, $type)
    {
        $fileName = time() . '_' . $image->getClientOriginalName();

        $imagePath = public_path('assets/images/garages/' . $type . '/' . $fileName);
        $thumbPath = public_path('assets/images/garages/thumb/' . $type . '/' . $fileName);

        $uploadedImage = Image::make($image->getRealPath())->save($imagePath);
        $uploadedImage->resize(500, null, function ($constraint) {
            $constraint->aspectRatio();
        })->save($thumbPath);

        return $fileName;
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $garage = Garage::findOrFail($id);

        // Paths to image directories
        $logoPath = public_path('assets/images/garages/logo/');
        $bannerPath = public_path('assets/images/garages/banner/');
        $thumbPath = public_path('assets/images/garages/thumb/');

        // Delete logo image if it exists
        if ($garage->logo) {
            $logoFilePath = $logoPath . $garage->logo;
            $logoThumbPath = $thumbPath . $garage->logo;

            if (file_exists($logoFilePath)) {
                unlink($logoFilePath);
            }

            if (file_exists($logoThumbPath)) {
                unlink($logoThumbPath);
            }
        }

        // Delete banner image if it exists
        if ($garage->banner) {
            $bannerFilePath = $bannerPath . $garage->banner;
            $bannerThumbPath = $thumbPath . $garage->banner;

            if (file_exists($bannerFilePath)) {
                unlink($bannerFilePath);
            }

            if (file_exists($bannerThumbPath)) {
                unlink($bannerThumbPath);
            }
        }

        // Delete the garage record
        $garage->delete();

        return redirect()->route('admin.garages.index')->with('success', 'Garage deleted successfully.');
    }
}
