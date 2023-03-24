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
            $table->integer('num_compr');
            $table->string('stscomp',3);
            $table->float('monto',14,2);
            $table->string('moneda',3);
            $table->unsignedBigInteger('id');
            $table->foreign('id')
                  ->references('id')
                  ->on('users');
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
