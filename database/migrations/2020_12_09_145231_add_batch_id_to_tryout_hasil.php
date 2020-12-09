<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBatchIdToTryoutHasil extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tryout_hasil', function (Blueprint $table) {
            $table->unsignedBigInteger('batch_id')->after('user_id');
            $table->char('jenis', 1)->comment('1: Gelombang; 2: Sekolah')->after('batch_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tryout_hasil', function (Blueprint $table) {
            $table->dropColumn('batch_id');
            $table->dropColumn('jenis');
        });
    }
}
