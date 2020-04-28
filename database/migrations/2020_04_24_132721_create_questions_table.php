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
            $table->unsignedBigInteger('question_description_id');
            $table->foreign('question_description_id')->references('id')
                ->on('question_descriptions')
                ->onUpdate('cascade')
                ->onDelete('restrict');
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
            $table->string('user_cpf');
            $table->foreign('user_cpf')->references('cpf')
                ->on('users')
                ->onUpdate('restrict')
                ->onDelete('cascade');
            $table->unsignedBigInteger('area_id');
            $table->foreign('area_id')->references('id')->on('areas')
                ->onUpdate('cascade')
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
