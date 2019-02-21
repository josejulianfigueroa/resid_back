<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\SignUpRequest; 
use App\User;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
       //  $this->middleware('auth:api', ['except' => ['login', 'signup']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {

            return response()->json(['error' => 'Usuario no Registrado'], 401);
        }

        return $this->respondWithToken($token);
    }

      public function signup(Request $request)
    {

         $validator = Validator::make($request->all(), [
             'nombre' => 'required',
            'email' => 'required|email|unique:users',
           // 'password' => 'required|confirmed'
            'password' => 'required'
        ]);

        
        if ($validator->passes()) {

            User::create($request->all());

            return $this->login($request);
        }else{

            return response()->json(['error' => 'Email ya existe, Intente con otro'], 422);
        }

        }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'nombre' => auth()->user()->nombre,
            'rol' => auth()->user()->admin,
            'id' => auth()->user()->id,
            'email' => auth()->user()->email,
            'apellido' => auth()->user()->apellido,
            'direccion' => auth()->user()->direccion,
            'imagen' => auth()->user()->imagen,
            'imagen' => auth()->user()->imagen
        ]);
    }
}
