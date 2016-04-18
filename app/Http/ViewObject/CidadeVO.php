<?php

namespace App\Http\ViewObject;
use App\Http\ViewObject\EstadoVO;
use App\Cidades;
use App\Estados;

class CidadeVO
{
  public $id;
  public $nome;
  public $estado;
  public $status;

  public function __construct(Cidades $obj = null){
    if($obj != null){
      $this->convertFromEntity($obj);
    }
  }

  public function convertFromEntity(Cidades $obj){
    $this->id  = $obj->id;
    $this->nome = $obj->nome;
    $this->estado = new EstadoVO(Estados::find($obj->id));
    $this->status = $obj->status;
  }

  public function convertToEntity(){
    $obj = new Cidades();
    $obj->id  = $this->id;
    $obj->nome = $this->nome;
    $obj->estado_id = $this->estado->convertToEntity()->id;
    $obj->status = $this->status;

    return $obj;
  }

}