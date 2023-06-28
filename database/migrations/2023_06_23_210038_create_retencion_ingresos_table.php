<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRetencionIngresosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('retencion_ingresos', function (Blueprint $table) {
            $table->id('idrein');
            $table->unsignedBigInteger('iding');
            $table->foreign('iding')
                  ->references('iding')
                  ->on('ingresos');
            $table->unsignedBigInteger('idasi');
            $table->foreign('idasi')
                  ->references('idasi')
                  ->on('asientos');
            $table->unsignedBigInteger('idcli');
            $table->foreign('idcli')
                  ->references('idcli')
                  ->on('clientes');
            $table->unsignedBigInteger('idfact');
            $table->foreign('idfact')
                  ->references('idfact')
                  ->on('facturas');
            $table->string('ncomprobante');
            $table->date('fecemi')->format('Y-m-d');
            $table->date('fecrecep')->format('Y-m-d');
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
        Schema::dropIfExists('retencion_ingresos');
    }
}
