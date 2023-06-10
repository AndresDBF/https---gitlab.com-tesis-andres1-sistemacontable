<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDescripcionFacturasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('descripcion_facturas', function (Blueprint $table) {
            $table->id('iddfact');
            $table->unsignedBigInteger('idfact');
            $table->foreign('idfact')
                  ->references('idfact')
                  ->on('facturas');
            $table->string('descripcion');
            $table->float('montounitariolocal',14,2);
            $table->float('monto_unitariomoneda',14,2);
            $table->float('montobienlocal',14,2);
            $table->float('monto_bienmoneda',14,2);
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
        Schema::dropIfExists('descripcion_facturas');
    }
}
