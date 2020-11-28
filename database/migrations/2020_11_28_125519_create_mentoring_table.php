<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMentoringTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mentoring', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('siswa_id');
            $table->unsignedBigInteger('mentor_id');
            $table->string('pengirim');
            $table->text('pesan');
            $table->char('status', 1)->default(0)->comment('0; Belum dibaca; 1: dibaca');
            $table->timestamps();

            $table->foreign('siswa_id')->references('id')->on('siswa')->onDelete('CASCADE');
            $table->foreign('mentor_id')->references('id')->on('mentor')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mentoring');
    }
}
