<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Usuario as User;
use Hash;
use JWTAuth;

use App\JSONUtils;
use App\Messages;

class AutenticacaoController extends Controller
{
 	public function __construct()
    {
        $this->middleware('jwt-auth', ['except' => ['authenticate']]);
    }
    /**
     * Return the user
     *
     * @return Response
     */
    public function index()
    {
        $users = User::all();
        return $users;
    }

    public static function verificaToken($token)
    {
    	try{

			$user = JWTAuth::toUser($token);
			
    		return $user->admin;

    	}catch(Exception $e){
    		return JSONUtils::returnDanger('Problema de acesso à base de dados.',$e);
    	}
    }
    /**
     * Return a JWT
     *
     * @return Response
     */
    public function authenticate(Request $request)
  	{
    	$input = $request->all();

    	if (!$token = JWTAuth::attempt($input)) {
            return response()->json(['erro' => 'Email ou senha incorretos']);
        }

    	$user = JWTAuth::toUser($token);

    	return response()->json(['token' => $token]);  	
    }
    /**
     * Return the authenticated user
     *
     * @return Response
     */
    public function getAuthenticatedUser(Request $request)
    {

    	$input 	= $request->all();
    	$user 	= JWTAuth::toUser($input['token']);
        try {
	    	$input = $request->all();
	    	$user = JWTAuth::toUser($input['token']);

            if (!$user) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['token_expired'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['token_absent'], $e->getStatusCode());
        }
	    	
    	return response()->json(['user' => $user]);
    }    
}