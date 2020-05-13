<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotafiscalItemNaoTributavelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notafiscal_item_nao_tributavel', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('notafiscal_id');
            $table->unsignedBigInteger('item_nao_tributavel_id');
            $table->foreign('notafiscal_id')->references('id')->on('notasfiscais')->onDelete('cascade');
            $table->foreign('item_nao_tributavel_id')->references('id')->on('itens_nao_tributaveis')->onDelete('cascade');
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
        Schema::dropIfExists('notafiscal_item_nao_tributavel');
    }
}
