<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddJenisGelombang extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('gelombang', function (Blueprint $table) {
            $table->char('jenis', 1)->comment('1: umum: 2: sekolah')->after('id')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('gelombang', function (Blueprint $table) {
            $table->dropColumn('jenis');
        });
    }
}
