<?php

use Illuminate\Database\Seeder;

class QuestionLevelSeeder extends Seeder
{
    public function run()
    {
        DB::table('question_levels')->insert([
            'name' => 'Fácil',
            'slug' => 'facil',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('question_levels')->insert([
            'name' => 'Intermediário',
            'slug' => 'intermediario',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
