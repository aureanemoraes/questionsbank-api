<?php

use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    public function run()
    {
        DB::table('subjects')->insert([
            'name' => 'Matemática',
            'grade_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('subjects')->insert([
            'name' => 'Português',
            'grade_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('subjects')->insert([
            'name' => 'História',
            'grade_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('subjects')->insert([
            'name' => 'Matemática',
            'grade_id' => 2,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('subjects')->insert([
            'name' => 'Português',
            'grade_id' => 2,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('subjects')->insert([
            'name' => 'História',
            'grade_id' => 2,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
