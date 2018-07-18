<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class, 100)->create();

        $roles = App\Role::all();

        App\User::where('id', '<>', 1)->each(function ($user) use ($roles) {
            $user->roles()->sync(
                $roles->random(rand(1, 2))->pluck('id')->toArray()
            );
        });

        $permissions = App\Permission::all();

        App\User::where('id', '<>', 1)->each(function ($user) use ($permissions) {
            $user->permissions()->sync(
                $permissions->random(rand(1, 5))->pluck('id')->toArray()
            );
        });
    }
}
