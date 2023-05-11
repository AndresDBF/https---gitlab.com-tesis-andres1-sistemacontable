<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConceptoGastosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('concepto_gastos', function (Blueprint $table) {
            $table->id('idcong');
            $table->unsignedBigInteger('idgast');
            $table->foreign('idgast')
                  ->references('idgast')
                  ->on('gasto_operativos');
            $table->string('descripcion');
            $table->float('monto_unitario',14,2);
            $table->float('monto_bien',14,2);
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
        Schema::dropIfExists('concepto_gastos');
    }
}
