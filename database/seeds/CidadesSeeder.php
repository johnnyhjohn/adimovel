<?php

use Illuminate\Database\Seeder;
use App\Cidades;

class CidadesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      for ($i=0; $i < 10; $i++) {
        Cidades::create(array(
          'nm_cidade'    => 'Cidade '.$i,
          'id_estado'   => 1,
          'ativo'  => 'true'
        ));
      }
    }
}
