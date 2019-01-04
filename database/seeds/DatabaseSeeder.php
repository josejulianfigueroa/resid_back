<?php

use App\User;
use App\Pagos;
use App\Hospedaje;
use App\Calendario;
use App\Reservacion;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {  
    	DB::statement('SET FOREIGN_KEY_CHECKS = 0');
       Pagos::truncate();
       Calendario::truncate();
       Hospedaje::truncate();
       Reservacion::truncate();
       User::truncate();

// Desactivar todos los eventos relacionados con los modelos
User::flushEventListeners();
Pagos::flushEventListeners();
Calendario::flushEventListeners();
Hospedaje::flushEventListeners();
Reservacion::flushEventListeners();


$cantidadUsuario= 10;
$cantidadPagos= 4;
$cantidadHospedaje= 2;
$cantidadReservacion= 2;

factory(User::class, $cantidadUsuario)->create();
factory(Hospedaje::class, $cantidadHospedaje)->create();
factory(Reservacion::class, $cantidadReservacion)->create();
factory(Pagos::class, $cantidadPagos)->create();
      // $this->call(UsersTableSeeder::class);

    }
}
