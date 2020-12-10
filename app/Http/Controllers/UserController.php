<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Mail\UserCreatedMailable;
use App\Traits\Authorizable;
use App\Traits\GenerateTokenTrait;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    use GenerateTokenTrait,Authorizable;

    public function index()
    {
        if (!request()->ajax()) {
            return view('users.index');
        }

        $role = auth()->user()->roles()->first();

        switch ($role->name){
            case 'Super Admin':
                $users = User::query()->with('roles')->select('users.*');
                break;
            case 'wsp':
                $wsp = auth()->user()->wsps()->first();
                $users = $wsp->users()->with('roles')->select('users.*');
                break;
            case 'wasreb':
                $users = User::whereHas("roles", function($q) use($role){ $q->where("name", $role->name); })
                    ->with('roles')->select('users.*');
                break;
            case 'wstf':
                $users = User::whereHas("roles", function($q) use($role){ $q->where("name", $role->name); })
                    ->with('roles')->select('users.*');
                break;
            default:
                $users = User::whereHas("roles", function($q) use($role){ $q->where("name", $role->name); })
                    ->with('roles')->select('users.*');
        }

        $datatable = Datatables::of($users);

        return $datatable->make(true);
    }

    public function store(UserRequest $request)
    {
        $user = new User();
        $password = $this->getToken();
        $request['password'] = bcrypt($password);
        $user->fill($request->all());
        $user->save();
        $role = auth()->user()->role->getRoleNames()->first();
        $user->assignRole($role);
        if ($role == 'wsp') {
            $user->wsps()->attach(auth()->user()->wsps()->first()->id);
        }
        Mail::to($user)->queue(new UserCreatedMailable($user, $password));

        return response()->json(['message' => 'User created successfully']);
    }


    public function edit(User $user)
    {
        return view('users.edit', ['edit_user' => $user->load('roles'), 'roles' => Role::all()]);
    }


    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|exists:roles,id'
        ]);

        $user->update($request->only('name', 'email'));

        $roles = Role::find($request->get('role', []));

        $user->syncRoles($roles);

        return response()->json(['message' => 'User updated successfully']);
    }

    public function show($id)
    {
        return view('users.show', ['edit_user' => User::withTrashed()->find($id)]);
    }

    public function destroy(User $user)
    {
        $user->delete();

        return response()->json(['message' => 'User deleted successfully!']);
    }

    public function trashed()
    {
        if (!request()->ajax()) {
            return view('users.trashed');
        }

        $role = auth()->user()->roles()->first();
//        if ($role->name == 'Super Admin') {
        $users = User::onlyTrashed()->with('roles')->select('users.*');


        $datatable = Datatables::of($users);

        return $datatable->make(true);
    }

    public function restore($id)
    {
        abort_unless(auth()->user()->can('delete_users'),403,'You dont have delete_users permission!');
        User::onlyTrashed()->find($id)->restore();
        return response()->json(['message' => 'User restored successfully!']);
    }
}
