<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatgSubCuentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() 
    {
        Schema::create('catg_sub_cuentas', function (Blueprint $table) {
            $table->id('idscu');
            $table->unsignedBigInteger('idcta');
            $table->foreign('idcta')
                  ->references('idcta')
                  ->on('cat_cuentas');
<<<<<<< HEAD
            $table->unsignedBigInteger('idgcu');
            $table->foreign('idgcu')
                  ->references('idgcu')
                  ->on('catg_cuentas');
=======
            $table->string('tipcta',20);
>>>>>>> 4a51ac9c67a34874a99c2b62bd7b65a48004bf06
            $table->string('tipsubcta',20);
            $table->string('descripcion');
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
        Schema::dropIfExists('catg_sub_cuentas');
    }
}
