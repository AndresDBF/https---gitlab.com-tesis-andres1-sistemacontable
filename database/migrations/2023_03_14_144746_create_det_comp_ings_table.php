<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetCompIngsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('det_comp_ings', function (Blueprint $table) {
            $table->id('iddcom');
            $table->unsignedBigInteger('idfadt');
            $table->foreign('idfadt')
                  ->references('idfadt')
                  ->on('det_facts');
            $table->string('nombre',100);
            $table->date('feccomp');
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
        Schema::dropIfExists('det_comp_ings');
    }
}
