<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetalleRetencionIslrsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_retencion_islrs', function (Blueprint $table) {
            $table->id('iddreti');
            $table->unsignedBigInteger('idreti');
            $table->foreign('idreti')
                  ->references('idreti')
                  ->on('retencion_islrs');
            $table->date('fecemifact')->format('Y-m-d');
            $table->string('numfact');
            $table->string('numctrl');
            $table->string('concepto');
            $table->float('baseimponible',14,2);
            $table->float('porcentajeret',14,2);
            $table->float('montoretenido',14,2);
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
        Schema::dropIfExists('detalle_retencion_islrs');
    }
}
