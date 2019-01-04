<?php

use App\User;
use App\Pagos;
use App\Hospedaje;
use App\Reservacion;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

// Factory para Usuario
$factory->define(App\User::class, function (Faker $faker) {
	static $password;
	// mt_rand(1,5) Rango de Numero
	// str_random(8)
    return [
    	'cedula' => mt_rand(17446750,22345555),
        'nombre' => $faker->name, 
        'apellido' => $faker->lastName, 
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'direccion' => $faker->address,
        'telefono' => '9'. mt_rand(66000000,99999999),
        'remember_token' => str_random(40),
        'verified' => $faker->randomElement([User::USUARIO_VERIFICADO,User::USUARIO_NO_VERIFICADO]),
        'verification_token' => User::generarVerificationToken(),
        'admin' =>$faker->randomElement([User::USUARIO_REGULAR,User::USUARIO_ADMINISTRADOR])
    ];
});


 // numberBetween(1,10)
// Factory para Hospedajes
$factory->define(App\Hospedaje::class, function (Faker $faker) {
    return [
        'tipo' => $faker->randomElement([Hospedaje::TIPO_APARTAMENTO]),
        'descripcion' => $faker->paragraph(1),
        'precio' => $faker->randomElement(['2000','4000','6000']),
        'image' =>  $faker->randomElement(['1.jpg','2.jpg','3.jpg']),
    ];
});


        
// Factory para Reservaciones
$factory->define(App\Reservacion::class, function (Faker $faker) {

//  Carbon::now()->format('Y-m-d H:i:s');
	// $format = 'Y-m-d H:i:s',
    return [
        'fechainicio'=>$faker->dateTimeBetween( $startDate = '2018-10-01', $endDate = '2018-10-24', $timezone = 'America/Santiago'),
        'fechasalida'=>$faker->dateTimeBetween($startDate = '2018-10-25', $endDate = '2018-11-24', $timezone = 'America/Santiago'),
        'user_id'=> User::all()->random()->id,
        'fechareserva'=>$faker->dateTime($max = 'now', $timezone = 'America/Santiago'),
        'hospedaje_id'=>  $faker->randomElement(['1','2']),
        'status' => Reservacion::POR_CONFIRMAR
    ];
});

// Factory para Pagos
$factory->define(App\Pagos::class, function (Faker $faker) {


    return [
        'reservacion_id'=>Reservacion::all()->random()->id,
         'monto'=> $faker->randomElement(['100','200','300']),
        'fecha'=>$faker->dateTime($max = 'now', $timezone = 'America/Santiago')
    ];
});
