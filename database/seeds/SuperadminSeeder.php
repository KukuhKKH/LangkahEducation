<?php

use Illuminate\Database\Seeder;

class SuperadminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superadmin = [
            'name' => 'Superadmin',
            'password' => 'superadmin',
            'email' => 'superadmin@gmail.com',
            'api_token' => \Illuminate\Support\Str::random(10),
            'is_active' => 1
        ];

        $admin = [
            'name' => 'Admin',
            'password' => 'admin',
            'email' => 'admin@gmail.com',
            'api_token' => \Illuminate\Support\Str::random(10),
            'is_active' => 1
        ];

        $user1 = \App\Models\User::create($superadmin);
        $user1->assignRole('superadmin');
        $user2 = \App\Models\User::create($admin);
        $user2->assignRole('admin');
    }
}
