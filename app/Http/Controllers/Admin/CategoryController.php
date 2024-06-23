<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image; // Import Image class

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search;
        if($search){
            $categories = Category::where('name', 'LIKE', "%$search%")->paginate(10);
        }else {
            $categories = Category::paginate(10);
        }
        return view('admin.categories.index', [
            'categories' => $categories,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'name' => 'required|max:255',
            'name_kh' => 'required|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Ensure image validation
        ]);

        // Create the category
        $category = new Category([
            'shop_id' => $request->user()->shop_id,
            'create_by_user_id' => $request->user()->id,
            'name' => $request->name,
            'name_kh' => $request->name_kh,
            'code' => $request->code,
        ]);

        // Handle the image upload and processing
        $image = $request->file('image');
        if ($image) {
            try {
                // Generate a unique filename
                $fileName = time() . '_' . $image->getClientOriginalName();

                // Define paths for the original image and the thumbnail
                $imagePath = public_path('assets/images/categories/' . $fileName);
                $thumbPath = public_path('assets/images/categories/thumb/' . $fileName);

                // Create an image instance and save the original image
                Image::make($image->getRealPath())->save($imagePath);

                // Resize the image to 500px in width while maintaining aspect ratio, and save the thumbnail
                Image::make($image->getRealPath())->fit(500, null)->save($thumbPath);

                // Store the filename in the category
                $category->image = $fileName;
            } catch (Exception $e) {
                // Handle any errors that may occur during the image processing
                return redirect()->back()->withErrors(['error' => 'Image processing failed: ' . $e->getMessage()]);
            }
        }

        // Save the category
        $category->save();

        return redirect('/admin/categories')->with('status', 'Category added successfully');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Category::find($id);
        if (!$category) {
            return redirect()->back()->withErrors(['error' => 'Category not found']);
        }

        return view('admin.categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = Category::find($id);
        if (!$category) {
            return redirect()->back()->withErrors(['error' => 'Category not found']);
        }

        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        // Validate the incoming request
        $request->validate([
            'name' => 'required|max:255',
            'name_kh' => 'required|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Image is optional on update
        ]);

        // Update category fields
        $category->name = $request->name;
        $category->name_kh = $request->name_kh;
        $category->code = $request->code;
        // $category->update_by_user_id = $request->user()->id;

        // Handle the image upload and processing
        $image = $request->file('image');
        if ($image) {
            try {
                // Generate a unique filename
                $fileName = time() . '_' . $image->getClientOriginalName();

                // Define paths for the original image and the thumbnail
                $imagePath = public_path('assets/images/categories/' . $fileName);
                $thumbPath = public_path('assets/images/categories/thumb/' . $fileName);

                // Create an image instance and save the original image
                Image::make($image->getRealPath())->save($imagePath);

                // Resize the image to 500px in width while maintaining aspect ratio, and save the thumbnail
                Image::make($image->getRealPath())->fit(500, null)->save($thumbPath);

                // Store the filename in the category
                $category->image = $fileName;

                // Remove the old image files
                if ($category->getOriginal('image')) {
                    @unlink(public_path('assets/images/categories/' . $category->getOriginal('image')));
                    @unlink(public_path('assets/images/categories/thumb/' . $category->getOriginal('image')));
                }
            } catch (Exception $e) {
                // Handle any errors that may occur during the image processing
                return redirect()->back()->withErrors(['error' => 'Image processing failed: ' . $e->getMessage()]);
            }
        }

        // Save the updated category
        $category->save();

        return redirect('/admin/categories')->with('status', 'Category updated successfully');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::find($id);
        if (!$category) {
            return redirect()->back()->withErrors(['error' => 'Category not found']);
        }

        // Remove the image files
        @unlink(public_path('assets/images/categories/' . $category->image));
        @unlink(public_path('assets/images/categories/thumb/' . $category->image));

        // Delete the category
        $category->delete();

        return redirect()->back()->with('status', 'Category deleted successfully');
    }
}
