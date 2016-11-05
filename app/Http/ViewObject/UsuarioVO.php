<?php

namespace App\Http\ViewObject;
use App\Usuario;

class UsuarioVO
{
  public $id;
  public $nm_usuario;
  public $tp_funcionario;
  public $email;
  public $foto;
  public $nr_cpf;
  public $nr_telefone;
  public $senha;
  public $admin;
  public $ativo;

    public function __construct(Usuario $obj = null){
        if($obj != null){
            $this->convertFromEntity($obj);
        }
    }

    public function convertFromEntity(Usuario $obj)
    {
        $this->id             = $obj->id;
        $this->nm_usuario     = $obj->nm_usuario;
        $this->nr_cpf         = $obj->nr_cpf;
        $this->senha          = $obj->senha;
        $this->email          = $obj->email;
        $this->foto           = $obj->foto;
        $this->nr_telefone    = $obj->nr_telefone;
        $this->ativo          = $obj->ativo;
        $this->tp_funcionario = $obj->tp_funcionario;
    }

    public function convertToEntity(){
        $obj                  = new Usuario();
        $obj->id              = $this->id;
        $obj->nm_usuario      = $this->nm_usuario;
        $obj->senha           = $this->senha;
        $obj->nr_cpf          = $this->nr_cpf;
        $obj->email           = $this->email;
        $obj->foto            = $this->foto;
        $obj->nr_telefone     = $this->nr_telefone;
        $obj->tp_funcionario  = $this->tp_funcionario;
        $obj->ativo           = $this->ativo;

        return $obj;
    }
}