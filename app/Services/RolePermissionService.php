<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\User;

/**
 * RolePermissionService
 */
class RolePermissionService
{
    /**
     * Handle saving of roles and permissions
     * @param  Illuminate\Http\Request $request [Instance of the request containing the input fields]
     * @param  App\User    $user    [Instance of the model to be updated/saved]
     * @param  string  $method  [The method to be used to save the many-to-many relation (attach/sync)]
     * @return Illuminate\Database\Eloquent\Model
     */
    public static function handleSave(Request $request, User $user, $method = 'attach')
    {
        $attributes = ['roles', 'permissions'];
        foreach ($attributes as $attribute) {
            if ($request->filled($attribute)) {
                foreach (array($request->{$attribute}) as $id) {
                    $model = title_case(str_singular($attribute));
                    $data = app('App\\'.$model)->findOrFail($id);
                    $user->{$attribute}()->{$method}($data);
                }
            }
        }
        return $user;
    }
}
