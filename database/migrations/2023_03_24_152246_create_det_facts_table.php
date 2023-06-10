<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetFactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('det_facts', function (Blueprint $table) {
            $table->id('iddfact');
            $table->unsignedBigInteger('idfact');
            $table->foreign('idfact')
                  ->references('idfact')
                  ->on('facturas');
            $table->string('numfact');
            $table->string('numctrl');
            $table->string('stsfact',3);
            $table->date('fec_emi');
            $table->float('mtolocal',14,2)->nullable();
            $table->float('mtomoneda',14,2)->nullable();
            $table->float('mtoimponiblelocal',14,2)->nullable();
            $table->float('mtoimponiblemoneda',14,2)->nullable();
            $table->float('mtoimpuestolocal',14,2)->nullable();
            $table->float('mtoimpuestomoneda',14,2)->nullable();
            $table->float('mtototallocal',14,2)->nullable();
            $table->float('mtototalmoneda',14,2)->nullable();
            $table->float('tasa_cambio',14,2)->nullable();
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
        Schema::dropIfExists('det_facts');
    }
}
