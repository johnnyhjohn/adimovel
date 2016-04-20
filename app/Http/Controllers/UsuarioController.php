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
    public function create(Request $request)
	{
		try{
            $usuario = new Usuario();

            $usuario->nome 	= $request->input('nome');
            //$usuario->cpf 	= $request->input('cpf');
            $usuario->email 	= $request->input('email');
            //$usuario->telefone = $request->input('telefone');
            $usuario->senha = $request->input('senha');

            if(UsuarioEnum::isValid($request->input('tipo'))){
            	$usuario->tipo_funcionario = $request->input('tipo');
        	}else{
        		$usuario->tipo_funcionario = UsuarioEnum::CORRETOR;
        	}

            $usuario->status = true;
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
			'nome'			  => 'required',
            //'cpf' 	  		  => 'required|numeric',
            'email'	  		  => 'required|email',
            //'telefone'		  => 'numeric'
            
        ];
    }

    public function show($id = null)
	{
        $usuarios = Usuario::orderBy('nome', 'asc')->get();

        $return = array();

        foreach ($usuarios as $key => $value) {
            $uVO = new UsuarioVO(Usuario::find($value->id));
            $return[] = $uVO;
        }

        return JSONUtils::returnSuccess('Consulta realizada com sucesso.', $return);

    }

}
