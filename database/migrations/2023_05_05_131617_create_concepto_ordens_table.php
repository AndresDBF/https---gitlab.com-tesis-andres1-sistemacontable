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
            $table->float('montounitariolocal',14,2);
            $table->float('montounitariomoneda',14,2);
            $table->float('montobienlocal',14,2);
            $table->float('montobienmoneda',14,2);
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
