<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGelombangIdTemp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('temp_prodi_tryout', function (Blueprint $table) {
            $table->unsignedBigInteger('gelombang_id')->after('id');
            $table->foreign('gelombang_id')->on('gelombang')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('temp_prodi_tryout', function (Blueprint $table) {
            $table->dropColumn('gelombang_id');
        });
    }
}
