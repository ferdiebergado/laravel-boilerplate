<?php

namespace App;

use App\BaseModel;

class Role extends BaseModel
{
    protected $fillable = [
        'name',
        'slug'
    ];
    
    public function permissions()
    {
        return $this->belongsToMany('App\Permission', 'roles_permissions');
    }
}
