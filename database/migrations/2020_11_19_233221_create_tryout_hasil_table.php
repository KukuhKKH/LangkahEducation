<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTryoutHasilTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tryout_hasil', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('tryout_paket_id');
            $table->integer('nilai_awal');
            $table->integer('nilai_sekarang');
            $table->integer('nilai_maksimal');
            $table->timestamps();
            
            $table->foreign('user_id')->on("users")->references('id')->onDelete('cascade');
            $table->foreign('tryout_paket_id')->on("tryout_paket")->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tryout_hasil');
    }
}
