<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Mail\UserCreatedMailable;
use App\Traits\GenerateTokenTrait;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    use GenerateTokenTrait;

    public function index()
    {
        if (!request()->ajax()) {
            return view('users.index');
        }

        $role = auth()->user()->roles()->first();
//        if ($role->name == 'Super Admin') {
        $users = User::query()->with('roles')->select('users.*');
//        } else {
//            $users = User::query()
//                ->select('users.id', 'users.name', 'email', 'roles.name as role', 'users.created_at')
//                ->join('user_roles', 'users.id', '=', 'user_id')
//                ->join('roles', 'roles.id', '=', 'user_roles.role_id')
//                ->where('user_roles.role_id', $role->id);
//        }

        $datatable = Datatables::of($users);

//        if ($role->hasPermissionTo('create-users')) {
//            $datatable->addColumn('action', function ($u) {
//                return '<a href="' . route("roles.edit", $u->id) . '" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i> Edit</a>';
//            });
//        }
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
        User::onlyTrashed()->find($id)->restore();
        return response()->json(['message' => 'User restored successfully!']);
    }
}
