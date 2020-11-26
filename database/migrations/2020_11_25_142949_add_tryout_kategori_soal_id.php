<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTryoutKategoriSoalId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tryout_soal', function (Blueprint $table) {
            $table->unsignedBigInteger('tryout_kategori_soal_id')->after('tryout_paket_id');
            $table->foreign('tryout_kategori_soal_id')->on('tryout_kategori_soal')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tryout_soal', function (Blueprint $table) {
            $table->dropColumn('tryout_kategori_soal_id');
        });
    }
}
