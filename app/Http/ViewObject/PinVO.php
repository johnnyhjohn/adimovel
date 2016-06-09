<?php

namespace App\Http\ViewObject;
use App\Http\ViewObject\CidadeVO;
use App\Cidades;
use App\Pin;

class PinVO
{
  public $id;
  public $titulo;
  public $endereco;
  public $nr_endereco;
  public $nr_cep;
  public $bairro;
  public $id_cidade;
  public $observacao;
  public $latitude;
  public $longitude;
  public $ativo;

  public function __construct(Pin $obj = null)
  {
    if($obj != null){
        $this->convertFromEntity($obj);
    }
  }

  public function convertFromEntity(Pin $obj)
  {
    $this->id           = $obj->id;
    $this->titulo       = $obj->titulo;
    $this->endereco     = $obj->endereco;
    $this->nr_endereco  = $obj->nr_endereco;
    $this->nr_cep       = $obj->nr_cep;
    $this->bairro       = $obj->bairro;
    $this->observacao   = $obj->observacao;
    $this->latitude     = $obj->latitude;
    $this->longitude    = $obj->longitude;
    $this->id_cidade    = new CidadeVO(Cidades::find($obj->id_cidade));
    $this->ativo        = $obj->ativo;
  }

  public function convertToEntity()
  {
    $obj = new Pin();
    $obj->id          = $this->id;
    $obj->titulo      = $this->titulo;
    $obj->endereco    = $this->endereco;
    $obj->nr_endereco = $this->nr_endereco;
    $obj->bairro      = $this->bairro;
    $obj->nr_cep      = $this->nr_cep;
    $obj->observacao  = $this->observacao;
    $obj->latitude    = $this->latitude;
    $obj->longitude   = $this->longitude;
    $obj->id_cidade   = $this->id_cidade->convertToEntity()->id;
    $obj->ativo       = $this->ativo;

    return $obj;
  }

}