<?php

namespace App\Http\ViewObject;
use App\Http\ViewObject\CidadeVO;
use App\Cidades;
use App\Pessoa;

class PessoaVO
{
  public $id;
  public $cod_pessoa;
  public $nm_pessoa;
  public $tp_pessoa;
  public $dt_nascimento;
  public $nr_cpf;
  public $nr_rg;
  public $email;
  public $nr_telefone;
  public $nr_cep;
  public $bairro;
  public $endereco;
  public $id_cidade;
  public $ativo;

  public function __construct(Pessoa $obj = null)
  {
    if($obj != null){
        $this->convertFromEntity($obj);
    }
  }

  public function convertFromEntity(Pessoa $obj)
  {
    $this->id           = $obj->id;
    $this->cod_pessoa   = $obj->cod_pessoa;
    $this->nm_pessoa    = $obj->nm_pessoa;
    $this->nr_cpf       = $obj->nr_cpf;
    $this->nr_rg        = $obj->nr_rg;
    $this->email        = $obj->email;
    $this->nr_telefone  = $obj->nr_telefone;
    $this->nr_cep       = $obj->nr_cep;
    $this->bairro       = $obj->bairro;
    $this->endereco     = $obj->endereco;
    $this->tp_pessoa    = $obj->tp_pessoa;
    $this->dt_nascimento = $obj->dt_nascimento;
    $this->id_cidade    = new CidadeVO(Cidades::find($obj->id_cidade));
    $this->ativo        = $obj->ativo;
  }

  public function convertToEntity()
  {
    $obj = new Pessoa();
    $obj->id          = $this->id;
    $obj->cod_pessoa  = $this->cod_pessoa;
    $obj->nm_pessoa   = $this->nm_pessoa;
    $obj->nr_cpf      = $this->nr_cpf;
    $obj->nr_rg       = $this->nr_rg;
    $obj->email       = $this->email;
    $obj->nr_telefone = $this->nr_telefone;
    $obj->nr_cep      = $this->nr_cep;
    $obj->bairro      = $this->bairro;
    $obj->endereco    = $this->endereco;
    $obj->tp_pessoa   = $this->tp_pessoa;
    $obj->dt_nascimento = $this->dt_nascimento;
    $obj->id_cidade   = $this->id_cidade->convertToEntity()->id;
    $obj->ativo       = $this->ativo;

    return $obj;
  }

}