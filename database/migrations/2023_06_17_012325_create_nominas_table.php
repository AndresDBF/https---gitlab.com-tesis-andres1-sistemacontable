<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNominasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nominas', function (Blueprint $table) {
            $table->id('idnom');
            $table->string('nombre');
            $table->string('tipid',1);
            $table->integer('identificacion');
            $table->string('tiprif',1)->nullable();
            $table->string('cargo');
            $table->date('fec_ingr')->format('Y-m-d');
            $table->date('fec_egre')->format('Y-m-d');
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
        Schema::dropIfExists('nominas');
    }
}
