<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

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

        $this->call(EstadosSeeder::class);
        $this->call(CidadesSeeder::class);        
        $this->call(UsuarioSeeder::class);
        $this->call(TpImovelSeeder::class);
        $this->call(PessoaSeeder::class);
        $this->call(ImovelSeeder::class);

        Model::reguard();
    }
}
