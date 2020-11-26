<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHasilDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tryout_hasil_detail', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tryout_paket_id');
            $table->unsignedBigInteger('tryout_hasil_id');
            $table->unsignedBigInteger('tryout_kategori_soal_id');
            $table->unsignedBigInteger('user_id');
            $table->string('nilai');
            $table->timestamps();

            $table->foreign('tryout_paket_id')->on("tryout_paket")->references('id')->onDelete('cascade');
            $table->foreign('tryout_hasil_id')->references('id')->on('tryout_hasil')->onDelete('CASCADE');
            $table->foreign('tryout_kategori_soal_id')->references('id')->on('tryout_kategori_soal')->onDelete('CASCADE');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hasil_detail');
    }
}
