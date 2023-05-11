<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAsientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asientos', function (Blueprint $table) {
            $table->id('idasi');
            $table->date('fec_asi');
            $table->string('observacion')->nullable();
/*             $table->string('contacto_acre',50);
            $table->string('contacto_benf',50); */
            $table->unsignedBigInteger('idcta1')->unsigned();
            $table->foreign('idcta1')
                  ->references('idcta')
                  ->on('cat_cuentas');
            $table->unsignedBigInteger('idcta2')->unsigned();
            $table->foreign('idcta2')
                  ->references('idcta')
                  ->on('cat_cuentas');
            $table->string('descripcion');
            $table->float('monto_deb',14,2);
            $table->float('monto_hab',14,2);
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
        Schema::dropIfExists('asientos');
    }
}
