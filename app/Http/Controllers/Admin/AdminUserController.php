<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Image;

class AdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search;
        if ($search) {
            $users = User::where('name', 'LIKE', "%$search%")->paginate(10);
        } else {
            $users = User::with('roles')->paginate(10);
        }
        // return $users;
        return view('admin.users.index', [
            'users' => $users,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();

        return view('admin.users.create', [
            'roles' => $roles,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $authUser = $request->user();

        // Validation rules
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|lowercase|max:255|unique:users',
            'password' => 'required|confirmed',
            'roles' => 'required',
            'image' => 'required|image|max:2048',
        ]);

        // Validation passed, proceed with storing data
        $data = $request->only(['name', 'email', 'password', 'roles']);

        if ($request->hasFile('image')) {
            try {
                $image = $request->file('image');
                // Generate a unique filename with a timestamp
                $fileName = time() . '_' . $image->getClientOriginalName();

                // Define paths for the original image and the thumbnail
                $imagePath = public_path('assets/images/users/' . $fileName);
                $thumbPath = public_path('assets/images/users/thumb/' . $fileName);

                // Create an image instance and save the original image
                $uploadedImage = Image::make($image->getRealPath())->save($imagePath);

                // Resize the image to 500px in width while maintaining aspect ratio, and save the thumbnail
                $uploadedImage->resize(500, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($thumbPath);

                // Store the filename in the input array for further processing or saving in the database
                $data['image'] = $fileName;
            } catch (Exception $e) {
                // Handle any errors that may occur during the image processing
                return back()->withErrors(['image' => 'Image processing failed: ' . $e->getMessage()])->withInput();
            }
        }

        // Create user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'gender' => $request->gender,
            'date_of_birth' => $request->date_of_birth,
            'add_by_user_id' => $authUser->id,
            'image' => $data['image'] ?? null,  // Store the image if it exists
        ]);

        // Assign roles to user
        $roles = $request->input('roles');
        if ($roles) {
            $user->syncRoles($roles);
        }

        // Create shop if the authenticated user doesn't have one
        if ($authUser->shop_id === null) {
            $createdShop = Shop::create([
                'name' => $request->name . ' Shop',
                'owner_user_id' => $user->id,
                'description' => 'Your shop description',
            ]);

            if ($createdShop) {
                // Update the user's shop_id
                $user->update(['shop_id' => $createdShop->id]);
            }
        } else {
            $user->update(['shop_id' => $authUser->shop_id]);
        }

        return redirect('/admin/users')->with('status', 'User created successfully');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        dd('view user', $id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // dd('Edit user', $id);
        $user = User::findOrFail($id);
        $roles = Role::all();
        $userRoles = DB::table('model_has_roles')
            ->where('model_id', $user->id)
            ->pluck('role_id', 'role_id')
            ->all();

        return view('admin.users.edit', [
            'roles' => $roles,
            'user' => $user,
            'userRoles' => $userRoles,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);
        $authUser = $request->user();

        // Validation rules
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|lowercase|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|confirmed',
            'roles' => 'required',
            'image' => 'nullable|image|max:2048',
        ]);

        // Validation passed, proceed with updating data
        $data = $request->only(['name', 'email', 'phone', 'gender', 'date_of_birth']);
        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('image')) {
            try {
                $image = $request->file('image');
                // Generate a unique filename with a timestamp
                $fileName = time() . '_' . $image->getClientOriginalName();

                // Define paths for the original image and the thumbnail
                $imagePath = public_path('assets/images/users/' . $fileName);
                $thumbPath = public_path('assets/images/users/thumb/' . $fileName);

                // Create an image instance and save the original image
                $uploadedImage = Image::make($image->getRealPath())->save($imagePath);

                // Resize the image to 500px in width while maintaining aspect ratio, and save the thumbnail
                $uploadedImage->resize(500, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($thumbPath);

                // Store the filename in the input array for further processing or saving in the database
                $data['image'] = $fileName;
            } catch (Exception $e) {
                // Handle any errors that may occur during the image processing
                return back()->withErrors(['image' => 'Image processing failed: ' . $e->getMessage()])->withInput();
            }
        }

        // Update user data
        $user->update($data);

        // Update user roles
        $roles = $request->input('roles');
        if ($roles) {
            $user->syncRoles($roles);
        }

        // Update the user's shop if the authenticated user doesn't have one
        if ($authUser->shop_id === null) {
            $createdShop = Shop::updateOrCreate(
                ['owner_user_id' => $user->id],
                ['name' => $request->name . ' Shop', 'description' => 'Your shop description']
            );

            if ($createdShop) {
                // Update the user's shop_id
                $user->update(['shop_id' => $createdShop->id]);
            }
        }

        return redirect('/admin/users')->with('status', 'User updated successfully');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->back()->with('status', 'Delete Successful!');
    }
}
