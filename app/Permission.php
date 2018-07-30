<?php

namespace App;

use App\BaseModel;

class Permission extends BaseModel
{
    protected $fillable = [
        'name',
        'slug'
    ];

    public function roles()
    {
        // return $this->belongsToMany('App\Role', 'roles_permissions');
        return $this->belongsToMany('App\Role')->using('App\RolePermission');
    }
}
