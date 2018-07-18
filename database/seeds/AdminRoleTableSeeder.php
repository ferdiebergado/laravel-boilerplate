<?php

use Illuminate\Database\Seeder;
use App\Permission;
use App\Role;

class AdminRoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin_role = new Role();
        $admin_role->slug = 'administrator';
        $admin_role->name = 'Administrator';
        $admin_role->save();
    }
}
