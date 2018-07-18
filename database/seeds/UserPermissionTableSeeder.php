<?php

use Illuminate\Database\Seeder;
use App\Permission;
use App\Role;

class UserPermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user_manager_role = Role::where('slug', 'user-manager')->first();
        $admin_role = Role::where('slug', 'administrator')->first();

        $create_users = new Permission();
        $create_users->slug = 'create-users';
        $create_users->name = 'Create Users';
        $create_users->save();
        $create_users->roles()->attach($user_manager_role);
        $create_users->roles()->attach($admin_role);

        $list_users = new Permission();
        $list_users->slug = 'list-users';
        $list_users->name = 'List Users';
        $list_users->save();
        $list_users->roles()->attach($user_manager_role);
        $list_users->roles()->attach($admin_role);

        $edit_users = new Permission();
        $edit_users->slug = 'edit-users';
        $edit_users->name = 'Edit Users';
        $edit_users->save();
        $edit_users->roles()->attach($user_manager_role);
        $edit_users->roles()->attach($admin_role);

        $delete_users = new Permission();
        $delete_users->slug = 'delete-users';
        $delete_users->name = 'Delete Users';
        $delete_users->save();
        $delete_users->roles()->attach($user_manager_role);
        $delete_users->roles()->attach($admin_role);
    }
}
