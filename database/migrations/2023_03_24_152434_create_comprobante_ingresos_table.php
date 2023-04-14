<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComprobanteIngresosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comprobante_ingresos', function (Blueprint $table) {
            $table->id('idcom');
            $table->unsignedBigInteger('idfact');
            $table->foreign('idfact')
                  ->references('idfact')
                  ->on('facturas');
            $table->string('numconfirm',20);
            $table->string('numfact');
            $table->string('moneda',3);
            $table->float('cantidad',14,2);
            $table->string('cantidad_escr',100);
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
        Schema::dropIfExists('comprobante_ingresos');
    }
}
