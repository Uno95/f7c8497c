<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{
    protected $table  = 'roles';
    // protected $fillable = ['hook_params'];

    public function users()
    {
        return $this->belongsToMany('App\User', 'role_user', 'role_id', 'user_id');
    }

    public function permissions()
    {
        $permissions = $this->belongsToMany('App\Permission', 'permission_role', 'role_id', 'permission_id');
        return $permissions;
    }
}
