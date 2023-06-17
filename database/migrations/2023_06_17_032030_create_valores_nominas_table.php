<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateValoresNominasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('valores_nominas', function (Blueprint $table) {
            $table->id('idval');
            $table->string('concepto_valor');
            $table->float('monto_valor',14,2);
            $table->date('fecsts')->format('Y-m-d');
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
        Schema::dropIfExists('valores_nominas');
    }
}
