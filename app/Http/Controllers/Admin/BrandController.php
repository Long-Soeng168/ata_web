<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Image;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search;
        if($search){
            $brands = Brand::where('name', 'LIKE', "%$search%")->paginate(10);
        }else {
            $brands = Brand::paginate(10);
        }
        // dd($brands, $shopId);
        return view('admin.brands.index', [
            'brands' => $brands,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.brands.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Brand $brand)
    {
        $request->validate([
            'name' => 'required|max:255',
            'name_kh' => 'required|max:255',
            'code' => 'required|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $brand->name = $request->name;
        $brand->name_kh = $request->name_kh;
        $brand->code = $request->code;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $fileName = time() . '_' . $image->getClientOriginalName();
            $imagePath = public_path('assets/images/brands/' . $fileName);
            $thumbPath = public_path('assets/images/brands/thumb/' . $fileName);

            try {
                // Create an image instance and save the original image
               $uploadedImage = Image::make($image->getRealPath())->save($imagePath);

               // Resize the image to 500px in width while maintaining aspect ratio, and save the thumbnail
               $uploadedImage->resize(500, null, function ($constraint) {
                   $constraint->aspectRatio();
               })->save($thumbPath);

                // Store the filename in the category
                $brand->image = $fileName;
            } catch (Exception $e) {
                // Handle any errors that may occur during the image processing
                return redirect()->back()->withErrors(['error' => 'Image processing failed: ' . $e->getMessage()]);
            }
        }

        $brand->save();

        return redirect('/admin/brands')->with('status', 'Add type Successful');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $brands = Brand::findOrFail($id); // Retrieve the brand with the given ID
        return view('admin.brands.show', compact('brands')); // Pass the brand object to the view
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $brands = Brand::findOrFail($id); // Retrieve the brand with the given ID
        return view('admin.brands.edit', compact('brands')); // Pass the brand object to the view
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
            'code' => 'required|string|max:255',
            'image' => 'nullable|sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Find the product by ID
        $brands = Brand::findOrFail($id);

        // Get all input data
        $input = $request->all();

        // Handle image upload
        $image = $request->file('image');
        if (!empty($image)) {
            try {
                // Generate a unique filename with a timestamp
                $fileName = time() . '_' . $image->getClientOriginalName();

                // Define paths for the original image and the thumbnail
                $imagePath = public_path('assets/images/brands/' . $fileName);
                $thumbPath = public_path('assets/images/brands/thumb/' . $fileName);

                // Create an image instance and save the original image
                $uploadedImage = Image::make($image->getRealPath())->save($imagePath);

                // Resize the image to 500px in width while maintaining aspect ratio, and save the thumbnail
                $uploadedImage->resize(500, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($thumbPath);

                // Store the filename in the input array for further processing or saving in the database
                $input['image'] = $fileName;

                // Remove the old image files
                if ($brands->image) {
                    @unlink(public_path('assets/images/brands/' . $brands->image));
                    @unlink(public_path('assets/images/brands/thumb/' . $brands->image));
                }
            } catch (Exception $e) {
                // Handle any errors that may occur during the image processing
                return response()->json(['error' => 'Image processing failed: ' . $e->getMessage()], 500);
            }
        }

        // Update the product with the new data
        $brands->update($input);



        // Redirect back to the product list with a success message
        return redirect('/admin/brands')->with('status', 'Body Type Updated Successfully');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $type = Brand::find($id);
        if (!$type) {
            return redirect()->back()->withErrors(['error' => 'Category not found']);
        }

        // Remove the image files
        @unlink(public_path('assets/images/brands/' . $type->image));
        @unlink(public_path('assets/images/brands/thumb/' . $type->image));

        // Delete the category
        $type->delete();

        return redirect()->back()->with('status', 'Category deleted successfully');
    }
}
