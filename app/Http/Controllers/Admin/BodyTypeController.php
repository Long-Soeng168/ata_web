<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BodyType;
use Illuminate\Http\Request;
use Image;

class BodyTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search;
        if($search){
            $bodytypes =BodyType::where('name', 'LIKE', "%$search%")->paginate(10);
        }else {
            $bodytypes =BodyType::paginate(10);
        }
        
        // dd($bodytypes, $shopId);
        return view('admin.bodytypes.index', [
            'bodytypes' => $bodytypes,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.bodytypes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, BodyType $bodyType)
    {
        $request->validate([
            'name' => 'required|max:255',
            'name_kh' => 'required|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $bodyType->name = $request->name;
        $bodyType->name_kh = $request->name_kh;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $fileName = time() . '_' . $image->getClientOriginalName();
            $imagePath = public_path('assets/images/body_types/' . $fileName);
            $thumbPath = public_path('assets/images/body_types/thumb/' . $fileName);

            try {
                // Create an image instance and save the original image
                Image::make($image->getRealPath())->save($imagePath);

                // Resize the image to 500px in width while maintaining aspect ratio, and save the thumbnail
                Image::make($image->getRealPath())->fit(500, null)->save($thumbPath);

                // Store the filename in the category
                $bodyType->image = $fileName;
            } catch (Exception $e) {
                // Handle any errors that may occur during the image processing
                return redirect()->back()->withErrors(['error' => 'Image processing failed: ' . $e->getMessage()]);
            }
        }

        $bodyType->save();

        return redirect('/admin/bodytypes')->with('status', 'Add type Successful');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $bodyType = BodyType::findOrFail($id); // Retrieve the BodyType with the given ID
        return view('admin.bodytypes.show', compact('bodyType')); // Pass the BodyType object to the view
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $bodyType = BodyType::findOrFail($id); // Retrieve the BodyType with the given ID
        return view('admin.bodytypes.edit', compact('bodyType')); // Pass the BodyType object to the view
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
            'name_kh' => 'required|string|max:255',
            'image' => 'nullable|sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Find the product by ID
        $bodyTypes = BodyType::findOrFail($id);

        // Get all input data
        $input = $request->all();

        // Handle image upload
        $image = $request->file('image');
        if (!empty($image)) {
            try {
                // Generate a unique filename with a timestamp
                $fileName = time() . '_' . $image->getClientOriginalName();

                // Define paths for the original image and the thumbnail
                $imagePath = public_path('assets/images/body_types/' . $fileName);
                $thumbPath = public_path('assets/images/body_types/thumb/' . $fileName);

                // Create an image instance and save the original image
                $uploadedImage = Image::make($image->getRealPath())->save($imagePath);

                // Resize the image to 500px in width while maintaining aspect ratio, and save the thumbnail
                $uploadedImage->resize(500, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($thumbPath);

                // Store the filename in the input array for further processing or saving in the database
                $input['image'] = $fileName;

                // Remove the old image files
                if ($bodyTypes->image) {
                    @unlink(public_path('assets/images/body_types/' . $bodyTypes->image));
                    @unlink(public_path('assets/images/body_types/thumb/' . $bodyTypes->image));
                }
            } catch (Exception $e) {
                // Handle any errors that may occur during the image processing
                return response()->json(['error' => 'Image processing failed: ' . $e->getMessage()], 500);
            }
        }

        // Update the product with the new data
        $bodyTypes->update($input);



        // Redirect back to the product list with a success message
        return redirect('/admin/bodytypes')->with('status', 'Body Type Updated Successfully');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $type = BodyType::find($id);
        if (!$type) {
            return redirect()->back()->withErrors(['error' => 'Category not found']);
        }

        // Remove the image files
        @unlink(public_path('assets/images/body_types/' . $type->image));
        @unlink(public_path('assets/images/body_types/thumb/' . $type->image));

        // Delete the category
        $type->delete();

        return redirect()->back()->with('status', 'Category deleted successfully');
    }
}
