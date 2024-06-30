<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Image;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        if($search){
            $shops = Shop::with('owner')->where('name', 'LIKE', "%$search%")->paginate(10);
        }else {
            $shops = Shop::with('owner')->paginate(10);
        }

        return view('admin.shops.index', compact('shops'));
    }

    public function create()
    {
        $users = User::all();
        return view('admin.shops.create', compact('users'));
    }

    public function show($id)
    {
        $users = User::all();
        $shop = Shop::findOrFail($id);
        return view('admin.shops.show', compact('users', 'shop'));
    }

    public function edit($id)
    {
        $users = User::all();
        $shop = Shop::findOrFail($id);
        return view('admin.shops.edit', compact('shop', 'users'));
    }

    public function store(Request $request)
    {
        // Validation rules
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'logo' => 'required|image|max:2048',
            // 'description' => 'required',
            // 'description_kh' => 'required',
            'owner_user_id' => 'required|integer|exists:users,id',
            'phone' => 'required',
            'address' => 'required|string|max:255',
            'vat_percent' => 'required|numeric',
            'exchange_rate_riel' => 'required|numeric',
        ]);

        // If validation fails
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Validation passed, proceed with storing data
        $data = $request->only(['name', 'description', 'description_kh', 'owner_user_id', 'phone', 'address', 'vat_percent', 'exchange_rate_riel']);

        if ($request->hasFile('logo')) {
            try {
                $image = $request->file('logo');
                // Generate a unique filename with a timestamp
                $fileName = time() . '_' . $image->getClientOriginalName();

                // Define paths for the original image and the thumbnail
                $imagePath = public_path('assets/images/shops/' . $fileName);
                $thumbPath = public_path('assets/images/shops/thumb/' . $fileName);

                // Create an image instance and save the original image
                $uploadedImage = Image::make($image->getRealPath())->save($imagePath);

                // Resize the image to 500px in width while maintaining aspect ratio, and save the thumbnail
                $uploadedImage->resize(500, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($thumbPath);

                // Store the filename in the input array for further processing or saving in the database
                $data['logo'] = $fileName;
            } catch (Exception $e) {
                // Handle any errors that may occur during the image processing
                return back()->withErrors(['logo' => 'Image processing failed: ' . $e->getMessage()])->withInput();
            }
        }

        Shop::create($data);

        return redirect()->route('admin.shops.index')->with('success', 'Shop created successfully.');
    }

    public function update(Request $request, $id)
    {
        // Validation rules
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'logo' => 'sometimes|image|max:2048', // 'sometimes' makes it optional
            // 'description' => 'required',
            // 'description_kh' => 'required',
            'owner_user_id' => 'required|integer|exists:users,id',
            'phone' => 'required',
            'address' => 'required|string|max:255',
            'vat_percent' => 'required|numeric',
            'exchange_rate_riel' => 'required|numeric',
        ]);

        // If validation fails
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Validation passed, proceed with updating data
        $data = $request->only(['name', 'description', 'description_kh', 'owner_user_id', 'phone', 'address', 'vat_percent', 'exchange_rate_riel']);

        $shop = Shop::findOrFail($id);

        if ($request->hasFile('logo')) {
            try {
                $image = $request->file('logo');
                // Generate a unique filename with a timestamp
                $fileName = time() . '_' . $image->getClientOriginalName();

                // Define paths for the original image and the thumbnail
                $imagePath = public_path('assets/images/shops/' . $fileName);
                $thumbPath = public_path('assets/images/shops/thumb/' . $fileName);

                // Create an image instance and save the original image
                $uploadedImage = Image::make($image->getRealPath())->save($imagePath);

                // Resize the image to 500px in width while maintaining aspect ratio, and save the thumbnail
                $uploadedImage->resize(500, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($thumbPath);

                // Delete the old images if they exist
                if ($shop->logo) {
                    $oldImagePath = public_path('assets/images/shops/' . $shop->logo);
                    $oldThumbPath = public_path('assets/images/shops/thumb/' . $shop->logo);

                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                    if (file_exists($oldThumbPath)) {
                        unlink($oldThumbPath);
                    }
                }

                // Store the new filename in the input array for further processing or saving in the database
                $data['logo'] = $fileName;
            } catch (Exception $e) {
                // Handle any errors that may occur during the image processing
                return back()->withErrors(['logo' => 'Image processing failed: ' . $e->getMessage()])->withInput();
            }
        }

        $shop->update($data);

        return redirect()->route('admin.shops.index')->with('success', 'Shop updated successfully.');
    }

    public function destroy($id)
    {
        $shop = Shop::findOrFail($id);

        try {
            // Delete the logo images if they exist
            if ($shop->logo) {
                $imagePath = public_path('assets/images/shops/' . $shop->logo);
                $thumbPath = public_path('assets/images/shops/thumb/' . $shop->logo);

                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
                if (file_exists($thumbPath)) {
                    unlink($thumbPath);
                }
            }

            // Delete the shop record from the database
            $shop->delete();

        } catch (Exception $e) {
            // Handle any errors that may occur during the deletion process
            return back()->withErrors(['error' => 'Failed to delete the shop: ' . $e->getMessage()]);
        }

        return redirect()->route('admin.shops.index')->with('success', 'Shop deleted successfully.');
    }
}
