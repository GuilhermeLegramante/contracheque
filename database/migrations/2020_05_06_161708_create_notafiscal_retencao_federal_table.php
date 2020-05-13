<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotafiscalRetencaoFederalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notafiscal_retencao_federal', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('notafiscal_id');
            $table->unsignedBigInteger('retencao_federal_id');
            $table->foreign('notafiscal_id')->references('id')->on('notasfiscais')->onDelete('cascade');
            $table->foreign('retencao_federal_id')->references('id')->on('retencoes_federais')->onDelete('cascade');
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
        Schema::dropIfExists('notafiscal_retencao_federal');
    }
}
