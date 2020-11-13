<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class SiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Siswa::class, 1000)->create()->each(function($user) {
            $id = $user->user_id;
            $user = User::find($id);
            $user->assignRole('siswa');
        });
    }
}
