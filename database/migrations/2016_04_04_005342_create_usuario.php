<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsuario extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuarios', function(Blueprint $table){
            $table->increments('id');
            $table->string('nm_usuario');
            $table->string('nr_cpf')->unique();
            $table->string('email')->unique();
            $table->string('nr_telefone')->nullable();
            $table->char('tp_funcionario', 3);
            $table->string('password');
            $table->boolean('admin');
            $table->boolean('ativo');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('usuarios');
    }
}
