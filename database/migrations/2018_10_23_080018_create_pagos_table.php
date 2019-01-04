<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pagos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('reservacion_id');
            $table->integer('monto')->unsigned();
            $table->timestamp('fecha')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Relacionando
            $table->foreign('reservacion_id')
                  ->references('id')
                  ->on('reservaciones'); // tabla reservaciones
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pagos');
    }
}
