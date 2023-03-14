<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatgSubCuentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() 
    {
        Schema::create('catg_sub_cuentas', function (Blueprint $table) {
            $table->id('idscu');
            $table->unsignedBigInteger('idcta');
            $table->foreign('idcta')
                  ->references('idcta')
                  ->on('cat_cuentas');
            $table->string('tipsubcta',20);
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
        Schema::dropIfExists('catg_sub_cuentas');
    }
}
