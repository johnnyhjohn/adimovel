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
use App\FuncoesAuxiliares;
use App\Usuario;

class UsuarioController extends Controller
{

    public function index(Request $request, $id = null)
    {  
        try{

        	$token 		= $request->input('token');
        	$usuario 	= AutenticacaoController::verificaToken($token);
            // dd($usuario);
        	if($usuario->admin || $usuario->id == $id){
	            if ($id == null) {
	            	return $this->getUsuarios();
	            } else {
	                return $this->show($id);
	            }
	        }
	        else{
	        	return JSONUtils::returnDanger('Usuário não tem permissão para esta ação.', "Falta de Permissão");   
	        }
        } catch (JWTException $e) {
            return JSONUtils::returnDanger('Token Expirou.', $e);   
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return JSONUtils::returnDanger('Token Expirou.', $e);  
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
            return JSONUtils::returnDanger('Token Expirou.', $e);  
        } catch(Exception $e){
        	return JSONUtils::returnDanger('Token Expirou.', $e);  
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
			if(AutenticacaoController::verificaToken($token)->admin){

	            $usuario = new Usuario();

	            $usuario->nm_usuario 	= $request->input('nome');
	            $usuario->nr_cpf 	= $request->input('cpf');
	            $usuario->email = $request->input('email');
	            //$usuario->telefone = $request->input('telefone');
	            $usuario->password = \Hash::make($request->input('senha'));

	         //    if(UsuarioEnum::isValid($request->input('tipo'))){
	         //    	$usuario->tp_funcionario = $request->input('tipo');
	        	// }else{
	        	// 	$usuario->tp_funcionario = UsuarioEnum::CORRETOR;
	        	// }
                $usuario->tp_funcionario       = new UsuarioEnum($request->input('tipo'));
	            $usuario->ativo = true;
	            if($request->input('tipo') == UsuarioEnum::ADMINISTRADOR){
	            	$usuario->admin = true;
	            } else{
	            	$usuario->admin = false;
	            }
                /**
                *
                *   Verifica se existe a pasta usuarios, se não existe cria uma para salvar
                *   as imagens dos usuários
                */
                if (!is_dir( public_path().'/image/usuarios/') ) {
                    mkdir(public_path().'/image/usuarios', 0777, true);
                }
                // Monta o caminho da foto
                $image_name = '/image/usuarios/'.$usuario->nm_usuario.'-'.$usuario->nr_cpf.'.jpg';           

                /**
                *
                *   Chama a função UploadImage para fazer o upload da imagem
                *
                *   @param {String} - Imagem em base64
                *   @param {String} - Caminho da imagem
                */
                FuncoesAuxiliares::UploadImage($request->input('imagem_thumb'), $image_name);

                /**
                *
                *   Monta o Objeto de Fotos do Imóvel e insere o caminho da imagem
                */
                $usuario->foto       = $image_name;
                $usuario->ativo     = true;                
                
	            
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
			if(AutenticacaoController::verificaToken($token)->admin){        	
	            $usuario = Usuario::find($id);

	            $usuario->nm_usuario  	= $request->input('nome');
	            $usuario->nr_cpf   		= $request->input('cpf');
	            $usuario->email 		= $request->input('email');
	            // $usuario->telefone 		= $request->input('telefone');
	            //$usuario->password = \Hash::make($request->input('senha'));

	            if(UsuarioEnum::isValid($request->input('tipo'))){
	                $usuario->tp_funcionario = $request->input('tipo');
	            }else{
	                $usuario->tp_funcionario = UsuarioEnum::CORRETOR;
	            }
                // Monta o caminho da foto
                $image_name = '/image/usuarios/'.$usuario->nm_usuario.'-'.$usuario->nr_cpf.'.jpg';           

                /**
                *
                *   Chama a função UploadImage para fazer o upload da imagem
                *
                *   @param {String} - Imagem em base64
                *   @param {String} - Caminho da imagem
                */

                if(FuncoesAuxiliares::UploadImage($request->input('imagem_thumb'), $image_name)){
                    /**
                    *
                    *   Monta o Objeto de Fotos do Imóvel e insere o caminho da imagem
                    */
                    $usuario->foto = $image_name;  
                    
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

	    	$busca = Usuario::where($input['coluna'],'ilike', $input['valor'].'%')
	    					->orderBy('nm_usuario', 'asc')
	    					->get();

	    	return JSONUtils::returnSuccess('Consulta realizada com sucesso.', $busca);
	    } catch(Exception $e){
    		return JSONUtils::returnDanger('Problema de acesso à base de dados.',$e);
    	}	
    }

    public function getUsuarios()
    {
	    $usuario = Usuario::orderBy('nm_usuario', 'asc')->get();

	    $return = array();

	    foreach ($usuario as $key => $value) {
	        $uVO = new UsuarioVO(Usuario::find($value->id));
	        $return[] = $uVO;
	    }

	    return JSONUtils::returnSuccess('Consulta realizada com sucesso.', $return);
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

    public function getPerfil(Request $request)
    {
    	try{
    		$token   = $request->input('token');
    		$usuario = AutenticacaoController::verificaToken($token);

    		return JSONUtils::returnSuccess('Consulta realizada com sucesso.', $usuario);
    	} catch(Exception $e){
    		return JSONUtils::returnDanger('Problema de acesso à basede dados.', $e);
    	}
    }
}
