<?php

namespace App\Http\Controllers\Pagos;

use App\Pagos;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Log;

class PagosController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $pagos = Pagos::all();

        //return $usuarios; // Retorna Json por Defecto
        //return response()->json(['data' => $usuarios],200);
       return $this->showAll($pagos);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Log::info($request);

        $rules = [
                'reservacion_id' => 'required',
                'monto' =>'required|numeric',
                //'fecha' => 'required'
        ];
    

        $this->validate($request,$rules);

       $campos = $request->all();

     //  $campos['password'] = bcrypt($request->password);


       $pago = Pagos::create($request->all());

       // Asignacion Masiva de los atributos
                                   // a un array
       // return response()->json(['data' => $usuario], 201);
            return $this->showOne($pago, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //public function show($id)
    public function show($id)
    {
        // Utilizando inyeccion implicita del modelo eliminamos la siguiente linea,
        // porque se hace automatico al entrar al metodo
     $pagos = Pagos::all()->where('reservacion_id','=',$id);
        // return  $id;
        //return response()->json(['data'=> $usuario],200);
        // return $this->showOne($pago);
          return $this->showAll($pagos);

    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pagos $pago)
    {

        // En este caso no es necesario validar esos 2 campos recibidos
          $pago->fill($request->only([
                'reservacion_id',
                'monto',
                'fecha'
        ])); //only revive un array con los atributos que queremos llenar

        if ($pago->isClean()) {
            return $this->errorResponse('Debe especificar algun valor diferente para poder actualizar',422);
        }

        $pago->save();
        return $this->showOne($pago);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pagos $pago)
    {
       // $user = User::findOrFail($id);

        $pago->delete();

        //return response()->json(['data' => $user ], 200);
          return $this->showOne($pago, 200);
    }
}
