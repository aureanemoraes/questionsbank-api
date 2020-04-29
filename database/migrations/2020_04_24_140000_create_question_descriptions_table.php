<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionDescriptionsTable extends Migration
{
    public function up()
    {
        Schema::create('question_descriptions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('description');
            $table->unsignedBigInteger('question_id');
            $table->foreign('question_id')->references('id')
                ->on('questions')
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('question_descriptions');
    }
}
