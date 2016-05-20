<?php

namespace App\Http\ViewObject;
use App\Recibo;

use App\Http\ViewObject\UsuarioVO;
use App\Usuario;

use App\Http\ViewObject\PessoaVO;
use App\Pessoa;

use App\Http\ViewObject\MovimentacaoVO;
use App\Movimentacao;

class ReciboVO
{
  public $id;
  public $usuario;
  public $proprietario;
  public $inquilino;
  public $valor;
  public $mes;
  public $ano;
  public $dt_emissao;
  public $descricao;
  public $movimentacao;
  public $ativo;

  public function __construct(Recibo $obj = null){
    if($obj != null){
      $this->convertFromEntity($obj);
    }
  }

  public function convertFromEntity(Recibo $obj){
    $this->id                 = $obj->id;
    $this->usuario             = new UsuarioVO(Usuario::find($obj->id_usuario));
    $this->proprietario       = new PessoaVO(Pessoa::find($obj->id_proprietario));
    $this->inquilino          = new PessoaVO(Pessoa::find($obj->id_inquilino));
    $this->valor              = $obj->valor;
    $this->mes                = $obj->mes;
    $this->ano                = $obj->ano;
    $this->dt_emissao         = $obj->dt_emissao;
    $this->descricao          = $obj->descricao;
    $this->movimentacao       = new MovimentacaoVO(Movimentacao::find($obj->id_movimentacao));
    $this->ativo              = $obj->ativo;
  }

  public function convertToEntity(){
    $obj = new Recibo();
    $obj->id                  = $this->id;
    $obj->id_usuario          = $this->usuario->convertToEntity()->id;
    $obj->id_proprietario     = $this->proprietario->convertToEntity()->id;
    $obj->id_inquilino        = $this->inquilino->convertToEntity()->id;
    $obj->valor               = $this->valor;
    $obj->mes                 = $this->mes;
    $obj->ano                 = $this->ano;
    $obj->dt_emissao          = $this->dt_emissao;
    $obj->descricao           = $this->descricao;
    $obj->id_movimentacao     = $this->movimentacao->convertToEntity()->id;
    $obj->ativo               = $this->ativo;
    
    return $obj;
  }

}
