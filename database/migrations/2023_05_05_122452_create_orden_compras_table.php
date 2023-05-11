<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdenComprasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orden_compras', function (Blueprint $table) {
            $table->id('idorco');
            $table->unsignedBigInteger('idprov');
            $table->foreign('idprov')
                   ->references('idprov')
                   ->on('proveedors');
            $table->integer('numorden');
            $table->string('stsorden');
            $table->float('monto',14,2);
            $table->float('monto_unit',14,2);
            $table->float('monto_iva',14,2);
            $table->float('monto_total',14,2);
            
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
        Schema::dropIfExists('orden_compras');
    }
}
