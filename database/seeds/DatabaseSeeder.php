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
        Model::unguard();

        //$this->call(EstadosSeeder::class);
        //$this->call(CidadesSeeder::class);
        
        Estados::create(array(
          'nm_estado'    => 'Estado 1 ok !',
          'uf'   => 1,
          'ativo'  => 'true'
        ));

        Cidades::create(array(
          'nm_cidade'    => 'Cidade 1 ok !',
          'id_estado'   => 1,
          'ativo'  => 'true'
        ));
        
        $this->call(UsuarioSeeder::class);

        Model::reguard();
    }
}
