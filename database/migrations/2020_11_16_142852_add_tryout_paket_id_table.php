<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTryoutPaketIdTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tryout_soal', function (Blueprint $table) {
            $table->unsignedBigInteger('tryout_paket_id')->after('user_id');
            $table->foreign('tryout_paket_id')->references('id')->on('tryout_paket')->onDelete('cascade');
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
            $table->dropColumn('tryout_paket_id');
        });
    }
}
