<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatSubGrusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cat_sub_grus', function (Blueprint $table) {
            $table->id('idsgr');
            $table->unsignedBigInteger('idcta');
            $table->foreign('idcta')
                  ->references('idcta')
                  ->on('cat_cuentas');
<<<<<<< HEAD
            $table->unsignedBigInteger('idgru');
            $table->foreign('idgru')
                  ->references('idgru')
                  ->on('cat_grupos');
=======
            $table->string('tipgrup',20);
>>>>>>> 4a51ac9c67a34874a99c2b62bd7b65a48004bf06
            $table->string('tipsubg',20);
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
        Schema::dropIfExists('cat_sub_grus');
    }
}
