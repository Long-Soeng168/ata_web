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

class ProductEdit extends Component
{
    use WithFileUploads;

    public $image = null;

    public $productId;
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
        'image' => 'nullable|image|max:2048', // 2048 KB = 2 MB
        'name' => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
        'code' => 'required|string|max:255|unique:products,code',
        'discount_percent' => 'nullable|numeric|min:0|max:100',
        'description' => 'nullable|string',
        'brand_id' => 'required|exists:brands,id',
        'model_id' => 'required|exists:models,id',
        'category_id' => 'required|exists:categories,id',
        'body_type_id' => 'required|exists:body_types,id',
        'shop_id' => 'required|exists:shops,id',
    ];

    public function mount($id = null)
    {
        $this->productId = $id;
        if ($this->productId) {
            $this->loadProduct();
        }
    }

    public function loadProduct()
    {
        $product = Product::findOrFail($this->productId);
        $this->name = $product->name;
        $this->price = $product->price;
        $this->code = $product->code;
        $this->discount_percent = $product->discount_percent;
        $this->description = $product->description;
        $this->brand_id = $product->brand_id;
        $this->model_id = $product->model_id;
        $this->category_id = $product->category_id;
        $this->body_type_id = $product->body_type_id;
        $this->shop_id = $product->shop_id;
    }

    public function save()
    {
        $validatedData = $this->validate([
            'image' => 'nullable|image|max:2048', // 2048 KB = 2 MB
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'code' => 'required|string|max:255|unique:products,code,' . $this->productId,
            'discount_percent' => 'nullable|numeric|min:0|max:100',
            'description' => 'nullable|string',
            'brand_id' => 'required|exists:brands,id',
            'model_id' => 'required|exists:models,id',
            'category_id' => 'required|exists:categories,id',
            'body_type_id' => 'required|exists:body_types,id',
            'shop_id' => 'required|exists:shops,id',
        ]);

        $validatedData['create_by_user_id'] = Auth::id();

        if ($this->image) {
            try {
                $fileName = time() . '_' . $this->image->getClientOriginalName();
                $imagePath = public_path('assets/images/products/' . $fileName);
                $thumbPath = public_path('assets/images/products/thumb/' . $fileName);

                $uploadedImage = Image::make($this->image->getRealPath())->save($imagePath);
                $uploadedImage->resize(500, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($thumbPath);

                $validatedData['image'] = $fileName;
            } catch (Exception $e) {
                session()->flash('error', 'Image processing failed: ' . $e->getMessage());
                return;
            }
        }

        if ($this->productId) {
            $product = Product::findOrFail($this->productId);
            $product->update($validatedData);
            session()->flash('message', 'Product successfully updated.');
        } else {
            Product::create($validatedData);
            session()->flash('message', 'Product successfully created.');
        }

        return redirect()->route('admin.products.index');
    }

    public function render()
    {
        $categories = Category::all();
        $brands = Brand::all();
        $models = BrandModel::where('brand_id', $this->brand_id)->get();
        $body_types = BodyType::all();
        $shops = Shop::all();

        return view('livewire.product-edit', [
            'categories' => $categories,
            'brands' => $brands,
            'models' => $models,
            'body_types' => $body_types,
            'shops' => $shops,
        ]);
    }
}
