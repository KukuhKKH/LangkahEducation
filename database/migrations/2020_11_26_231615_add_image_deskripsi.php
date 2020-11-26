<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddImageDeskripsi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tryout_paket', function (Blueprint $table) {
            $table->string('image')->after('slug');
            $table->text('deskripsi')->after('image');
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
            $table->dropColumn('image');
            $table->dropColumn('deskripsi');
        });
    }
}
