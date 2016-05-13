<?php

namespace App\Http\ViewObject;
use App\ContratoAluguel;

use App\Http\ViewObject\ImovelVO;
use App\Imovel;

use App\Http\ViewObject\PessoaVO;
use App\Pessoa;

class AdministrarVO
{
  public $id;
  public $imovel;
  public $proprietario;
  public $inquilino;
  public $nr_contrato;
  public $dt_inicio;
  public $dt_vencimento;
  public $dt_revogado;
  public $valor;
  public $situacao_pagamento;
  public $ativo;
  public $finalidade;

  public function __construct(ContratoAluguel $obj = null){
    if($obj != null){
      $this->convertFromEntity($obj);
    }
  }

  public function convertFromEntity(ContratoAluguel $obj){
    $this->id                 = $obj->id;
    $this->imovel             = new ImovelVO(Imovel::find($obj->id_imovel));
    $this->proprietario       = new PessoaVO(Pessoa::find($obj->id_proprietario));
    $this->inquilino          = new PessoaVO(Pessoa::find($obj->id_inquilino));
    $this->nr_contrato        = $obj->nr_contrato;
    $this->dt_inicio          = $obj->dt_inicio;
    $this->dt_vencimento      = $obj->dt_vencimento;
    $this->dt_revogado        = $obj->dt_revogado;
    $this->valor              = $obj->valor;
    $this->situacao_pagamento = $obj->situacao_pagamento;
    $this->finalidade         = $obj->finalidade;
    $this->ativo              = $obj->ativo;
  }

  public function convertToEntity(){
    $obj = new ContratoAluguel();
    $obj->id                  = $this->id;
    $obj->id_imovel           = $this->imovel->convertToEntity()->id;
    $obj->id_proprietario     = $this->proprietario->convertToEntity()->id;
    $obj->id_inquilino        = $this->inquilino->convertToEntity()->id;
    $obj->nr_contrato         = $this->nr_contrato;
    $obj->dt_inicio           = $this->dt_inicio;
    $obj->dt_vencimento       = $this->dt_vencimento;
    $obj->dt_revogado         = $this->dt_revogado;
    $obj->valor               = $this->valor;
    $obj->situacao_pagamento  = $this->situacao_pagamento;
    $obj->ativo               = $this->ativo;
    $obj->finalidade          = $this->finalidade; 

    return $obj;
  }

}
