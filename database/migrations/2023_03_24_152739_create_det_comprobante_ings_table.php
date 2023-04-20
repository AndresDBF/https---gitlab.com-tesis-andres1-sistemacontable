<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetComprobanteIngsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('det_comprobante_ings', function (Blueprint $table) {
            $table->id('iddcomp');
            $table->unsignedBigInteger('idcom');
            $table->foreign('idcom')
                  ->references('idcom')
                  ->on('comprobante_ingresos');
            $table->unsignedBigInteger('idcli');
            $table->foreign('idcli')
                  ->references('idcli')
                  ->on('clientes');
            $table->string('nombre_cliente');
            $table->date('fec_trans')->format('d-m-y');
            $table->string('stscom',3);
            $table->string('formpago',3);
            $table->string('descripcion');
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
        Schema::dropIfExists('det_comprobante_ings');
    }
}
