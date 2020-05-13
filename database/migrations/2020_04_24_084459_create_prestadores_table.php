<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrestadoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prestadores', function (Blueprint $table) {
            $table->id();
            $table->string('cpfcnpj')->unique;
            $table->string('razaosocial');
            $table->string('nomefantasia')->nullable();
            $table->string('inscricaomunicipal');
            $table->string('inscricaoestadual')->nullable();
            $table->string('email');
            $table->string('telefone');
            $table->string('cep');
            $table->string('rua');
            $table->string('numero');
            $table->string('bairro');
            $table->string('cidade');
            $table->string('uf');
            $table->enum('emissaonotafiscal', ['Sim', 'Não']);
            $table->enum('emissaoreciboprovisorio', ['Sim', 'Não']);
            $table->unsignedBigInteger('escritorio_id');
            $table->foreign('escritorio_id')->references('id')->on('escritorios')->onDelete('cascade');
            $table->enum('regimetributario', ['Simples Nacional', 'Lucro Presumido', 'Lucro Real']);
            $table->enum('faixasimplesnacional', ['1', '2', '3', '4', '5', '6'])->nullable();
            $table->double('aliquota', 3, 2);
            $table->enum('exigibilidadeissqn', ['Sim', 'Não']);
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
        Schema::dropIfExists('prestadores');
    }
}
