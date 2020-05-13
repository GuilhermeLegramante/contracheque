<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRetencoesFederaisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('retencoes_federais', function (Blueprint $table) {
            $table->id();
            $table->enum('tipo', ['COFINS', 'PIS/PASEP', 'IR', 'CSLL']);
            $table->double('basecalculo', 12, 2);
            $table->double('percentual', 12, 2);
            $table->double('valor', 12, 2);
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
        Schema::dropIfExists('retencoes_federais');
    }
}
