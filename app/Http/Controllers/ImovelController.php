<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\ViewObject\ImovelVO;
use App\Http\ViewObject\FotoImovelVO;
use App\Http\Enum\ImoveisEnum;

use App\JSONUtils;
use App\FuncoesAuxiliares;
use App\Messages;
use App\Imovel;
use App\FotoImovel;
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
            $fto_imovel = FotoImovel::where('id_imovel', '=', $id)->count();
            
            if($fto_imovel != 0){
                $imovel = FotoImovel::where('id_imovel', '=', $id)->get();
                return JSONUtils::returnSuccess(Messages::MSG_QUERY_SUCCESS,
                new FotoImovelVO($imovel[0]));
            } else{
                return JSONUtils::returnSuccess(Messages::MSG_QUERY_SUCCESS,
                new ImovelVO(Imovel::find($id)));
            }
        }catch(Exception $e){
            return JSONUtils::returnDanger('Problema de acesso à base de dados.',$e);
        }
    }

    /**
    *
    *   @author Johnny
    *   @description 
    *   Método para inserção no banco o imóvel cadastrado e upload de foto
    *
    */

    public function create(Request $request)
	{
		try{
            $imovel     = new Imovel();
            $imovel_img = new FotoImovel();

            $imovel->tp_imovel        = $request->input('tipo');
            $imovel->titulo_anuncio   = $request->input('nome');
            $imovel->id_proprietario  = $request->input('proprietario');
            $imovel->id_corretor      = $request->input('corretor');
            $imovel->codigo_interno   = $request->input('codigo_interno');
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
            $imovel->reservado        = $request->input('reservado');
            $imovel->dt_cadastrado    = $request->input('dt_cadastrado');
            $imovel->latitude         = $request->input('lat');
            $imovel->longitude        = $request->input('lng');
            // $imovel->situacao_imovel  = 1;
            $imovel->ativo = true;
            // dd($imovel);
        
            $validator = \Validator::make($request->all(), $this->validaCadastro());
            if ($validator->fails()) {
                return JSONUtils::returnDanger('Problema de validação verifique os campos e tente novamente.', $validator->errors()->all());   
            }
            
            $imovel->save();

            /**
            *
            *   Usa o nome da pasta publica do Laravel com o titulo e ID do imovel, para nunca repetir
            */
            $image_name = '/image/'.$imovel->titulo_anuncio.'-'.$imovel->id.'.jpg';

            /**
            *
            *   Chama a função UploadImage para fazer o upload da imagem
            *
            *   @param {String} - Imagem em base64
            *   @param {String} - Caminho da imagem
            */
            if( FuncoesAuxiliares::UploadImage($request->input('imagem_thumb'), $image_name) ){
                /**
                *
                *   Monta o Objeto de Fotos do Imóvel e insere o caminho da imagem
                */
                $imovel_img->foto       = $image_name;
            } else{
                $imovel_img->foto       = '/image/no-image-box.png';
            }

            $imovel_img->id_imovel  = $imovel->id;
            $imovel_img->ativo     = true;

            $imovel_img->save();   

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

    public function update(Request $request, $id)
    {
        try{
            $imovel = Imovel::find($id);
            $imovel_img = FotoImovel::where('id_imovel', '=', $id)->get();

            $imovel->tp_imovel        = $request->input('tipo');
            $imovel->titulo_anuncio   = $request->input('nome');
            $imovel->id_proprietario  = $request->input('proprietario');
            $imovel->id_corretor      = $request->input('corretor');
            $imovel->codigo_interno   = $request->input('codigo_interno');
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
            // $imovel->situacao_imovel  = 1;
            $imovel->ativo = true;
            // dd($imovel);

            $validator = \Validator::make($request->all(), $this->validaCadastro());
            if ($validator->fails()) {
                return JSONUtils::returnDanger('Problema de validação verifique os campos e tente novamente.', $validator->errors()->all());   
            }
            /**
            *
            *   Usa o nome da pasta publica do Laravel com o titulo e ID do imovel, para nunca repetir
            */
            $image_name = '/image/'.$imovel->titulo_anuncio.'-'.$id.'.jpg';

            /**
            *
            *   Chama a função UploadImage para fazer o upload da imagem
            *
            *   @param {String} - Imagem em base64
            *   @param {String} - Caminho da imagem
            */
            if( FuncoesAuxiliares::UploadImage($request->input('imagem_thumb'), $image_name) ){
                /**
                *
                *   Monta o Objeto de Fotos do Imóvel e insere o caminho da imagem
                */
                $imovel_img[0]->foto       = $image_name;
                $imovel_img[0]->save();
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
