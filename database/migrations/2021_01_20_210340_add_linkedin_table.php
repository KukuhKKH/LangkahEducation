<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLinkedinTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('landing_page', function (Blueprint $table) {
            $table->string('akunLinkedin')->after('urlYoutube');
            $table->string('urlLinkedin')->after('akunLinkedin');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('landing_page', function (Blueprint $table) {
            //
        });
    }
}
