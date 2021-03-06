<?php

namespace App\Services;

use App\Login;

/**
 * RolePermissionService
 */
class LoginService
{
    /**
     * Delete logins associated with a user.
     *
     * @param [integer] $id
     * @return void
     */
    public static function handleDelete($id)
    {
        return Login::withTrashed()->where('user_id', $id)->forceDelete();
    }
}
