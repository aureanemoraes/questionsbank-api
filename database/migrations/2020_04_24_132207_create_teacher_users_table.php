<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeacherUsersTable extends Migration
{
    public function up()
    {
        Schema::create('teacher_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('cpf');
            $table->boolean('isValid')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('teacher_users');
    }
}
