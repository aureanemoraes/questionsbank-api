<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->string('cpf')->unique();
            $table->primary('cpf');
            $table->string('name');
            $table->string('email')->nullable()->unique();
            $table->string('password');
    /**
     *  O campo verified_at servirá para validar o usuário:
     *  Professor: verificará se é válido no sigeduc e preencherá o sigeduc_id
     *  Aluno: confirmação pelo sigeduc e preencherá o sigeduc_id ou por
     * verificação de e-mail
     */
            $table->timestamp('verified_at')->nullable();
            $table->integer('level')->default(2);
            $table->bigInteger('sigeduc_id')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}
