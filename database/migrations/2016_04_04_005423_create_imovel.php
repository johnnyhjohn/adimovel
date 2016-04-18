<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImovel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('imovels', function(Blueprint $table){
            $table->increments('id');
            $table->string('titulo_anuncio');
            $table->char('situacao', 3);
            $table->string('codigo_interno');
            $table->string('endereco');
            $table->string('bairro');
            $table->string('cep');
            $table->integer('numero');
            $table->string('area');
            $table->integer('qtd_quartos');
            $table->integer('qtd_banheiros');
            $table->integer('qtd_garagem');
            $table->string('referencia')->nullabel();
            $table->string('descricao')->nullabel();
            $table->string('latitude')->nullabel();
            $table->string('longitude')->nullabel();
            $table->string('list_fotos')->nullabel();
            $table->double('valor',20,2);
            $table->boolean('vitrine');
            $table->boolean('financiamento');
            $table->boolean('admin');
            $table->boolean('status');
            $table->integer('cidade')->unsigned();
            $table->foreign('cidade')->references('id')->on('cidades');
            $table->integer('tipo_imovel')->unsigned();
            $table->foreign('tipo_imovel')->references('id')->on('tipo_imovels');
            $table->integer('proprietario')->unsigned();
            $table->foreign('proprietario')->references('id')->on('pessoas');
            $table->integer('corretor')->unsigned();
            $table->foreign('corretor')->references('id')->on('usuarios');            
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
        Schema::drop('imovels');
    }
}
