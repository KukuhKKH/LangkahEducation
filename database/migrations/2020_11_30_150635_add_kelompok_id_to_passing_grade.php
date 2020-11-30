<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddKelompokIdToPassingGrade extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('passing_grade', function (Blueprint $table) {
            $table->unsignedBigInteger('kelompok_id')->after('universitas_id');
            $table->foreign('kelompok_id')->references('id')->on('kelompok_passing_grade')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('passing_grade', function (Blueprint $table) {
            $table->dropColumn('kelompok_id');
        });
    }
}
