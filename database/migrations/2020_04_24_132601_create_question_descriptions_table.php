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
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('question_descriptions');
    }
}
