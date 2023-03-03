<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTipFactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tip_facts', function (Blueprint $table) {
            $table->id('idtfact');
            $table->unsignedBigInteger('idcomp')->nullable();
            $table->foreign('idcomp')
                  ->references('idcomp')
                  ->on('comp_pagos');
            $table->integer('idord')->unsigned();
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
        Schema::dropIfExists('tip_facts');
    }
}
