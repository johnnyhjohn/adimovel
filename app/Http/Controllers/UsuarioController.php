<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\ViewObject\UsuarioVO;
use App\Http\Enum\UsuarioEnum;

use App\Http\Controllers\AutenticacaoController;

use App\JSONUtils;
use App\Messages;
use App\Usuario;

class UsuarioController extends Controller
{

    public function index(Request $request, $id = null)
    {  
        try{
        	$token = $request->input('token');
        	if(AutenticacaoController::verificaToken($token)){
	            if ($id == null) {
	                $usuario = Usuario::orderBy('nm_usuario', 'asc')->get();

	                $return = array();

	                foreach ($usuario as $key => $value) {
	                    $uVO = new UsuarioVO(Usuario::find($value->id));
	                    $return[] = $uVO;
	                }

	                return JSONUtils::returnSuccess('Consulta realizada com sucesso.', $return);
	            } else {
	                return $this->show($id);
	            }
	        }
	        else{
	        	return JSONUtils::returnDanger('Usuário não tem permissão para esta ação.', "Falta de Permissão");   
	        }
        } catch (JWTException $e) {
            return JSONUtils::returnDanger('Token Expirou.', "Falta de Permissão");   
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return JSONUtils::returnDanger('Token Expirou.', "Falta de Permissão");  
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
            return JSONUtils::returnDanger('Token Expirou.', "Falta de Permissão");  
        }    catch(Exception $e){
        	return JSONUtils::returnDanger('Token Expirou.', "Falta de Permissão");  
        }
    }

    public function show($id)
    {
        try{
            return JSONUtils::returnSuccess(Messages::MSG_QUERY_SUCCESS,
            new UsuarioVO(Usuario::find($id)));
        }catch(Exception $e){
            return JSONUtils::returnDanger('Problema de acesso à base de dados.',$e);
        }
    }

    public function create(Request $request)
	{
		try{
			$token = $request->input('token');
			if(AutenticacaoController::verificaToken($token)){

	            $usuario = new Usuario();

	            $usuario->nm_usuario 	= $request->input('nome');
	            $usuario->nr_cpf 	= $request->input('cpf');
	            $usuario->email = $request->input('email');
	            //$usuario->telefone = $request->input('telefone');
	            $usuario->password = \Hash::make($request->input('senha'));

	            if(UsuarioEnum::isValid($request->input('tipo'))){
	            	$usuario->tp_funcionario = $request->input('tipo');
	        	}else{
	        		$usuario->tp_funcionario = UsuarioEnum::CORRETOR;
	        	}

	            $usuario->ativo = true;
	            if($request->input('tipo') == UsuarioEnum::ADMINISTRADOR){
	            	$usuario->admin = true;
	            } else{
	            	$usuario->admin = false;
	            }

	            
	            $validator = \Validator::make($request->all(), $this->validaCadastro());
		        if ($validator->fails()) {
					return JSONUtils::returnDanger('Problema de validação verifique os campos e tente novamente.',  $validator->errors()->all());   
		        }

	        	$usuario->save();
				return JSONUtils::returnSuccess('Usuário '. $usuario->nm_usuario .' cadastrada com sucesso.', $usuario);
			}
			else{
				return JSONUtils::returnDanger('Usuário não tem permissão para esta ação.', "Falta de Permissão");   
			}
    	}catch(Exception $e){
    		return JSONUtils::returnDanger('Problema de acesso à base de dados.', $e);
    	}
    }

    public function validaCadastro()
    {
		return [
			'nome'			=> 'required',
            //'cpf' 	  		  => 'required|numeric',
            'email'	  		=> 'required|email',
            //'senha'		  	=> 'required'
            
        ];
    }

    public function update(Request $request, $id)
    {
        try{
			$token = $request->input('token');
			if(AutenticacaoController::verificaToken($token)){        	
	            $usuario = Usuario::find($id);

	            $usuario->nm_usuario  	= $request->input('nome');
	            $usuario->nr_cpf   		= $request->input('cpf');
	            $usuario->email 		= $request->input('email');
	            $usuario->telefone 		= $request->input('telefone');
	            //$usuario->password = \Hash::make($request->input('senha'));

	            if(UsuarioEnum::isValid($request->input('tipo'))){
	                $usuario->tp_funcionario = $request->input('tipo');
	            }else{
	                $usuario->tp_funcionario = UsuarioEnum::CORRETOR;
	            }

	            $usuario->ativo = true;

	            if($request->input('tipo') == UsuarioEnum::ADMINISTRADOR){
	            	$usuario->admin = true;
	            } else{
	            	$usuario->admin = false;
	            }

	            $validator = \Validator::make($request->all(), $this->validaCadastro());
	            if ($validator->fails()) {
	                return JSONUtils::returnDanger('Problema de validação verifique os campos e tente novamente.', $validator->errors()->all());   
	            }

	            $usuario->save();
	            return JSONUtils::returnSuccess($usuario->nm_usuario .' alterada com sucesso.', $usuario);
	        }
			else{
				return JSONUtils::returnDanger('Usuário não tem permissão para esta ação.', "Falta de Permissão");   
			}   
        }catch(Exception $e){
            return JSONUtils::returnDanger('Problema de acesso à base de dados.', $e);
        }
    }

    public function destroy(Request $request, $id)
    {
        try{
        	//dd($request->input('token'), $id);
            $usuario = Usuario::find($id);
            $usuario->ativo = false;
            $usuario->save();

            return JSONUtils::returnSuccess('Item deletado com sucesso.', $usuario);
        }catch(Exception $e){
            return JSONUtils::returnDanger('Problema de acesso à base de dados.',$e);
        }
    }

    public function busca(Request $request)
    {
    	try{
	    	$input = $request->all();

	    	$busca = Usuario::where($input['coluna'],'like', $input['valor'].'%')
	    					->orderBy('nm_usuario', 'asc')
	    					->get();

	    	return JSONUtils::returnSuccess('Consulta realizada com sucesso.', $busca);
	    } catch(Exception $e){
    		return JSONUtils::returnDanger('Problema de acesso à base de dados.',$e);
    	}	
    }

    public function getCorretores()
    {
    	try{
    		$corretor = Usuario::where("tp_funcionario", "=", "COR")
    							->where("ativo", "=", "true")
    							->orderBy('nm_usuario','asc')
    							->get();
    		
    		return JSONUtils::returnSuccess('Consulta realizada com sucesso.', $corretor);

    	} catch(Exception $e){
    		return JSONUtils::returnDanger('Problema de acesso à base de dados.',$e);
    	}
    }
}
