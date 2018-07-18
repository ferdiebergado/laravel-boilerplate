<?php

use Illuminate\Database\Seeder;

class RolesPermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Role::class, 20)->create();
        factory(App\Permission::class, 50)->create();

        $roles = App\Role::all();

        App\Permission::all()->each(function ($permission) use ($roles) {
            $permission->roles()->sync(
                $roles->random(rand(1, 3))->pluck('id')->toArray()
            );
        });

        $permissions = App\Permission::all();

        App\Role::all()->each(function ($role) use ($permissions) {
            $role->permissions()->sync(
                $permissions->random(rand(1, 2))->pluck('id')->toArray()
            );
        });
    }
}
