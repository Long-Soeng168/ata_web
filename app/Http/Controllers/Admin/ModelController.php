<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\BrandModel;
use App\Models\Brand;
use Illuminate\Http\Request;

class ModelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $models = BrandModel::paginate(10);
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
        // return $request->all();
        $request->validate([
            'name' => 'required|max:255',
            'name_kh' => 'required|max:255',
            'brand_id' => 'required',
        ]);

        $type = BrandModel::create([
            'create_by_user_id' => $request->user()->id,
            'name' => $request->name,
            'name_kh' => $request->name_kh,
            'brand_id' => $request->brand_id,
        ]);

        return redirect('/admin/models')->with('status', 'Add type Successful');

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
        BrandModel::destroy($id);
        return redirect()->back()->with('status', 'Delete Successful');
    }
}