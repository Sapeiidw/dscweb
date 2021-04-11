<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        $roles = Role::with('permissions')
            ->where('name','like',"%{$request->search}%")
            ->paginate(15);
        return view('pages.role.index', compact('roles'));
    }

    public function create()
    {
        return view('pages.role.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:roles',
        ]);
        Role::create(['name'=> $request->name]);
        return back()->with('success','Role was Created!!');
    }

    public function edit($id)
    {
        $permissions = Permission::all();
        $role = Role::with('permissions')
            ->findOrFail($id);
        return view('pages.role.edit', compact('role','permissions'));
    }

    public function update(Request $request, $id)
    {
        $role = Role::find($id);
        $request->validate([
            'name' => 'required|string|unique:roles,name,'.$id,
            'permissions' => 'nullable',
        ]);

        $role->update([
            'name' => $request->name,
        ]);
        $role->syncPermissions($request->permissions);
        return back()->with('success','Role was Updated!!');
    }

    public function destroy(Request $request, $id)
    {
        $role = Role::find($id);
        $role->delete();
        return back()->with('success','Role was Deleted!!');
    }
}
