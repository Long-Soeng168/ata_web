<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Garage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Image;

class GarageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    { 
        
        $search = $request->input('search');
        $expertId = $request->input('expertId');
    
        $query = Garage::with('expert');
    
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%$search%")
                  ->orWhere('address', 'LIKE', "%$search%")
                  ->orWhere('bio', 'LIKE', "%$search%");
            });
        }
    
        if ($expertId) {
            $query->where('brand_id', $expertId);
        }
    
        $garages = $query->paginate(10);
    
        return response()->json($garages); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
     public function store(Request $request)
    {
        // Validate incoming request  
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4000', // Validate logo image
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4000', // Validate banner image
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 400);
        }
    
        $userId = $request->user()->id;
    
        try {
            $logoName = null;
            $bannerName = null;
    
            // Process logo image
            if ($request->hasFile('logo')) {
                $logo = $request->file('logo');
                $logoName = time() . '_' . $logo->getClientOriginalName();
                $logoPath = public_path('assets/images/garages/logo/' . $logoName);
                $logoThumbPath = public_path('assets/images/garages/thumb/logo/' . $logoName);
    
                try {
                    $uploadedLogo = Image::make($logo->getRealPath())->save($logoPath);
                    $uploadedLogo->resize(500, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save($logoThumbPath);
                } catch (Exception $e) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Failed to save logo image.',
                    ], 500);
                }
            }
    
            // Process banner image
            if ($request->hasFile('banner')) {
                $banner = $request->file('banner');
                $bannerName = time() . '_' . $banner->getClientOriginalName();
                $bannerPath = public_path('assets/images/garages/banner/' . $bannerName);
                $bannerThumbPath = public_path('assets/images/garages/thumb/banner/' . $bannerName);
    
                try {
                    $uploadedBanner = Image::make($banner->getRealPath())->save($bannerPath);
                    $uploadedBanner->resize(800, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save($bannerThumbPath);
                } catch (Exception $e) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Failed to save banner image.',
                    ], 500);
                }
            }
    
            // Create garage record in the database
            $garage = Garage::create([
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'address' => $request->input('address'),
                'phone' => $request->input('phone'),
                'logo' => $logoName,
                'banner' => $bannerName,
                'user_id' => $userId,
            ]);
    
            // Update user details and assign role
            $user = User::find($userId);
            $user->update(['garage_id' => $garage->id]);
            $user->assignRole('garage');
    
            return response()->json([
                'success' => true,
                'message' => 'Garage created successfully',
                'garage' => $garage
            ], 200);
    
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating garage: ' . $e->getMessage(),
            ], 500);
        }
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $garage = Garage::with('expert')->find($id);
        return response()->json($garage);
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
    public function update(Request $request, $id)
    {
        // Validate incoming request  
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4000', // Validate logo image
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4000', // Validate banner image
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 400);
        }
    
        try {
            $garage = Garage::findOrFail($id); // Find the existing garage by ID
            $logoName = $garage->logo; // Keep existing logo name if no new logo uploaded
            $bannerName = $garage->banner; // Keep existing banner name if no new banner uploaded
    
            // Process logo image if uploaded
            if ($request->hasFile('logo')) {
                // Delete the old logo if it exists
                if ($logoName) {
                    unlink(public_path('assets/images/garages/logo/' . $logoName));
                    unlink(public_path('assets/images/garages/thumb/logo/' . $logoName));
                }
    
                // Save new logo
                $logo = $request->file('logo');
                $logoName = time() . '_' . $logo->getClientOriginalName();
                $logoPath = public_path('assets/images/garages/logo/' . $logoName);
                $logoThumbPath = public_path('assets/images/garages/thumb/logo/' . $logoName);
    
                try {
                    $uploadedLogo = Image::make($logo->getRealPath())->save($logoPath);
                    $uploadedLogo->resize(500, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save($logoThumbPath);
                } catch (Exception $e) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Failed to save logo image.',
                    ], 500);
                }
            }
    
            // Process banner image if uploaded
            if ($request->hasFile('banner')) {
                // Delete the old banner if it exists
                if ($bannerName) {
                    unlink(public_path('assets/images/garages/banner/' . $bannerName));
                    unlink(public_path('assets/images/garages/thumb/banner/' . $bannerName));
                }
    
                // Save new banner
                $banner = $request->file('banner');
                $bannerName = time() . '_' . $banner->getClientOriginalName();
                $bannerPath = public_path('assets/images/garages/banner/' . $bannerName);
                $bannerThumbPath = public_path('assets/images/garages/thumb/banner/' . $bannerName);
    
                try {
                    $uploadedBanner = Image::make($banner->getRealPath())->save($bannerPath);
                    $uploadedBanner->resize(800, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save($bannerThumbPath);
                } catch (Exception $e) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Failed to save banner image.',
                    ], 500);
                }
            }
    
            // Update the garage record
            $garage->update([
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'address' => $request->input('address'),
                'phone' => $request->input('phone'),
                'logo' => $logoName,
                'banner' => $bannerName,
            ]);
    
            // Update user details if needed
            $user = User::find($garage->user_id);
            if ($user) {
                $user->update(['garage_id' => $garage->id]);
                // You can update the role here if needed, for example:
                // $user->assignRole('garage'); 
            }
    
            return response()->json([
                'success' => true,
                'message' => 'Garage updated successfully',
                'garage' => $garage
            ], 200);
    
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating garage: ' . $e->getMessage(),
            ], 500);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
