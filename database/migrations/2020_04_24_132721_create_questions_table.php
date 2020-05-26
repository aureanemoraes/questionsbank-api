<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionsTable extends Migration
{
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->unsignedBigInteger('answer_type_id');
            $table->foreign('answer_type_id')->references('id')
                ->on('answer_types')
                ->onUpdate('restrict')
                ->onDelete('cascade');
            $table->unsignedBigInteger('question_level_id');
            $table->foreign('question_level_id')->references('id')
                ->on('question_levels')
                ->onUpdate('restrict')
                ->onDelete('cascade');
            $table->unsignedBigInteger('teacher_id');
            $table->foreign('teacher_id')->references('id')
                ->on('users')
                ->onUpdate('restrict')
                ->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('questions');
    }
}
