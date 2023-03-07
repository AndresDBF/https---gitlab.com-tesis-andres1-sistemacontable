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
            $table->unsignedBigInteger('idcont')->nullable();
            $table->foreign('idcont')
                  ->references('idcont')
                  ->on('contr_clis');
            $table->date('fec_asi');
            $table->string('refer');
            $table->string('observacion',100)->nullable();
            $table->string('contacto_acre',50);
            $table->string('contacto_benf',50);
            $table->unsignedBigInteger('idcta')->unsigned();
            $table->foreign('idcta')
                  ->references('idcta')
                  ->on('cat_cuentas');
            $table->string('descripcion');
            $table->float('monto_deb',14,2);
            $table->float('monto_cre',14,2);
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
