<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagoNominasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pago_nominas', function (Blueprint $table) {
            $table->id('iddnom');
            $table->unsignedBigInteger('idnom');
            $table->foreign('idnom')
                  ->references('idnom')
                  ->on('nominas');
            $table->float('sueldo_men', 14, 2);
            $table->string('ind_horas_ext_diurnas', 1);
            $table->string('ind_horas_ext_nocturnas', 1);
            $table->string('ind_feriado', 1);
            $table->string('ind_dias_no_laborados', 1);
            $table->float('montohorasextdiur', 14, 2)->nullable();
            $table->float('montohorasextnoct', 14, 2)->nullable();
            $table->float('montoferiado', 14, 2)->nullable();
            $table->float('cestaticket', 14, 2);
            $table->float('montototalasignacion', 14, 2);
            $table->float('montototaldeduccion', 14, 2);
            $table->float('montotnetocobrar', 14, 2);
        
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
        Schema::dropIfExists('pago_nominas');
    }
}
