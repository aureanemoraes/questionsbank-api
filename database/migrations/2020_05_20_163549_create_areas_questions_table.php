<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAreasQuestionsTable extends Migration
{
    public function up()
    {
        Schema::create('areas_questions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('question_id');
            $table->foreign('question_id')->references('id')
                ->on('questions');
            $table->unsignedBigInteger('area_id');
            $table->foreign('area_id')->references('id')
                ->on('areas');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('areas_questions');
    }
}
