<?php

use Illuminate\Database\Seeder;

class TopicSeeder extends Seeder
{
    public function run()
    {
        DB::table('topics')->insert([
            'name' => 'Logarítimo',
            'slug' => 'logaritimo',
            'subject_id' => 1,
            'grade_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('topics')->insert([
            'name' => 'função de primeiro grau',
            'slug' => 'funcao-de-primeiro-grau',
            'subject_id' => 1,
            'grade_id' => 2,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('topics')->insert([
            'name' => '1 guerra mundial',
            'slug' => '1-guerra-mundial',
            'subject_id' => 3,
            'grade_id' => 4,
            'created_at' => now(),
            'updated_at' => now()
        ]);

    }
}
