<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatGruposTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cat_grupos', function (Blueprint $table) {
            $table->id('idgru');
            $table->unsignedBigInteger('idcta');
            $table->foreign('idcta')
                  ->references('idcta')
                  ->on('cat_cuentas');
            $table->string('tipgrup',20);
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
        Schema::dropIfExists('cat_grupos');
    }
}
