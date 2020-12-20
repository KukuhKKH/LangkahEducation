<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddKoreksiHasil extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tryout_paket', function (Blueprint $table) {
            $table->char('koreksi', 1)->comment('0: belum koreksi; 1: sudah koreksi')->default(0)->after('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tryout_paket', function (Blueprint $table) {
            $table->dropColumn('koreksi');
        });
    }
}
