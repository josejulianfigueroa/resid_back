<?php

namespace App\Http\Controllers\User;

use App\User;
use Carbon\Carbon;
use App\Reservacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\ApiController;

class UserReservacionController extends ApiController
{
    public function busqueda2(Request $request)
    {
    $mytime=Carbon::now('America/Santiago');
    $mytime=date("Y-m-d h:i:s",strtotime($mytime));
  // $fecha_date=date("Y-m-d",strtotime($mytime));

    if (request()->has('sort_by')){
    }

   $sql='';
   $clientes = '';
       
// Por tabla Reservacion 

        $clientes = Reservacion::with(['hospedaje'=> 
                    function ($query) use ($request) { 
                        if (request()->has('descripcion')){
                            $query= strtolower(trim($request->get('descripcion')));
                            $query->whereRaw( 'LOWER(descripcion) like ?', '%'.$query.'%'); 
                        } 
                            
                    }])
                    ->with(['es_de_usuario' => 
                    function ($query) use ($request) { 
                         if (request()->has('user_id')  and request()->get('user_id') != '0'){
                            $query = $query->where('id',request()->get('user_id')); 
                             } 
                            
                    }]);

                            if (request()->has('status') and request()->get('status') != 'vacio' ){
                               $clientes= $clientes->where('status',$request->get('status'));
                                }

                            if (request()->has('fecha1') and request()->has('fecha2')){

                                $start = Carbon::parse($request->get('fecha1'))->format('Y-m-d');

                                $end = Carbon::parse($request->get('fecha2'))->format('Y-m-d');

                               $clientes = $clientes->whereDate('fechainicio','>=',$start)
                                      ->whereDate('fechasalida','<=',$end);
                                } 
                                if (request()->has('hospedaje')){
                                $clientes = $clientes->where('hospedaje_id',$request->get('hospedaje'));
                                }

                    $clientes = $clientes->get();


 



        return $this->showAll($clientes);

  }
       public function busqueda(Request $request)
    {
         //Log::info('Hola');
         // Log::info($request->get('user_id'));
  
    $mytime=Carbon::now('America/Santiago');
    $mytime=date("Y-m-d h:i:s",strtotime($mytime));
  // $fecha_date=date("Y-m-d",strtotime($mytime));

    if (request()->has('sort_by')){
    }

   $sql='';
   $clientes = '';
       
// Por tabla Reservacion 
/*
        $clientes = Reservacion::with(['hospedaje'=> 
                    function ($query) use ($request) { 
                        if (request()->has('descripcion')){
                            $query= strtolower(trim($request->get('descripcion')));
                            $query->whereRaw( 'LOWER(descripcion) like ?', '%'.$query.'%'); 
                        } 
                            
                    }])
                    ->with(['es_de_usuario' => 
                    function ($query) use ($request) { 
                         if (request()->has('user_id')  and request()->get('user_id') != '0'){
                            $query = $query->where('id',request()->get('user_id')); 
                             } 
                            
                    }]);

                            if (request()->has('status') and request()->get('status') != 'vacio' ){
                               $clientes= $clientes->where('status',$request->get('status'));
                                }

                            if (request()->has('fecha1') and request()->has('fecha2')){

                                $start = Carbon::parse($request->get('fecha1'))->format('Y-m-d');

                                $end = Carbon::parse($request->get('fecha2'))->format('Y-m-d');

                               $clientes = $clientes->whereDate('fechainicio','>=',$start)
                                      ->whereDate('fechasalida','<=',$end);
                                } 
                                if (request()->has('hospedaje')){
                                $clientes = $clientes->where('hospedaje_id',$request->get('hospedaje'));
                                }

                    $clientes = $clientes->get();


 



        return $this->showAll($clientes);

        */
    }

                 /*  return collect($clientes)
                            ->reject(function ($clientes) {
                            return is_null($clientes->pluck('es_de_usuario'));
                            });
                // return  dd($clientes->get('data'));
                     // return  dd($clientes->pluck('es_de_usuario')->isEmpty());
                  //  $clientes = $clientes->reject(function($clientes){
                   //     return $clientes->es_de_usuario->isEmpty();
                   // });
                   */
}
