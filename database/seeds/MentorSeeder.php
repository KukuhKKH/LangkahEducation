<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class MentorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Mentor::class, 100)->create()->each(function($user) {
            $id = $user->user_id;
            $user = User::find($id);
            $user->assignRole('mentor');
        });
    }
}
