<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConceptoOrdensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('concepto_ordens', function (Blueprint $table) {
            $table->id('idcon');
            $table->unsignedBigInteger('idorpa');
            $table->foreign('idorpa')
                  ->references('idorpa')
                  ->on('orden_pagos');
            $table->string('descripcion');
            $table->float('monto_unitario',14,2);
            $table->float('monto_bien',14,2);
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
        Schema::dropIfExists('concepto_ordens');
    }
}
