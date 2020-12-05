<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddKelompokPassingGradeId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('temp_prodi_tryout', function (Blueprint $table) {
            $table->unsignedBigInteger('kelompok_passing_grade_id')->after('passing_grade_id');
            $table->foreign('kelompok_passing_grade_id')->on('kelompok_passing_grade')->references('id')->onDelete('CASCADE');
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
            $table->dropColumn('kelompok_passing_grade_id');
        });
    }
}
