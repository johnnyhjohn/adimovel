<?php

use Illuminate\Database\Seeder;
use App\Pessoa;

class PessoaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i < 2; $i++) {
              Pessoa::create(array(
                'nm_pessoa'         => 'Pessoa'.$i,
                'dt_nascimento'     => '2016-01-01',
                'nr_cpf'            => '534.412.978-'.$i,
                'nr_rg'             => '78.324.549-'.$i,
                'nr_telefone'       => '3222-222'.$i,
                'email'             => 'email'.$i.'@email.com',
                'id_cidade'         => 1,
                'endereco'          => 'Av xpto '.$i,
                'bairro'            => 'Bairro',
                'nr_endereco'       => '10'.$i,
                'nr_cep'            => '84030220',
                'ativo'             => true,
              ));
        }
      
    }
}
