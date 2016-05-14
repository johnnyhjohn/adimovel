<?php

namespace App\Http\ViewObject;

use App\Http\ViewObject\CidadeVO;
use App\Cidades;

use App\Http\ViewObject\PessoaVO;
use App\Pessoa;

use App\Http\ViewObject\UsuarioVO;
use App\Usuario;

use App\Http\ViewObject\TpImovelVO;
use App\TpImovel;

use App\Imovel;

class ImovelVO
{
    public $id;
    public $tp_imovel;
    public $titulo_anuncio;
    public $id_proprietario;
    public $id_corretor;
    public $codigo_interno;
    public $endereco;
    public $nm_endereco;
    public $bairro;
    public $cidade;
    public $nm_cep;
    public $area;
    public $qt_quartos;
    public $qt_banheiros;
    public $qt_vagasgaragem;
    public $referencia;
    public $descricao;
    public $valor;
    public $vitrine;
    public $financiamento;
    public $dt_cadastrado;
    public $latitude;
    public $longitude;
    public $situacao_imovel;
    public $ativo;

  public function __construct(Imovel $obj = null)
  {
    if($obj != null){
        $this->convertFromEntity($obj);
    }
  }

  public function convertFromEntity(Imovel $obj)
  {
    $this->id               = $obj->id;
    $this->tp_imovel        = new TpImovelVO(TpImovel::find($obj->tp_imovel));
    $this->titulo_anuncio   = $obj->titulo_anuncio;
    $this->id_proprietario  = new PessoaVO(Pessoa::find($obj->id_proprietario));
    $this->id_corretor      = new UsuarioVO(Usuario::find($obj->id_corretor));
    $this->codigo_interno   = $obj->codigo_interno;
    $this->endereco         = $obj->endereco;
    $this->nm_endereco      = $obj->nm_endereco;
    $this->bairro           = $obj->bairro;
    $this->cidade           = new CidadeVO(Cidades::find($obj->id_cidade));
    $this->nm_cep           = $obj->nm_cep;
    $this->area             = $obj->area;
    $this->qt_quartos       = $obj->qt_quartos;
    $this->qt_banheiros     = $obj->qt_banheiros;
    $this->qt_vagasgaragem  = $obj->qt_vagasgaragem;
    $this->referencia       = $obj->referencia;
    $this->descricao        = $obj->descricao;
    $this->valor            = $obj->valor;
    $this->vitrine          = $obj->vitrine;
    $this->financiamento    = $obj->financiamento;
    $this->dt_cadastrado    = $obj->dt_cadastrado;
    $this->latitude         = $obj->latitude;
    $this->longitude        = $obj->longitude;
    $this->situacao_imovel  = $obj->situacao_imovel;
    $this->ativo            = $obj->ativo;
  }

  public function convertToEntity()
  {
    $obj = new Imovel();
    $obj->id                   = $this->id;
    $obj->tp_imovel            = $this->tp_imovel->convertToEntity()->id;
    $obj->titulo_anuncio       = $this->titulo_anuncio;
    $obj->id_proprietario      = $this->id_proprietario->convertToEntity()->id;
    $obj->id_corretor          = $this->id_corretor->convertToEntity()->id;
    $obj->codigo_interno       = $this->codigo_interno;
    $obj->endereco             = $this->endereco;
    $obj->nm_endereco          = $this->nm_endereco;
    $obj->bairro               = $this->bairro;
    $obj->cidade               = $this->id_cidade->convertToEntity()->id;
    $obj->nm_cep               = $this->nm_cep;
    $obj->area                 = $this->area;
    $obj->qt_quartos           = $this->qt_quartos;
    $obj->qt_banheiros         = $this->qt_banheiros;
    $obj->qt_vagasgaragem      = $this->qt_vagasgaragem;
    $obj->referencia           = $this->referencia;
    $obj->descricao            = $this->descricao;
    $obj->valor                = $this->valor;
    $obj->vitrine              = $this->vitrine;
    $obj->financiamento        = $this->financiamento;
    $obj->dt_cadastrado        = $this->dt_cadastrado;
    $obj->latitude             = $this->latitude;
    $obj->longitude            = $this->longitude;
    $obj->situacao_imovel      = $this->situacao_imovel;
    $obj->ativo                = $this->ativo;

    return $obj;
  }

}