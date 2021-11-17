<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BloodsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('bloods')->delete();

        $bgs = ['O-', 'O+', 'A+', 'A-', 'B+', 'B-', 'AB+', 'AB-'];

        foreach($bgs as  $bg){
            \App\Models\Blood::create(['Name' => $bg]);
        }
    }
}
