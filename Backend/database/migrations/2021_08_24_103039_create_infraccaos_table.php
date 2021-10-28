<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInfraccaosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('infraccaos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idCondutor')->nullable(false)->constrained('condutors', 'id');
            $table->foreignId('idRegraTransito')->nullable(false)->constrained('regra_transitos', 'id');
            $table->string('condicaoPsiquica');
            $table->string('condicaoRodovia');
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
        Schema::dropIfExists('infraccaos');
    }
}
