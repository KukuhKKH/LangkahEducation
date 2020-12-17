<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddKodeKelompokPassingGrade extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kelompok_passing_grade', function (Blueprint $table) {
            $table->string('kode', 10)->after('nama');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kelompok_passing_grade', function (Blueprint $table) {
            $table->dropColumn('kode');
        });
    }
}
