<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiswaHasGelombangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('siswa_has_gelombang', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('siswa_id');
            $table->unsignedBigInteger('gelombang_id');
            $table->char('selesai', 1)->comment('0: Belum; 1: Selesai')->default(0);
            $table->timestamps();
            
            $table->foreign('siswa_id')->references('id')->on('siswa')->onDelete('CASCADE');
            $table->foreign('gelombang_id')->references('id')->on('gelombang')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('siswa_has_gelombang');
    }
}
