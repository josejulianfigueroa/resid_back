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

//Usuarios-Reservaciones
Route::name('users.reservaciones')->post('users/reservaciones','User\UserReservacionController@busqueda');



// Hospedajes
Route::resource('hospedajes','Hospedajes\HospedajesController',['only'=>['index','show','update','destroy','store','update_imagen']]);

Route::post('hospedajes/{id?}','Hospedajes\HospedajesController@update_imagen');

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
MAIL_DRIVER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=59372054904a80
MAIL_PASSWORD=f6c84fe8ad0870
MAIL_ENCRYPTION=tls

MAIL_DRIVER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=josejulianfigueroa@gmail.com
MAIL_PASSWORD=yltjsiagljxkfukr
MAIL_ENCRYPTION=tls

MAIL_DRIVER=smtp
MAIL_HOST=mail.eficaz.cl
MAIL_PORT=587
MAIL_USERNAME=jfigueroa
MAIL_PASSWORD=Jfigueroa16
MAIL_ENCRYPTION=tls
*/