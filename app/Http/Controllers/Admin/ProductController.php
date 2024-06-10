<?php

namespace App\Http\Controllers\Admin;

use App\Models\BodyType;
use App\Models\Brand;
use App\Models\Shop;
use App\Models\BrandModel;
use App\Models\Category;
use App\Models\Product;
use App\Models\Type;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Image;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('brand', 'brand_model','categories','body_type')->paginate(10);
        // return $products;
        return view('admin.products.index', [
            'products' => $products,
        ]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $categories = Category::get();
        $brands = Brand::get();
        $models = BrandModel::get();
        $body_types = BodyType::get();
        $shops = Shop::all();

        return view('admin.products.create', [
            'categories' => $categories,
            'brands' => $brands,
            'models' => $models,
            'body_types' => $body_types,
            'shops' => $shops,
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'discount_percent' => 'nullable|sometimes|numeric',
            'code' => 'nullable|sometimes|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|sometimes|string',
            'category_id' => 'nullable|sometimes|integer',
            'sub_category_id' => 'nullable|sometimes|integer',
            'brand_id' => 'nullable|sometimes|integer',
            'shop_id' => 'nullable|sometimes|integer',
            'model_id' => 'nullable|sometimes|integer',
            'body_type_id' => 'nullable|sometimes|integer',
            'status' => 'nullable|integer'
        ]);

        $input = $request->all();

        $image = $request->file('image');

        if (!empty($image)) {
            try {
                // Generate a unique filename with a timestamp
                $fileName = time() . '_' . $image->getClientOriginalName(); // 202406090408_the-mountain.jpg

                // Define paths for the original image and the thumbnail
                $imagePath = public_path('assets/images/products/' . $fileName); // public/assets/images/products/202406090408_the-mountain.jpg
                $thumbPath = public_path('assets/images/products/thumb/' . $fileName); // public/assets/images/products/thumb_202406090408_the-mountain.jpg

                // Create an image instance and save the original image
                $uploadedImage = Image::make($image->getRealPath())->save($imagePath);

                // Resize the image to 500px in width while maintaining aspect ratio, and save the thumbnail
                $uploadedImage->resize(500, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($thumbPath);

                // Store the filename in the input array for further processing or saving in the database
                $input['image'] = $fileName;
            } catch (Exception $e) {
                // Handle any errors that may occur during the image processing
                return response()->json(['error' => 'Image processing failed: ' . $e->getMessage()], 500);
            }
        }


        // Create the product
        $product = Product::create($input);

        $product->update([
            'create_by_user_id' => $request->user()->id,
            'shop_id' => $input['shop_id'] ? $input['shop_id'] : $request->user()->shop_id,
        ]);

        return redirect('/admin/products')->with('status', 'Add Product Successful');
    }



    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {

        $brands = Brand::all();
        $models = BrandModel::all();
        $categories = Category::all();
        $types = Type::all();
        $body_types = BodyType::all();

        return view('admin.products.show', compact('product', 'brands', 'models', 'categories', 'types', 'body_types'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $brands = Brand::all();
        $models = BrandModel::all();
        $categories = Category::all();
        $types = Type::all();
        $body_types = BodyType::all();

        return view('admin.products.edit', compact('product', 'brands', 'models', 'categories', 'types', 'body_types'));
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'discount_percent' => 'nullable|numeric',
            'code' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
            'category_id' => 'nullable|integer',
            'sub_category_id' => 'nullable|integer',
            'brand_id' => 'nullable|integer',
            'model_id' => 'nullable|integer',
            'body_type_id' => 'nullable|integer',
            'status' => 'nullable|integer'
        ]);

        $product = Product::findOrFail($id);
        $input = $request->all();

        if ($request->hasFile('image')) {
            // Get the file name with extension
            $fileNameWithExt = $request->file('image')->getClientOriginalName();
            // Get the file name without extension
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            // Get the file extension
            $extension = $request->file('image')->getClientOriginalExtension();
            // Create a new file name with timestamp to ensure uniqueness
            $fileNameToStore = $fileName . '_' . time() . '.' . $extension;
            // Move the image to public/images directory
            $request->file('image')->move(public_path('images'), $fileNameToStore);
            // Save the file name to the database
            $input['image'] = $fileNameToStore;

            // Delete old image
            if ($product->image) {
                unlink(public_path('images') . '/' . $product->image);
            }
        }

        // Add additional fields to the input array
        $input['shop_id'] = $request->user()->shop_id;
        $input['created_by_user_id'] = $request->user()->id;

        // Update the product
        $product->update($input);

        return redirect('/admin/products')->with('status', 'Update Product Successful');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
    }
}
