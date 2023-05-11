<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetalleGastoOperativosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_gasto_operativos', function (Blueprint $table) {
            $table->id('iddgas');
            $table->unsignedBigInteger('idgast');
            $table->foreign('idgast')
                  ->references('idgast')
                  ->on('gasto_operativos');
            $table->unsignedBigInteger('idcong');
            $table->foreign('idcong')
                  ->references('idcong')
                  ->on('concepto_gastos');
            $table->float('baseimponible',14,2);
            $table->float('monto_impuesto',14,2);
            $table->float('monto_iva',14,2);
            $table->float('monto_total',14,2);
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
        Schema::dropIfExists('detalle_gasto_operativos');
    }
}
