<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComprobantePagosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comprobante_pagos', function (Blueprint $table) {
            $table->id('idpag');
            $table->unsignedBigInteger('idorpa');
            $table->foreign('idorpa')
                  ->references('idorpa')
                  ->on('orden_pagos');
            $table->unsignedBigInteger('idasi');
            $table->foreign('idasi')
                  ->references('idasi')
                  ->on('asientos');
            $table->integer('numconfirm');
            $table->string('moneda',3);
            $table->float('montolocal',14,2);
            $table->float('montomoneda',14,2);
            $table->string('cantidad_escr');
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
        Schema::dropIfExists('comprobante_pagos');
    }
}
