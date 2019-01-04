<?php

namespace App\Http\Controllers\Reservaciones;

use Carbon\Carbon;
use App\Calendario;
use App\Pagos;
use App\Reservacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ApiController;

class ReservacionesController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $reservaciones = Reservacion::all();

          return $this->showAll($reservaciones);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
                'fechainicio' => 'required',
                'fechasalida' =>'required',
                'hospedaje_id' => 'required',
                'user_id' => 'required'
       ];

       $this->validate($request,$rules);

       //Validamos que sean fecha coherentes
        $fechainicio = Carbon::parse($request->input('fechainicio'));
        $fechasalida = Carbon::parse($request->input('fechasalida'));

        $diasDiferencia = $fechasalida->diffInDays($fechainicio);

        if ($fechainicio >= $fechasalida){ 
         return $this->errorResponse('Las Fechas ingresadas no son validas', 409);
       }

        //return response()->json($diasDiferencia);


       //Validamos que el rango de fechas se pueda reservar
        $start = Carbon::parse($request->get('fechainicio'))->format('Y-m-d');

        $end = Carbon::parse($request->get('fechasalida'))->format('Y-m-d');

        $calen = Calendario::whereDate('fecha','>=',$start)
                            ->whereDate('fecha','<=',$end)
                            ->where('hospedaje_id',$request->get('hospedaje_id'))
                            ->count();

              
        if ($calen > 0){ 
         return $this->errorResponse('Las Fechas ingresadas no estan disponibles', 409);
       }

       $ban=0;

       for($i = 0; $i < $diasDiferencia+1; $i++){
        $calen = new Calendario;

        if ($i == 0) {
                     $calen->fecha = $fechainicio;
        }else if ($i == 1) { 
                            $ban=1;
        }else {
                $calen->fecha = $fechainicio->addDay(1);
        }
        
        $calen->hospedaje_id = $request->hospedaje_id;

        if($ban == 0){
        $calen->save();  
        }
        $ban=0;
        }
        
      //  return response()->json($diasDiferencia);

       $campos = $request->all();

       $mytime=Carbon::now('America/Santiago');
       $mytime=date("Y-m-d h:i:s",strtotime($mytime));

       $campos['status'] = Reservacion::POR_CONFIRMAR;
       $campos['fechareserva'] = $mytime;

       $reservacion = Reservacion::create($campos);

       return $this->showOne($reservacion, 201);
       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Reservacion $reservacione)
    {
                 // return response()->json(['data' => $reservaciones],200);
          return $this->showOne($reservacione);
    }

   
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
  
  return DB::transaction( function ()  use ($id) {


        $reservacion = Reservacion::findOrFail($id);
        $start = Carbon::parse($reservacion->fechainicio)->format('Y-m-d');

        $end = Carbon::parse($reservacion->fechasalida)->format('Y-m-d');

        $calen = Calendario::whereDate('fecha','>=',$start)
                            ->whereDate('fecha','<',$end)
                            ->where('hospedaje_id',$reservacion->hospedaje_id)
                            ->delete();
        $pagos = Pagos::where('reservacion_id',$id)
                        ->delete();

        $reservacion->delete();
        return $this->showOne($reservacion, 200);

   });

        
       

    }
}
