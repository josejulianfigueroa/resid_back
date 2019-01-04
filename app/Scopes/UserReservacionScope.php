<?php 

namespace App\Scopes;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Builder;

class UserReservacionScope implements Scope {
// Casa vez que se requiera esta instancia de modelo se ejecuta este scope

public function apply(Builder $builder, Model $model) {
	$builder->has('tiene_reservacion'); 
}


}