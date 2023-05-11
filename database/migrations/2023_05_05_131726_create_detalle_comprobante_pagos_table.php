<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetalleComprobantePagosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_comprobante_pagos', function (Blueprint $table) {
            $table->id('iddpag');
            $table->unsignedBigInteger('idpag');
            $table->foreign('idpag')
                  ->references('idpag')
                  ->on('comprobante_pagos');
            $table->unsignedBigInteger('idprov');
            $table->foreign('idprov')
                  ->references('idprov')
                  ->on('proveedors');
            $table->date('fec_trans')->format('d/y/m');;
            $table->string('formpago',5);
            $table->string('descripcion');            
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
        Schema::dropIfExists('detalle_comprobante_pagos');
    }
}
