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
            $table->id('idfadt');
            $table->unsignedBigInteger('idcfact');
            $table->foreign('idcfact')
                  ->references('idcfact')
                  ->on('concepto_facts');
            $table->string('nomacre',50);
            $table->string('dirfact');
            $table->string('tipid',1);
            $table->string('identificacion',15);
            $table->integer('tipref')->nullable();
            $table->string('email')->nullable();
            $table->string('telefono',15);
            $table->string('tip_pago',10);
            $table->string('desc_fact');
            $table->string('moneda',3);
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
