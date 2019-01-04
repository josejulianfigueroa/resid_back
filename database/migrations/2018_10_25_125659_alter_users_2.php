<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterUsers2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
          Schema::table('reservaciones', function (Blueprint $table) {
         $table->dropForeign('reservaciones_users_id_foreign');
         $table->renameColumn('users_id', 'user_id');
         $table->foreign('user_id')->references('id')->on('users');
        });
       
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
