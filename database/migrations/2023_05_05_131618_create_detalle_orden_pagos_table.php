<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetalleOrdenPagosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_orden_pagos', function (Blueprint $table) {
            $table->id('iddorp');
            $table->unsignedBigInteger('idorpa');
            $table->foreign('idorpa')
                  ->references('idorpa')
                  ->on('orden_pagos');
            $table->unsignedBigInteger('idcon');
            $table->foreign('idcon')
                  ->references('idcon')
                  ->on('concepto_ordens');
            $table->float('baseimponible',14,2);
            $table->float('monto_iva',14,2);
            $table->float('monto_total',14,2);
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
        Schema::dropIfExists('detalle_orden_pagos');
    }
}
