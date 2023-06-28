<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRetencionIslrsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('retencion_islrs', function (Blueprint $table) {
            $table->id('idreti');
            $table->unsignedBigInteger('idpag');
            $table->foreign('idpag')
                  ->references('idpag')
                  ->on('comprobante_pagos');
            $table->unsignedBigInteger('idasi');
            $table->foreign('idasi')
                  ->references('idasi')
                  ->on('asientos');
            $table->unsignedBigInteger('idprov');
            $table->foreign('idprov')
                  ->references('idprov')
                  ->on('proveedors');
            $table->unsignedBigInteger('idorpa');
            $table->foreign('idorpa')
                  ->references('idorpa')
                  ->on('orden_pagos');
            $table->unsignedBigInteger('idage');
            $table->foreign('idage')
                  ->references('idage')
                  ->on('tipo_agentes');
            $table->string('ncomprobante');
            $table->date('fecemi')->format('Y-m-d');
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
        Schema::dropIfExists('retencion_islrs');
    }
}
