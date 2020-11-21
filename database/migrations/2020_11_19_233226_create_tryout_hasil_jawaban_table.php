<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTryoutHasilJawabanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tryout_hasil_jawaban', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tryout_hasil_id');
            $table->unsignedBigInteger('tryout_soal_id');
            $table->unsignedBigInteger('tryout_jawaban_id');
            $table->timestamps();

            $table->foreign('tryout_hasil_id')->on('tryout_hasil')->references('id')->onDelete('cascade');
            $table->foreign('tryout_soal_id')->on('tryout_soal')->references('id')->onDelete('cascade');
            $table->foreign('tryout_jawaban_id')->on('tryout_jawaban')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tryout_hasil_jawaban');
    }
}
