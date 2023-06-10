<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacturasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facturas', function (Blueprint $table) {
            $table->id('idfact');
            $table->unsignedBigInteger('idcfact');
            $table->foreign('idcfact')
                  ->references('idcfact')
                  ->on('concepto_facts');
            $table->unsignedBigInteger('idcli');
            $table->foreign('idcli')
                        ->references('idcli')
                        ->on('clientes');
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
        Schema::dropIfExists('facturas');
    }
}
