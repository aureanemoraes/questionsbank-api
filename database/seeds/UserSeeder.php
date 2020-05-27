<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            'cpf' => '12345678910',
            'name'  => 'Estudante',
            'email' => 'estudante@teste.com',
            'password' => bcrypt('123456'),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('users')->insert([
            'cpf' => '12345678911',
            'name'  => 'Professor',
            'email' => 'professor@teste.com',
            'password' => bcrypt('123456'),
            'level' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
