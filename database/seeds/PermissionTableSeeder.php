<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_manager_role = Role::where('slug', 'role-manager')->first();
        $admin_role = Role::where('slug', 'administrator')->first();

        $create_roles = new Permission();
        $create_roles->slug = 'create-roles';
        $create_roles->name = 'Create Roles';
        $create_roles->save();
        $create_roles->roles()->attach($role_manager_role);
        $create_roles->roles()->attach($admin_role);

        $list_roles = new Permission();
        $list_roles->slug = 'list-roles';
        $list_roles->name = 'List roles';
        $list_roles->save();
        $list_roles->roles()->attach($role_manager_role);
        $list_roles->roles()->attach($admin_role);

        $edit_roles = new Permission();
        $edit_roles->slug = 'edit-roles';
        $edit_roles->name = 'Edit roles';
        $edit_roles->save();
        $edit_roles->roles()->attach($role_manager_role);
        $edit_roles->roles()->attach($admin_role);

        $delete_roles = new Permission();
        $delete_roles->slug = 'delete-roles';
        $delete_roles->name = 'Delete roles';
        $delete_roles->save();
        $delete_roles->roles()->attach($role_manager_role);
        $delete_roles->roles()->attach($admin_role);
    }
}
