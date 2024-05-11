<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('roles')->get();
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
        // return $authUser;
        // dd($request->all());
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed'],
            'roles' => ['required'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'gender' => $request->gender,
            'date_of_birth' => $request->date_of_birth,
            'add_by_user_id' => $request->user()->id,
        ]);

        $roles = $request->only('roles');

        if($roles) {
            $user->syncRoles($roles);
        }

        if($authUser->shop_id == null) {
            $createdShop = Shop::create([
                'name' => $request->name . ' Shop',
                'owner_user_id' => $user->id,
                'description' => 'Your shop description'
            ]);

            if ($createdShop) {
                // Update the user's shop_id
                $user->update([
                    'shop_id' => $createdShop->id,
                ]);
            }
        }else {
            $user->update([
                'shop_id' => $authUser->shop_id,
            ]);
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
        dd('Edit user', $id);
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
        //
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
