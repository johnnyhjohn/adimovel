<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
//use App\Http\Enum\UsuarioEnum;

use App\JSONUtils;
use App\Messages;
use App\Pin;

class PinController extends Controller
{

    public function index($id = null)
    {  
        try{
            if ($id == null) {
                
                $pin = Pin::orderBy('titulo', 'asc')->get();

                $return = array();

                foreach ($pin as $key => $value) {
                    $pVO = new PinVO(Pin::find($value->id));
                    $return[] = $pVO;
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
            new PinVO(Pin::find($id)));
        }catch(Exception $e){
            return JSONUtils::returnDanger('Problema de acesso à base de dados.',$e);
        }
    }

    public function create(Request $request)
	{
		try{
            $pin = new Pin();

            $pin->titulo   = $request->input('titulo');
            $pin->ativo = $request->input('ativo');

            $validator = \Validator::make($request->all(), $this->validaCadastro());
	        if ($validator->fails()) {
				return JSONUtils::returnDanger('Problema de validação verifique os campos e tente novamente.', "Erro");   
	        }

        	$pin->save();
			return JSONUtils::returnSuccess($pin->titulo .' cadastrada com sucesso.', $pin);

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
            $pin = Pin::find($id);

            $pin->titulo   = $request->input('titulo');
            $pin->ativo = $request->input('ativo');

            $validator = \Validator::make($request->all(), $this->validaCadastro());
            if ($validator->fails()) {
                return JSONUtils::returnDanger('Problema de validação verifique os campos e tente novamente.', $validator->errors()->all());   
            }

            $pin->save();
            return JSONUtils::returnSuccess($pin->titulo .' alterada com sucesso.', $pin);
        }catch(Exception $e){
            return JSONUtils::returnDanger('Problema de acesso à base de dados.', $e);
        }
    }

    public function destroy($id){
        try{
            $pin = Pin::find($id);
            $pin->ativo = false;
            $pin->save();

            return JSONUtils::returnSuccess('Item deletado com sucesso.', $pin);
        }catch(Exception $e){
            return JSONUtils::returnDanger('Problema de acesso à base de dados.',$e);
        }
    }

    public function busca(Request $request)
    {
    	try{
	    	$input = $request->all();

            if($input['valor'] == ''){
                $busca = Pin::orderBy('titulo', 'asc')->get();

            }else{
	    	  $busca = Pin::where($input['coluna'],'like', $input['valor'].'%')
	    					->orderBy('titulo', 'asc')
	    					->get();
            }

	    	return JSONUtils::returnSuccess('Consulta realizada com sucesso.', $busca);
	    } catch(Exception $e){
    		return JSONUtils::returnDanger('Problema de acesso à base de dados.',$e);
    	}	
    }
}
