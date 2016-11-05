<?php

namespace App\Http\ViewObject;
use App\Http\ViewObject\ImovelVO;
use App\Imovel;
use App\FotoImovel;

class FotoImovelVO
{
  public $id;
  public $imovel;
  public $foto;
  public $status;

  public function __construct(FotoImovel $obj = null){
    if($obj != null){
      $this->convertFromEntity($obj);
    }
  }

  public function convertFromEntity(FotoImovel $obj){
    $this->id  = $obj->id;
    $this->foto = $obj->foto;
    $this->imovel = new ImovelVO(Imovel::find($obj->id_imovel));
    $this->status = $obj->status;
  }

  public function convertToEntity(){
    $obj = new FotoImovel();
    $obj->id  = $this->id;
    $obj->foto = $this->foto;
    $obj->imovel = $this->id_imovel->convertToEntity()->id;
    $obj->status = $this->status;

    return $obj;
  }

}