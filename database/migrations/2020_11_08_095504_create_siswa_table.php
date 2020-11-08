<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiswaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('siswa', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('nisn')->unique();
            $table->string('asal_sekolah')->nullable();
            $table->string('tanggal_lahir');
            $table->string('nomor_hp');
            $table->char('batch', 1)->comment("0: Daftar sendiri; 1: Didaftarkan Sekolah")->default(0);
            $table->timestamps();
            $table->foreign('user_id')->on('uesrs')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('siswa');
    }
}
