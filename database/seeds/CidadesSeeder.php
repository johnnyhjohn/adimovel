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
      for ($i=0; $i < 28; $i++) {
        Cidade::create(array(
          'nome'    => 'Cidade '.$i.' ok !',
          'estado'   => 1,
          'status'  => 'true'
        ));
      }
    }
}
