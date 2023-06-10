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
            $table->float('montounitlocal',14,2);
            $table->float('montounitmoneda',14,2);
            $table->float('montobienlocal',14,2);
            $table->float('montobienmoneda',14,2);
            $table->float('montoivalocal',14,2)->nullable();
            $table->float('montoivamoneda',14,2)->nullable();
            $table->float('montototallocal',14,2)->nullable();
            $table->float('montototalmoneda',14,2)->nullable();
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
        Schema::dropIfExists('detalle_orden_compras');
    }
}
