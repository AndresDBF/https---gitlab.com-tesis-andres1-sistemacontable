<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatgCuentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('catg_cuentas', function (Blueprint $table) {
            $table->id('idgcu');
            $table->unsignedBigInteger('idcta');
            $table->foreign('idcta')
                  ->references('idcta')
                  ->on('cat_cuentas');
            $table->string('tipsubg',20);
            $table->string('tipcta',20);
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
        Schema::dropIfExists('catg_cuentas');
    }
}
