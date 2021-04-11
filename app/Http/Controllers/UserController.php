<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::with('roles')
                ->where('name','like',"%{$request->search}%")
                ->paginate(15);
        return view('pages.user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all()->pluck("name");
        return view('pages.user.create', compact("roles"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => "required|string",
            'email' => "required|email|unique:users",
            'password' => "required|min:8|confirmed",
            'foto_profile' => "nullable|image|mimes:jpg,png,jpeg,gif",
        ]);
        $request->role = $request->role !== null ? $request->role : 'user';
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'foto_profile' => $request->foto_profile ? request()->file('foto_profile')->store('image/user') : null,
        ])->syncRoles($request->role);

        return back()->with('success','Selamat user berhasil di buat!!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $roles = Role::all();
        $user = User::with('roles')->find($id);
        return view('pages.user.edit', compact('user','roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        $request->validate([
            'name' => "required|string",
            'email' => "required|email|unique:users,email,".$id,
            'foto_profile' => "nullable|image|mimes:jpg,png,jpeg,gif",
        ]);
        $request->role = $request->role !== null ? $request->role : 'user';

        if ($request->foto_profile) {
            Storage::delete($user->foto_profile);
            $foto = request()->file('foto_profile')->store('image/user');
        } elseif($request->foto_profile == null) {
            $foto = $user->foto_profile;
        }else {
            $foto = null;
        }
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'foto_profile' => $foto,
        ])->syncRoles($request->role);

        return back()->with('success','Selamat user berhasil di edit!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        Storage::delete($user->foto_profile);
        $user->delete();
        return back()->with('success','Selamat user berhasil di hapus!!');
    }
}
