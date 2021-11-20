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
        $this->call(BloodsTableSeeder::class);
        $this->call(NationalitiesTableSeeder::class);
        $this->call(ReligionssTableSeeder::class);
        $this->call(SpecializationsTableSeeder::class);
    }
}
