<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Garage;
use App\Models\GaragePost;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Image;

class GaragePostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search;
        if($search){
            $garageposts = GaragePost::where('name', 'LIKE', "%$search%")->paginate(10);
        }else {
            $garageposts = GaragePost::paginate(10);
        }
        return view('admin.garageposts.index', [
            'garageposts' => $garageposts,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $garages = Garage::all();
        $users = User::all();
        return view('admin.garageposts.create', compact('garages', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|max:255',
        'description' => 'nullable',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'garage_id' => 'nullable|exists:garages,id',
    ]);

    $garagepost = new GaragePost();
    $garagepost->name = $request->name;
    $garagepost->description = $request->description;

    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $fileName = time() . '_' . $image->getClientOriginalName();
        $imagePath = public_path('assets/images/garageposts/' . $fileName);
        $thumbPath = public_path('assets/images/garageposts/thumb/' . $fileName);

        try {
            // Create an image instance and save the original image
            $uploadedImage = Image::make($image->getRealPath())->save($imagePath);

            // Resize the image to 500px in width while maintaining aspect ratio, and save the thumbnail
            $uploadedImage->resize(500, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save($thumbPath);

            $garagepost->image = $fileName;
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Image processing failed: ' . $e->getMessage()]);
        }
    }

    $garagepost->garage_id = $request->garage_id;
    $garagepost->create_by_user_id = $request->user()->id;
    $garagepost->save();

    return redirect('/admin/garageposts')->with('status', 'Garage post created successfully');
}


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $garagepost = GaragePost::findOrFail($id);
        return view('admin.garageposts.show', compact('garagepost'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $garagepost = GaragePost::findOrFail($id);
        $garages = Garage::all();
        // $users = User::all();
        return view('admin.garageposts.edit', compact('garagepost', 'garages'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|max:255',
        'description' => 'nullable',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'garage_id' => 'nullable|exists:garages,id',
    ]);

    $garagepost = GaragePost::findOrFail($id);
    $garagepost->name = $request->name;
    $garagepost->description = $request->description;

    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $fileName = time() . '_' . $image->getClientOriginalName();
        $imagePath = public_path('assets/images/garageposts/' . $fileName);
        $thumbPath = public_path('assets/images/garageposts/thumb/' . $fileName);

        try {
            // Ensure directories exist
            if (!file_exists(public_path('assets/images/garageposts'))) {
                mkdir(public_path('assets/images/garageposts'), 0777, true);
            }
            if (!file_exists(public_path('assets/images/garageposts/thumb'))) {
                mkdir(public_path('assets/images/garageposts/thumb'), 0777, true);
            }

           // Create an image instance and save the original image
           $uploadedImage = Image::make($image->getRealPath())->save($imagePath);

           // Resize the image to 500px in width while maintaining aspect ratio, and save the thumbnail
           $uploadedImage->resize(500, null, function ($constraint) {
               $constraint->aspectRatio();
           })->save($thumbPath);

            // Store the filename in the model
            $garagepost->image = $fileName;
        } catch (Exception $e) {
            // Handle any errors that may occur during the image processing
            return redirect()->back()->withErrors(['error' => 'Image processing failed: ' . $e->getMessage()]);
        }
    }
    $garagepost->garage_id = $request->garage_id;
    $garagepost->update($request->only(['garage_id', 'create_by_user_id']));

    return redirect('/admin/garageposts')->with('status', 'Garage post updated successfully');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $garagepost = GaragePost::findOrFail($id);

        if ($garagepost->image) {
            @unlink(public_path('assets/images/garageposts/' . $garagepost->image));
            @unlink(public_path('assets/images/garageposts/thumb/' . $garagepost->image));
        }

        $garagepost->delete();

        return redirect('/admin/garageposts')->with('status', 'Garage post deleted successfully');
    }
}
