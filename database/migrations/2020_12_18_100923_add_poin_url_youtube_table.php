<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPoinUrlYoutubeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tryout_paket', function (Blueprint $table) {
            $table->string('poin_1')->after('deskripsi');
            $table->string('poin_2')->after('poin_1');
            $table->string('poin_3')->after('poin_2');
            $table->string('poin_4')->after('poin_3');
            $table->string('url_youtube_saintek')->after('poin_4')->nullable();
            $table->string('url_youtube_soshum')->after('url_youtube_saintek')->nullable();
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
            $table->dropColumn('poin_1');
            $table->dropColumn('poin_2');
            $table->dropColumn('poin_3');
            $table->dropColumn('poin_4');
            $table->dropColumn('url_youtube_saintek');
            $table->dropColumn('url_youtube_soshum');
        });
    }
}
