<?php

use Illuminate\Database\Seeder;
use App\Estado;

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
      for ($i=0; $i < 28; $i++) {
        

        Estado::create(array(
          'nome'    => 'Estado '.$i.' ok !',
          'sigla'   => $i,
          'status'  => 'true'
        ));
      }
    }
}
