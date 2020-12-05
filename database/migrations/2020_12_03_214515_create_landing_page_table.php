<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLandingPageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('landing_page', function (Blueprint $table) {
            $table->id();
            // Hero
            $table->text('headline');
            $table->text('tagline');
            $table->string('foto_hero')->nullable();
            
            //Tentang Kami
            $table->text('tentang_kami');
            $table->string('foto_tentang_kami')->nullable();

            // Produk
            $table->text('headline_produk');

            // Blog
            $table->text('headline_blog');

            // Testimoni
            $table->text('headline_testimoni');

            // Footer
            $table->text('deskripsi');
            $table->text('alamat');
            $table->text('noHP');
            $table->text('akunIG');
            $table->text('urlIG');
            $table->text('akunFB');
            $table->text('urlFB');
            $table->text('akunTwitter');
            $table->text('urlTwitter');
            $table->text('akunLine');
            $table->text('akunYoutube');
            $table->text('urlYoutube');
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
        Schema::dropIfExists('landing_page');
    }
}
