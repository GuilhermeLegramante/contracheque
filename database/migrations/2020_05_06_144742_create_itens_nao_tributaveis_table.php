<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItensNaoTributaveisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('itens_nao_tributaveis', function (Blueprint $table) {
            $table->id();
            $table->enum('tipo', ['Despesa Adicional', 'Reembolso']);
            $table->string('descricao');
            $table->double('valor', 12, 2);
            $table->date('datapagamento');
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
        Schema::dropIfExists('itens_nao_tributaveis');
    }
}
