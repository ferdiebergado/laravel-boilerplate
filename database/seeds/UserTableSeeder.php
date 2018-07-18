<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\User;
use Illuminate\Support\Str;

class UserTableSeeder extends Seeder
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

        $admin = new User();
        $admin->name = 'admin';
        $admin->email = 'admin@example.com';
        $admin->password = 'letmein';
        $admin->verified = true;
        $admin->verified_at = now();
        $admin->setRememberToken(Str::random(60));
        $admin->save();
        $admin->roles()->attach($user_manager_role);
        $admin->roles()->attach($admin_role);

        $user = new User();
        $user->name = 'Default User';
        $user->email = 'user@example.com';
        $user->password = 'abc@123';
        $user->verified = true;
        $user->verified_at = now();
        $user->setRememberToken(Str::random(60));
        $user->save();
    }
}
