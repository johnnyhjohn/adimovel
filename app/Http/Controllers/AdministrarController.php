<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\ViewObject\AdministrarVO;
//use App\Http\Enum\UsuarioEnum;

use App\JSONUtils;
use App\Messages;
use App\ContratoAluguel;

class AdministrarController extends Controller
{

    public function index($id = null)
    {  
        try{
            if ($id == null) {
                
                $contrato = ContratoAluguel::orderBy('id', 'asc')->get();
                //$contrato = ContratoAluguel::orderBy('id', 'asc')->where('ativo', '=', 'true')->get();

                $return = array();

                foreach ($contrato as $key => $value) {
                    $cVO = new AdministrarVO(ContratoAluguel::find($value->id));
                    $return[] = $cVO;
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
            new AdministrarVO(ContratoAluguel::find($id)));
        }catch(Exception $e){
            return JSONUtils::returnDanger('Problema de acesso à base de dados.',$e);
        }
    }

    public function create(Request $request)
	{
		try{
            $contrato = new ContratoAluguel();

            $contrato->id_imovel   = $request->input('imovel');
            $contrato->id_proprietario   = $request->input('proprietario');
            $contrato->id_inquilino   = $request->input('inquilino');
            $contrato->nr_contrato   = $request->input('nr_contrato');
            $contrato->dt_inicio   = $request->input('dt_inicio');
            $contrato->dt_vencimento   = $request->input('dt_vencimento');
            $contrato->dt_revogado   = $request->input('dt_revogado');
            $contrato->valor   = $request->input('valor');
            $contrato->situacao_pagamento   = $request->input('situacao');
            $contrato->finalidade   = $request->input('finalidade');
            $contrato->ativo = true;

            $contrato->dt_revogado = '2016-01-01';
            //$validator = \Validator::make($request->all(), $this->validaCadastro());
	        //if ($validator->fails()) {
			//	return JSONUtils::returnDanger('Problema de validação verifique os campos e tente novamente.', "Erro");   
	        //}

        	$contrato->save();
			return JSONUtils::returnSuccess($contrato->nr_contrato .' cadastrada com sucesso.', $contrato);

    	}catch(Exception $e){
    		return JSONUtils::returnDanger('Problema de acesso à base de dados.', $e);
    	}
    }

    public function validaCadastro()
    {
		return [
			'titulo'			=> 'required',
        ];
    }

    public function update(Request $request, $id)
    {
        try{
            $contrato = ContratoAluguel::find($id);

            $contrato->id_imovel            = $request->input('imovel');
            $contrato->id_proprietario      = $request->input('proprietario');
            $contrato->id_inquilino         = $request->input('inquilino');
            $contrato->nr_contrato          = $request->input('nr_contrato');
            $contrato->dt_inicio            = $request->input('dt_inicio');
            $contrato->dt_vencimento        = $request->input('dt_vencimento');
            $contrato->dt_revogado          = $request->input('dt_revogado');
            $contrato->valor                = $request->input('valor');
            $contrato->situacao_pagamento   = $request->input('situacao');
            $contrato->finalidade   = $request->input('finalidade');
            $contrato->ativo                = $request->input('ativo');

            $contrato->dt_revogado = '2016-01-01';
            //$validator = \Validator::make($request->all(), $this->validaCadastro());
            //if ($validator->fails()) {
            //    return JSONUtils::returnDanger('Problema de validação verifique os campos e tente novamente.', $validator->errors()->all());   
            //}

            $contrato->save();
            return JSONUtils::returnSuccess($contrato->nr_contrato .' alterada com sucesso.', $contrato);
        }catch(Exception $e){
            return JSONUtils::returnDanger('Problema de acesso à base de dados.', $e);
        }
    }

    public function destroy($id){
        try{
            $contrato = ContratoAluguel::find($id);
            //$contrato->delete();
            $contrato->ativo = false;

            $contrato->save();

            return JSONUtils::returnSuccess('Item deletado com sucesso.', $contrato);
        }catch(Exception $e){
            return JSONUtils::returnDanger('Problema de acesso à base de dados.',$e);
        }
    }

    public function busca(Request $request)
    {
    	try{
	    	$input = $request->all();

	    	$busca = ContratoAluguel::where($input['coluna'],'like', $input['valor'].'%')
	    					->orderBy('id', 'asc')
	    					->get();
            
            $return = array();

            foreach ($busca as $key => $value) {
                $cVO = new AdministrarVO(ContratoAluguel::find($value->id));
                $return[] = $cVO;
            }

            //$return[] = $cVO;
	    	return JSONUtils::returnSuccess('Consulta realizada com sucesso.', $return);
	    } catch(Exception $e){
    		return JSONUtils::returnDanger('Problema de acesso à base de dados.',$e);
    	}	
    }
}
