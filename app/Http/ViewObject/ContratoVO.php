<?php

namespace App\Http\ViewObject;
use App\Movimentacao;
use App\Http\ViewObject\MovimentacaoVO;

use App\Http\ViewObject\ContratoVO;
use App\Contrato;

use App\Http\ViewObject\ImovelVO;
use App\Imovel;
use App\Http\ViewObject\PessoaVO;
use App\Pessoa;

class ContratoVO
{
  public $id;
  public $imovel;
  public $proprietario;
  public $inquilino;
  public $nr_contrato;
  public $valor;
  public $dt_inicio;
  public $dt_vencimento;
  public $dt_revogado;
  public $situacao_pagamento;
  public $finalidade;
  public $ativo;

  public function __construct(Contrato $obj = null){
    if($obj != null){
      $this->convertFromEntity($obj);
    }
  }

  public function convertFromEntity(Contrato $obj){
    //dd(new MovimentacaoVO(Movimentacao::where('id_contrato','=',$obj->id)->get()[0]), Movimentacao::find(4));
    $this->id                 = $obj->id;
    $this->imovel             = new ImovelVO(Imovel::find($obj->id_imovel));
    $this->proprietario       = new PessoaVO(Pessoa::find($obj->id_proprietario));
    $this->inquilino          = new PessoaVO(Pessoa::find($obj->id_inquilino));
    $this->nr_contrato        = $obj->nr_contrato;
    $this->valor              = $obj->valor;
    $this->dt_inicio          = $obj->dt_inicio;
    $this->dt_vencimento      = $obj->dt_vencimento;
    $this->dt_revogado        = $obj->dt_revogado;
    $this->situacao_pagamento = $obj->situacao_pagamento;
    $this->finalidade         = $obj->finalidade;
    $this->ativo              = $obj->ativo;
  }

  public function convertToEntity(){
    $obj = new Contrato();
    $obj->id                  = $this->id;
    $obj->id_imovel           = $this->imovel->convertToEntity()->id;
    $obj->id_proprietario     = $this->proprietario->convertToEntity()->id;
    $obj->id_inquilino        = $this->inquilino->convertToEntity()->id;
    $obj->nr_contrato         = $this->nr_contrato;
    $obj->valor               = $this->valor;
    $obj->dt_inicio           = $this->dt_inicio;
    $obj->dt_vencimento       = $this->dt_vencimento;
    $obj->dt_revogado         = $this->dt_revogado;
    $obj->situacao_pagamento  = $this->situacao_pagamento;
    $obj->finalidade          = $this->finalidade;
    $obj->ativo               = $this->ativo;
    
    return $obj;
  }

}
