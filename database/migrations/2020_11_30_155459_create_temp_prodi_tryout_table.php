<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTempProdiTryoutTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temp_prodi_tryout', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('paket_id');
            $table->unsignedBigInteger('passing_grade_id');
            $table->timestamps();
            $table->foreign('paket_id')->references('id')->on('tryout_paket')->onDelete('CASCADE');
            $table->foreign('passing_grade_id')->references('id')->on('passing_grade')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('temp_prodi_tryout');
    }
}
