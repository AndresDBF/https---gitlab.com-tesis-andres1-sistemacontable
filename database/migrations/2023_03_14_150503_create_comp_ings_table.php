<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompIngsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comp_ings', function (Blueprint $table) {
            $table->id('idcomp');
            $table->unsignedBigInteger('iddcom');
            $table->foreign('iddcom')
                  ->references('iddcom')
                  ->on('det_comp_ings');
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
        Schema::dropIfExists('comp_ings');
    }
}
