<?php

namespace App\Http\ViewObject;
use App\Usuario;

class UsuarioVO
{
  public $id;
  public $nome;
  public $tipo_funcionario;
  public $email;
  public $cpf;
  public $telefone;
  public $senha;
  public $admin;
  public $status;

    public function __construct(Pessoa $obj = null){
        if($obj != null){
            $this->convertFromEntity($obj);
        }
    }

    public function convertFromEntity(Pessoa $obj)
    {
        $this->id       = $obj->id;
        $this->nome     = $obj->nome;
        $this->cpf      = $obj->cpf;
        $this->senha    = $obj->senha;
        $this->email    = $obj->email;
        $this->telefone = $obj->telefone;
        $this->status   = $obj->status;
        $this->tipo_funcionario = $obj->tipo_funcionario;
    }

    public function convertToEntity(){
        $obj            = new Pessoa();
        $obj->id        = $this->id;
        $obj->nome      = $this->nome;
        $obj->senha     = $this->senha;
        $obj->cpf       = $this->cpf
        $obj->email     = $this->email;
        $obj->telefone  = $this->telefone;
        $obj->tipo_funcionario = $this->tipo_funcionario;
        $obj->status    = $this->status;

        return $obj;
    }
}