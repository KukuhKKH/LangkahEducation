<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatistikWebTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statistik_web', function (Blueprint $table) {
            $table->id();
            $table->string('ip');
            $table->string('os');
            $table->string('browser');
            $table->string('kota')->nullable();
            $table->string('negara')->nullable();
            $table->string('provinsi')->nullable();
            $table->string('long')->nullable();
            $table->string('lat')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('statistik_web');
    }
}
