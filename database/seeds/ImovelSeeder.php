<?php

use Illuminate\Database\Seeder;
use App\Imovel;

class ImovelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i < 2; $i++) {
            Imovel::create(array(
            'tp_imovel'         => 1,
            'titulo_anuncio'    => 'Imóvel '.$i,
            'id_proprietario'   => 1,
            'id_corretor'       => 2,
            'codigo_interno'    => '123-'.$i,
            'endereco'          => 'Av. xurupita',
            'nm_endereco'       => '10'.$i,
            'bairro'            => 'Bairro XV',
            'cidade'            => 1,
            'nm_cep'            => '123565'.$i,
            'area'              => '124'.$i,
            'qt_quartos'        => $i,
            'qt_banheiros'      => $i,
            'qt_vagasgaragem'   => $i,
            'referencia'        => '',
            'descricao'         => '',
            'valor'             => 2000.00,
            'vitrine'           => true,
            'financiamento'     => true,
            'reservado'         => false,
            'dt_cadastrado'     => '2016-01-01',
            'latitude'          => '-25.0993621',
            'longitude'         => '-50.1584514',
            'finalidade'        => 'AMB',
            'ativo'             => true
            
            ));
        }
      
    }
}
