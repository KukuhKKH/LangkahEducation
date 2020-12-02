<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKomentarMentorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('komentar_mentor', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tryout_hasil_id');
            $table->unsignedBigInteger('mentor_id');
            $table->text('komentar');
            $table->timestamps();
            $table->foreign('tryout_hasil_id')->on('tryout_hasil')->references('id')->onDelete('CASCADE');
            $table->foreign('mentor_id')->on('mentor')->references('id')->onDelete('CASCADE');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('komentar_mentor');
    }
}
