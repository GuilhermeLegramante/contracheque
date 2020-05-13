<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNameDataemissaoTableNotasfiscais extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('notasfiscais', function (Blueprint $table) {
            $table->date('dataprestacao')->after('dataemissao');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('notasfiscais', function (Blueprint $table) {
            $table->dropColumn('dataprestacao');
        });
    }
}
