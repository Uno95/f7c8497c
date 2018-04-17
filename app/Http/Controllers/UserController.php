<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Role;

class UserController extends Controller
{
    public function users()
    {
        $users = User::with('roles')->orderBy('id', 'DESC')->get();
        
        if(request()->wantsJson()){
            return response($users, 200);
        }

        return view('admin.UserList',[
            'users' => $users
        ]);
    }

    public function roles()
    {
        $roles = Role::with(['permissions', 'users'])->orderBy('id', 'DESC')->get();
        
        if(request()->wantsJson()){
            return response($roles, 200);
        }

        return view('admin.UserRoleList',[
            'roles' => $roles
        ]);
    }
}
