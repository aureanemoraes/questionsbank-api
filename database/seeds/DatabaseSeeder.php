<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(AreaSeeder::class);
        $this->call(GradeSeeder::class);
        $this->call(SubjectSeeder::class);
        $this->call(TopicSeeder::class);
        $this->call(AnswerTypeSeeder::class);
        $this->call(QuestionLevelSeeder::class);

    }
}
