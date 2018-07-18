<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Interfaces\RoleRepositoryInterface as RoleRepository;

class RolesComposer
{
    /**
     * The role repository implementation.
     *
     * @var RoleRepository
     */
    protected $roles;

    /**
     * Create a new profile composer.
     *
     * @param  RoleRepository  $roles
     * @return void
     */
    public function __construct(RoleRepository $roles)
    {
        // Dependencies automatically resolved by service container...
        $this->roles = $roles;
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('roles', $this->roles->all());
    }
}
