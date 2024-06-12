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

    public function index(Request $request)
    {
<<<<<<< HEAD
        $products = Product::with('brand', 'brand_model','category','body_type')->paginate(10);
        // return $products;
=======
        // Get the sorting parameters from the request, with defaults
        $sortColumn = $request->get('sort_by', 'id');
        $sortDirection = $request->get('sort_direction', 'desc'); // Default sort direction 'desc'

        // Retrieve products with sorting and relationships
        $products = Product::with('brand', 'brand_model', 'categories', 'body_type')
            ->orderBy($sortColumn, $sortDirection)
            ->paginate(10);

>>>>>>> 9906800 (update)
        return view('admin.products.index', [
            'products' => $products,
            'sortColumn' => $sortColumn,
            'sortDirection' => $sortDirection,
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
        $shops = Shop::all();

        return view('admin.products.edit', compact('product', 'brands', 'models', 'categories', 'types', 'body_types','shops'));
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, $id)
    {
        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'discount_percent' => 'nullable|sometimes|numeric',
            'code' => 'nullable|sometimes|string|max:255',
            'image' => 'nullable|sometimes|image|mimes:jpeg,png,jpg,gif|max:2048', // Image is not required during update
            'description' => 'nullable|sometimes|string',
            'category_id' => 'nullable|sometimes|integer',
            'sub_category_id' => 'nullable|sometimes|integer',
            'brand_id' => 'nullable|sometimes|integer',
            'shop_id' => 'nullable|sometimes|integer',
            'model_id' => 'nullable|sometimes|integer',
            'body_type_id' => 'nullable|sometimes|integer',
            'status' => 'nullable|integer'
        ]);

        // Find the product by ID
        $product = Product::findOrFail($id);

        // Get all input data
        $input = $request->all();

        // Handle image upload
        $image = $request->file('image');
        if (!empty($image)) {
            try {
                // Generate a unique filename with a timestamp
                $fileName = time() . '_' . $image->getClientOriginalName();

                // Define paths for the original image and the thumbnail
                $imagePath = public_path('assets/images/products/' . $fileName);
                $thumbPath = public_path('assets/images/products/thumb/' . $fileName);

                // Create an image instance and save the original image
                $uploadedImage = Image::make($image->getRealPath())->save($imagePath);

                // Resize the image to 500px in width while maintaining aspect ratio, and save the thumbnail
                $uploadedImage->resize(500, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($thumbPath);

                // Store the filename in the input array for further processing or saving in the database
                $input['image'] = $fileName;

                // Remove the old image files
                if ($product->image) {
                    @unlink(public_path('assets/images/products/' . $product->image));
                    @unlink(public_path('assets/images/products/thumb/' . $product->image));
                }
            } catch (Exception $e) {
                // Handle any errors that may occur during the image processing
                return response()->json(['error' => 'Image processing failed: ' . $e->getMessage()], 500);
            }
        }

        // Update the product with the new data
        $product->update($input);

        // Update additional fields if necessary
        $product->update([
            'create_by_user_id' => $request->user()->id,
            'shop_id' => $input['shop_id'] ? $input['shop_id'] : $request->user()->shop_id,
        ]);

        // Redirect back to the product list with a success message
        return redirect('/admin/products')->with('status', 'Product Updated Successfully');
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
