<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\ViewObject\TpImovelVO;
//use App\Http\Enum\UsuarioEnum;

use App\JSONUtils;
use App\Messages;
use App\TpImovel;

class TipoImovelController extends Controller
{

    public function index($id = null)
    {  
        try{
            if ($id == null) {
                
                $tipoimovel = TpImovel::orderBy('titulo', 'asc')->get();

                $return = array();

                foreach ($tipoimovel as $key => $value) {
                    $iVO = new TpImovelVO(TpImovel::find($value->id));
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
            new TpImovelVO(TpImovel::find($id)));
        }catch(Exception $e){
            return JSONUtils::returnDanger('Problema de acesso à base de dados.',$e);
        }
    }

    public function create(Request $request)
	{
		try{
            $tipoimovel = new TpImovel();

            $tipoimovel->titulo   = $request->input('titulo');
            $tipoimovel->ativo = $request->input('ativo');

            $validator = \Validator::make($request->all(), $this->validaCadastro());
	        if ($validator->fails()) {
				return JSONUtils::returnDanger('Problema de validação verifique os campos e tente novamente.', "Erro");   
	        }

        	$tipoimovel->save();
			return JSONUtils::returnSuccess($tipoimovel->titulo .' cadastrada com sucesso.', $tipoimovel);

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
            $tipoimovel = TpImovel::find($id);

            $tipoimovel->titulo   = $request->input('titulo');
            $tipoimovel->ativo = $request->input('ativo');

            $validator = \Validator::make($request->all(), $this->validaCadastro());
            if ($validator->fails()) {
                return JSONUtils::returnDanger('Problema de validação verifique os campos e tente novamente.', $validator->errors()->all());   
            }

            $tipoimovel->save();
            return JSONUtils::returnSuccess($tipoimovel->titulo .' alterada com sucesso.', $tipoimovel);
        }catch(Exception $e){
            return JSONUtils::returnDanger('Problema de acesso à base de dados.', $e);
        }
    }

    public function destroy($id){
        try{
            $tipoimovel = TpImovel::find($id);
            $tipoimovel->ativo = false;
            $tipoimovel->save();

            return JSONUtils::returnSuccess('Item deletado com sucesso.', $tipoimovel);
        }catch(Exception $e){
            return JSONUtils::returnDanger('Problema de acesso à base de dados.',$e);
        }
    }

    public function busca(Request $request)
    {
    	try{
	    	$input = $request->all();

	    	$busca = TpImovel::where($input['coluna'],'like', $input['valor'].'%')
	    					->orderBy('titulo', 'asc')
	    					->get();

	    	return JSONUtils::returnSuccess('Consulta realizada com sucesso.', $busca);
	    } catch(Exception $e){
    		return JSONUtils::returnDanger('Problema de acesso à base de dados.',$e);
    	}	
    }
}
