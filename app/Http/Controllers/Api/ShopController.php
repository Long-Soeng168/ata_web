<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Image;
use App\Models\Product;

class ShopController extends Controller
{
    public function index()
    {
        $shops = Shop::paginate(10);

        return response()->json($shops);
    }

    public function store(Request $request)
    {
        // Validate incoming request  
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:20048', // Validate logo image
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:20048', // Validate banner image
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 400);
        }
        
        $userId = $request->user()->id;
    
        try { 
            // Store images if they are provided 
            // Create shop in the database
            $logoName;
            if ($request->hasFile('logo')) {
                $image = $request->file('logo');
                $fileName = time() . '_' . $image->getClientOriginalName();
                $imagePath = public_path('assets/images/shops/logo/' . $fileName); 
                $thumbPath = public_path('assets/images/shops/logo/thumb/' . $fileName);
    
                try {
                    // Create an image instance and save the original image
                   $uploadedImage = Image::make($image->getRealPath())->save($imagePath); 
                   
                   $uploadedImage->resize(500, null, function ($constraint) {
                       $constraint->aspectRatio();
                   })->save($thumbPath);
    
                    // Store the filename in the category
                    $logoName = $fileName;
                } catch (Exception $e) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Fail to Save Image.',
                    ], 500);
                }
            }
            
            $bannerName;
            if ($request->hasFile('banner')) {
                $image = $request->file('banner');
                $fileName = time() . '_' . $image->getClientOriginalName();
                $imagePath = public_path('assets/images/shops/banner/' . $fileName); 
                $thumbPath = public_path('assets/images/shops/banner/thumb/' . $fileName);
    
                try {
                    // Create an image instance and save the original image
                   $uploadedImage = Image::make($image->getRealPath())->save($imagePath);  
                   $uploadedImage->resize(800, null, function ($constraint) {
                       $constraint->aspectRatio();
                   })->save($thumbPath);
    
                    // Store the filename in the category
                    $banner = $fileName;
                } catch (Exception $e) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Fail to Save Image.',
                    ], 500);
                }
            }
            
            $shop = Shop::create([
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'address' => $request->input('address'),
                'phone' => $request->input('phone'),
                'logo' => $logoName, // Save the relative path
                'banner' => $banner, // Save the relative path
                'owner_user_id' => $userId,
            ]);
            
            $user = User::find($userId);
            $user->update([
                'shop_id' => $shop->id,
            ]);
    
            return response()->json([
                'success' => true,
                'message' => 'Shop created successfully',
                'shop' => $shop
            ], 200);
    
        } catch (\Exception $e) {
            // Handle any error that occurs during the process
            return response()->json([
                'success' => false,
                'message' => 'Error creating shop: ' . $e->getMessage()
            ], 500);
        }
    }


    public function show(String $id)
    {
        $shop = Shop::with('owner')->findOrFail($id);

        return response()->json($shop);
    }

    public function edit($id)
    {
        $shop = Shop::findOrFail($id);
        return $shop;
        // return view('admin.shops.edit', compact('dtc'));
    }

 

    public function update(Request $request, $id)
    {
        // Validation rules
        $validator = Validator::make($request->all(), [
            'dtc_code' => 'required|string|max:255',
            'description_en' => 'required',
            'description_kh' => 'required',
        ]);

        // If validation fails
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Validation passed, proceed with updating data
        $data = $request->only(['dtc_code', 'description_en', 'description_kh']);
        Shop::findOrFail($id)->update($data);

        return redirect()->route('admin.shops.index')->with('success', 'DTC updated successfully.');
    }

    public function destroy($id)
    {
        Shop::findOrFail($id)->delete();

        return redirect()->route('admin.shops.index')->with('success', 'DTC deleted successfully.');
    }
    
    //Products
    
    public function storeProduct(Request $request)
    {
        // Validate incoming request  
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'price' => 'required', 
            'categoryId' => 'required', 
            'bodyTypeId' => 'required', 
            'brandId' => 'required', 
            'brandModelId' => 'required', 
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:20048', 
            'description' => 'required|string',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 400);
        }
        
        $userId = $request->user()->id;
    
        try { 
            // Store images if they are provided  
            $imageName;
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $fileName = time() . '_' . $image->getClientOriginalName();
                $imagePath = public_path('assets/images/products/' . $fileName); 
                $thumbPath = public_path('assets/images/products/thumb/' . $fileName);
    
                try {
                    // Create an image instance and save the original image
                   $uploadedImage = Image::make($image->getRealPath())->save($imagePath); 
                   
                   $uploadedImage->resize(500, null, function ($constraint) {
                       $constraint->aspectRatio();
                   })->save($thumbPath);
    
                    // Store the filename in the category
                    $imageName = $fileName;
                } catch (Exception $e) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Fail to Save Image.',
                    ], 500);
                }
            }
            
             
            
            $product = Product::create([
                'name' => $request->input('name'),
                'price' => $request->input('price'), 
                'description' => $request->input('description'), 
                'category_id' => $request->input('categoryId'), 
                'body_type_id' => $request->input('bodyTypeId'), 
                'brand_id' => $request->input('brandId'), 
                'model_id' => $request->input('brandModelId'), 
                'image' => $imageName,  
            ]);
             
            $product->update([
                'create_by_user_id' => $request->user()->id,
                'shop_id' => $request->user()->shop_id,
            ]);
    
            return response()->json([
                'success' => true,
                'message' => 'Product created successfully',
                'product' => $product
            ], 200);
    
        } catch (\Exception $e) {
            // Handle any error that occurs during the process
            return response()->json([
                'success' => false,
                'message' => 'Error creating Product: ' . $e->getMessage()
            ], 500);
        }
    }
}

