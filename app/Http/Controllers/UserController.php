<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Mail\UserCreatedMailable;
use App\Traits\GenerateTokenTrait;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    use GenerateTokenTrait;

    public function index()
    {
        if(!request()->ajax()){
            return view('users.index');
        }

        $role = auth()->user()->roles()->first();
        if ($role->name == 'Super Admin') {
            $users = User::query()->with('roles');
        } else {
            $users = User::query()->select('users.id', 'users.name', 'email', 'users.created_at')
                ->join('user_roles', 'users.id', '=', 'user_id')
                ->where('user_roles.role_id', $role->id);
        }

        $datatable = Datatables::of($users);

        if ($role->hasPermissionTo('create-users')) {
            $datatable->addColumn('action', function ($u) {
                return '<a href="' . route("users.edit", $u->id) . '" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i> Edit</a>';
            });
        }
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


}
