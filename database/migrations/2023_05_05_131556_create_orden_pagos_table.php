<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdenPagosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orden_pagos', function (Blueprint $table) {
            $table->id('idorpa');
            $table->unsignedBigInteger('idorco');
            $table->foreign('idorco')
                  ->references('idorco')
                  ->on('orden_compras');
            $table->unsignedBigInteger('idprov');
            $table->foreign('idprov')
                  ->references('idprov')
                  ->on('proveedors');
            $table->string('stsorpa',3);
            $table->string('numfact');
            $table->string('numctrl');
            $table->date('fec_emi')->format('d/y/m');
            $table->date('fec_vencimiento')->format('d/y/m');
            $table->string('tippago');
            $table->string('moneda',3);
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
        Schema::dropIfExists('orden_pagos');
    }
}
