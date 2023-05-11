<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetalleOrdenComprasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_orden_compras', function (Blueprint $table) {
            $table->id('iddord');
            $table->unsignedBigInteger('idorco');
            $table->foreign('idorco')
                   ->references('idorco')
                   ->on('orden_compras');
            $table->string('tiempo_pago');
            $table->string('autorizacion');
            $table->string('descripcion');
            $table->date('fec_autoriza')->format('d/y/m');
            
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
        Schema::dropIfExists('detalle_orden_compras');
    }
}
