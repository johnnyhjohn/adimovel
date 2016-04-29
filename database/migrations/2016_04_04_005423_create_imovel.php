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
            $table->integer('tp_imovel')->unsigned();
            $table->foreign('tp_imovel')->references('id')->on('tp_imovels');
            $table->string('titulo_anuncio');
            $table->integer('id_proprietario')->unsigned();
            $table->foreign('id_proprietario')->references('id')->on('pessoas');
            $table->integer('id_corretor')->unsigned();
            $table->foreign('id_corretor')->references('id')->on('usuarios');
            $table->string('codigo_interno');
            $table->string('endereco');
            $table->integer('nm_endereco');
            $table->string('bairro');
            $table->integer('cidade')->unsigned();
            $table->foreign('cidade')->references('id')->on('cidades');
            $table->string('nm_cep');
            $table->string('area');
            $table->integer('qt_quartos');
            $table->integer('qt_banheiros');
            $table->integer('qt_vagasgaragem');
            $table->string('referencia')->nullabel();
            $table->string('descricao')->nullabel();
            $table->double('valor',20,2);
            $table->boolean('vitrine');
            $table->boolean('financiamento');
            $table->date('dt_cadastrado');
            $table->string('latitude')->nullabel();
            $table->string('longitude')->nullabel();
            $table->char('situacao_imovel', 3);
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
        Schema::drop('imovels');
    }
}
