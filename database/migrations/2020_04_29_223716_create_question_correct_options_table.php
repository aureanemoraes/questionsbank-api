<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionCorrectOptionsTable extends Migration
{
    public function up()
    {
        Schema::create('question_correct_options', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('question_id');
            $table->foreign('question_id')->references('id')
                ->on('questions')
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->unsignedBigInteger('option_id');
            $table->foreign('option_id')->references('id')
                ->on('options')
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('question_correct_options');
    }
}
