<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Estados;
use App\Cidades;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserTableSeeder::class);
        
        Estados::create(array(
          'nome'    => 'Estado',
          'sigla'   => 'AA',
          'status'  => 'true'
        ));
        Cidades::create(array(
          'nome'    => 'Cidade',
          'estado'   => 1,
          'status'  => 'true'
        ));
    }
}
