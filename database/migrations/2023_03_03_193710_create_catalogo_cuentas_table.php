<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatalogoCuentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('catalogo_cuentas', function (Blueprint $table) {
            $table->id('idcta');
            $table->string('nombre_cuenta',25);
            $table->string('tipcta');
            $table->string('tipmov');
            $table->string('stscta',3);
            $table->string('cta1');
            $table->string('cta2');
            $table->string('cta3');
            $table->string('cta4');
            $table->string('cta5');
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
        Schema::dropIfExists('catalogo_cuentas');
    }
}
