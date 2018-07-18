<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AdminRoleTableSeeder::class);
        $this->call(UserRoleTableSeeder::class);
        $this->call(RoleTableSeeder::class);
        $this->call(UserPermissionTableSeeder::class);
        $this->call(PermissionTableSeeder::class);
        $this->call(UserTableSeeder::class);
        // $this->call(RolesPermissionsTableSeeder::class);
        // $this->call(UsersTableSeeder::class);
    }
}
