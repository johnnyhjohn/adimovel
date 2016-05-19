<?php

namespace App\Http\ViewObject;
use App\Movimentacao;

use App\Http\ViewObject\ContratoVO;
use App\Contrato;

//use App\Http\ViewObject\MovimentacaoVO;
//use App\Movimentacao;

class MovimentacaoVO
{
  public $id;
  public $contrato;
  public $valor;
  public $mes;
  public $ano;
  public $dt_movimentacao;
  public $descricao;
  public $movimentacoes;

  public function __construct(Movimentacao $obj = null){
    if($obj != null){
      $this->convertFromEntity($obj);
    }
  }

  public function convertFromEntity(Movimentacao $obj){
    $this->id                 = $obj->id;
    $this->contrato           = new ContratoVO(Contrato::find($obj->id_contrato));
    $this->valor              = $obj->valor;
    $this->mes                = $obj->mes;
    $this->ano                = $obj->ano;
    $this->dt_movimentacao    = $obj->dt_movimentacao;
    $this->descricao          = $obj->descricao;
    $this->movimentacoes      = $obj->movimentacoes;
  }

  public function convertToEntity(){
    $obj = new Movimentacao();
    $obj->id                  = $this->id;
    $obj->id_contrato         = $this->contrato->convertToEntity()->id;
    $obj->valor               = $this->valor;
    $obj->mes                 = $this->mes;
    $obj->ano                 = $this->ano;
    $obj->dt_movimentacao     = $this->dt_movimentacao;
    $obj->descricao           = $this->descricao;
    $obj->id_movimentacao     = $this->movimentacao->convertToEntity()->id;
    $obj->movimentacoes       = $this->movimentacoes;
    
    return $obj;
  }

}
