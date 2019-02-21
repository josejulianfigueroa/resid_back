<?php

namespace App;

use App\Calendario;
use App\Reservacion;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hospedaje extends Model
{	
	 use SoftDeletes;

	 const TIPO_APARTAMENTO = 'Apartamento';
	 const TIPO_CASA = 'Casa';
	 const TIPO_HABITACION = 'Habitacion';

	 protected $table ='hospedajes' ;

 	 protected $primaryKey = 'id';

     protected $fillable = [
    			'descripcion',
    			'tipo',
    			'precio',
    			'image',
    			'image0',
    			'image1',
    			'image2'
    ];
	protected $dates = ['deleted_at'];

	public function fechas_calendario(){
		return $this->hasMany(Calendario::class);
	}
	public function pertene_reservaciones(){
		return $this->belongsToMany(Reservacion::class);
	}

}
