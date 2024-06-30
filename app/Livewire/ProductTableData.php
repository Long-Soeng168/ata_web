<?php

namespace App\Livewire;

use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

use App\Models\BodyType;
use App\Models\Brand;
use App\Models\Shop;
use App\Models\BrandModel;
use App\Models\Category;
use App\Models\Product;
use App\Models\Type;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;
use Image;


class ProductTableData extends Component
{
    use WithPagination;

    #[Url(history: true)]
    public $search = '';

    #[Url(history: true)]
    public $perPage = 10;

    #[Url(history: true)]
    public $filter = 0;

    #[Url(history: true)]
    public $sortBy = 'created_at';

    #[Url(history: true)]
    public $sortDir = 'DESC';

    public function setFilter($value) {
        $this->filter = $value;
        $this->resetPage();
    }

    public function setSortBy($newSortBy) {
        if($this->sortBy == $newSortBy){
            $newSortDir = ($this->sortDir == 'DESC') ? 'ASC' : 'DESC';
            $this->sortDir = $newSortDir;
        }else{
            $this->sortBy = $newSortBy;
        }
    }

    // ResetPage when updated search
    public function updatedSearch() {
        $this->resetPage();
    }

    public function delete($id)
    {
        $location = Product::find($id);
        $location->delete();

        session()->flash('success', 'Product successfully deleted!');
    }

    public function render()
    {
        $products = Product::where(function($query){
                                $query->where('name', 'LIKE', "%$this->search%");
                            })
                            ->when($this->filter != 0, function($query){
                                $query->where('category_id', $this->filter);
                            })
                            ->with('brand', 'brand_model', 'category', 'body_type')
                            ->orderBy($this->sortBy, $this->sortDir)
                            ->paginate($this->perPage);
        // dd($products);
        $categories = Category::latest()->get();
        $selectedCategory = Category::find($this->filter);

        return view('livewire.product-table-data', [
            'products' => $products,
            'categories' => $categories,
            'selectedCategory' => $selectedCategory,
        ]);
    }
}
