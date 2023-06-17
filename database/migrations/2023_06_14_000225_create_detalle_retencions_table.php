<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetalleRetencionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_retencions', function (Blueprint $table) {
            $table->id('iddret');
            $table->unsignedBigInteger('idret');
            $table->foreign('idret')
                  ->references('idret')
                  ->on('retencions');
            $table->date('fecemifact')->format('Y-m-d');
            $table->string('numfact');
            $table->string('numctrl');
            $table->float('totalfact',14,2);
            $table->float('baseimponible',14,2);
            $table->float('montoimpuesto',14,2);
            $table->float('impuestoretenido',14,2);
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
        Schema::dropIfExists('detalle_retencions');
    }
}
