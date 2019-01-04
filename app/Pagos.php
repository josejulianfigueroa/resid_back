<?php

namespace App;

use App\Reservacion;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pagos extends Model
{

   	 use SoftDeletes;

	 protected $table ='pagos' ;

 	 protected $primaryKey = 'id';

     protected $fillable = [
    			'reservacion_id',
    			'monto',
    			'fecha'
     ];

	 protected $dates = ['deleted_at'];

     public function de_la_reservacion(){
     	return $this->belongsTo(Reservacion::class);
     }

}
