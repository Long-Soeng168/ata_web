<?php

namespace App\Http\Controllers\Api;

use App\Models\Item;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ItemController extends Controller
{
    // GET /api/items - Display a listing of the items
    public function index()
    {
        return Item::select('id', 'name')->get();
    }

    // POST /api/items - Store a newly created item
    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string']);
        $item = Item::create(['name' => $request->name]);
        return response()->json($item, 201);
    }

    // GET /api/items/{id} - Display a specific item
    public function show(Item $item)
    {
        return response()->json([
            'id' => $item->id,
            'name' => $item->name,
        ]);
    }

    // PUT/PATCH /api/items/{id} - Update a specific item
    public function update(Request $request, Item $item)
    {
        $request->validate(['name' => 'required|string']);
        $item->update(['name' => $request->name]);
        return response()->json($item, 200);
    }

    // DELETE /api/items/{id} - Remove a specific item
   public function destroy(Item $item)
    {
        $item->delete();
        return response()->json(['message' => 'Item deleted successfully'], 200);
    }

}
