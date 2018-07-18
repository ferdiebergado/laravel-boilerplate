<?php

use Illuminate\Database\Seeder;
use App\Permission;
use App\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $create_roles = Permission::where('slug', 'create-roles')->first();
        $list_roles = Permission::where('slug', 'list-roles')->first();
        $edit_roles = Permission::where('slug', 'edit-roles')->first();
        $delete_roles = Permission::where('slug', 'delete-roles')->first();

        $role_manager_role = new Role();
        $role_manager_role->slug = 'role-manager';
        $role_manager_role->name = 'Role Manager';
        $role_manager_role->save();
        $role_manager_role->permissions()->attach($create_roles);
        $role_manager_role->permissions()->attach($list_roles);
        $role_manager_role->permissions()->attach($edit_roles);
        $role_manager_role->permissions()->attach($delete_roles);

        $admin_role = Role::where('slug', 'administrator')->first();
        $admin_role->permissions()->attach($create_roles);
        $admin_role->permissions()->attach($list_roles);
        $admin_role->permissions()->attach($edit_roles);
        $admin_role->permissions()->attach($delete_roles);
    }
}
