<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTryoutJawabanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tryout_jawaban', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tryout_soal_id');
            $table->string('jawaban');
            $table->integer('benar')->default(0)->comment('0: salah, 1: benar');
            $table->timestamps();
            $table->foreign('tryout_soal_id')->references('id')->on('tryout_soal')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tryout_jawaban');
    }
}
