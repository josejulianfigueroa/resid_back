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
       public function busqueda(Request $request)
    {
    
    $mytime=Carbon::now('America/Santiago');
    $mytime=date("Y-m-d h:i:s",strtotime($mytime));
  // $fecha_date=date("Y-m-d",strtotime($mytime));


    if (request()->has('sort_by')){
    }

   $sql='';
   $clientes = '';
/*
if (request()->has('nombre')){
    $query= strtolower(trim($request->get('nombre')));
    $sql =User::whereRaw( 'LOWER(nombre) like ?', '%'.$query.'%'); 
} else {
    $sql = User::where('id','>=','0');
}

        $clientes = $sql->with(['tiene_reservacion' => 
                    function ($query) use ($request) { 

                            if (request()->has('status')){
                                $query->where('status',$request->get('status'));
                                }

                            if (request()->has('fecha1') and request()->has('fecha2')){

                                $start = Carbon::parse($request->get('fecha1'))->format('Y-m-d');

                                $end = Carbon::parse($request->get('fecha2'))->format('Y-m-d');

                                $query->whereDate('fechainicio','>=',$start)
                                      ->whereDate('fechasalida','<=',$end);
                                } 
                                if (request()->has('hospedaje')){
                                $query->where('hospedaje_id',$request->get('hospedaje'));
                                }

                               $query->has('pertenece_a_hospejade');

                    }])
                    ->get()
                    ->reject(function($user){
                        return $user->tiene_reservacion->isEmpty();
                    });
*/


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
                        if (request()->has('nombre')){
                            $query= strtolower(trim($request->get('nombre')));
                            $query->whereRaw( 'LOWER(nombre) like ?', '%'.$query.'%'); 
                        } 
                            
                    }]);

                            if (request()->has('status')){
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
                   /* ->reject(function($user){
                        return $user->tiene_reservacion->isEmpty();
                    });*/



        return $this->showAll($clientes);
    }


}
