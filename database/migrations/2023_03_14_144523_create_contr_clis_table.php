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
            $table->string('ind_girosre',1);
            $table->string('tip_pag');
            $table->date('fec_emi')->format('Y-m-d');
            $table->float('montopaglocal',14,2);
            $table->float('montopagmoneda',14,2);
            $table->string('moneda',3);
            $table->float('tasa_cambio',14,2)->nullable();
            /* $table->foreign('idasi')
                    ->references('idasi')
                    ->on('asientos'); */
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
