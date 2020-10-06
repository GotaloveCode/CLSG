<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Mail\NewPassword;
use App\Mail\UserCreatedMailable;
use App\Traits\GenerateTokenTrait;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    use GenerateTokenTrait;

    public function store(UserRequest $request)
    {
        $user = new User();
        $password = $this->getToken();
        $request['password'] = bcrypt($password);
        $user->fill($request->all());
        $user->save();
        $role = auth()->user()->role->getRoleNames()->first();
        $user->assignRole($role);
        if($role == 'wsp'){
            $user->wsps()->attach(auth()->user()->wsps()->first()->id);
        }
        Mail::to($user)->queue(new UserCreatedMailable($user, $password));
    }
}
