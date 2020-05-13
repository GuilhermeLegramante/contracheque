<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servicos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique();
            $table->string('descricao')->nullable();
            $table->string('subservico');
            $table->double('quantidade', 12, 2);
            $table->double('valorunitario', 12, 2);
            $table->double('descontoincondicional', 12, 2)->nullable();
            $table->double('descontocondicional', 12, 2)->nullable();
            $table->double('reducaobasecalculo', 12, 2)->nullable();
            $table->double('aliquota', 12, 2);
            $table->enum('responsabilidadeissqn', ['PRESTADOR', 'TOMADOR'])->nullable();
            $table->string('municipioissqn')->nullable();
            $table->double('valoraproximadotributos', 12, 2)->nullable();
            $table->enum('exigibilidadeissvariavel', ['EXIGÍVEL',
                'NÃO INCIDÊNCIA', 'ISENÇÃO', 'EXPORTAÇÃO',
                'IMUNIDADE', 'EXIGIBILIDADE SUSPENSA POR DECISÃO JUDICIAL',
                'EXIGIBILIDADE SUSPENSA POR PROCESSO ADMINISTRATIVO']);
            $table->unsignedBigInteger('local_id');
            $table->foreign('local_id')->references('id')->on('locais')->onDelete('cascade');
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
        Schema::dropIfExists('servicos');
    }
}
