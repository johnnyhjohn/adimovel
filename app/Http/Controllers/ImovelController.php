<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\ViewObject\ImovelVO;
use App\Http\Enum\ImoveisEnum;

use App\JSONUtils;
use App\FuncoesAuxiliares;
use App\Messages;
use App\Imovel;
use App\Pessoa;
use App\Contrato;

class ImovelController extends Controller
{

    public function index($id = null)
    {  
        try{
            if ($id == null) {
                
                $imovel = Imovel::orderBy('titulo_anuncio', 'asc')->get();

                $return = array();

                foreach ($imovel as $key => $value) {
                    $iVO = new ImovelVO(Imovel::find($value->id));
                    $return[] = $iVO;
                }

                return JSONUtils::returnSuccess('Consulta realizada com sucesso.', $return);
            } else {
                return $this->show($id);
            }
        } catch(Exception $e){
            return JSONUtils::returnDanger('Problema de acesso à base de dados.', $e);
        }    
    }

    public function show($id)
    {
        try{
            return JSONUtils::returnSuccess(Messages::MSG_QUERY_SUCCESS,
            new ImovelVO(Imovel::find($id)));
        }catch(Exception $e){
            return JSONUtils::returnDanger('Problema de acesso à base de dados.',$e);
        }
    }

    /*
    *   Função para CADASTRAR um imóvel
    */
    public function create(Request $request)
	{
		try{
            $imovel = new Imovel();

            $id_proprietario        = $request->input('proprietario');
            
            /*
            *   seleciona o código_pessoa do proprietario do imóvel ex: 000001 
            */
            $proprietario           = Pessoa::find($id_proprietario);
            $cod_proprietario       = $proprietario->cod_pessoa;
            
            /*
            *   seleciona o último código cadastrado para seguir a sequencia crescente de código imóvel
            */
            $max_cod = Imovel::where('id_proprietario', '=', $id_proprietario)->max('codigo_interno');
            
            /*
            *   Condição para ver se já existe imóveis do proprietário selecionado
            *   Se não houver nenhum imóvel ele cadastra o imóvel com o código 001 
            */
            if ($max_cod != null) {
                
                /*
                *   Seleciona somente o código do imóvel
                */
                $cod_int     = substr($max_cod, 7, 9);

                /*
                *   Soma +1 no valor do ultimo código de imóvel do proprietário
                */
                $cod_imv     = intval($cod_int)+1;

                /*
                *   Formata o código interno do imóvel ex:  000001-001
                *   000001  - código do proprietário
                *   001     - código do imóvel
                */
                $cod_interno = $cod_proprietario .'-'. FuncoesAuxiliares::formataDigitos( $cod_imv, 3);

            }else{
                /*
                *   Seta o código do imóvel com o codigo do proprietário + o número do imóvel (001)
                */
                $cod_interno = $cod_proprietario.'-001';
            }

            $imovel->codigo_interno   = $cod_interno;
   
            $imovel->tp_imovel        = $request->input('tipo');
            $imovel->titulo_anuncio   = $request->input('nome');
            $imovel->id_proprietario  = $request->input('proprietario');
            $imovel->id_corretor      = $request->input('corretor');
            $imovel->endereco         = $request->input('endereco');
            $imovel->nm_endereco      = $request->input('nm_endereco');
            $imovel->bairro           = $request->input('bairro');
            $imovel->cidade           = $request->input('cidade');
            $imovel->nm_cep           = $request->input('cep');
            $imovel->area             = $request->input('area');
            $imovel->qt_quartos       = $request->input('quartos');
            $imovel->qt_banheiros     = $request->input('banheiros');
            $imovel->qt_vagasgaragem  = $request->input('garagens');
            $imovel->referencia       = $request->input('referencia');
            $imovel->descricao        = $request->input('descricao');
            $imovel->valor            = $request->input('valor');
            $imovel->vitrine          = $request->input('vitrine');
            $imovel->financiamento    = $request->input('financiamento');
            $imovel->finalidade       = $request->input('finalidade');
            $imovel->reservado       = $request->input('reservado');
            $imovel->dt_cadastrado    = $request->input('dt_cadastrado');
            $imovel->latitude         = $request->input('lat');
            $imovel->longitude        = $request->input('lng');
            $imovel->situacao_imovel  = 1;
            $imovel->ativo = true;
            // dd($imovel);
            
            $validator = \Validator::make($request->all(), $this->validaCadastro());
	        if ($validator->fails()) {
				return JSONUtils::returnDanger('Problema de validação verifique os campos e tente novamente.', $validator->errors()->all());   
	        }
    
        	$imovel->save();
			return JSONUtils::returnSuccess($imovel->titulo_anuncio .' cadastrado com sucesso.', $imovel);

    	}catch(Exception $e){
    		return JSONUtils::returnDanger('Problema de acesso à base de dados.', $e);
    	}
    }

    public function validaCadastro()
    {
		return [
			'nome'	            => 'required',
            'proprietario' 	    => 'required',
            'corretor'	        => 'required',
            'codigo_interno'  	=> 'required',
            'endereco'          => 'required',
            'nm_endereco'       => 'required|numeric',
            'quartos'           => 'required|numeric',
            'banheiros'         => 'required|numeric',
            'garagens'          => 'required|numeric',
            
        ];
    }

    public function atualizaSituacao(Request $request, $id)
    {
        try{
            $imovel = Imovel::find($id);
            $imovel->situacao_imovel = ($request->input('situacao') == "pago") ? true : false;

            $imovel->save();
            return JSONUtils::returnSuccess($imovel->titulo_anuncio .' alterado com sucesso.', $imovel);
        }catch(Exception $e){
            return JSONUtils::returnDanger('Problema de acesso à base de dados.', $e);
        }
    }
/*
    public function atualizaReserva(Request $request, $id)
    {
        try{
            $imovel = Imovel::find($id);
            $imovel->reservado = true;

            $imovel->save();
            return JSONUtils::returnSuccess($imovel->titulo_anuncio .' alterado com sucesso.', $imovel);
        }catch(Exception $e){
            return JSONUtils::returnDanger('Problema de acesso à base de dados.', $e);
        }
    }
*/

    /*
    *   Função para marcar a condição do imóvel como RESERVADO
    */
    public function imovelReservado(Request $request, $id)
    {
        try{
            $imovel = Imovel::find($id);
            $imovel->reservado = true;

            $imovel->save();
            return JSONUtils::returnSuccess($imovel->titulo_anuncio .' agora está reservado.', $imovel);
        }catch(Exception $e){
            return JSONUtils::returnDanger('Problema de acesso à base de dados.', $e);
        }
    }

    /*
    *   Função para marcar a situação do imóvel como DISPONIVEL 
    */
    public function imovelDisponivel(Request $request, $id)
    {
        try{
            $imovel = Imovel::find($id);
            $imovel->reservado = false;

            $imovel->save();
            return JSONUtils::returnSuccess($imovel->titulo_anuncio .' está disponível novamente.', $imovel);
        }catch(Exception $e){
            return JSONUtils::returnDanger('Problema de acesso à base de dados.', $e);
        }
    }

    /*
    *   Função para ATUALIZAR as informações de um imóvel
    */
    public function update(Request $request, $id)
    {
        try{
            $imovel = Imovel::find($id);
            $imovel->tp_imovel        = $request->input('tipo');
            $imovel->titulo_anuncio   = $request->input('nome');
            $imovel->id_proprietario  = $request->input('proprietario');
            $imovel->id_corretor      = $request->input('corretor');
            //$imovel->codigo_interno   = $request->input('codigo_interno');
            $imovel->endereco         = $request->input('endereco');
            $imovel->nm_endereco      = $request->input('nm_endereco');
            $imovel->bairro           = $request->input('bairro');
            $imovel->cidade           = $request->input('cidade');
            $imovel->nm_cep           = $request->input('cep');
            $imovel->area             = $request->input('area');
            $imovel->qt_quartos       = $request->input('quartos');
            $imovel->qt_banheiros     = $request->input('banheiros');
            $imovel->qt_vagasgaragem  = $request->input('garagens');
            $imovel->referencia       = $request->input('referencia');
            $imovel->descricao        = $request->input('descricao');
            $imovel->valor            = $request->input('valor');
            $imovel->vitrine          = $request->input('vitrine');
            $imovel->financiamento    = $request->input('financiamento');
            $imovel->finalidade       = new ImoveisEnum($request->input('finalidade'));
            $imovel->reservado    = $request->input('reservado');
            $imovel->dt_cadastrado    = $request->input('dt_cadastrado');
            $imovel->latitude         = $request->input('lat');
            $imovel->longitude        = $request->input('lng');
            $imovel->situacao_imovel  = 1;
            $imovel->ativo = true;
            // dd($imovel);
            // $validator = \Validator::make($request->all(), $this->validaCadastro());
            // if ($validator->fails()) {
            //     return JSONUtils::returnDanger('Problema de validação verifique os campos e tente novamente.', "Erro");   
            // }

            $validator = \Validator::make($request->all(), $this->validaCadastro());
            if ($validator->fails()) {
                return JSONUtils::returnDanger('Problema de validação verifique os campos e tente novamente.', $validator->errors()->all());   
            }
    
            $imovel->save();
            return JSONUtils::returnSuccess($imovel->titulo_anuncio .' alterada com sucesso.', $imovel);
        }catch(Exception $e){
            return JSONUtils::returnDanger('Problema de acesso à base de dados.', $e);
        }
    }

    public function destroy($id){
        try{
            $imovel = Imovel::find($id);
            $imovel->ativo = false;
            $imovel->save();

            return JSONUtils::returnSuccess('Item deletado com sucesso.', $imovel);
        }catch(Exception $e){
            return JSONUtils::returnDanger('Problema de acesso à base de dados.',$e);
        }
    }

    public function busca(Request $request)
    {
    	try{
	    	$input = $request->all();

	    	$busca = Imovel::where($input['coluna'],'like', $input['valor'].'%')
	    					->orderBy('titulo_anuncio', 'asc')
	    					->get();

	    	return JSONUtils::returnSuccess('Consulta realizada com sucesso.', $busca);
	    } catch(Exception $e){
    		return JSONUtils::returnDanger('Problema de acesso à base de dados.',$e);
    	}	
    }

    public function getCountVendas()
    {
        try{

            $count = Contrato::where('finalidade','=','VEN')
                            ->where('situacao_pagamento', '=', 'true')
                            ->get();
            return JSONUtils::returnSuccess('Consulta realizada com sucesso.', $count);  
        }catch(Exception $e){
          return JSONUtils::returnDanger('Problema de acesso à base de dados.',$e);  
        }
    }
    public function getCountAluguel()
    {
        try{

            $count = Contrato::where('finalidade','=','LOC')
                            ->where('situacao_pagamento', '=', 'true')
                            ->get();
            return JSONUtils::returnSuccess('Consulta realizada com sucesso.', $count);  
        }catch(Exception $e){
          return JSONUtils::returnDanger('Problema de acesso à base de dados.',$e);  
        }
    }
}
