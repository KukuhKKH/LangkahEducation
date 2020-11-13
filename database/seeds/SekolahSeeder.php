<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class SekolahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Sekolah::class, 30)->create()->each(function($user) {
            $id = $user->user_id;
            $user = User::find($id);
            $user->assignRole('sekolah');
        });
    }
}
