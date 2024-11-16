<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ShopController extends Controller
{
    public function index()
    {
        $shops = Shop::paginate(10);

        return response()->json($shops);
    }

    public function create()
    {
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


    public function store(Request $request)
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

        // Validation passed, proceed with storing data
        $data = $request->only(['dtc_code', 'description_en', 'description_kh']);
        Shop::create($data);

        return redirect()->route('admin.shops.index')->with('success', 'DTC created successfully.');
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
}

