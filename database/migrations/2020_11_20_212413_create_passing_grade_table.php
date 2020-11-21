<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePassingGradeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('passing_grade', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('universitas_id');
            $table->string('prodi');
            $table->string('passing_grade');
            $table->timestamps();
            $table->foreign('universitas_id')->on('universitas')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('passing_grade');
    }
}
