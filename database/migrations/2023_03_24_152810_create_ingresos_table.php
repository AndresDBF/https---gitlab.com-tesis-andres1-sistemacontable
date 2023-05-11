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
            $table->unsignedBigInteger('idcli');
            $table->foreign('idcli')
                    ->references('idcli')
                    ->on('clientes');
            $table->unsignedBigInteger('iddfact');
            $table->foreign('iddfact')
                  ->references('iddfact')
                  ->on('det_facts');
            $table->unsignedBigInteger('coduser');
            $table->foreign('coduser')
                  ->references('id')
                  ->on('users');
            $table->unsignedBigInteger('idasi');
            $table->foreign('idasi')
                  ->references('idasi')
                  ->on('asientos');    
            $table->string('concepto_ing');
            $table->string('moneda',3);
            $table->string('stsing',3);
            $table->date('fec_ing')->format('d-y-m');
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
