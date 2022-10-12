<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request) {
        //utilizado para gerar o token de login
        $credenciais = $request->all(['email', 'password']);
        
        //validar o usuario por email e senha
        $token = auth('api')->attempt($credenciais);
        
        if($token) {
            //usuario autenticado com sucesso
            return response()->json(['token' => $token]);
        } else {
            //erro no usuario ou senha
            return response()->json(['erro' => 'Usúario ou senha incorreto!'], 403);
        }

        return 'login';
    }
    
    public function logout() {
        auth('api')->logout();
        return response()->json(['msg' => 'logout realizado com sucesso']);
    }
    
    public function refresh() {
        //utilizado para atualizar a autenticação(token) para renovar o tempo do token
        $token = auth('api')->refresh(); //necessario um token valido
        return response()->json(['token' => $token]);
    }
    
    public function me() {
        //utilizado para retornar as informações do usuario que criou o token passado
        return response()->json(auth()->user());
    }
}
