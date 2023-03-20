<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatCuentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cat_cuentas', function (Blueprint $table) {
            $table->id('idcta');
            $table->string('stscta',3);
            $table->integer('cta1');
            $table->string('cta2')->nullable();
            $table->string('cta3')->nullable();
            $table->string('cta4')->nullable();
            $table->string('cta5')->nullable();
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
        Schema::dropIfExists('cat_cuentas');
    }
}
