<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    use ApiResponser;

      /*  public function __construct(){
        	// Le mandamos el guard que vamos a utilizar api
        		$this->middleware('auth:api');
    }*/
}
