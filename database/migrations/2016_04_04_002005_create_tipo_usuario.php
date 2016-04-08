<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTipoUsuario extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('usuario', function(Blueprint $table){
        //     $table->increments('id');
        //     $table->string('nome');
        //     $table->char('tipo_funcionario', 3);
        //     $table->string('email')->unique();
        //     $table->string('senha');
        //     $table->boolean('admin');
        //     $table->boolean('status');
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
