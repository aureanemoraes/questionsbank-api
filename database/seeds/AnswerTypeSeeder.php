<?php

use Illuminate\Database\Seeder;

class AnswerTypeSeeder extends Seeder
{
    public function run()
    {
        DB::table('answer_types')->insert([
            'name' => 'Objetiva',
            'slug' => 'objetiva',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('answer_types')->insert([
            'name' => 'Subjetiva',
            'slug' => 'subjetiva',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
