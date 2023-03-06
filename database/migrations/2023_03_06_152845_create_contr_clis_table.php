<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContrClisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contr_clis', function (Blueprint $table) {
            $table->id('idcont');
            $table->unsignedBigInteger('idcli')->nullable();
            $table->foreign('idcli')
                  ->references('idcli')
                  ->on('clientes');
            $table->string('stscontr',3);
            $table->string('tip_pag');
            $table->float('monto_pag',14,2);
            $table->string('moneda',2);
            $table->unsignedBigInteger('idcta')->nullable();
            $table->foreign('idcta')
                    ->references('idcta')
                    ->on('cat_cuentas');
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
        Schema::dropIfExists('contr_clis');
    }
}
