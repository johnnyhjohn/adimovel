<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\ViewObject\UsuarioVO;
use App\Http\Enum\UsuarioEnum;

use App\JSONUtils;
use App\Messages;
use App\Usuario;

class UsuarioController extends Controller
{

    public function index($id = null)
    {  
        try{
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
        } catch(Exception $e){
            return JSONUtils::returnDanger('Problema de acesso à base de dados.', $e);
        }    
    }

    public function create(Request $request)
	{
		try{
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
            $usuario->admin = false;

            $validator = \Validator::make($request->all(), $this->validaCadastro());
	        if ($validator->fails()) {
				return JSONUtils::returnDanger('Problema de validação verifique os campos e tente novamente.', "Erro");   
	        }

        	$usuario->save();
			return JSONUtils::returnSuccess('usuario '. $usuario->nome .' cadastrada com sucesso.', $usuario);

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
            'senha'		  	=> 'required'
            
        ];
    }

    public function show($id = null)
	{
        $usuarios = Usuario::orderBy('nm_usuario', 'asc')->get();

        $return = array();

        foreach ($usuarios as $key => $value) {
            $uVO = new UsuarioVO(Usuario::find($value->id));
            $return[] = $uVO;
        }

        return JSONUtils::returnSuccess('Consulta realizada com sucesso.', $return);

    }

<<<<<<< Updated upstream
    public function update(Request $request, $id)
    {
        try{
            $usuario = Usuario::find($id);

            $usuario->nm_usuario  = $request->input('nome');
            $usuario->nr_cpf   = $request->input('cpf');
            $usuario->email = $request->input('email');
            //$usuario->telefone = $request->input('telefone');
            $usuario->password = \Hash::make($request->input('senha'));

            if(UsuarioEnum::isValid($request->input('tipo'))){
                $usuario->tp_funcionario = $request->input('tipo');
            }else{
                $usuario->tp_funcionario = UsuarioEnum::CORRETOR;
            }

            $usuario->ativo = true;
            $usuario->admin = false;


            $validator = \Validator::make($request->all(), $this->validaCadastro());
            if ($validator->fails()) {
                return JSONUtils::returnDanger('Problema de validação verifique os campos e tente novamente.', $validator->errors()->all());   
            }

            $usuario->save();
            return JSONUtils::returnSuccess($usuario->nome .' alterada com sucesso.', $usuario);
        }catch(Exception $e){
            return JSONUtils::returnDanger('Problema de acesso à base de dados.', $e);
        }
    }

    public function destroy($id){
        try{
            $usuario = Usuario::find($id);
            $usuario->delete();

            return JSONUtils::returnSuccess('Item deletado com sucesso.', $usuario);
        }catch(Exception $e){
            return JSONUtils::returnDanger('Problema de acesso à base de dados.',$e);
        }
    }

=======
    public function busca(Request $request)
    {
    	try{
	    	$input = $request->all();

	    	$busca = Usuario::where($input['coluna'],'like', $input['valor'].'%')
	    					->orderBy('nome', 'asc')
	    					->get();

	    	return JSONUtils::returnSuccess('Consulta realizada com sucesso.', $busca);
	    } catch(Exception $e){
    		return JSONUtils::returnDanger('Problema de acesso à base de dados.',$e);
    	}	
    }
>>>>>>> Stashed changes
}
