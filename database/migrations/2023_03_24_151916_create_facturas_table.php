<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacturasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facturas', function (Blueprint $table) {
            $table->id('idfact');
            $table->unsignedBigInteger('numreling');
            $table->foreign('numreling')
                  ->references('idcfact')
                  ->on('concepto_facts');
            $table->string('nomacre',50);
            $table->string('dirfact');
            $table->string('tipid',1);
            $table->string('identificacion',10);
            $table->integer('tiprif')->nullable();
            $table->string('telefono',15);
            $table->string('tip_pago',10);
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
        Schema::dropIfExists('facturas');
    }
}
