<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\ViewObject\PessoaVO;
use App\Http\Enum\PessoaEnum;

use App\JSONUtils;
use App\Messages;
use App\Pessoa;

class PessoaController extends Controller
{
    public function create(Request $request)
    {	
    	try{
            $pessoa = new Pessoa();

            $pessoa->nome 	= $request->input('nome');
            $pessoa->cpf 	= $request->input('cpf');
            $pessoa->rg 	= $request->input('rg');
            $pessoa->email 	= $request->input('email');
            $pessoa->data_nascimento = $request->input('dta_nasc');
            $pessoa->cep 	= $request->input('cep');
            $pessoa->telefone = $request->input('telefone');
            $pessoa->endereco = $request->input('endereco');
            // $pessoa->bairro   = $request->input('bairro');

            if(PessoaEnum::isValid($request->input('tipo'))){
            	$pessoa->tipo_pessoa = $request->input('tipo');
        	}else{
        		$pessoa->tipo_pessoa = PessoaEnum::INQUILINO;
        	}

           	$pessoa->cidade = 1;
            $pessoa->status = true;

            $validator = \Validator::make($request->all(), $this->validaCadastro());
	        if ($validator->fails()) {
				return JSONUtils::returnDanger('Problema de validação verifique os campos e tente novamente.', $validator->errors()->all());   
	        }

        	$pessoa->save();
			return JSONUtils::returnSuccess('Pessoa '. $pessoa->nome .' cadastrada com sucesso.', $pessoa);

    	}catch(Exception $e){
    		return JSONUtils::returnDanger('Problema de acesso à base de dados.', $e);
    	}
    }

    public function validaCadastro()
    {
		return [
            'data_nascimento' => 'date_format:YYYY/mm/dd',
            'cpf' 	  		  => 'required|numeric',
            'email'	  		  => 'required|email',
            'telefone'		  => 'numeric',
            'cep'		  	  => 'numeric',
            'rg'		  	  => 'numeric'
        ];
    }

    public function update(Request $request, $id)
    {
    	try{
    		$pessoa = Pessoa::find($id);

    		$pessoa->nome 	= $request->input('nome');
            $pessoa->cpf 	= $request->input('cpf');
            $pessoa->rg 	= $request->input('rg');
            $pessoa->email 	= $request->input('email');
            $pessoa->data_nascimento = $request->input('dta_nasc');
            $pessoa->cep 	= $request->input('cep');
            $pessoa->telefone = $request->input('telefone');
            $pessoa->endereco = $request->input('endereco');
            $pessoa->bairro   = $request->input('bairro');

            if (PessoaEnum::isValid($request->input('tipo'))) {
            	$pessoa->tipo_pessoa = $request->input('tipo');
        	} else {
        		$pessoa->tipo_pessoa = PessoaEnum::INQUILINO;
        	}

           	$pessoa->cidade = 1;
            $pessoa->status = true;

            $validator = \Validator::make($request->all(), $this->validaCadastro());
	        if ($validator->fails()) {
				return JSONUtils::returnDanger('Problema de validação verifique os campos e tente novamente.', $validator->errors()->all());   
	        }

            $pessoa->save();
            return JSONUtils::returnSuccess($pessoa->nome .' alterada com sucesso.', $pessoa);
    	}catch(Exception $e){
    		return JSONUtils::returnDanger('Problema de acesso à base de dados.', $e);
    	}
    }

    public function index($id = null)
    {  
    	try{
	    	if ($id == null) {
		        $pessoas = Pessoa::orderBy('nome', 'asc')->get();

		        $return = array();

		        foreach ($pessoas as $key => $value) {
		            $pVO = new PessoaVO(Pessoa::find($value->id));
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
          	new PessoaVO(Pessoa::find($id)));
      	}catch(Exception $e){
        	return JSONUtils::returnDanger('Problema de acesso à base de dados.',$e);
      	}
    }

    public function destroy($id){
    	try{
    		$pessoa = Pessoa::find($id);
    		$pessoa->delete();

    		return JSONUtils::returnSuccess('Item deletado com sucesso.', $pessoa);
    	}catch(Exception $e){
    		return JSONUtils::returnDanger('Problema de acesso à base de dados.',$e);
    	}
    }
}
