<?php

namespace App\Http\Controllers;

use App\Traits\Authorizable;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    use Authorizable;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::all();
        $permissions = Permission::all();

        return view('roles.index', compact('roles', 'permissions'));
    }


    public function store(Request $request)
    {
        $this->validate($request, ['name' => 'required|unique:roles']);

        if (Role::create($request->only('name'))) {
            return redirect()->back()->with('alerts', [
                ['type' => 'success', 'message' => 'Role Added']
            ]);
        }

        return redirect()->back();
    }


    public function edit($id)
    {
        return view('roles.edit', ['role' => Role::find($id)]);
    }

    public function update(Request $request, $id): \Illuminate\Http\RedirectResponse
    {
        $role = Role::findOrFail($id);
        $system_roles = collect(['wasreb', 'wsp', 'wstf']);

        if ($system_roles->contains($role->name)) {
            return redirect()->back()->withErrors('Cannot update system roles such as ' . $system_roles->implode(','));
        }

        $role->name = $request->name;
        $role->save();

        return redirect()->back()->with('alerts', [
            ['type' => 'success', 'message' => $role->name . ' has been updated.']
        ]);
    }


    public function permissions(Request $request, Role $role): \Illuminate\Http\RedirectResponse
    {
        // admin role has everything
        if ($role->name === 'Super Admin') {
            $role->syncPermissions(Permission::all());
            return redirect()->route('roles.index');
        }

        $permissions = $request->get('permissions', []);
        $role->syncPermissions($permissions);

        return redirect()->back()->with('alerts', [
            ['type' => 'success', 'message' => $role->name . ' permissions has been updated.']
        ]);
    }


    public function destroy($id)
    {
        if ($role = Role::findOrFail($id)) {
            if ($role->users()->exists()) {
                return response()->json(['errors' => ['Role cannot be deleted if it has users linked!!']], 422);
            }
            $role->delete();
        }

        return response()->json(['message' => 'Role deleted successfully!'], 200);
    }


}
