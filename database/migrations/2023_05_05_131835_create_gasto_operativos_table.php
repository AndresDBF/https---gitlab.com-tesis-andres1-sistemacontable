<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGastoOperativosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gasto_operativos', function (Blueprint $table) {
            $table->id('idgast');
            $table->unsignedBigInteger('idprov');
            $table->foreign('idprov')
                  ->references('idprov')
                  ->on('proveedors');
            $table->unsignedBigInteger('idasi');
            $table->foreign('idasi')
                  ->references('idasi')
                  ->on('asientos');
            $table->unsignedBigInteger('idtga');
            $table->foreign('idtga')
                  ->references('idtga')
                  ->on('tip_gasto_operativos');
            $table->unsignedBigInteger('idorco');
            $table->foreign('idorco')
                  ->references('idorco')
                  ->on('orden_compras');
            $table->string('numfact');
            $table->string('numcrtl');
            $table->date('fec_emi')->format('d/y/m');
            $table->string('tippago',5);
            $table->string('moneda',3);
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
        Schema::dropIfExists('gasto_operativos');
    }
}
