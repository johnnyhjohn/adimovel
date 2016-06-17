<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Pin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pins', function(Blueprint $table){
            $table->increments('id');
            $table->string('titulo');
            $table->string('endereco');
            $table->integer('nr_endereco');
            $table->string('bairro');
            $table->string('nr_cep', 8)->nullable();
            $table->integer('id_cidade')->unsigned();
            $table->foreign('id_cidade')->references('id')->on('cidades');
            $table->string('observacao');
            $table->string('latitude');
            $table->string('longitude');
            $table->boolean('ativo')->default(true);
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
        Schema::drop('pins');
    }
}
