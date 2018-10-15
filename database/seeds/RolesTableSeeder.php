<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!\App\Role::count()) {
            $roles = config('auth.roles');

            foreach($roles as $role) {
                resolve(\App\Role::class)->createRole($role);
            }
        }
    }
}
