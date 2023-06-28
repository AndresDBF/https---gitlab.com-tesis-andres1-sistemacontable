<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProyeccionGastosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proyeccion_gastos', function (Blueprint $table) {
            $table->id('idpro');
            $table->float('presupuesto',14,2);
            $table->float('presupuesto_ini',14,2);
            $table->date('fecstsini')->format('Y-m-d');
            $table->date('fecstsfin')->format('Y-m-d');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proyeccion_gastos');
    }
}
