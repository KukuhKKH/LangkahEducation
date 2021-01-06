<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdBank extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pembayaran_bukti', function (Blueprint $table) {
            $table->unsignedBigInteger('bank_id')->after('pembayaran_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pembayaran_bukti', function (Blueprint $table) {
            $table->dropColumn('bank_id');
        });
    }
}
