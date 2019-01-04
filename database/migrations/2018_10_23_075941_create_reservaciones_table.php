<?php

use App\Reservacion;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReservacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservaciones', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamp('fechainicio');
            $table->timestamp('fechasalida');
            $table->integer('users_id');
            $table->timestamp('fechareserva');
            $table->integer('hospedaje_id');
            $table->string('status')->default(Reservacion::POR_CONFIRMAR);
            
            $table->timestamps();
            $table->softDeletes();

            // Relaciones
            $table->foreign('users_id')->references('id')->on('users');
            $table->foreign('hospedaje_id')->references('id')->on('hospedaje');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reservaciones');
    }
}
