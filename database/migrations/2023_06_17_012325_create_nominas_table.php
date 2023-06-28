<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use function PHPUnit\Framework\once;

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
            $table->unsignedBigInteger('idcarg');
            $table->foreign('idcarg')
                  ->references('idcarg')
                  ->on('tip_cargo_empleados');
            $table->string('nombre');
            $table->string('tipid',1);
            $table->integer('identificacion');
            $table->string('tiprif',1)->nullable();
            $table->string('telefono',15);
            $table->string('direccion');
            $table->string('correo',50);
            $table->string('stsemp',3);
            $table->float('sueldo',14,2);
            $table->date('fec_ingr')->format('Y-m-d');
            $table->date('fec_egre')->format('Y-m-d')->nullable();
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
