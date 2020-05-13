<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotasFiscaisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notasfiscais', function (Blueprint $table) {
            $table->id();
            $table->string('numero')->unique;
            $table->date('dataemissao');
            $table->date('dataprestacao');
            $table->string('serie');
            $table->string('competencia');
            $table->string('ano');
            $table->double('basecalculo', 12, 2);
            $table->double('total', 12, 2);
            $table->double('valoriss', 12, 2);
            $table->double('valorliquido', 12, 2);
            
            // Relacionamentos
            $table->unsignedBigInteger('usuario_id');
            $table->unsignedBigInteger('prestador_id');
            $table->unsignedBigInteger('tomador_id')->nullable();
            $table->foreign('usuario_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('prestador_id')->references('id')->on('prestadores')->onDelete('cascade');
            $table->foreign('tomador_id')->nullable()->references('id')->on('tomadores')->onDelete('cascade');

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
        Schema::dropIfExists('notasfiscais');
    }
}
