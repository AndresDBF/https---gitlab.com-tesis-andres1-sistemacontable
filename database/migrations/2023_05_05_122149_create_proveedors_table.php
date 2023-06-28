<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProveedorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proveedors', function (Blueprint $table) {
            $table->id('idprov');
            $table->string('nombre');
            $table->string('tipid',1);
            $table->integer('identificacion');
            $table->integer('tiprif',)->nullable();
            $table->string('direccion');
            $table->string('telefono');
            $table->string('correo');
            $table->string('categoria');
            $table->string('indcontribuyente',1);
            $table->float('porcentajereten',14,2);
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
        Schema::dropIfExists('proveedors');
    }
}
