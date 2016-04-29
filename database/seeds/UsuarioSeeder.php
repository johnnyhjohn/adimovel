<?php

use Illuminate\Database\Seeder;
use App\Usuario;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

      Usuario::create(array(
        'nm_usuario'        => 'Admin',
        'email'             => 'admin@admin.com',
        'nr_cpf'            => '12312312311',
        'nr_telefone'       => '123123123',
        'tp_funcionario'    => 'ADM',
        'password'          => \Hash::make('admin'),
        'admin'             => true,
        'ativo'             => true
      ));
      
    }
}
