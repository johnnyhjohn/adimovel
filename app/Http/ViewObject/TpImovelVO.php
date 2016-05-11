<?php

namespace App\Http\ViewObject;
use App\TpImovel;

class TpImovelVO
{
  public $id;
  public $titulo;
  public $ativo;

  public function __construct(TpImovel $obj = null){
    if($obj != null){
      $this->convertFromEntity($obj);
    }
  }

  public function convertFromEntity(TpImovel $obj){
    $this->id  = $obj->id;
    $this->titulo = $obj->titulo;
    $this->ativo = $obj->ativo;
  }

  public function convertToEntity(){
    $obj = new TpImovel();
    $obj->id  = $this->id;
    $obj->titulo = $this->titulo;
    $obj->ativo = $this->ativo;

    return $obj;
  }

}
