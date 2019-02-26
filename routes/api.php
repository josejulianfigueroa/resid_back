<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

// Usuarios
Route::resource('users','User\UserController',['only'=>['index','show','update','destroy','store']]);
Route::post('users/{id?}','User\UserController@update_imagen');

//Usuarios-Reservaciones
/*Route::name('users.reservaciones')->post('users/reservaciones','User\UserReservacionController@busqueda');
*/
Route::name('usersyreservaciones')->post('usersyreservaciones','User\UserReservacionController@busqueda2');



// Hospedajes
Route::resource('hospedajes','Hospedajes\HospedajesController',['only'=>['index','show','update','destroy','store','update_imagen']]);

Route::post('hospedajes/{id?}','Hospedajes\HospedajesController@update_imagen');
Route::name('hospedaje_fecha')->get('hospedaje_fecha','Hospedajes\HospedajesController@index_fechas');

//Route::name('hospedajes')->post('hospedajes/{id?}','HospedajesController@update_imagen');



// Reservaciones
Route::resource('reservaciones','Reservaciones\ReservacionesController',['only'=>['index','show','destroy','store']]);



// Pagos
Route::resource('pagos','Pagos\PagosController',['only'=>['index','show','update','destroy','store']]);



// Calendarios
Route::resource('calendarios','Calendarios\CalendariosController',['only'=>['index','show','update','destroy','store']]);


Route::group([
    'middleware' => 'api',
], function () {

    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');
    Route::post('logout', 'AuthController@logout');

    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');

    Route::post('sendPasswordResetLink', 'ResetPasswordController@sendEmail');
    Route::post('resetPassword', 'ChangePasswordController@process');
});


/*

*/