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
            $table->integer('numfact');
            $table->string('numctrl');
            $table->string('stsfact',3);
            $table->float('monto',14,2);
            $table->float('mtoimponible',14,2);
            $table->float('mtoimpuesto',14,2);
            $table->float('mtototal',14,2);
            $table->unsignedBigInteger('idcfact')->nullable();
            $table->foreign('idcfact')
                  ->references('idcfact')
                  ->on('concepto_facts');
            $table->unsignedBigInteger('idtfact')->nullable();
            $table->foreign('idtfact')
                  ->references('idtfact')
                  ->on('tip_facts');
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
