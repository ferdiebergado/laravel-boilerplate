<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Interfaces\PermissionRepositoryInterface as PermissionRepository;

class PermissionsComposer
{
    /**
     * The permissions repository implementation.
     *
     * @var PermissionsRepository
     */
    protected $permissions;

    /**
     * Create a new permission composer.
     *
     * @param  PermissionRepository  $permissions
     * @return void
     */
    public function __construct(PermissionRepository $permissions)
    {
        // Dependencies automatically resolved by service container...
        $this->permissions = $permissions;
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('permissions', $this->permissions->all());
    }
}
