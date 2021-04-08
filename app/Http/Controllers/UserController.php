<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::paginate(15);
        return view('pages.user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.user.create');
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
        
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'foto_profile' => $request->foto_profile ? request()->file('foto_profile')->store('image/user') : null,
        ]);

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
        $user = User::find($id);
        return view('pages.user.edit', compact('user'));
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
        $request->validate([
            'name' => "required|string",
            'email' => "required|email|unique:users,email,".$id,
            'foto_profile' => "nullable|image|mimes:jpg,png,jpeg,gif",
        ]);
        
        $user = User::find($id);
        
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
        ]);

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
