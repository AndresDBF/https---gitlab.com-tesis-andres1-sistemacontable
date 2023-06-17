<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTipoAgentesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipo_agentes', function (Blueprint $table) {
            $table->id('idage');
            $table->string('tippersona',1);
            $table->string('concepto');
            $table->string('porcentajebase');
            $table->string('porcentajereten');    
            $table->string('mayorpago');
            $table->string('sustraendo');
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
        Schema::dropIfExists('tipo_agentes');
    }
}
