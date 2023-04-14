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
            $table->id('iddfact');
            $table->unsignedBigInteger('idfact');
            $table->foreign('idfact')
                  ->references('idfact')
                  ->on('facturas');
            $table->string('numfact');
            $table->string('numctrl');
            $table->string('stsfact',3);
            $table->date('fec_emi');
            $table->float('monto',14,2)->nullable();
            $table->float('mtoimponible',14,2)->nullable();
            $table->float('mtoimpuesto',14,2)->nullable();
            $table->float('mtototal',14,2)->nullable();
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
