<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BrandModel;
use App\Models\Brand;
use Illuminate\Http\Request;
use Image;

class ModelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search;
        if($search){
            $models = BrandModel::where('name', 'LIKE', "%$search%")->paginate(10);
        }else {
            $models = BrandModel::paginate(10);
        }
        // dd($models, $shopId);
        return view('admin.models.index', [
            'models' => $models,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $brands = Brand::all();
        return view('admin.models.create', [
            'brands' => $brands,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'name_kh' => 'required|max:255',
            'brand_id' => 'required|exists:brands,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $models = new BrandModel();
        $models->name = $validatedData['name'];
        $models->name_kh = $validatedData['name_kh'];
        $models->brand_id = $validatedData['brand_id'];

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $fileName = time() . '_' . $image->getClientOriginalName();
            $imagePath = public_path('assets/images/models/' . $fileName);
            $thumbPath = public_path('assets/images/models/thumb/' . $fileName);

            try {
                // Ensure directories exist
                if (!file_exists(public_path('assets/images/models'))) {
                    mkdir(public_path('assets/images/models'), 0777, true);
                }
                if (!file_exists(public_path('assets/images/models/thumb'))) {
                    mkdir(public_path('assets/images/models/thumb'), 0777, true);
                }

                // Create an image instance and save the original image
               $uploadedImage = Image::make($image->getRealPath())->save($imagePath);

               // Resize the image to 500px in width while maintaining aspect ratio, and save the thumbnail
               $uploadedImage->resize(500, null, function ($constraint) {
                   $constraint->aspectRatio();
               })->save($thumbPath);

                // Store the filename in the model
                $models->image = $fileName;
            } catch (Exception $e) {
                // Handle any errors that may occur during the image processing
                return redirect()->back()->withErrors(['error' => 'Image processing failed: ' . $e->getMessage()]);
            }
        }

        $models->create_by_user_id = $request->user()->id;
        $models->save();

        return redirect('/admin/models')->with('status', 'Add type Successful');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $model = BrandModel::findOrFail($id);

        // Retrieve all brands for the dropdown
        $brands = Brand::all();

        // Pass the model instance and brands to the view
        return view('admin.models.show', compact('model', 'brands'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $model = BrandModel::findOrFail($id);

        // Retrieve all brands for the dropdown
        $brands = Brand::all();

        // Pass the model instance and brands to the view
        return view('admin.models.edit', compact('model', 'brands'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'name_kh' => 'required|max:255',
            'brand_id' => 'required|exists:brands,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $model = BrandModel::findOrFail($id);
        $model->name = $validatedData['name'];
        $model->name_kh = $validatedData['name_kh'];
        $model->brand_id = $validatedData['brand_id'];

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $fileName = time() . '_' . $image->getClientOriginalName();
            $imagePath = public_path('assets/images/models/' . $fileName);
            $thumbPath = public_path('assets/images/models/thumb/' . $fileName);

            try {
                // Ensure directories exist
                if (!file_exists(public_path('assets/images/models'))) {
                    mkdir(public_path('assets/images/models'), 0777, true);
                }
                if (!file_exists(public_path('assets/images/models/thumb'))) {
                    mkdir(public_path('assets/images/models/thumb'), 0777, true);
                }

                // Create an image instance and save the original image
               $uploadedImage = Image::make($image->getRealPath())->save($imagePath);

               // Resize the image to 500px in width while maintaining aspect ratio, and save the thumbnail
               $uploadedImage->resize(500, null, function ($constraint) {
                   $constraint->aspectRatio();
               })->save($thumbPath);

                // Store the filename in the model
                $model->image = $fileName;
            } catch (Exception $e) {
                // Handle any errors that may occur during the image processing
                return redirect()->back()->withErrors(['error' => 'Image processing failed: ' . $e->getMessage()]);
            }
        }

        $model->create_by_user_id = $request->user()->id;
        $model->save();

        return redirect('/admin/models')->with('status', 'Update successful');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        BrandModel::destroy($id);
        return redirect()->back()->with('status', 'Delete Successful');
    }
}
