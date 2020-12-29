<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusBaca extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('komentar_mentor', function (Blueprint $table) {
            $table->char('status', 1)->after('komentar')->default(0)->comment('0: Belum baca; 1: Sudah Baca');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('komentar_mentor', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}
