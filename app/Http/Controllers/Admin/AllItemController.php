<?php

namespace App\Http\Controllers\Admin;

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Item;
use App\Models\Type;
use Illuminate\Http\Request;

class AllItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search;
        if($search){
            $items = Item::where('name', 'LIKE', "%$search%")->paginate(10);
        }else {
            $items = Item::with('category')
                    ->with('type')
                    ->with('shop')
                    ->paginate(10);
        }
        return view('admin.allitems.index', [
            "items" => $items,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $categories = Category::get();
        $types = Type::get();

        return view('admin.allitems.create', [
            'categories' => $categories,
            'types' => $types,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        dd($request->all()) ;
        $request->validate([
            'name' => 'required|max:255',
            'price' => 'required|numeric',
            'category_id' => 'required|numeric',
            'type_id' => 'required|numeric',
        ]);

        $input = $request->all();

        $item = Item::create($input);
        $item->update([
                'shop_id' => $request->user()->shop_id,
                'create_by_user_id' => $request->user()->id,
            ]);

        return redirect('/admin/items')->with('status', 'Add Item Successful');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Item::destroy($id);
        return redirect()->back()->with('status', 'Delete Item Successful');
    }
}
