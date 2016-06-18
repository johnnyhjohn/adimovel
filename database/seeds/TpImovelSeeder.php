<?php

use Illuminate\Database\Seeder;
use App\TpImovel;

class TpImovelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TpImovel::create(array(
          'titulo'    => 'Casa',
          'ativo'  => true
        ));
    }
}
