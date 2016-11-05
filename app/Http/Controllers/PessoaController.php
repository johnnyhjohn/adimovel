<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\ViewObject\PessoaVO;
use App\Http\Enum\PessoaEnum;

use App\Http\Controllers\AutenticacaoController;

use App\JSONUtils;
use App\FuncoesAuxiliares;
use App\Messages;
use App\Pessoa;

class PessoaController extends Controller
{
    public function create(Request $request)
    {	
    	try{
    		$token = $request->input('token');

    		//if(AutenticacaoController::verificaToken($token)){
	            $pessoa = new Pessoa();

	            $ultimo_cod = Pessoa::max('cod_pessoa');
	            $pessoa->cod_pessoa = FuncoesAuxiliares::formataDigitos($ultimo_cod+1, 6);

	            $pessoa->nm_pessoa 	= $request->input('nome');
	            $pessoa->nr_cpf 	= $request->input('cpf');
	            $pessoa->nr_rg 	= $request->input('rg');
	            $pessoa->email 	= $request->input('email');
	            $pessoa->dt_nascimento = $request->input('dta_nasc');
	            $pessoa->nr_cep 	= $request->input('cep');
	            $pessoa->nr_telefone = $request->input('telefone');
	            $pessoa->endereco = $request->input('endereco');
	            $pessoa->bairro   = $request->input('bairro');

	           	$pessoa->id_cidade = 2;
	            $pessoa->ativo = true;

	            $validator = \Validator::make($request->all(), $this->validaCadastro());
		        if ($validator->fails()) {
					return JSONUtils::returnDanger('Problema de validação verifique os campos e tente novamente.', $validator->errors()->all());   
		        }

	        	$pessoa->save();
				return JSONUtils::returnSuccess('Pessoa '. $pessoa->nm_pessoa .' cadastrada com sucesso.', $pessoa);
			//}
			//else{
			//	return JSONUtils::returnDanger('Usuário não tem permissão para esta ação.', "Falta de Permissão");   
			//}
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
    		$token = $request->input('token');

    		if(AutenticacaoController::verificaToken($token)->admin){
	    		$pessoa = Pessoa::find($id);

	    		$pessoa->nm_pessoa 	= $request->input('nome');
	            $pessoa->nr_cpf 	= $request->input('cpf');
	            $pessoa->nr_rg 	= $request->input('rg');
	            $pessoa->email 	= $request->input('email');
	            $pessoa->dt_nascimento = $request->input('dta_nasc');
	            $pessoa->nr_cep 	= $request->input('cep');
	            $pessoa->nr_telefone = $request->input('telefone');
	            $pessoa->endereco = $request->input('endereco');
	            $pessoa->bairro   = $request->input('bairro');

	           	$pessoa->id_cidade = 1;
	            $pessoa->ativo = true;

	            $validator = \Validator::make($request->all(), $this->validaCadastro());
		        if ($validator->fails()) {
					return JSONUtils::returnDanger('Problema de validação verifique os campos e tente novamente.', $validator->errors()->all());   
		        }

	            $pessoa->save();
	            return JSONUtils::returnSuccess($pessoa->nm_pessoa .' alterada com sucesso.', $pessoa);
	        }    
			else{
				return JSONUtils::returnDanger('Usuário não tem permissão para esta ação.', "Falta de Permissão");   
			}	        
    	}catch(Exception $e){
    		return JSONUtils::returnDanger('Problema de acesso à base de dados.', $e);
    	}
    }

    public function index($id = null)
    { 
 		
    	try{
	    	if ($id == null) {
		        $pessoas = Pessoa::orderBy('nm_pessoa', 'asc')->get();

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

    public function destroy($id)
    {
    	try{
    		$pessoa = Pessoa::find($id);
    		$pessoa->ativo = false;
    		$pessoa->save();

    		return JSONUtils::returnSuccess('Item deletado com sucesso.', $pessoa);
    	}catch(Exception $e){
    		return JSONUtils::returnDanger('Problema de acesso à base de dados.',$e);
    	}
    }

    public function busca(Request $request)
    {
    	try{
	    	$input = $request->all();

	    	$busca = Pessoa::where($input['coluna'],'ilike', '%'.$input['valor'].'%')
	    					->orderBy('nm_pessoa', 'asc')
	    					->get();

	        $return = array();

	        foreach ($busca as $key => $value) {
	            $pVO = new PessoaVO(Pessoa::find($value->id));
	            $return[] = $pVO;
	        }
	    	return JSONUtils::returnSuccess('Consulta realizada com sucesso.', $return);
	    } catch(Exception $e){
    		return JSONUtils::returnDanger('Problema de acesso à base de dados.',$e);
    	}	
    }
}
