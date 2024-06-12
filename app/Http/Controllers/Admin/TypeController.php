<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Type;
use Illuminate\Http\Request;
use Image;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $types = Type::paginate(10);
        // dd($types, $shopId);
        return view('admin.types.index', [
            'types' => $types,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.types.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request ,Type $type)
    {
        $request->validate([
            'name' => 'required|max:255',
            'name_kh' => 'required|max:255',
            'code' => 'required|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $type->name = $request->name;
        $type->name_kh = $request->name_kh;
        $type->code = $request->code;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $fileName = time() . '_' . $image->getClientOriginalName();
            $imagePath = public_path('assets/images/types/' . $fileName);
            $thumbPath = public_path('assets/images/types/thumb/' . $fileName);

            try {
                // Create an image instance and save the original image
                Image::make($image->getRealPath())->save($imagePath);

                // Resize the image to 500px in width while maintaining aspect ratio, and save the thumbnail
                Image::make($image->getRealPath())->fit(500, null)->save($thumbPath);

                // Store the filename in the category
                $type->image = $fileName;
            } catch (Exception $e) {
                // Handle any errors that may occur during the image processing
                return redirect()->back()->withErrors(['error' => 'Image processing failed: ' . $e->getMessage()]);
            }
        }

        $type->save();

        return redirect('/admin/types')->with('status', 'Add type Successful');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $types = Type::findOrFail($id); // Retrieve the brand with the given ID
        return view('admin.types.show', compact('types')); // Pass the brand object to the view
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $types = Type::findOrFail($id); // Retrieve the brand with the given ID
        return view('admin.types.edit', compact('types')); // Pass the brand object to the view
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'name_kh' => 'required|string|max:255',
            'code' => 'required|string|max:255',
            'image' => 'nullable|sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Find the product by ID
        $types = Type::findOrFail($id);

        // Get all input data
        $input = $request->all();

        // Handle image upload
        $image = $request->file('image');
        if (!empty($image)) {
            try {
                // Generate a unique filename with a timestamp
                $fileName = time() . '_' . $image->getClientOriginalName();

                // Define paths for the original image and the thumbnail
                $imagePath = public_path('assets/images/types/' . $fileName);
                $thumbPath = public_path('assets/images/types/thumb/' . $fileName);

                // Create an image instance and save the original image
                $uploadedImage = Image::make($image->getRealPath())->save($imagePath);

                // Resize the image to 500px in width while maintaining aspect ratio, and save the thumbnail
                $uploadedImage->resize(500, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($thumbPath);

                // Store the filename in the input array for further processing or saving in the database
                $input['image'] = $fileName;

                // Remove the old image files
                if ($types->image) {
                    @unlink(public_path('assets/images/types/' . $types->image));
                    @unlink(public_path('assets/images/types/thumb/' . $types->image));
                }
            } catch (Exception $e) {
                // Handle any errors that may occur during the image processing
                return response()->json(['error' => 'Image processing failed: ' . $e->getMessage()], 500);
            }
        }

        // Update the product with the new data
        $types->update($input);

        // Redirect back to the product list with a success message
        return redirect('/admin/types')->with('status', 'Type Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $type = Type::find($id);
        if (!$type) {
            return redirect()->back()->withErrors(['error' => 'Type not found']);
        }

        // Remove the image files
        @unlink(public_path('assets/images/types/' . $type->image));
        @unlink(public_path('assets/images/types/thumb/' . $type->image));

        // Delete the Types
        $type->delete();

        return redirect()->back()->with('status', 'Types deleted successfully');
    }
    
}
