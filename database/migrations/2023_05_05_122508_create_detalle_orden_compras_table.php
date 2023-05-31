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
            $table->string('descripcion');
            $table->float('monto_unit',14,2);
            $table->float('monto_bien',14,2);
            $table->float('monto_iva',14,2)->nullable();
            $table->float('monto_total',14,2)->nullable();
            
            
            
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
