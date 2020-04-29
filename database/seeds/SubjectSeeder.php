<?php

use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    public function run()
    {
        DB::table('subjects')->insert([
            'name' => 'Matemática',
            'slug' => 'matematica',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('subjects')->insert([
            'name' => 'Português',
            'slug' => 'portugues',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('subjects')->insert([
            'name' => 'História',
            'slug' => 'historia',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
