<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGelombangTryoutTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gelombang_tryout', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('gelombang_id');
            $table->unsignedBigInteger('tryout_paket_id');
            $table->foreign('gelombang_id')->on('gelombang')->references('id')->onDelete('cascade');
            $table->foreign('tryout_paket_id')->on('tryout_paket')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gelombang_tryout');
    }
}
