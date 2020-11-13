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
        // $this->call(RoleSeeder::class);
        // $this->call(SuperadminSeeder::class);
        // $this->call(SiswaSeeder::class);
        $this->call(SekolahSeeder::class);
        $this->call(MentorSeeder::class);
    }
}
