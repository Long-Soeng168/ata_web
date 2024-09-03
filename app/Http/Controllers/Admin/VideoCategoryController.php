<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VideoCategory;
use Exception;
use Illuminate\Http\Request;
use Image;

class VideoCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search;
        if($search){
            $video_categories = VideoCategory::where('name', 'LIKE', "%$search%")->paginate(10);
        }else {
            $video_categories = VideoCategory::paginate(10);
        }
        return view('admin.video_categories.index', [
            'video_categories' => $video_categories,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.video_categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'required|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Ensure image validation
        ]);

        // Create the category
        $category = new VideoCategory([
            // 'category_id' => $request->videocategory()->category_id,
            'name' => $request->name,
            'description' => $request->description,
        ]);

        // Handle the image upload and processing
        $image = $request->file('image');
        if ($image) {
            try {
                // Generate a unique filename
                $fileName = time() . '_' . $image->getClientOriginalName();

                // Define paths for the original image and the thumbnail
                $imagePath = public_path('assets/images/video_categories/' . $fileName);
                $thumbPath = public_path('assets/images/video_categories/thumb/' . $fileName);

                // Create an image instance and save the original image
               $uploadedImage = Image::make($image->getRealPath())->save($imagePath);

               // Resize the image to 500px in width while maintaining aspect ratio, and save the thumbnail
               $uploadedImage->resize(500, null, function ($constraint) {
                   $constraint->aspectRatio();
               })->save($thumbPath);

                // Store the filename in the category
                $category->image = $fileName;
            } catch (Exception $e) {
                // Handle any errors that may occur during the image processing
                return redirect()->back()->withErrors(['error' => 'Image processing failed: ' . $e->getMessage()]);
            }
        }

        // Save the category
        $category->save();

        return redirect('/admin/video_categories')->with('status', 'Category added successfully');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = VideoCategory::find($id);
        if (!$category) {
            return redirect()->back()->withErrors(['error' => 'Category not found']);
        }

        return view('admin.video_categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = VideoCategory::find($id);
        if (!$category) {
            return redirect()->back()->withErrors(['error' => 'Category not found']);
        }

        return view('admin.video_categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, VideoCategory $videoCategory)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Image is optional on update
        ]);

        $videoCategory->name = $request->name;
        $videoCategory->description = $request->description;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $fileName = time() . '_' . $image->getClientOriginalName();
            $imagePath = public_path('assets/images/video_categories/' . $fileName);
            $thumbPath = public_path('assets/images/video_categories/thumb/' . $fileName);

            try {
                // Ensure directories exist
                if (!file_exists(public_path('assets/images/video_categories'))) {
                    mkdir(public_path('assets/images/video_categories'), 0777, true);
                }
                if (!file_exists(public_path('assets/images/video_categories/thumb'))) {
                    mkdir(public_path('assets/images/video_categories/thumb'), 0777, true);
                }

                // Create an image instance and save the original image
               $uploadedImage = Image::make($image->getRealPath())->save($imagePath);

               // Resize the image to 500px in width while maintaining aspect ratio, and save the thumbnail
               $uploadedImage->resize(500, null, function ($constraint) {
                   $constraint->aspectRatio();
               })->save($thumbPath);

                // Store the filename in the model
                $videoCategory->image = $fileName;
            } catch (Exception $e) {
                // Handle any errors that may occur during the image processing
                return redirect()->back()->withErrors(['error' => 'Image processing failed: ' . $e->getMessage()]);
            }
        }

        // Save the updated category
        $videoCategory->save();

        return redirect()->route('admin.video_categories.index')->with('status', 'Category updated successfully');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = VideoCategory::find($id);
        if (!$category) {
            return redirect()->back()->withErrors(['error' => 'Category not found']);
        }

        // Remove the image files
        @unlink(public_path('assets/images/video_categories/' . $category->image));
        @unlink(public_path('assets/images/video_categories/thumb/' . $category->image));

        // Delete the category
        $category->delete();

        return redirect()->back()->with('status', 'Category deleted successfully');
    }
}
