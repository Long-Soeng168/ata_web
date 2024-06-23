<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Garage;
use App\Models\Promotion;
use Exception;
use Illuminate\Http\Request;
use Image;

class PromotionController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        if($search){
            $promotions = Promotion::where('title', 'LIKE', "%$search%")->paginate(10);
        }else {
            $promotions = Promotion::paginate(10);
        }
        return view('admin.promotions.index', compact('promotions'));
    }

    public function create()
    {
        $garages = Garage::all();
        return view('admin.promotions.create', compact('garages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'garage_id' => 'required|exists:garages,id',
        ]);

        $input = $request->all();

        $image = $request->file('image');

        if (!empty($image)) {
            try {
                $fileName = time() . '_' . $image->getClientOriginalName();

                $imagePath = public_path('assets/images/promotions/' . $fileName);
                $thumbPath = public_path('assets/images/promotions/thumb/' . $fileName);

                $uploadedImage = Image::make($image->getRealPath())->save($imagePath);

                $uploadedImage->resize(500, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($thumbPath);

                $input['image'] = $fileName;
            } catch (Exception $e) {
                return response()->json(['error' => 'Image processing failed: ' . $e->getMessage()], 500);
            }
        }

        // $input['garage_id'] = $request->garage()->id;
        $promotion = Promotion::create($input);

        return redirect()->route('admin.promotions.index')->with('success', 'Promotion created successfully.');
    }

    public function show(string $id)
    {
        return view('admin.promotions.show', compact('promotion'));
    }

    public function edit(Promotion $promotion)
    {
        $garages = Garage::all();
        return view('admin.promotions.edit', compact('garages', 'promotion'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'garage_id' => 'required|exists:garages,id',
        ]);

        $promotion = Promotion::findOrFail($id);
        $input = $request->all();

        $image = $request->file('image');
        if (!empty($image)) {
            try {
                $fileName = time() . '_' . $image->getClientOriginalName();

                $imagePath = public_path('assets/images/promotions/' . $fileName);
                $thumbPath = public_path('assets/images/promotions/thumb/' . $fileName);

                $uploadedImage = Image::make($image->getRealPath())->save($imagePath);

                $uploadedImage->resize(500, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($thumbPath);

                $input['image'] = $fileName;

                if ($promotion->image) {
                    @unlink(public_path('assets/images/promotions/' . $promotion->image));
                    @unlink(public_path('assets/images/promotions/thumb/' . $promotion->image));
                }
            } catch (Exception $e) {
                return response()->json(['error' => 'Image processing failed: ' . $e->getMessage()], 500);
            }
        }

        $promotion->update($input);

        return redirect()->route('admin.promotions.index')->with('status', 'Promotion updated successfully.');
    }

    public function destroy(Promotion $promotion)
    {
        if ($promotion->image) {
            @unlink(public_path('assets/images/promotions/' . $promotion->image));
            @unlink(public_path('assets/images/promotions/thumb/' . $promotion->image));
        }

        $promotion->delete();
        return redirect()->route('admin.promotions.index')->with('success', 'Promotion deleted successfully.');
    }
}
