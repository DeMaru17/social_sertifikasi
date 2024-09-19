<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class HapusKolomHashtagDariPostsDanComments extends Migration
{
    /**
     * Jalankan migrasi.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('hashtag');
        });

        Schema::table('comments', function (Blueprint $table) {
            $table->dropColumn('hashtag');
        });
    }

    /**
     * Kembalikan migrasi.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->string('hashtag');
        });

        Schema::table('comments', function (Blueprint $table) {
            $table->string('hashtag');
        });
    }
}
