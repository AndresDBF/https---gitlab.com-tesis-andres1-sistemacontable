<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetCompPagoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('det_comp_pago', function (Blueprint $table) {
            $table->unsignedBigInteger('idcomp')->nullable();
            $table->foreign('idcomp')
                  ->references('idcomp')
                  ->on('compr_pago');
            $table->string('nombre',50);
            $table->date('fecha');
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
        Schema::dropIfExists('det_comp_pago');
    }
}
