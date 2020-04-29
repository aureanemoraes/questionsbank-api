<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class AreaSeeder extends Seeder
{
    public function run()
    {
        DB::table('areas')->insert([
            'name' => 'enem',
            'slug' => 'enem',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('areas')->insert([
            'name' => 'eja fundamental',
            'slug' => 'eja-fundamental',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('areas')->insert([
            'name' => 'eja médio',
            'slug' => 'eja-medio',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
