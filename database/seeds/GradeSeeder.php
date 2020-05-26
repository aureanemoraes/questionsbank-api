<?php

use Illuminate\Database\Seeder;

class GradeSeeder extends Seeder
{
    public function run()
    {
        DB::table('grades')->insert([
            'name' => 'Fundamental II',
            'year' => 6,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('grades')->insert([
            'name' => 'Fundamental II',
            'year' => 7,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('grades')->insert([
            'name' => 'Fundamental II',
            'year' => 8,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('grades')->insert([
            'name' => 'Ensino Médio',
            'year' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('grades')->insert([
            'name' => 'Ensino Médio',
            'year' => 2,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
