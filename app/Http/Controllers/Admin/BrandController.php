<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $brands = Brand::paginate(10);
        // dd($brands, $shopId);
        return view('admin.brands.index', [
            'brands' => $brands,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.brands.create');
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
        ]);

        $type = Brand::create([
            'create_by_user_id' => $request->user()->id,
            'name' => $request->name,
            'name_kh' => $request->name_kh,
        ]);

        return redirect('/admin/brands')->with('status', 'Add type Successful');

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
        Brand::destroy($id);
        return redirect()->back()->with('status', 'Delete Successful');
    }
}
