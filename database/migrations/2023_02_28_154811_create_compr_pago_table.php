<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComprPagoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compr_pago', function (Blueprint $table) {
            $table->id('idcomp');
            $table->integer('numcompr');
            $table->string('nombre',50);
            $table->float('monto',14,2);
            $table->string('stscompr',3);
            $table->unsignedBigInteger('iduser')->nullable();
            $table->foreign('iduser')
                  ->references('id')
                  ->on('users');
            $table->unsignedBigInteger('idcli')->nullable();
            $table->foreign('idcli')
                  ->references('idcli')
                  ->on('clientes');
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
        Schema::dropIfExists('compr_pago');
    }
}
