<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Image;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search;
        if($search){
            $items = Course::where('name', 'LIKE', "%$search%")->paginate(10);
        }else {
            $items = Course::paginate(10);
        }
        return view('admin.courses.index', [
            'items' => $items,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.courses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Course $item)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'price' => 'nullable',
            'start' => 'nullable|date',
            'end' => 'nullable|date',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $item->title = $request->title;
        $item->description = $request->description;
        $item->price = $request->price;
        $item->start = $request->start;
        $item->end = $request->end;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $fileName = time() . '_' . $image->getClientOriginalName();
            $imagePath = public_path('assets/images/courses/' . $fileName);
            $thumbPath = public_path('assets/images/courses/thumb/' . $fileName);

            try {
               // Create an image instance and save the original image
               $uploadedImage = Image::make($image->getRealPath())->save($imagePath);

               // Resize the image to 500px in width while maintaining aspect ratio, and save the thumbnail
               $uploadedImage->resize(500, null, function ($constraint) {
                   $constraint->aspectRatio();
               })->save($thumbPath);

                // Store the filename in the category
                $item->image = $fileName;
            } catch (Exception $e) {
                // Handle any errors that may occur during the image processing
                return redirect()->back()->withErrors(['error' => 'Image processing failed: ' . $e->getMessage()]);
            }
        }

        $item->save();

        return redirect('/admin/courses')->with('status', 'Add App Intro Successful');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $item = Course::findOrFail($id); // Retrieve the item with the given ID
        return view('admin.courses.show', compact('item')); // Pass the item object to the view
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $item = Course::findOrFail($id); // Retrieve the item with the given ID
        return view('admin.courses.edit', compact('item')); // Pass the item object to the view
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
            'title' => 'required|max:255',
            'description' => 'nullable',
            'price' => 'nullable',
            'start' => 'nullable|date',
            'end' => 'nullable|date',
        ]);

        // Find the product by ID
        $courses = Course::findOrFail($id);

        // Get all input data
        $input = $request->all();

        // Handle image upload
        $image = $request->file('image');
        if (!empty($image)) {
            try {
                // Generate a unique filename with a timestamp
                $fileName = time() . '_' . $image->getClientOriginalName();

                // Define paths for the original image and the thumbnail
                $imagePath = public_path('assets/images/courses/' . $fileName);
                $thumbPath = public_path('assets/images/courses/thumb/' . $fileName);

                // Create an image instance and save the original image
                $uploadedImage = Image::make($image->getRealPath())->save($imagePath);

                // Resize the image to 500px in width while maintaining aspect ratio, and save the thumbnail
                $uploadedImage->resize(500, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($thumbPath);

                // Store the filename in the input array for further processing or saving in the database
                $input['image'] = $fileName;

                // Remove the old image files
                if ($courses->image) {
                    @unlink(public_path('assets/images/courses/' . $courses->image));
                    @unlink(public_path('assets/images/courses/thumb/' . $courses->image));
                }
            } catch (Exception $e) {
                // Handle any errors that may occur during the image processing
                return response()->json(['error' => 'Image processing failed: ' . $e->getMessage()], 500);
            }
        }

        // Update the product with the new data
        $courses->update($input);



        // Redirect back to the product list with a success message
        return redirect('/admin/courses')->with('status', 'Updated Successfully');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = Course::find($id);
        if (!$item) {
            return redirect()->back()->withErrors(['error' => 'App Intro not found']);
        }

        // Remove the image files
        @unlink(public_path('assets/images/courses/' . $item->image));
        @unlink(public_path('assets/images/courses/thumb/' . $item->image));

        // Delete the category
        $item->delete();

        return redirect()->back()->with('status', 'Deleted successfully');
    }

}
