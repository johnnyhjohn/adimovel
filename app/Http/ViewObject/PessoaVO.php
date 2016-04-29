<?php

namespace App\Http\ViewObject;
use App\Http\ViewObject\CidadeVO;
use App\Cidades;
use App\Pessoa;

class PessoaVO
{
  public $id;
  public $nome;
  public $tipo_pessoa;
  public $data_nascimento;
  public $cpf;
  public $rg;
  public $email;
  public $telefone;
  public $cep;
  public $bairro;
  public $endereco;
  public $cidade;
  public $status;

  public function __construct(Pessoa $obj = null)
  {
    if($obj != null){
        $this->convertFromEntity($obj);
    }
  }

  public function convertFromEntity(Pessoa $obj)
  {
    $this->id       = $obj->id;
    $this->nome     = $obj->nome;
    $this->cpf      = $obj->cpf;
    $this->rg       = $obj->rg;
    $this->email    = $obj->email;
    $this->telefone = $obj->telefone;
    $this->cep      = $obj->cep;
    $this->bairro      = $obj->bairro;
    $this->endereco = $obj->endereco;
    $this->tipo_pessoa = $obj->tipo_pessoa;
    $this->data_nascimento = $obj->data_nascimento;
    $this->cidade = new CidadeVO(Cidades::find($obj->cidade));
    $this->status = $obj->status;
  }

  public function convertToEntity()
  {
    $obj = new Pessoa();
    $obj->id      = $this->id;
    $obj->nome    = $this->nome;
    $obj->cpf     = $this->cpf;
    $obj->rg      = $this->rg;
    $obj->email   = $this->email;
    $obj->telefone= $this->telefone;
    $obj->cep     = $this->cep;
    $obj->bairro  = $this->bairro;
    $obj->endereco= $this->endereco;
    $obj->tipo_pessoa = $this->tipo_pessoa;
    $obj->data_nascimento = $this->data_nascimento;
    $obj->cidade = $this->cidade->convertToEntity()->id;
    $obj->status = $this->status;

    return $obj;
  }

}