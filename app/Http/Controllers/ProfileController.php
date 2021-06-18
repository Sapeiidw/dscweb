<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Rules\MatchOldPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        return view('profile');
    }

    public function update(Request $request,$id)
    {
        $user = User::find($id);
        $request->validate([
            'name' => "required|string",
            'email' => "required|email|unique:users,email,".$user->id,
            'foto_profile' => "nullable|image|mimes:jpg,png,jpeg,gif",
        ]);

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

        return back()->with('success','Selamat user berhasil di update!!');
    }

    public function destroy(Request $request,User $user)
    {
        $request->validate([
            'password' => "required|min:8",
        ]);

        if ($user->password == Hash::make($request->password)) {
            Storage::delete($user->foto_profile);
            $user->delete();
            return back()->with('success','Selamat user berhasil di hapus!!');
        }else {
            return back()->with('error','password didnt match');
        }
    }

    public function change_password(Request $request,User $user)
    {
        $request->validate([
            'old_password' => ['required', new MatchOldPassword],
            'password' => 'required|min:8|confirmed',
        ]);

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Password was changed!!');
    }
}
