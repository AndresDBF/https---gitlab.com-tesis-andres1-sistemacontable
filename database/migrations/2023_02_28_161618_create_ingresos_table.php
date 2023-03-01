<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIngresosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingresos', function (Blueprint $table) {
            $table->id('iding');
            $table->string('concepto_ing');
            $table->string('moneda',2);
            $table->float('monto',14,2);
            $table->string('stsing',3);
            $table->date('fec_sts');
            $table->unsignedBigInteger('idcfact')->nullable();
            $table->foreign('idcfact')
                  ->references('idcfact')
                  ->on('concepto_fact');
            $table->unsignedBigInteger('coduser')->nullable();
            $table->foreign('coduser')
                  ->references('id')
                  ->on('users');
            $table->unsignedBigInteger('idcli')->nullable();
            $table->foreign('idcli')
                  ->references('idcli')
                  ->on('clientes');
            $table->unsignedBigInteger('idcta')->nullable();
            $table->foreign('idcta')
                  ->references('idcta')
                  ->on('cat_cuentas');
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
        Schema::dropIfExists('ingresos');
    }
}
