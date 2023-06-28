<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetalleRetencionIngresosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_retencion_ingresos', function (Blueprint $table) {
            $table->id('iddrein');
            $table->unsignedBigInteger('idrein');
            $table->foreign('idrein')
                  ->references('idrein')
                  ->on('retencion_ingresos');
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
        Schema::dropIfExists('detalle_retencion_ingresos');
    }
}
