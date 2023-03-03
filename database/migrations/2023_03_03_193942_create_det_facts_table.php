<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetFactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('det_facts', function (Blueprint $table) {
            $table->unsignedBigInteger('idfact')->nullable();
            $table->foreign('idfact')
                  ->references('idfact')
                  ->on('facturas');
            $table->string('nomacre',50);
            $table->string('dirfact',100);
            $table->string('rif-cedula',15);
            $table->string('email');
            $table->string('telefono',15);
            $table->string('tip_pago',10);
            $table->string('desc_fact');
            $table->string('moneda',2);
            $table->date('fec_emi');
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
        Schema::dropIfExists('det_facts');
    }
}
