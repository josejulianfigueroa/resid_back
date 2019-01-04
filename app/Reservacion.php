<?php

namespace App;

use App\User;
use App\Hospedaje;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reservacion extends Model
{
     use SoftDeletes;

     const CONFIRMADA = 'Confirmada';
     const POR_CONFIRMAR = 'Por Confirmar';
     const CANCELADA = 'Cancelada';
     const PAGADA = 'Pagada';

	 protected $table ='reservaciones' ;

 	 protected $primaryKey = 'id';

     protected $fillable = [
    			'fechainicio',
    			'fechasalida',
    			'fechareserva',
    			'hospedaje_id',
    			'user_id',
    			'status'
     ];

     public function estaConfirmada(){
        return $this->status == Reservacion::CONFIRMADA;
    } 

	 protected $dates = ['deleted_at'];

     public function es_de_usuario(){
     	return $this->belongsTo(User::class,'user_id');
     }

     public function hospedaje (){
     	return $this->belongsTo(Hospedaje::class,'hospedaje_id');
     }
}
