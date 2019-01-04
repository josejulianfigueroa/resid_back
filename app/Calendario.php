<?php

namespace App;

use App\Hospedaje;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Calendario extends Model
{
     use SoftDeletes;
    
	 protected $table ='calendarios' ;

 	 protected $primaryKey = 'id';

     protected $fillable = [
    			'fecha',
    			'hospedaje_id'
     ];

     public function del_hospedaje(){
     	return $this->belongsTo(Hospedaje::class);
     }
}
