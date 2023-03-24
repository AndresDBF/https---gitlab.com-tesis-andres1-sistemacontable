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
            $table->unsignedBigInteger('iddcomp');
            $table->foreign('iddcomp')
                  ->references('iddcomp')
                  ->on('det_comprobante_ings');
            $table->string('concepto_ing');
            $table->string('moneda',3);
            $table->float('stsing',3);
            $table->date('fecsts');
            $table->unsignedBigInteger('idcli');
            $table->foreign('idcli')
                  ->references('idcli')
                  ->on('clientes');
            $table->unsignedBigInteger('idcta');
            $table->foreign('idcta')
                  ->references('idcta')
                  ->on('cat_cuentas');      
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
        Schema::dropIfExists('ingresos');
    }
}
