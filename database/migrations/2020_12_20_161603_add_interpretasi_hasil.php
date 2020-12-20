<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInterpretasiHasil extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tryout_paket', function (Blueprint $table) {
            $table->text('interpretasi_1')->after('url_youtube_soshum');
            $table->text('interpretasi_2')->after('interpretasi_1');
            $table->text('interpretasi_3')->after('interpretasi_2');
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
            $table->dropColumn('interpretasi_1');
            $table->dropColumn('interpretasi_2');
            $table->dropColumn('interpretasi_3');
        });
    }
}
