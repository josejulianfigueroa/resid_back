<?php

namespace App\Http\Controllers\User;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class UserController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $usuarios = User::all();

        //return $usuarios; // Retorna Json por Defecto
        //return response()->json(['data' => $usuarios],200);
       return $this->showAll($usuarios);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
                'nombre' => 'required',
                'email' =>'required|email|unique:users',
                'password' => 'required|min:6|confirmed'
        ];

        $this->validate($request,$rules);

       $campos = $request->all();

       $campos['password'] = bcrypt($request->password);
       $campos['verified'] = User::USUARIO_NO_VERIFICADO;
       $campos['verification_token'] = User::generarVerificationToken();
       $campos['admin'] = User::USUARIO_REGULAR;

       $usuario = User::create($campos);

       // Asignacion Masiva de los atributos
                                   // a un array
       // return response()->json(['data' => $usuario], 201);
            return $this->showOne($usuario, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //public function show($id)
    public function show(User $user)
    {
        // Utilizando inyeccion implicita del modelo eliminamos la siguiente linea,
        // porque se hace automatico al entrar al metodo
        //$usuario = User::findOrFail($id);

        //return response()->json(['data'=> $usuario],200);
         return $this->showOne($user);

    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
       // $user= User::findOrFail($id);

        $rules = [
                    // exceptuamos el propio email del usuario
                'email' =>'email|unique:users,email,' . $user->id ,
                'admin' => 'in:' . User::USUARIO_REGULAR . ',' . User::USUARIO_REGULAR,
                'password' => 'min:6|confirmed'
        ];

        $this->validate($request,$rules);

        if ($request->has('nombre')) {
            $user->nombre = $request->nombre;
        }
         if ($request->has('cedula')) {
            $user->cedula = $request->cedula;
        }

        if ($request->has('email') && $user->email != $request->email){
            $user->verified = User::USUARIO_NO_VERIFICADO;
            $user->verification_token = User::generarVerificationToken();
            $user->email = $request->email;
        }

        if ($request->has('password')) {
            $user->password = bcrypt($request->password);
        }

        if ($request->has('admin')){
            if (!$user->esVerificado()) {
            //    return response()->json(['error' => 'Unicamente los usuarios verificados pueden cambiar su valor a administrado','code' => 409], 409);
                return $this->errorResponse('Unicamente los usuarios verificados pueden cambiar su valor a administrador', 409);
            }
            $user->admin = $request->admin;
        }
        if (!$user->isDirty()){

            return $this->errorResponse('Deben existir valores diferentes para poder actualizar', 422);

              
        }

        $user->save();

        //return response()->json(['data' => $user], 200);
         return $this->showOne($user, 201);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
       // $user = User::findOrFail($id);

        $user->delete();

        //return response()->json(['data' => $user ], 200);
          return $this->showOne($user, 200);
    }
}
