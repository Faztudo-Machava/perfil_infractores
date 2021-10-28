<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);

        if (!Auth::attempt($credentials)) {
            return response(['mensagem' => 'Falha na autenticação', 'is_loged' => false], Response::HTTP_UNAUTHORIZED);
        }

        $user = Auth::user();
        $token = $user->createToken('token')->plainTextToken;
        $cookie = cookie('jwt', $token, 60 * 12);
        return response([
            'mensagem' => 'Usuario autenticado com sucesso',
            'token' => $token,
            'is_loged' => true,
            'user' => $user
        ], Response::HTTP_OK)->withCookie($cookie);
    }

    public function currentUser(){
        return Auth::user();
    }

    public function logout(){
        $cookie = Cookie::forget('jwt');
        return response([
            'mensagem' => 'Sucesso'
        ], Response::HTTP_ACCEPTED)->withCookie($cookie);
    }
}
