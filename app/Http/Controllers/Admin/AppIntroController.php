<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppIntro;
use Illuminate\Http\Request;
use Image;

class AppIntroController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search;
        if($search){
            $appintros = AppIntro::where('name', 'LIKE', "%$search%")->paginate(10);
        }else {
            $appintros = AppIntro::paginate(10);
        }
        return view('admin.appintros.index', [
            'appintros' => $appintros,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.appintros.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, AppIntro $appIntro)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $appIntro->name = $request->name;
        $appIntro->description = $request->description;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $fileName = time() . '_' . $image->getClientOriginalName();
            $imagePath = public_path('assets/images/appintros/' . $fileName);
            $thumbPath = public_path('assets/images/appintros/thumb/' . $fileName);

            try {
                // Create an image instance and save the original image
                Image::make($image->getRealPath())->save($imagePath);

                // Resize the image to 500px in width while maintaining aspect ratio, and save the thumbnail
                Image::make($image->getRealPath())->fit(500, null)->save($thumbPath);

                // Store the filename in the category
                $appIntro->image = $fileName;
            } catch (Exception $e) {
                // Handle any errors that may occur during the image processing
                return redirect()->back()->withErrors(['error' => 'Image processing failed: ' . $e->getMessage()]);
            }
        }

        $appIntro->save();

        return redirect('/admin/appintros')->with('status', 'Add App Intro Successful');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $appIntro = AppIntro::findOrFail($id); // Retrieve the appIntro with the given ID
        return view('admin.appintros.show', compact('appIntro')); // Pass the appIntro object to the view
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $appIntro = AppIntro::findOrFail($id); // Retrieve the appIntro with the given ID
        return view('admin.appintros.edit', compact('appIntro')); // Pass the appIntro object to the view
    }

    /**
     * Update the specified resource in storage.
     */
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable',
            'image' => 'nullable|sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Find the product by ID
        $appIntros = AppIntro::findOrFail($id);

        // Get all input data
        $input = $request->all();

        // Handle image upload
        $image = $request->file('image');
        if (!empty($image)) {
            try {
                // Generate a unique filename with a timestamp
                $fileName = time() . '_' . $image->getClientOriginalName();

                // Define paths for the original image and the thumbnail
                $imagePath = public_path('assets/images/appintros/' . $fileName);
                $thumbPath = public_path('assets/images/appintros/thumb/' . $fileName);

                // Create an image instance and save the original image
                $uploadedImage = Image::make($image->getRealPath())->save($imagePath);

                // Resize the image to 500px in width while maintaining aspect ratio, and save the thumbnail
                $uploadedImage->resize(500, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($thumbPath);

                // Store the filename in the input array for further processing or saving in the database
                $input['image'] = $fileName;

                // Remove the old image files
                if ($appIntros->image) {
                    @unlink(public_path('assets/images/appintros/' . $appIntros->image));
                    @unlink(public_path('assets/images/appintros/thumb/' . $appIntros->image));
                }
            } catch (Exception $e) {
                // Handle any errors that may occur during the image processing
                return response()->json(['error' => 'Image processing failed: ' . $e->getMessage()], 500);
            }
        }

        // Update the product with the new data
        $appIntros->update($input);



        // Redirect back to the product list with a success message
        return redirect('/admin/appintros')->with('status', 'Updated Successfully');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $appintro = AppIntro::find($id);
        if (!$appintro) {
            return redirect()->back()->withErrors(['error' => 'App Intro not found']);
        }

        // Remove the image files
        @unlink(public_path('assets/images/appintros/' . $appintro->image));
        @unlink(public_path('assets/images/appintros/thumb/' . $appintro->image));

        // Delete the category
        $appintro->delete();

        return redirect()->back()->with('status', 'Deleted successfully');
    }

}
