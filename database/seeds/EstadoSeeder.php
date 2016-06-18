<?php

use Illuminate\Database\Seeder;
use App\Estados;

class EstadosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      //DB::table('estados')->delete();
      for ($i=0; $i < 4; $i++) {
        Estados::create(array(
          'nm_estado'    => 'Estado '.$i,
          'uf'   => 'a'.$i,
          'ativo'  => 'true'
        ));
      }
    }
}
