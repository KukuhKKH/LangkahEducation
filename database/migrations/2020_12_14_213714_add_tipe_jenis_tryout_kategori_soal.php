<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTipeJenisTryoutKategoriSoal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tryout_kategori_soal', function (Blueprint $table) {
            $table->string('jenis')->after('id');
            $table->string('tipe')->after('jenis');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tryout_kategori_soal', function (Blueprint $table) {
            $table->dropColumn('jenis');
            $table->dropColumn('tipe');
        });
    }
}
