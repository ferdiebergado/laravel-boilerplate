<?php

use Illuminate\Database\Seeder;
use App\Permission;
use App\Role;

class UserRoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $create_users = Permission::where('slug', 'create_users')->first();
        $list_users = Permission::where('slug', 'list_users')->first();
        $edit_users = Permission::where('slug', 'edit_users')->first();
        $delete_users = Permission::where('slug', 'delete_users')->first();

        $user_manager_role = new Role();
        $user_manager_role->slug = 'user-manager';
        $user_manager_role->name = 'User Manager';
        $user_manager_role->save();
        $user_manager_role->permissions()->attach($create_users);
        $user_manager_role->permissions()->attach($list_users);
        $user_manager_role->permissions()->attach($edit_users);
        $user_manager_role->permissions()->attach($delete_users);

        $admin_role = Role::where('slug', 'administrator')->first();
        $admin_role->permissions()->attach($create_users);
        $admin_role->permissions()->attach($list_users);
        $admin_role->permissions()->attach($edit_users);
        $admin_role->permissions()->attach($delete_users);
    }
}
