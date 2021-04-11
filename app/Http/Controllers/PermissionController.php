<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index(Request $request)
    {
        $permissions = Permission::where('name','like',"%{$request->search}%")->paginate(15);
        return view('pages.permission.index', compact('permissions'));
    }

    public function create()
    {
        return view('pages.permission.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:permissions',
        ]);
        Permission::create(['name'=> $request->name]);
        return back()->with('success','Permission was Created!!');
    }

    public function edit($id)
    {
        $permission = Permission::findOrFail($id);
        return view('pages.permission.edit', compact('permission'));
    }

    public function update(Request $request, $id)
    {
        $permission = Permission::find($id);
        $request->validate([
            'name' => 'required|string|unique:permissions,name,'.$id,
        ]);

        $permission->update([
            'name' => $request->name,
        ]);
        return back()->with('success','Permission was Updated!!');
    }

    public function destroy(Request $request, $id)
    {
        $permission = Permission::find($id);
        $permission->delete();
        return back()->with('success','Permission was Deleted!!');
    }
}
