<?php

namespace App\Http\ViewObject;
use App\Estados;

class EstadoVO
{
  public $id;
  public $nome;
  public $sigla;
  public $status;

  public function __construct(Estados $obj = null){
    if($obj != null){
      $this->convertFromEntity($obj);
    }
  }

  public function convertFromEntity(Estados $obj){
    $this->id  = $obj->id;
    $this->nome = $obj->nome;
    $this->sigla = $obj->sigla;
    $this->status = $obj->status;
  }

  public function convertToEntity(){
    $obj = new Estado();
    $obj->id  = $this->id;
    $obj->nome = $this->nome;
    $obj->sigla = $this->sigla;
    $obj->status = $this->status;

    return $obj;
  }

}
