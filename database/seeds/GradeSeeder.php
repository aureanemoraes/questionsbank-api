<?php

use Illuminate\Database\Seeder;

class GradeSeeder extends Seeder
{
    public function run()
    {
        DB::table('grades')->insert([
            'name' => 'Fundamental II',
            'year' => 6,
            'slug' => 'fundamental-ii-6',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('grades')->insert([
            'name' => 'Fundamental II',
            'year' => 7,
            'slug' => 'fundamental-ii-7',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('grades')->insert([
            'name' => 'Fundamental II',
            'year' => 8,
            'slug' => 'fundamental-ii-8',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('grades')->insert([
            'name' => 'Ensino Médio',
            'year' => 1,
            'slug' => 'ensino-medio-1',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('grades')->insert([
            'name' => 'Ensino Médio',
            'year' => 2,
            'slug' => 'ensino-medio-2',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
