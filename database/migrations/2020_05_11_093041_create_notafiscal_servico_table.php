<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotafiscalServicoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notafiscal_servico', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('notafiscal_id');
            $table->unsignedBigInteger('servico_id');
            $table->foreign('notafiscal_id')->references('id')->on('notasfiscais')->onDelete('cascade');
            $table->foreign('servico_id')->references('id')->on('servicos')->onDelete('cascade');
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
        Schema::dropIfExists('notafiscal_servico');
    }
}
