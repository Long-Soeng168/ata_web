<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\BodyType;
use App\Models\Brand;
use App\Models\Shop;
use App\Models\BrandModel;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Image;
use Exception;

class ProductCreate extends Component
{
    use WithFileUploads;

    public $image = null;

    public $name;
    public $price;
    public $code;
    public $discount_percent;
    public $description;
    public $brand_id;
    public $model_id;
    public $category_id;
    public $body_type_id;
    public $shop_id;

    protected $rules = [
        'image' => 'required|image|max:2048', // 2048 KB = 2 MB
        'name' => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
        'code' => 'nullable|string|max:255|unique:products,code',
        'discount_percent' => 'nullable|numeric|min:0|max:100',
        'description' => 'nullable|string',
        'brand_id' => 'required|exists:brands,id',
        'model_id' => 'required|exists:models,id',
        'category_id' => 'required|exists:categories,id',
        'body_type_id' => 'required|exists:body_types,id',
        'shop_id' => 'required|exists:shops,id',
    ];

    public function save()
    {
        $validatedData = $this->validate();

        $validatedData['create_by_user_id'] = Auth::id();

        $imageFiles = [];
        if ($this->image) {
            try {
                $fileName = time() . '_' . $this->image->getClientOriginalName();
                $imagePath = public_path('assets/images/products/' . $fileName);
                $thumbPath = public_path('assets/images/products/thumb/' . $fileName);

                // Create an image instance and save the original image
                $uploadedImage = Image::make($this->image->getRealPath())->save($imagePath);

                // Resize the image to 500px in width while maintaining aspect ratio, and save the thumbnail
                $uploadedImage->resize(500, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($thumbPath);

                $validatedData['image'] = $fileName;
            } catch (Exception $e) {
                session()->flash('error', 'Image processing failed: ' . $e->getMessage());
                return;
            }
        }



        Product::create($validatedData);

        session()->flash('message', 'Product successfully created.');
        return redirect()->route('admin.products.index');
    }

    public function render()
    {
        $categories = Category::all();
        $brands = Brand::all();
        $models = BrandModel::where('brand_id', $this->brand_id)->get();
        $body_types = BodyType::all();
        $shops = Shop::all();

        return view('livewire.product-create', [
            'categories' => $categories,
            'brands' => $brands,
            'models' => $models,
            'body_types' => $body_types,
            'shops' => $shops,
        ]);
    }
}
