<?php

namespace App\Http\Controllers\Hospedajes;

use App\Hospedaje;
use App\Reservacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Storage;

class HospedajesController extends ApiController
 {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $hospedajes = Hospedaje::all();

        //return $usuarios; // Retorna Json por Defecto
        //return response()->json(['data' => $usuarios],200);
       return $this->showAll($hospedajes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
 // Log::info($request);
// return $request;
        $rules = [
                'descripcion' => 'required',
                'tipo' =>'required|in: ' . Hospedaje::TIPO_APARTAMENTO . ',' . Hospedaje::TIPO_CASA. ',' . Hospedaje::TIPO_HABITACION,
               // 'precio' => 'required|numeric|min:0'
        ];

        $this->validate($request,$rules);

        $hospedaje=new Hospedaje;
        $hospedaje->descripcion=$request->get('descripcion');
         $hospedaje->tipo=$request->get('tipo');
          $hospedaje->precio=$request->get('precio');


       //$campos = $request->all();

      //$data= $request->all();

            if (Input::hasFile('image')){
        $valor =str_random(3);
        // Log::info($valor);

        $file = Input::file('image');
        $file->move(public_path().'/img/',$valor.'_'.$file->getClientOriginalName());

         $hospedaje->image = $valor.'_'.$file->getClientOriginalName();
        
        }

     // $data['image'] = $request->image->store('');//'1.jpg';
      /*
if(Input::hasFile('imagen')){
            $file = Input::file('imagen');
            $file->move(public_path().'/imagenes/articulos/',$file->getClientOriginalName());
            $articulo->imagen=$file->getClientOriginalName();
        }
      */
            $hospedaje->save();
    //  $hospedaje = Hospedaje::create($data);

       // Asignacion Masiva de los atributos
                                   // a un array
       // return response()->json(['data' => $usuario], 201);
            return $this->showOne($hospedaje, 201);
    
}


 public function update_imagen(Request $request,$id)
    {

        if ($id) {

        $hospedaje = Hospedaje::findOrFail($id);

        $hospedaje->descripcion= $request->get('descripcion');
         $hospedaje->tipo= $request->get('tipo');
          $hospedaje->precio= $request->get('precio');


       if (Input::hasFile('image')){
        $valor =str_random(3);
        // Log::info($valor);

        Storage::delete($hospedaje->image);

        $file = Input::file('image');
        $file->move(public_path().'/img/',$valor.'_'.$file->getClientOriginalName());

        $hospedaje->image = $valor.'_'.$file->getClientOriginalName();
        
        }
        $hospedaje->update();  
    }
          else{
             return $this->errorResponse('No hay Id para actualizar',422); 
          }
       

        return $this->showOne($hospedaje);
        }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //public function show($id)
    public function show(Hospedaje $hospedaje)
    {
        // Utilizando inyeccion implicita del modelo eliminamos la siguiente linea,
        // porque se hace automatico al entrar al metodo
        //$usuario = User::findOrFail($id);

        //return response()->json(['data'=> $usuario],200);
         return $this->showOne($hospedaje);

    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Hospedaje $hospedaje)
    {
       
         
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       // $user = User::findOrFail($id);
        $count = Reservacion::where('hospedaje_id',$id)
                ->count();

        if($count > 0) {
        return $this->errorResponse('Imposible eliminar, El hospedaje está vinculado al menos a una reservacion',422); 
        }
            else{

        
        $hospedaje = Hospedaje::findOrFail($id);
        Storage::delete($hospedaje->image);
        $hospedaje->delete();

        return $this->showOne($hospedaje, 200);
        }
        //return response()->json(['data' => $user ], 200);
         
    }
}
