<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTopicsQuestionsTable extends Migration
{
    public function up()
    {
        Schema::create('topics_questions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('question_id');
            $table->foreign('question_id')->references('id')
                ->on('questions');
            $table->unsignedBigInteger('topic_id');
            $table->foreign('topic_id')->references('id')
                ->on('topics');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('topics_questions');
    }
}
