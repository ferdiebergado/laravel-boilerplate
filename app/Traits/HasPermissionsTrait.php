<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Collection;
use App\Permission;

trait HasPermissionsTrait
{
    public function roles()
    {
        return $this->belongsToMany('App\Role', 'users_roles');
    }

    public function permissions()
    {
        return $this->belongsToMany('App\Permission', 'users_permissions');
    }

    public function hasRole(...$roles)
    {
        foreach ($roles as $role) {
            if ($this->roles->contains('slug', $role)) {
                return true;
            }
        }
        return false;
    }

    public function hasPermissionTo($permission)
    {
        $permission = $this->findBySlug($permission);
        if (!is_null($permission)) {
            return $this->hasPermissionThroughRole($permission) || $this->hasPermission($permission);
        }
        return false;
    }

    public function hasPermission($permission)
    {
        return (bool) $this->permissions->where('slug', $permission->slug)->count();
    }

    protected function hasPermissionThroughRole(Permission $permission)
    {
        $roles = $permission->roles;
        if ($roles) {
            foreach ($roles as $role) {
                if ($this->roles->contains($role)) {
                    return true;
                }
            }
        }
        return false;
    }

    public function givePermissionsTo(...$permissions)
    {
        $permissions = $this->getAllPermissions($permissions);
        if ($permissions === null) {
            return $this;
        }
        $this->permissions()->attach($permissions);
        return $this;
    }

    public function assignRoles(...$roles)
    {
        $roles = $this->getAllRoles($roles);
        if ($roles === null) {
            return $this;
        }
        $this->roles()->attach($roles);
        return $this;
    }
    protected function getAllPermissions($permissions)
    {
        $perms = [];
        foreach ($permissions as $permission) {
            $perm = $this->findBySlug($permission);
            if ($perm) {
                array_push($perms, $perm->id);
            }
        }
        return $perms;
    }

    protected function getAllRoles($roles)
    {
        $r = [];
        foreach ($roles as $role) {
            $role = $this->findRoleBySlug($role);
            if ($role) {
                array_push($r, $role->id);
            }
        }
        return $r;
    }
    public function deletePermissions(...$permissions)
    {
        $permissions = $this->getAllPermissions($permissions);
        $this->permissions()->detach($permissions);
        return $this;
    }

    public function removeRoles(...$roles)
    {
        $roles = $this->getAllRoles($roles);
        $this->roles()->detach($roles);
        return $this;
    }

    private function findBySlug($slug)
    {
        return Permission::where('slug', $slug)->first();
    }

    private function findRoleBySlug($slug)
    {
        return Role::where('slug', $slug)->first();
    }
}
