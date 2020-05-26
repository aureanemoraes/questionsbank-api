<?php

use Illuminate\Database\Seeder;

class AnswerTypeSeeder extends Seeder
{
    public function run()
    {
        DB::table('answer_types')->insert([
            'name' => 'Única escolha',
            'slug' => 'unica-escolha',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('answer_types')->insert([
            'name' => 'Múltipla escolha',
            'slug' => 'multipla-escolha',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('answer_types')->insert([
            'name' => 'Discursiva',
            'slug' => 'discursiva',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
